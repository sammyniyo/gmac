document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.getElementById('site-navbar');
    const burger = document.getElementById('navbar-burger');
    const panel = document.getElementById('navbar-panel');
    const backdrop = document.getElementById('navbar-backdrop');

    // Navbar scroll state
    if (navbar) {
        const onScroll = () => {
            const y = window.scrollY || 0;
            navbar.classList.toggle('is-scrolled', y > 60);
        };

        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });
    }

    const NAV_BREAKPOINT = 1024;

    function setNavOpen(open) {
        if (!burger || !panel || !backdrop) return;
        panel.classList.toggle('is-open', open);
        backdrop.classList.toggle('is-open', open);
        burger.classList.toggle('is-open', open);
        burger.setAttribute('aria-expanded', open ? 'true' : 'false');
        burger.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
        document.body.style.overflow = open ? 'hidden' : '';
    }

    if (burger && backdrop && panel) {
        burger.addEventListener('click', () => {
            setNavOpen(!panel.classList.contains('is-open'));
        });
        backdrop.addEventListener('click', () => setNavOpen(false));
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && panel && panel.classList.contains('is-open')) {
            setNavOpen(false);
        }
    });

    window.addEventListener(
        'resize',
        () => {
            if (window.innerWidth > NAV_BREAKPOINT && panel && panel.classList.contains('is-open')) {
                setNavOpen(false);
            }
        },
        { passive: true }
    );

    document.querySelectorAll('#navbar-links a').forEach((a) => {
        a.addEventListener('click', () => {
            if (window.innerWidth <= NAV_BREAKPOINT) setNavOpen(false);
        });
    });

    function initHeroSlider() {
        const slider = document.getElementById('gh-hero-slider');
        if (!slider) return;

        const slides = Array.from(slider.querySelectorAll('[data-slide]'));
        if (slides.length <= 1) return;

        const heroCopy = document.querySelector('.gh-hero__copy');
        const titleEl = document.getElementById('gh-hero-title');
        const subtitleEl = document.getElementById('gh-hero-subtitle');

        const dots = Array.from(slider.querySelectorAll('[data-dot]'));
        const prevBtn = slider.querySelector('[data-prev]');
        const nextBtn = slider.querySelector('[data-next]');
        const primaryBtn = document.getElementById('gh-hero-cta-primary');
        const secondaryBtn = document.getElementById('gh-hero-cta-secondary');

        const interval = Number(slider.getAttribute('data-interval') || '6500');
        const prefersReducedMotion =
            window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        let idx = slides.findIndex((s) => s.classList.contains('is-active'));
        if (idx < 0) idx = 0;

        let timer = null;
        let animTimer = null;

        function triggerTextAnimation() {
            if (!heroCopy) return;
            heroCopy.classList.remove('is-text-animating');
            // Force reflow so animation restarts
            // eslint-disable-next-line no-unused-expressions
            heroCopy.offsetHeight;
            heroCopy.classList.add('is-text-animating');
            if (animTimer) window.clearTimeout(animTimer);
            animTimer = window.setTimeout(() => heroCopy.classList.remove('is-text-animating'), 950);
        }

        function setMultilineText(el, text) {
            if (!el) return;
            el.textContent = '';
            const parts = String(text ?? '').split(/\r?\n/);
            parts.forEach((p, i) => {
                if (i > 0) el.appendChild(document.createElement('br'));
                el.appendChild(document.createTextNode(p));
            });
        }

        function updateHeroCtas(activeSlide) {
            const defPL = slider.getAttribute('data-default-primary-label') || '';
            const defPH = slider.getAttribute('data-default-primary-href') || '#';
            const secL = slider.getAttribute('data-secondary-label') || '';
            const secH = slider.getAttribute('data-secondary-href') || '#';
            if (secondaryBtn) {
                secondaryBtn.textContent = secL;
                secondaryBtn.setAttribute('href', secH);
            }
            if (!activeSlide) {
                if (primaryBtn) {
                    primaryBtn.textContent = defPL;
                    primaryBtn.setAttribute('href', defPH);
                }
                return;
            }
            const pLabel = activeSlide.getAttribute('data-primary-label') || defPL;
            const pHref = activeSlide.getAttribute('data-primary-href') || defPH;
            if (primaryBtn) {
                primaryBtn.textContent = pLabel;
                primaryBtn.setAttribute('href', pHref);
            }
        }

        function render(nextIdx) {
            idx = (nextIdx + slides.length) % slides.length;

            slides.forEach((s, i) => s.classList.toggle('is-active', i === idx));
            dots.forEach((d, i) => {
                const active = i === idx;
                d.classList.toggle('is-active', active);
                d.setAttribute('aria-selected', active ? 'true' : 'false');
            });

            const activeSlide = slides[idx];
            if (activeSlide) {
                setMultilineText(titleEl, activeSlide.getAttribute('data-title') || '');
                if (subtitleEl) subtitleEl.textContent = activeSlide.getAttribute('data-subtitle') || '';
                triggerTextAnimation();
            }
            updateHeroCtas(activeSlide);
        }

        function start() {
            if (prefersReducedMotion) return;
            stop();
            timer = window.setInterval(() => render(idx + 1), interval);
        }

        function stop() {
            if (timer) window.clearInterval(timer);
            timer = null;
        }

        prevBtn?.addEventListener('click', () => {
            render(idx - 1);
            start();
        });
        nextBtn?.addEventListener('click', () => {
            render(idx + 1);
            start();
        });

        dots.forEach((d) => {
            d.addEventListener('click', () => {
                const next = Number(d.getAttribute('data-dot'));
                if (Number.isFinite(next)) render(next);
                start();
            });
        });

        updateHeroCtas(slides[idx]);

        slider.addEventListener('mouseenter', stop);
        slider.addEventListener('mouseleave', start);
        slider.addEventListener('focusin', stop);
        slider.addEventListener('focusout', start);
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                stop();
            } else {
                start();
            }
        });

        // Swipe support (mobile)
        let touchStartX = 0;
        let touchStartY = 0;
        let touching = false;

        slider.addEventListener(
            'touchstart',
            (e) => {
                if (!e.touches || e.touches.length !== 1) return;
                touching = true;
                touchStartX = e.touches[0].clientX;
                touchStartY = e.touches[0].clientY;
                stop();
            },
            { passive: true }
        );

        slider.addEventListener(
            'touchend',
            (e) => {
                if (!touching) return;
                touching = false;
                const t = e.changedTouches && e.changedTouches[0];
                if (!t) return;
                const dx = t.clientX - touchStartX;
                const dy = t.clientY - touchStartY;
                if (Math.abs(dx) > 40 && Math.abs(dx) > Math.abs(dy)) {
                    render(dx < 0 ? idx + 1 : idx - 1);
                }
                start();
            },
            { passive: true }
        );

        render(idx);
        start();
    }

    initHeroSlider();

    const appearOptions = {
        threshold: 0.12,
        rootMargin: '0px 0px -40px 0px',
    };

    function observeReveal(selector, visibleClass) {
        const nodes = document.querySelectorAll(selector);
        if (!nodes.length) return;

        if (!('IntersectionObserver' in window)) {
            nodes.forEach((el) => el.classList.add(visibleClass));
            return;
        }

        const observer = new IntersectionObserver((entries, obs) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                entry.target.classList.add(visibleClass);
                obs.unobserve(entry.target);
            });
        }, appearOptions);

        nodes.forEach((el) => observer.observe(el));
    }

    observeReveal('.fade-in', 'visible');
    observeReveal('.reveal-on-scroll', 'is-visible');
});
