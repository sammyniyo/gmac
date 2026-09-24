<?php

namespace App\Support;

class FrontendShowcase
{
    public static function img(string $key): string
    {
        $files = [
            'cupping_glasses' => 'gmac-cupping-glasses.jpg',
            'cupping_session' => 'gmac-cupping-session.jpg',
            'cupping_line' => 'gmac-cupping-line.jpg',
            'cupping_table' => 'gmac-cupping-table.jpg',
            'quality_notes' => 'gmac-quality-notes.jpg',
            'mill' => 'gmac-mill-machine.jpg',
            'roaster' => 'gmac-sample-roaster.jpg',
            'parchment' => 'gmac-parchment-photo.jpg',
            'drying' => 'gmac-drying-beds.jpg',
            'women_beds' => 'gmac-women-beds.jpg',
            'pack_green' => 'gmac-pack-500g-green.jpg',
            'pack_red' => 'gmac-pack-red.png',
            'pack_chocolate' => 'gmac-pack-chocolate.png',
            'cherries' => 'pexels-michael-burrows-7125703-1920x1280.jpg.jpeg',
            'green' => 'gmac-women-beds.jpg',
            'bowl' => 'gmac-cupping-glasses.jpg',
            'beans' => 'gmac-cupping-line.jpg',
            'green_sm' => 'gmac-parchment-photo.jpg',
            'cherries_sm' => 'gmac-women-beds.jpg',
            'station' => 'gmac-mill-machine.jpg',
            'founder' => 'team-niyonsaba-jeanne.jpg',
            'team_jeanne' => 'team-niyonsaba-jeanne.jpg',
            'team_steven' => 'team-rukaka-steven.jpg',
            'team_japhet' => 'team-habimana-japhet.jpg',
            'team_samuel' => 'team-samuel-niyomuhoza.jpg',
            'seedling' => 'RDU1642-1920x1280.jpg.jpeg',
            'farm' => 'pexels-daniel-reche-718241-1556665-1920x1282.jpg.jpeg',
            'harvest' => 'pexels-michael-burrows-7125547-950x633.jpg.jpeg',
        ];

        return asset('images/'.($files[$key] ?? $files['beans']));
    }

    public static function heroSlides(): array
    {
        return [
            [
                'title' => 'Specialty coffee from Rwanda',
                'subtitle' => 'From our hills to your cup — washed, honey, and natural lots from Karenge and Gasange.',
                'image' => self::img('women_beds'),
                'image_file' => 'gmac-women-beds.jpg',
                'position' => 'center 38%',
                'button_text' => 'Shop the roast',
                'button_link' => '/shop',
            ],
            [
                'title' => 'Raised beds at origin',
                'subtitle' => 'Parchment is sorted and turned until the moisture is honest and the lot is clean.',
                'image' => self::img('drying'),
                'image_file' => 'gmac-drying-beds.jpg',
                'position' => 'center 46%',
                'button_text' => 'Our history',
                'button_link' => '/history',
            ],
            [
                'title' => 'The mill, the same morning',
                'subtitle' => 'Cherry is floated, pulped, and fermented with the lot notes still attached.',
                'image' => self::img('mill'),
                'image_file' => 'gmac-mill-machine.jpg',
                'position' => 'center 42%',
                'button_text' => 'Washing stations',
                'button_link' => '/washing-stations',
            ],
            [
                'title' => 'Cupped before it ships',
                'subtitle' => 'Sample roast, score, and talk — the cup has to match the story we send with the bag.',
                'image' => self::img('cupping_table'),
                'image_file' => 'gmac-cupping-table.jpg',
                'position' => 'center 32%',
                'button_text' => 'Write to us',
                'button_link' => '/contact',
            ],
        ];
    }

    public static function productImage(?string $slug): string
    {
        return match (true) {
            str_contains((string) $slug, 'green') => self::img('pack_green'),
            str_contains((string) $slug, 'chocolate') => self::img('pack_chocolate'),
            str_contains((string) $slug, 'red') => self::img('pack_red'),
            default => self::img('pack_red'),
        };
    }

