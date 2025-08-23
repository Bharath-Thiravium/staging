@echo off
echo Starting WordPress Image Optimizations...
echo.

cd /d "c:\Users\bhara\Downloads\staging"

echo 1. Running image optimization...
php wp-content\optimize-images.php

echo.
echo 2. Clearing all caches...
php wp-content\themes\cache-clear.php

echo.
echo 3. Optimization complete!
echo.
echo Next steps:
echo - Test your website on mobile and desktop
echo - Run PageSpeed Insights
echo - Add image-optimization-pipeline.php to your theme's functions.php
echo.
pause