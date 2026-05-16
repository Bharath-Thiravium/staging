<?php

namespace App\Modules\Blog;

use App\Core\View;
use App\Services\WordPressAPI;

class BlogController
{
    private WordPressAPI $api;
    private View $view;

    public function __construct()
    {
        $this->api  = new WordPressAPI();
        $this->view = new View();
    }

    public function index(array $params = []): void
    {
        $page  = max(1, (int) ($_GET['page'] ?? 1));
        $posts = $this->api->getPosts(['per_page' => 9, 'page' => $page]);

        $this->view->render('modules/blog/views/index.php', [
            'title' => 'Blog',
            'posts' => $posts,
            'page'  => $page,
        ]);
    }

    public function single(array $params): void
    {
        $post = $this->api->getPost($params['slug']);

        if (!$post) {
            http_response_code(404);
            $this->view->render('templates/404.php', []);
            return;
        }

        $seo = WordPressAPI::seoMeta($post);

        $this->view->render('modules/blog/views/single.php', [
            'title'       => $seo['title'],
            'description' => $seo['description'],
            'og_image'    => $seo['og_image'],
            'post'        => $post,
        ]);
    }

    public function category(array $params): void
    {
        $categories = $this->api->getCategories();
        $category   = current(array_filter($categories, fn($c) => $c['slug'] === $params['slug']));

        if (!$category) {
            http_response_code(404);
            return;
        }

        $posts = $this->api->getPostsByCategory($category['id']);

        $this->view->render('modules/blog/views/index.php', [
            'title' => 'Category: ' . esc($category['name']),
            'posts' => $posts,
            'page'  => 1,
        ]);
    }
}
