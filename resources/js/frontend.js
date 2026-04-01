document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.getElementById('site-navbar');
    const burger = document.getElementById('navbar-burger');
    const backdrop = document.getElementById('navbar-backdrop');

    // Navbar scroll (avoid jitter with hysteresis)
    if (navbar) {
        const ENTER_AT = 90;
        const EXIT_AT = 30;
        let isScrolled = false;

        const onScroll = () => {
            const y = window.scrollY || 0;
            if (!isScrolled && y >= ENTER_AT) {
                isScrolled = true;
                navbar.classList.add('scrolled');
            } else if (isScrolled && y <= EXIT_AT) {
                isScrolled = false;
                navbar.classList.remove('scrolled');
            }
        };

        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });
    }

    const NAV_BREAKPOINT = 1024;

    function setNavOpen(open) {
        if (!navbar || !burger) return;
        navbar.classList.toggle('is-open', open);
        burger.setAttribute('aria-expanded', open ? 'true' : 'false');
        burger.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
        document.body.style.overflow = open ? 'hidden' : '';
    }

    if (burger && backdrop && navbar) {
        burger.addEventListener('click', () => {
            setNavOpen(!navbar.classList.contains('is-open'));
        });
        backdrop.addEventListener('click', () => setNavOpen(false));
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && navbar && navbar.classList.contains('is-open')) {
            setNavOpen(false);
        }
    });

    window.addEventListener(
        'resize',
        () => {
            if (window.innerWidth > NAV_BREAKPOINT && navbar && navbar.classList.contains('is-open')) {
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

        slider.addEventListener('mouseenter', stop);
        slider.addEventListener('mouseleave', start);
        slider.addEventListener('focusin', stop);
        slider.addEventListener('focusout', start);

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

    // Fade-in on scroll animation observer
    const fadeElements = document.querySelectorAll('.fade-in');
    
    if ('IntersectionObserver' in window && fadeElements.length > 0) {
        const appearOptions = {
            threshold: 0.15,
            rootMargin: "0px 0px -50px 0px"
        };
        
        const appearOnScroll = new IntersectionObserver(function(entries, observer) {
            entries.forEach(entry => {
                if (!entry.isIntersecting) {
                    return;
                } else {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, appearOptions);
        
        fadeElements.forEach(item => {
            appearOnScroll.observe(item);
        });
    } else {
        // Fallback for browsers without IntersectionObserver
        fadeElements.forEach(item => {
            item.classList.add('visible');
        });
    }
});