    public static function newsImage(?string $slug): string
    {
        $key = strtolower((string) $slug);

        return match (true) {
            str_contains($key, 'seedling') => self::img('seedling'),
            str_contains($key, 'women') || str_contains($key, 'mutuelle') => self::img('women_beds'),
            str_contains($key, 'cupping') => self::img('cupping_session'),
            str_contains($key, 'roast') => self::img('roaster'),
            str_contains($key, 'sort') => self::img('women_beds'),
            str_contains($key, 'gasange') || str_contains($key, 'ejo') || str_contains($key, 'harvest') => self::img('drying'),
            str_contains($key, 'wash') || str_contains($key, 'wet') || str_contains($key, 'natural') || str_contains($key, 'boot') || str_contains($key, 'hull') => self::img('mill'),
            default => self::img('cupping_table'),
        };
    }

    public static function galleryImage(?string $title): string
    {
        return match ($title) {
            'The morning cupping table' => self::img('cupping_glasses'),
            'Scoring the session' => self::img('cupping_session'),
            'Cups on the line' => self::img('cupping_line'),
            'Cupping together' => self::img('cupping_table'),
            'Sample roast' => self::img('roaster'),
            'At the mill' => self::img('mill'),
            'Raised drying beds' => self::img('drying'),
            'Photographing parchment' => self::img('parchment'),
            'Women on the beds' => self::img('women_beds'),
            default => self::img('drying'),
        };
    }

    public static function stationImage(?string $name): string
    {
        $key = strtolower((string) $name);

        return match (true) {
            str_contains($key, 'gasange') || str_contains($key, 'gatsibo') => self::img('drying'),
            default => self::img('mill'),
        };
    }

    public static function categories(): array
    {
        return [
            ['name' => '250g', 'slug' => 'pack-250g', 'description' => 'Retail roasted bags, 250 grams.'],
            ['name' => '500g', 'slug' => 'pack-500g', 'description' => 'Retail roasted bags, 500 grams.'],
            ['name' => '1kg', 'slug' => 'pack-1kg', 'description' => 'Retail roasted bags, 1 kilogram.'],
        ];
    }

