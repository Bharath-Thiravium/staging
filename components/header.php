<header class="border-b border-gray-100 sticky top-0 bg-white z-50">
    <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
        <a href="<?= APP_URL ?>/" class="text-xl font-bold tracking-tight">MySite</a>
        <?php (new App\Core\View())->component('nav') ?>
    </div>
</header>
