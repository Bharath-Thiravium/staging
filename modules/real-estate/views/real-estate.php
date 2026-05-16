<?php
/**
 * Real Estate Services Page
 * Template modelled on: athenas.co.in/services/accounting-services/
 *
 * Sections:
 *  1. Hero headline
 *  2. Intro split  (alert + description | image)
 *  3. Tagline strip
 *  4. Values grid  (3 points | SVG illustration)
 *  5. Why Choose Us (alert | pain-point list)
 *  6. Services detail list
 *  7. Commitment paragraph
 *  8. CTA section  (steps | image card)
 */
?>

<!-- ═══════════════════════════════════════════════
     1. HERO HEADLINE
════════════════════════════════════════════════ -->
<section class="bg-white py-10 px-4 text-center">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight">
            Maximize Returns with Powerful Real Estate Services
        </h1>
    </div>
</section>

<!-- ═══════════════════════════════════════════════
     2. INTRO SPLIT — alert + description | image
════════════════════════════════════════════════ -->
<section class="bg-gray-50 py-12 px-4">
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-10 items-center">

        <!-- Left: alert + description -->
        <div class="flex flex-col gap-6">
            <!-- Alert banner (mirrors Elementor alert widget) -->
            <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg px-5 py-4" role="alert">
                <p class="font-semibold text-blue-800 text-base">Struggling with Complex Property Decisions?</p>
                <p class="text-blue-700 text-sm mt-1">Our Real Estate Services Make It Simple!</p>
            </div>

            <!-- Intro paragraph (fadeInUp equivalent — CSS animation) -->
            <p class="text-gray-600 text-base leading-relaxed animate-fade-in-up">
                Welcome to our Real Estate division — your dedicated property partner. Whether you're a first-time
                buyer, seasoned investor, or a business seeking commercial space, we provide end-to-end guidance
                so you can focus on your goals while we handle the complexities of the market.
            </p>
        </div>

        <!-- Right: service image -->
        <div class="flex justify-center">
            <img
                src="<?= APP_URL ?>/assets/images/real-estate-hero.webp"
                alt="Real Estate Services"
                loading="lazy"
                class="w-full max-w-sm rounded-2xl shadow-md object-cover"
                onerror="this.src='https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=600&q=80'; this.onerror=null;"
            >
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════
     3. TAGLINE STRIP  (animated-headline equivalent)
════════════════════════════════════════════════ -->
<section class="py-10 px-4 bg-white">
    <div class="max-w-4xl mx-auto text-center">
        <h3 class="text-2xl md:text-3xl font-semibold text-gray-800">
            At <span class="text-blue-600 font-bold">Our Firm</span>, we're not only
            <span class="relative inline-block">
                <span class="relative z-10 text-blue-600">just agents</span>
                <span class="absolute bottom-0 left-0 w-full h-2 bg-yellow-300 opacity-60 rounded"></span>
            </span>
        </h3>
    </div>
</section>

<!-- ═══════════════════════════════════════════════
     4. VALUES GRID — 3 points | SVG illustration
