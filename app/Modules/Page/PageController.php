<?php

namespace App\Modules\Page;

use App\Core\View;
use App\Services\WordPressAPI;

class PageController
{
    public function show(array $params): void
    {
        $api  = new WordPressAPI();
        $page = $api->getPage($params['slug']);

        if (!$page) {
            http_response_code(404);
            (new View())->render('templates/404.php', []);
            return;
        }

        $seo = WordPressAPI::seoMeta($page);

        (new View())->render('modules/page/views/page.php', [
            'title'       => $seo['title'],
            'description' => $seo['description'],
            'page'        => $page,
        ]);
    }
}