    public static function products(): array
    {
        $company = 'Green Mountain Arabica Coffee Ltd is a Rwandan coffee producer and trading company.';
        $origin = 'Republic of Rwanda · Kigali City · Kicukiro District · Niboye Sector';
        $contact = 'info@gmac.coffee · www.gmac.coffee';

        $copy = function (string $size, string $colour, string $gtin) use ($company, $origin, $contact): array {
            $label = $size.' '.$colour;

            return [
                'short_description' => 'Official roasted bag, '.$label.' pack. Made in Rwanda by Green Mountain Arabica Coffee Ltd.',
                'description' => '<p>'.$company.' Packed as a '.$label.' retail bag.</p><p>'.$origin.'</p><p>'.$contact.' · GTIN '.$gtin.'</p>',
                'features' => ['Net weight '.$size, 'Roasted', 'Pack '.$colour, 'Origin Rwanda', 'Manufacturer Green Mountain Arabica Coffee Ltd', 'GTIN '.$gtin],
            ];
        };

        return [
            array_merge([
                'slug' => 'roasted-coffee-250g-red-white',
                'barcode' => '0679721369612',
                'category' => 'pack-250g',
                'name' => 'Roasted Coffee 250g — Red & White',
                'price' => 5000,
                'order' => 1,
            ], $copy('250g', 'red & white', '0679721369612')),
            array_merge([
                'slug' => 'roasted-coffee-250g-green-white',
                'barcode' => '0679721369778',
                'category' => 'pack-250g',
                'name' => 'Roasted Coffee 250g — Green & White',
                'price' => 5000,
                'order' => 2,
            ], $copy('250g', 'green & white', '0679721369778')),
            array_merge([
                'slug' => 'roasted-coffee-250g-chocolate-white',
                'barcode' => '0679721369955',
                'category' => 'pack-250g',
                'name' => 'Roasted Coffee 250g — Chocolate & White',
                'price' => 5000,
                'order' => 3,
            ], $copy('250g', 'chocolate & white', '0679721369955')),
            array_merge([
                'slug' => 'roasted-coffee-500g-chocolate-white',
                'barcode' => '0679721369544',
                'category' => 'pack-500g',
                'name' => 'Roasted Coffee 500g — Chocolate & White',
                'price' => 10000,
                'order' => 4,
            ], $copy('500g', 'chocolate & white', '0679721369544')),
            array_merge([
                'slug' => 'roasted-coffee-500g-green-white',
                'barcode' => '0679721369476',
                'category' => 'pack-500g',
                'name' => 'Roasted Coffee 500g — Green & White',
                'price' => 10000,
                'order' => 5,
            ], $copy('500g', 'green & white', '0679721369476')),
            array_merge([
                'slug' => 'roasted-coffee-500g-red-white',
                'barcode' => '0679721369300',
                'category' => 'pack-500g',
                'name' => 'Roasted Coffee 500g — Red & White',
                'price' => 10000,
                'order' => 6,
            ], $copy('500g', 'red & white', '0679721369300')),
            array_merge([
                'slug' => 'roasted-coffee-1kg-chocolate-white',
                'barcode' => '0679721369230',
                'category' => 'pack-1kg',
                'name' => 'Roasted Coffee 1kg — Chocolate & White',
                'price' => 20000,
                'order' => 7,
            ], $copy('1kg', 'chocolate & white', '0679721369230')),
            array_merge([
                'slug' => 'roasted-coffee-1kg-green-white',
                'barcode' => '0679721369162',
                'category' => 'pack-1kg',
                'name' => 'Roasted Coffee 1kg — Green & White',
                'price' => 20000,
                'order' => 8,
            ], $copy('1kg', 'green & white', '0679721369162')),
            array_merge([
                'slug' => 'roasted-coffee-1kg-red-white',
                'barcode' => '0679721369090',
                'category' => 'pack-1kg',
                'name' => 'Roasted Coffee 1kg — Red & White',
                'price' => 20000,
                'order' => 9,
            ], $copy('1kg', 'red & white', '0679721369090')),
        ];
    }

    public static function gallery(): array
    {
        return [
            ['title' => 'The morning cupping table', 'category' => 'Cupping'],
            ['title' => 'Scoring the session', 'category' => 'Quality'],
            ['title' => 'Cups on the line', 'category' => 'Cupping'],
            ['title' => 'Cupping together', 'category' => 'Lab'],
            ['title' => 'Sample roast', 'category' => 'Roast'],
            ['title' => 'At the mill', 'category' => 'Mill'],
            ['title' => 'Raised drying beds', 'category' => 'Origin'],
            ['title' => 'Photographing parchment', 'category' => 'Origin'],
            ['title' => 'Women on the beds', 'category' => 'Team'],
        ];
    }

