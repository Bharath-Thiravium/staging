<?php
$image = App\Services\WordPressAPI::featuredImage($post);
?>
<article class="max-w-3xl mx-auto px-4 py-12">

    <?php if ($image): ?>
    <img src="<?= esc($image) ?>"
         alt="<?= esc($post['title']['rendered']) ?>"
         class="w-full aspect-video object-cover rounded-xl mb-8">
    <?php endif; ?>

    <header class="mb-8">
        <time class="text-sm text-gray-400"><?= date('F j, Y', strtotime($post['date'])) ?></time>
        <h1 class="text-4xl font-bold mt-2 leading-tight"><?= $post['title']['rendered'] ?></h1>
    </header>

    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
        <?= $post['content']['rendered'] ?>
    </div>

    <footer class="mt-12 pt-6 border-t border-gray-100">
        <a href="<?= APP_URL ?>/blog" class="text-sm text-blue-600 hover:underline">← Back to Blog</a>
    </footer>

</article>
