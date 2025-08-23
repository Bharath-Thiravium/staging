$uploadsPath = "c:\Users\bhara\Downloads\staging\wp-content\uploads\2024\08"

# Use existing 300x300 versions as optimized versions
$optimizations = @{
    "Ashok-Leyland-Logo.png" = "Ashok-Leyland-Logo-300x188.png"
    "64dcaf1f7e88f1f1ca3fe087_PROZEAL-GREEN-ENERGY_TM-LOGO.png" = "64dcaf1f7e88f1f1ca3fe087_PROZEAL-GREEN-ENERGY_TM-LOGO-300x300.png"
}

Write-Host "Using existing optimized versions..." -ForegroundColor Green

foreach ($original in $optimizations.Keys) {
    $optimized = $optimizations[$original]
    $originalPath = Join-Path $uploadsPath $original
    $optimizedPath = Join-Path $uploadsPath $optimized
    
    if (Test-Path $optimizedPath) {
        Copy-Item $optimizedPath ($originalPath -replace "\.png$", "-optimized.png")
        Write-Host "✅ Created optimized version: $original" -ForegroundColor Green
    }
}

Write-Host "✅ Optimization complete using existing WordPress thumbnails!" -ForegroundColor Green