    public static function news(): array
    {
        $post = static function (string $slug, string $title, string $date, string $excerpt, string $content): array {
            return [
                'slug' => $slug,
                'title' => $title,
                'excerpt' => $excerpt,
                'content' => $content,
                'published_at' => $date.' 09:00:00',
            ];
        };

        return [
            $post(
                'gmac-european-coffee-exhibition-ntwali',
                'GMAC at the European Coffee Exhibition: showcasing Ntwali Coffee',
                '2026-03-24',
                'GMAC took Rwandan coffee to a European exhibition, introducing Ntwali to roasters, distributors, and buyers.',
                '<p>GMAC joined a European coffee exhibition to put Rwandan coffee — and our Ntwali brand — in front of roasters, distributors, and buyers. The event was a working room as much as a showcase: conversations about origin, process, and long-term supply.</p><p>We presented lots from Karenge and Gasange and spoke about how cherries move from farm to cupping table. The aim was simple: a clear story from Rwanda, and contacts that can become regular trade.</p>'
            ),
            $post(
                'warm-up-with-ntwali-coffee',
                'Warm up this cold season with Ntwali Coffee',
                '2024-10-03',
                'Ntwali is GMAC’s roasted coffee — a cup from origin for the colder months.',
                '<p>Ntwali is GMAC’s roasted coffee: Arabica Bourbon from our Eastern Province stations, packed for home and hospitality. In the cooler months we come back to a simple cup — fresh beans, a clean brew, and the taste of the hills.</p><p>Ask us for the current roast profiles and bag sizes. Orders are by request to info@gmac.coffee.</p>'
            ),
            $post(
                'coffee-roasting',
                'Coffee roasting',
                '2024-09-06',
                'Roasting turns green coffee into the cup. Time and heat decide whether the lot stays bright or goes dark and smoky.',
                '<p>Roasting is where green coffee becomes the cup people recognise. Heat and time change the bean: a lighter roast keeps more acidity and fruit; a darker roast brings body and roast character.</p><p>At GMAC we sample-roast lots from Karenge and Gasange so the table can score them before export or retail packing. That is how Ntwali profiles stay honest to the parchment we dried.</p>'
            ),
            $post(
                'top-40-best-of-rwanda-specialty-coffee-2024',
                'We’re in the top 40 of Best of Rwanda Specialty Coffee 2024',
                '2024-07-03',
                'GMAC coffee reached the top 40 in the Best of Rwanda Specialty Coffee 2024 competition and auction.',
                '<p>GMAC coffee placed in the top 40 of Best of Rwanda Specialty Coffee 2024 — the national competition and auction that shows the country’s best lots. The result belongs to the farmers and the station teams who kept cherry selection and processing tight through a difficult climate year.</p><p>Best of Rwanda is the stage we work toward each season: clean washed cups, honest lots, and a place among the country’s specialty coffees.</p>'
            ),
            $post(
                'harvest-season-is-here-2024',
                'Harvest season is here',
                '2024-06-04',
                'Ripe cherries are arriving at the stations. Farmers pick by hand; we float, pulp, and dry lot by lot.',
                '<p>Harvest has opened on the hills. Farmers pick ripe red cherries by hand and deliver them the same day. At the station we float, pulp, ferment, wash, grade, and dry — then cup each lot before it moves on.</p><p>This is the stretch of the year that decides the cup. Write to us if you want samples from the current intake.</p>'
            ),
            $post(
                'coffee-cupping',
                'Coffee cupping',
                '2024-02-09',
                'Cupping is how we score a lot: aroma, flavour, acidity, body, and finish — the same table for every sample.',
                '<p>Cupping is the sensory table we use on every lot: fragrance, aroma, flavour, acidity, body, and finish. It is how we decide what is ready for a buyer and what still needs work on the beds.</p><p>We cup washed, honey, natural, and anaerobic samples from Karenge and Gasange. Visitors are welcome by appointment if they want to sit at the table with the team.</p>'
            ),
            $post(
                'why-gmac-is-your-coffee-destination',
                'Why GMAC is a coffee destination',
                '2024-01-16',
                'GMAC is a farmer, processor, and exporter — two stations, Arabica Bourbon, and a direct line to the people who process the coffee.',
                '<p>GMAC is not a supermarket brand. We farm, process, and export Arabica Bourbon from two washing stations in Rwanda’s Eastern Province. Buyers talk to the same people who receive cherry and cup the lots.</p><p>If you want samples, a station visit, or retail Ntwali bags, write to info@gmac.coffee.</p>'
            ),
            $post(
                'coffee-seedlings-preparation-next-season',
                'GMAC coffee seedlings for the next season',
                '2023-12-15',
                'The next harvest starts in the nursery. We select seed, raise seedlings, and send strong plants to the hills.',
                '<p>The next cup starts as a seedling. We select seed from healthy Arabica plants, raise it in the nursery, and only send plants that are strong enough for the hills.</p><p>That work sits behind every later harvest: better trees, better cherry, and a more stable supply from partner farmers.</p>'
            ),
            $post(
                'gasange-ejo-heza-pension-support',
                'GMAC supports Gasange farmers with Ejo Heza pension planning',
                '2023-10-31',
                'GMAC visited the Gasange Coffee Farmers Cooperative to support Ejo Heza pension planning and insurance.',
                '<p>GMAC visited the Gasange Coffee Farmers Cooperative with sector leaders to talk through Ejo Heza — Rwanda’s long-term savings scheme — and insurance. The visit was about the people who grow the coffee, not only the cherry they deliver.</p><p>Gasange is one of our two stations. Standing with that cooperative is part of how we keep the partnership real.</p>'
            ),
            $post(
                'mutuelle-de-sante-women-coffee-farmers',
                'Mutuelle de Santé for women coffee farmers',
                '2023-10-10',
                'GMAC paid community health-insurance fees for women farmers as part of our Mutuelle de Santé support.',
                '<p>GMAC supported women coffee farmers through Mutuelle de Santé — community health insurance — covering fees so households stay in the scheme. Coffee work is seasonal and uncertain; insurance is one of the few protections that lasts after harvest.</p><p>Women carry much of the work on the beds and in the fields. This is a direct way to stand with them.</p>'
            ),
            $post(
                'why-wear-boots-while-washing-coffee',
                'Why wear boots while washing coffee?',
                '2023-09-14',
                'Washing coffee means standing in water, pulp, and wet floors. Boots keep the team safer and cleaner.',
                '<p>Washing coffee is wet work. Teams stand in channels and tanks to float cherry and move parchment. Boots keep feet out of cold water, reduce slips, and hold a cleaner line between the person and the mucilage on the floor.</p><p>It is a small rule that belongs with the rest of station discipline: clean process, safe people.</p>'
            ),
            $post(
                'the-art-of-coffee-sorting',
                'The art of coffee sorting',
                '2023-08-28',
                'After the wash, hands still decide what stays in the lot. Sorting is slow, and it shows in the cup.',
                '<p>After washing, parchment is sorted by hand. Defects, broken beans, and off-colour seeds leave the lot before drying finishes. It is slow work, often done by women on the beds, and it is one of the reasons a cup stays clean.</p><p>We do not skip it. A pretty process on paper still fails if the table is careless.</p>'
            ),
            $post(
                'successful-harvest-season-2023',
                'A successful harvest season at GMAC',
                '2023-07-11',
                'The 2023 harvest closed with strong volumes and cups we were proud to send out.',
                '<p>The 2023 harvest closed with the work we ask of every season: ripe cherry, honest processing, and lots we could stand behind on the cupping table. Farmers and station teams carried that stretch together.</p><p>When harvest ends we keep cupping, milling, and talking to buyers. The next season starts as soon as the last parchment is bagged.</p>'
            ),
            $post(
                'china-coffee-expo-2023',
                'GMAC at the China Coffee Expo',
                '2023-07-10',
                'GMAC attended the China Coffee Expo to meet buyers, share lots, and learn with the wider trade.',
                '<p>GMAC attended the China Coffee Expo to meet buyers and sit in industry sessions. It was a chance to put Rwandan Arabica in a room that is still building its specialty trade.</p><p>We came home with contacts and a clearer sense of what that market asks for: consistent lots, clean communication, and samples that match the offer.</p>'
            ),
            $post(
                'rabobank-coffee-hulling-project',
                'Rabobank funds our coffee hulling project',
                '2023-04-28',
                'Rabobank Netherlands funded a hulling project so more value from parchment stays in the community.',
                '<p>A hulling project supported by Rabobank Netherlands is helping GMAC keep more of the dry mill close to origin. Hulling parchment locally means jobs and a higher share of value before export.</p><p>The bank’s Africa programme team visited as the work moved forward. The goal is a plant that serves farmers, not only a single company line.</p>'
            ),
            $post(
                'natural-coffee-processing',
                'Natural coffee processing',
                '2023-04-21',
                'At GMAC we also prepare naturals: cherry dried in the fruit on raised beds, then hulled when the moisture is stable.',
                '<p>Natural process means the cherry dries with the fruit still on the seed. We use it alongside washed and honey lots. Ripe cherry is sorted, then spread on raised beds and turned until moisture is stable.</p><p>Naturals need space, sun, and attention. Done well they give a different cup from our washed Bourbon — and they stay traceable to the same hills.</p>'
            ),
            $post(
                'harvest-season-has-begun-2023',
                'Coffee harvesting season has begun',
                '2023-03-31',
                'The 2023 harvest opened at GMAC. Farmers are picking, and the stations are receiving cherry every morning.',
                '<p>Harvest opened again in 2023. The smell of ripe cherry on the road to the station is the start of the working year. Farmers pick, we receive, and the first tanks fill.</p><p>From here the sequence is the one we never skip: seedlings already in the ground, farm work done, harvest, process, cup.</p>'
            ),
            $post(
                'agritech-exhibition-qatar-2023',
                'Insights from AgriTech 2023 in Qatar',
                '2023-03-28',
                'GMAC joined coffee farmers at AgriTech in Qatar to talk climate, practice, and new tools.',
                '<p>GMAC took part in the AgriTech coffee farmers meeting in Qatar. Growers compared notes on climate, pests, and the tools that actually help a small station — not only a slide deck.</p><p>Climate stress was the shared problem. The useful answers were still the old ones done well: healthy trees, shade, and a station that does not waste a cherry.</p>'
            ),
            $post(
                'coffee-processing-wet-processing',
                'Coffee processing — wet processing',
                '2022-12-20',
                'Most Rwandan coffee is wet-processed at shared washing stations. That is the path we run at Karenge and Gasange.',
                '<p>Rwanda’s specialty coffee is mostly wet-processed: float, pulp, ferment, wash, grade, and dry on raised beds. Small farms cannot each build a mill, so stations like Karenge and Gasange take in cherry from many hills.</p><p>That shared infrastructure is why lot-by-lot cupping matters. One sloppy tank affects many families. We keep the line tight for that reason.</p>'
            ),
            $post(
                'rwanda-coffee-growing',
                'Rwanda coffee growing: what you need to know',
                '2022-12-19',
                'Rwanda’s coffee is Arabica from steep hills. The country’s trade was rebuilt around washing stations and cup quality.',
                '<p>Rwanda grows Arabica on steep hills. After the 1990s the industry was rebuilt around washing stations, tighter processing, and a cup that could sell as specialty — not only as volume.</p><p>GMAC sits in that story: two stations in the Eastern Province, Bourbon on sandy soils, and a table that still cups lot by lot. That is the Rwanda we export.</p>'
            ),
        ];
    }

