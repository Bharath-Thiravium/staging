<?php

namespace App\Modules\Home;

use App\Core\View;
use App\Services\WordPressAPI;

class HomeController
{
    public function index(array $params = []): void
    {
        $api   = new WordPressAPI();
        $posts = $api->getPosts(['per_page' => 6]);

        (new View())->render('modules/home/views/home.php', [
            'title'       => 'Home',
            'description' => 'Welcome to our site',
            'posts'       => $posts,
        ]);
    }
}
