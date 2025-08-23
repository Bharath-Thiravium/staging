<?php
/**
 * Automatic Image Optimization Pipeline
 * Add to functions.php or as a plugin
 */

// Hook into WordPress upload process
add_filter('wp_handle_upload', 'auto_optimize_uploaded_image');

function auto_optimize_uploaded_image($upload) {
    $file_path = $upload['file'];
    $file_type = $upload['type'];
    
    // Only process images
    if (!str_starts_with($file_type, 'image/')) {
        return $upload;
    }
    
    // Get image info
    $image_info = getimagesize($file_path);
    if (!$image_info) return $upload;
    
    $width = $image_info[0];
    $height = $image_info[1];
    
    // Auto-resize if too large (over 800px for logos)
    if ($width > 800 || $height > 800) {
        optimize_large_image($file_path, 800);
    }
    
    return $upload;
}

function optimize_large_image($file_path, $max_size) {
    $image_info = getimagesize($file_path);
    $width = $image_info[0];
    $height = $image_info[1];
    $mime_type = $image_info['mime'];
    
    // Calculate new dimensions
    $ratio = min($max_size / $width, $max_size / $height);
    $new_width = round($width * $ratio);
    $new_height = round($height * $ratio);
    
    // Create image resource based on type
    switch ($mime_type) {
        case 'image/jpeg':
            $source = imagecreatefromjpeg($file_path);
            break;
        case 'image/png':
            $source = imagecreatefrompng($file_path);
            break;
        case 'image/webp':
            $source = imagecreatefromwebp($file_path);
            break;
        default:
            return false;
    }
    
    if (!$source) return false;
    
    // Create optimized image
    $optimized = imagecreatetruecolor($new_width, $new_height);
    
    // Preserve transparency for PNG/WebP
    if ($mime_type === 'image/png' || $mime_type === 'image/webp') {
        imagealphablending($optimized, false);
        imagesavealpha($optimized, true);
    }
    
    // Resize
    imagecopyresampled($optimized, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    
    // Save back to original file
    switch ($mime_type) {
        case 'image/jpeg':
            imagejpeg($optimized, $file_path, 85);
            break;
        case 'image/png':
            imagepng($optimized, $file_path, 9);
            break;
        case 'image/webp':
            imagewebp($optimized, $file_path, 85);
            break;
    }
    
    // Cleanup
    imagedestroy($source);
    imagedestroy($optimized);
    
    return true;
}

// Add WebP support
add_filter('upload_mimes', 'add_webp_support');
function add_webp_support($mimes) {
    $mimes['webp'] = 'image/webp';
    return $mimes;
}
?>