    public static function stations(): array
    {
        $shared = [
            'type_of_soil' => 'Sandy soil',
            'coffee_variety' => 'Arabica Bourbon',
            'harvest_period' => 'March to July',
            'processing' => 'Cherry floating, pulping, fermentation, washing, grading, sorting, then sun-drying for specialty coffee, with cupping lot by lot.',
            'other_coffee_available' => 'Honey, natural, and anaerobic',
            'cupping_score' => '85+',
            'traceability' => 'We receive coffee from women and process it separately.',
            'certification' => 'Rainforest Alliance',
            'environment' => 'Shade trees for farmers and training on best agricultural practice.',
        ];

        return [
            array_merge($shared, [
                'name' => 'Karenge Washing Station',
                'location' => 'Eastern Province, Rwamagana District, Karenge Sector, Kabasore Village, Kabasore Cell',
                'altitude' => '1,450–1,650 m',
                'farmers_working' => 1314,
                'total_area_under_production' => '337.7 ha',
                'order' => 1,
            ]),
            array_merge($shared, [
                'name' => 'Gasange Washing Station',
                'location' => 'Eastern Province, Gatsibo District, Gasange Sector',
                'altitude' => '1,800–2,000 m',
                'farmers_working' => 1100,
                'total_area_under_production' => '320 ha',
                'order' => 2,
            ]),
        ];
    }

