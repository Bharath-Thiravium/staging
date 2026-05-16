<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Site') ?></title>
    <?php if (!empty($description)): ?>
    <meta name="description" content="<?= esc($description) ?>">
    <?php endif; ?>
    <?php if (!empty($og_image)): ?>
    <meta property="og:image" content="<?= esc($og_image) ?>">
    <?php endif; ?>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/app.css">
</head>
<body class="bg-white text-gray-800 font-sans">

<?php (new App\Core\View())->component('header') ?>

<main class="min-h-screen">
    <?= $content ?>
</main>

<?php (new App\Core\View())->component('footer') ?>

<script src="<?= APP_URL ?>/assets/js/app.js"></script>
</body>
</html>
