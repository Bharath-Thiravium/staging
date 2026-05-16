<?php

namespace App\Modules\RealEstate;

use App\Core\View;

class RealEstateController
{
    public function show(array $params = []): void
    {
        (new View())->render('modules/real-estate/views/real-estate.php', [
            'title'       => 'Real Estate Services — Buy, Sell & Invest with Confidence',
            'description' => 'Expert real estate services including property buying, selling, investment advisory, legal documentation, and rental management.',
            'og_image'    => APP_URL . '/assets/images/real-estate-og.jpg',
        ]);
    }
}