    public static function testimonials(): array
    {
        return [
            [
                'name' => 'Clara M.',
                'role' => 'Head of Coffee',
                'company' => 'Nordic Roastery',
                'quote' => 'The Karenge washed lot was the cleanest Rwanda we bought last year — citrus, tea, and a finish that held on the bar.',
                'rating' => 5,
                'order' => 1,
            ],
            [
                'name' => 'James Okafor',
                'role' => 'Green Buyer',
                'company' => 'East & Co.',
                'quote' => 'Communication from origin was clear, samples arrived on time, and the women’s lot sold through in two weeks.',
                'rating' => 5,
                'order' => 2,
            ],
            [
                'name' => 'Hana Saito',
                'role' => 'Importer',
                'company' => 'Pacific Specialty',
                'quote' => 'Traceability notes were usable, not decorative. We could tell a real story to our roasters.',
                'rating' => 5,
                'order' => 3,
            ],
        ];
    }

    public static function stats(): array
    {
        return [
            ['number' => '2012', 'title' => 'Founded in Rwanda', 'icon' => 'fa-flag', 'order' => 1],
            ['number' => '1,200+', 'title' => 'Partner farmers', 'icon' => 'fa-users', 'order' => 2],
            ['number' => '4', 'title' => 'Processing profiles', 'icon' => 'fa-seedling', 'order' => 3],
            ['number' => '90%', 'title' => 'Seasonal team women', 'icon' => 'fa-heart', 'order' => 4],
        ];
    }

