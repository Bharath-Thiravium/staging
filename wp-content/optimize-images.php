<?php
/**
 * Image Optimization Script
 * Resizes oversized images and optimizes file structure
 */

// Configuration
$upload_dir = wp_upload_dir();
$base_path = $upload_dir['basedir'] . '/2024/08/';
$max_logo_size = 400;

// Images to optimize (oversized ones)
$images_to_optimize = [
    'Ashok-Leyland-Logo.png',
    '64dcaf1f7e88f1f1ca3fe087_PROZEAL-GREEN-ENERGY_TM-LOGO.png'
];

function optimize_image($file_path, $max_size) {
    if (!file_exists($file_path)) return false;
    
    $image_info = getimagesize($file_path);
    if (!$image_info) return false;
    
    $width = $image_info[0];
    $height = $image_info[1];
    
    // Skip if already optimized
    if ($width <= $max_size && $height <= $max_size) return true;
    
    // Calculate new dimensions maintaining aspect ratio
    $ratio = min($max_size / $width, $max_size / $height);
    $new_width = round($width * $ratio);
    $new_height = round($height * $ratio);
    
    // Create new image
    $source = imagecreatefrompng($file_path);
    $optimized = imagecreatetruecolor($new_width, $new_height);
    
    // Preserve transparency
    imagealphablending($optimized, false);
    imagesavealpha($optimized, true);
    
    // Resize
    imagecopyresampled($optimized, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    
    // Save optimized version
    $optimized_path = str_replace('.png', '-optimized.png', $file_path);
    imagepng($optimized, $optimized_path, 9);
    
    // Cleanup
    imagedestroy($source);
    imagedestroy($optimized);
    
    return $optimized_path;
}

function cleanup_large_files($base_path) {
    $files_to_remove = [];
    
    // Remove files larger than 1536px (keep up to 768px versions)
    $patterns = [
        '*-1536x*.png',
        '*-2048x*.png'
    ];
    
    foreach ($patterns as $pattern) {
        $files = glob($base_path . $pattern);
        $files_to_remove = array_merge($files_to_remove, $files);
    }
    
    foreach ($files_to_remove as $file) {
        if (file_exists($file)) {
            unlink($file);
        }
    }
    
    return count($files_to_remove);
}

// Execute optimization
echo "Starting image optimization...\n";

foreach ($images_to_optimize as $image) {
    $file_path = $base_path . $image;
    $result = optimize_image($file_path, $max_logo_size);
    
    if ($result) {
        echo "✅ Optimized: $image\n";
    } else {
        echo "⚠️ Failed to optimize: $image\n";
    }
}

// Cleanup large files
$removed_count = cleanup_large_files($base_path);
echo "🗑️ Removed $removed_count large files\n";

echo "✅ Optimization complete!\n";
?>