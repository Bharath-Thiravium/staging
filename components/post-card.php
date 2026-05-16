<?php
// $post — WP REST API post object (with _embed)
$image   = App\Services\WordPressAPI::featuredImage($post);
$excerpt = App\Services\WordPressAPI::excerpt($post);
$url     = APP_URL . '/blog/' . $post['slug'];
?>
<article class="group flex flex-col gap-3">
    <?php if ($image): ?>
    <a href="<?= esc($url) ?>">
        <img src="<?= esc($image) ?>"
             alt="<?= esc($post['title']['rendered']) ?>"
             loading="lazy"
             class="w-full aspect-video object-cover rounded-lg group-hover:opacity-90 transition">
    </a>
    <?php endif; ?>

    <div class="flex flex-col gap-1">
        <time class="text-xs text-gray-400"><?= date('M j, Y', strtotime($post['date'])) ?></time>
        <h2 class="font-semibold text-lg leading-snug">
            <a href="<?= esc($url) ?>" class="hover:text-blue-600"><?= esc($post['title']['rendered']) ?></a>
        </h2>
        <p class="text-sm text-gray-500"><?= esc($excerpt) ?></p>
        <a href="<?= esc($url) ?>" class="text-sm text-blue-600 hover:underline mt-1">Read more →</a>
    </div>
</article>