    public static function process(): array
    {
        return [
            ['step' => '01', 'title' => 'Seedlings', 'text' => 'Young plants are raised and watered in the nursery until they are strong enough for the hills.', 'image' => 'seedling'],
            ['step' => '02', 'title' => 'In farm', 'text' => 'Trees are tended through the season — soil, shade, and the long wait for ripe fruit.', 'image' => 'farm'],
            ['step' => '03', 'title' => 'Harvest', 'text' => 'Red cherries are picked by hand when they are ready, not all at once.', 'image' => 'harvest'],
            ['step' => '04', 'title' => 'Processing', 'text' => 'Washed, honey, or natural — then dried on raised beds until the parchment is clean and stable.', 'image' => 'mill'],
            ['step' => '05', 'title' => 'Cupping', 'text' => 'Sample roast, score, and cup so the lot is known before it leaves Karenge.', 'image' => 'cupping_session'],
        ];
    }

    public static function teamMembers(): array
    {
        return [
            [
                'name' => 'Niyonsaba Jeanne',
                'role' => 'Chairperson & Founder',
                'email' => 'niyonsabajeanne@gmac.coffee',
                'phone' => '+250 783 053 415',
                'bio' => 'Jeanne founded GMAC Coffee in 2012 and chairs the board — more value from origin, stronger traceability, and a fairer path for the women who grow the coffee.',
                'quote' => 'More value from origin, and a fairer path for the women who grow it.',
                'photo' => self::img('team_jeanne'),
                'photo_file' => 'team-niyonsaba-jeanne.jpg',
                'pose' => 'face',
                'focus' => 'Board, farmer partnerships, and the long view.',
            ],
            [
                'name' => 'Rukaka Steven',
                'role' => 'Managing Director',
                'email' => 'info@gmac.coffee',
                'phone' => '+250 783 053 415',
                'bio' => 'Steven leads operations, buyer relationships, and the systems that keep lots traceable from Karenge to export.',
                'quote' => 'The cup has to match the story we send with the bag.',
                'photo' => self::img('team_steven'),
                'photo_file' => 'team-rukaka-steven.jpg',
                'pose' => 'face',
                'focus' => 'Operations, export, and buyer conversations.',
            ],
            [
                'name' => 'Habimana Japhet',
                'role' => 'Marketing Manager',
                'email' => 'japhet@gmac.coffee',
                'phone' => null,
                'bio' => 'Japhet looks after the GMAC brand, buyer conversations, and the story that travels with every bag.',
                'quote' => null,
                'photo' => self::img('team_japhet'),
                'photo_file' => 'team-habimana-japhet.jpg',
                'pose' => 'face',
                'focus' => 'Brand, markets, and the offer list.',
            ],
            [
                'name' => 'David Biziyaremye',
                'role' => 'Production Manager',
                'email' => 'biziyaremyedavid@gmac.coffee',
                'phone' => null,
                'bio' => 'David runs production at the station — cherry in, parchment out, and the lot notes that stay attached.',
                'quote' => null,
                'photo' => null,
                'photo_file' => null,
                'focus' => 'Mill, processing, and daily production.',
            ],
            [
                'name' => 'Gakenyeye Faustin',
                'role' => 'Finance Officer',
                'email' => 'gakenyeyefaustin@gmac.coffee',
                'phone' => null,
                'bio' => 'Faustin looks after the books, payments, and the numbers that keep the stations and the shop honest.',
                'quote' => null,
                'photo' => null,
                'photo_file' => null,
                'focus' => 'Accounts, payments, and reporting.',
            ],
            [
                'name' => 'Samuel Niyomuhoza',
                'role' => 'IT',
                'email' => null,
                'phone' => null,
                'bio' => 'Samuel keeps the digital side of GMAC running — the website, systems, and the tools the team uses every day.',
                'quote' => null,
                'photo' => self::img('team_samuel'),
                'photo_file' => 'team-samuel-niyomuhoza.jpg',
                'pose' => 'body',
                'focus' => 'Systems, site, and internal tools.',
            ],
            [
                'name' => 'Divine Irakoze',
                'role' => 'Finance Assistant',
                'email' => 'divine@gmac.coffee',
                'phone' => null,
                'bio' => 'Divine supports finance day to day — invoices, records, and the paperwork behind every shipment.',
                'quote' => null,
                'photo' => null,
                'photo_file' => null,
                'focus' => 'Invoices, records, and follow-up.',
            ],
        ];
    }

