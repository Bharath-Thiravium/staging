<section class="max-w-6xl mx-auto px-4 py-12">
    <h1 class="text-4xl font-bold mb-10"><?= esc($title) ?></h1>

    <?php if (empty($posts)): ?>
        <p class="text-gray-400">No posts found.</p>
    <?php else: ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($posts as $post): ?>
            <?php (new App\Core\View())->component('post-card', ['post' => $post]) ?>
        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <div class="flex gap-4 mt-12 justify-center text-sm">
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>" class="px-4 py-2 border rounded hover:bg-gray-50">← Prev</a>
        <?php endif; ?>
        <?php if (count($posts) >= 9): ?>
            <a href="?page=<?= $page + 1 ?>" class="px-4 py-2 border rounded hover:bg-gray-50">Next →</a>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</section>