════════════════════════════════════════════════ -->
<section class="bg-gray-50 py-12 px-4">
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-10 items-center">

        <!-- Left: value points -->
        <ul class="flex flex-col gap-4 text-gray-700 text-base">
            <?php
            $values = [
                'We believe in honest, transparent property dealings.',
                'We respect your timeline and budget constraints.',
                'We stay current with market trends and legal regulations.',
            ];
            foreach ($values as $value): ?>
            <li class="flex items-start gap-3">
                <span class="mt-1 flex-shrink-0 w-5 h-5 rounded-full bg-blue-100 flex items-center justify-center">
                    <svg class="w-3 h-3 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </span>
                <?= esc($value) ?>
            </li>
            <?php endforeach; ?>
        </ul>

        <!-- Right: inline SVG illustration (property/investment themed) -->
        <div class="flex justify-center">
            <svg viewBox="0 0 200 180" class="w-64 h-auto" xmlns="http://www.w3.org/2000/svg" aria-label="Real estate illustration">
                <!-- House body -->
                <rect x="50" y="90" width="100" height="70" rx="4" fill="#DBEAFE"/>
                <!-- Roof -->
                <polygon points="40,90 100,40 160,90" fill="#3B82F6"/>
                <!-- Door -->
                <rect x="85" y="125" width="30" height="35" rx="3" fill="#1D4ED8"/>
                <!-- Window left -->
                <rect x="58" y="105" width="22" height="18" rx="2" fill="#93C5FD"/>
                <!-- Window right -->
                <rect x="120" y="105" width="22" height="18" rx="2" fill="#93C5FD"/>
                <!-- Chimney -->
                <rect x="120" y="52" width="12" height="28" fill="#60A5FA"/>
                <!-- Ground -->
                <rect x="30" y="160" width="140" height="6" rx="3" fill="#BFDBFE"/>
                <!-- Growth arrow -->
                <polyline points="20,155 40,130 65,140 90,110 120,120 155,80" stroke="#10B981" stroke-width="3" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                <polygon points="155,80 148,90 162,88" fill="#10B981"/>
                <!-- Dollar sign -->
                <text x="158" y="76" font-size="14" fill="#10B981" font-weight="bold">$</text>
            </svg>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════
     5. WHY CHOOSE US — alert | pain-point list
════════════════════════════════════════════════ -->
<section class="py-12 px-4 bg-white">
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-10 items-start">

        <!-- Left: "Why Choose Us" alert -->
        <div>
            <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg px-5 py-5" role="alert">
                <p class="font-bold text-blue-800 text-lg text-center">Why Choose Us?</p>
            </div>
        </div>

        <!-- Right: pain-point list -->
        <div>
            <h2 class="text-xl font-semibold text-gray-800 mb-4">You should consider hiring us if you:</h2>
            <ul class="list-disc list-inside space-y-2 text-gray-600 text-sm leading-relaxed">
                <li>Feel overwhelmed by property listings and legal paperwork.</li>
                <li>Worry about overpaying or underselling your property.</li>
                <li>Struggle to find verified tenants or reliable rental income.</li>
                <li>Want a trusted advisor for long-term real estate investment.</li>
            </ul>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════
     6. SERVICES DETAIL LIST
════════════════════════════════════════════════ -->
<section class="py-12 px-4 bg-gray-50">
    <div class="max-w-4xl mx-auto">

        <h3 class="text-2xl font-bold text-gray-900 mb-8">
            <a href="<?= APP_URL ?>/services" class="hover:text-blue-600 transition-colors">Our Best Services:</a>
        </h3>

        <?php
        $services = [
            [
                'title' => 'Property Buying Assistance',
                'body'  => 'We guide buyers through every step — from shortlisting properties and site visits to price negotiation and final registration. Our market intelligence ensures you never overpay.',
            ],
            [
                'title' => 'Property Selling & Valuation',
                'body'  => 'Accurate market valuations, professional listing photography, targeted marketing, and end-to-end negotiation support to help you sell faster and at the best price.',
            ],
            [
                'title' => 'Rental & Lease Management',
                'body'  => 'Tenant screening, lease drafting, rent collection, and property maintenance coordination — we manage your rental portfolio so you earn passive income without the hassle.',
            ],
            [
                'title' => 'Investment Advisory',
                'body'  => 'Data-driven insights on high-yield residential and commercial opportunities. We analyse ROI, rental yields, and capital appreciation potential before you commit a single rupee.',
            ],
            [
                'title' => 'Legal Documentation & Due Diligence',
                'body'  => 'Title verification, encumbrance checks, sale deed drafting, and registration support. We ensure every transaction is legally sound and free from hidden liabilities.',
            ],
            [
                'title' => 'Commercial Real Estate',
                'body'  => 'Office spaces, retail outlets, warehouses, and co-working solutions. We match businesses with the right commercial property to support growth and operational efficiency.',
            ],
            [
                'title' => 'NRI Property Services',
                'body'  => 'Dedicated support for Non-Resident Indians — property management, power of attorney assistance, repatriation guidance, and FEMA compliance for seamless remote ownership.',
            ],
            [
                'title' => 'Home Loan & Finance Assistance',
                'body'  => 'We partner with leading banks and NBFCs to help you secure the best home loan rates, process documentation, and get approvals faster — all under one roof.',
            ],
        ];
        foreach ($services as $service): ?>
        <div class="mb-8">
            <h4 class="text-lg font-bold text-gray-800 mb-2"><?= esc($service['title']) ?>:</h4>
            <p class="text-gray-600 text-sm leading-relaxed pl-4 border-l-2 border-blue-200">
                <?= esc($service['body']) ?>
            </p>
        </div>
        <?php endforeach; ?>

    </div>
