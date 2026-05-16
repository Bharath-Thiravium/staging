<section class="max-w-6xl mx-auto px-4 py-16">
    <!-- Hero -->
    <div class="text-center mb-16">
        <h1 class="text-5xl font-bold tracking-tight mb-4">Welcome to MySite</h1>
        <p class="text-xl text-gray-500 max-w-xl mx-auto">Fresh ideas, delivered.</p>
        <a href="<?= APP_URL ?>/blog"
           class="mt-6 inline-block bg-black text-white px-6 py-3 rounded-lg hover:bg-gray-800 transition">
            Read the Blog
        </a>
    </div>

    <!-- Latest Posts -->
    <?php if (!empty($posts)): ?>
    <h2 class="text-2xl font-semibold mb-8">Latest Posts</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($posts as $post): ?>
            <?php (new App\Core\View())->component('post-card', ['post' => $post]) ?>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</section>