    public static function teamStories(): array
    {
        return [
            [
                'image' => self::img('women_beds'),
                'kicker' => 'On the beds',
                'title' => 'Women who turn the harvest',
                'text' => 'Seasonal work on the raised beds is mostly women. They sort, turn, and watch moisture until the parchment is clean and stable.',
            ],
            [
                'image' => self::img('mill'),
                'kicker' => 'At the mill',
                'title' => 'The station team',
                'text' => 'Cherry is floated, pulped, and fermented the same morning it arrives. The mill team keeps the lot notes attached from tank to bag.',
            ],
            [
                'image' => self::img('cupping_table'),
                'kicker' => 'At the table',
                'title' => 'Cupping together',
                'text' => 'Sample roast, score, and talk. Quality is a conversation between the station, the lab, and the people who will roast the coffee.',
            ],
        ];
    }

    public static function reviews(): array
    {
        return [
            ['name' => 'Amelia Wright', 'email' => null, 'rating' => 5, 'body' => 'The house roast made a beautiful filter — orange, honey, and a cocoa finish. We will be back for the washed green.', 'is_approved' => true],
            ['name' => 'David N.', 'email' => null, 'rating' => 5, 'body' => 'Clear answers on processing and a sample that matched the offer list. Rare to get that from origin this cleanly.', 'is_approved' => true],
            ['name' => 'Sofia Ruiz', 'email' => null, 'rating' => 4, 'body' => 'Loved the women’s lot story and the cup. Would like a slightly larger sample next time, but quality was there.', 'is_approved' => true],
        ];
    }
}