</section>

<!-- ═══════════════════════════════════════════════
     7. COMMITMENT PARAGRAPH
════════════════════════════════════════════════ -->
<section class="py-10 px-4 bg-white">
    <div class="max-w-4xl mx-auto">
        <h4 class="text-xl font-bold text-gray-800 mb-3">Our Commitment</h4>
        <p class="text-gray-600 text-base leading-relaxed">
            We empower property buyers, sellers, and investors with fierce confidence in every decision.
            With our market clarity and high-level support, you can navigate the real estate landscape
            without feeling overwhelmed. Let's transform your property journey and achieve real financial
            freedom together!
        </p>
    </div>
</section>

<!-- ═══════════════════════════════════════════════
     8. CTA SECTION — dark bg, steps | image card
════════════════════════════════════════════════ -->
<section class="py-14 px-4 bg-gray-900">
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-10 items-center">

        <!-- Left: Get Started steps -->
        <div class="text-white">
            <h2 class="text-3xl font-bold mb-2">Get Started</h2>
            <h3 class="text-xl font-medium text-gray-300 mb-6">Ready to empower your property future?</h3>
            <h3 class="text-lg font-medium text-gray-300 mb-6">Here's how:</h3>

            <?php
            $steps = [
                ['label' => 'Schedule a Free Consultation:', 'detail' => "Let's discuss your property goals."],
                ['label' => 'Share Your Requirements:',      'detail' => 'Help us understand your budget and preferences.'],
                ['label' => 'Finally say goodbye to property stress', 'detail' => ''],
            ];
            foreach ($steps as $step): ?>
            <div class="mb-4">
                <h4 class="text-base font-semibold text-white">
                    <?= esc($step['label']) ?>
                    <?php if ($step['detail']): ?>
                    <span class="font-normal text-gray-300"> <?= esc($step['detail']) ?></span>
                    <?php endif; ?>
                </h4>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Right: CTA image card (mirrors Elementor call-to-action widget) -->
        <div class="relative rounded-2xl overflow-hidden shadow-2xl group">
            <img
                src="https://images.unsplash.com/photo-1582407947304-fd86f028f716?w=700&q=80"
                alt="Real Estate Consultation"
                loading="lazy"
                class="w-full h-72 object-cover transition-transform duration-500 group-hover:scale-105"
            >
            <!-- Overlay -->
            <div class="absolute inset-0 bg-black/50 flex flex-col items-center justify-center text-center px-6">
                <h2 class="text-white text-2xl font-bold mb-2">Free Consultation</h2>
                <p class="text-gray-200 text-sm mb-5">
                    Get Your Free Property Consultation Today — Start Simplifying Your Real Estate Journey!
                </p>
                <a href="<?= APP_URL ?>/contact"
                   class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-6 py-3 rounded-lg transition-colors">
                    Book Now
                </a>
            </div>

            <!-- Ribbon (mirrors Elementor ribbon) -->
            <div class="absolute top-4 right-0 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-l-full shadow">
                Free
            </div>
        </div>

    </div>
</section>
