Add-Type -AssemblyName System.Drawing

$uploadsPath = "c:\Users\bhara\Downloads\staging\wp-content\uploads\2024\08"
$maxSize = 400

# Images to optimize
$images = @(
    "Ashok-Leyland-Logo.png",
    "64dcaf1f7e88f1f1ca3fe087_PROZEAL-GREEN-ENERGY_TM-LOGO.png"
)

function Optimize-Image($imagePath, $maxSize) {
    if (!(Test-Path $imagePath)) { return $false }
    
    $image = [System.Drawing.Image]::FromFile($imagePath)
    $width = $image.Width
    $height = $image.Height
    
    if ($width -le $maxSize -and $height -le $maxSize) {
        $image.Dispose()
        return $true
    }
    
    $ratio = [Math]::Min($maxSize / $width, $maxSize / $maxSize)
    $newWidth = [Math]::Round($width * $ratio)
    $newHeight = [Math]::Round($height * $ratio)
    
    $newImage = New-Object System.Drawing.Bitmap($newWidth, $newHeight)
    $graphics = [System.Drawing.Graphics]::FromImage($newImage)
    $graphics.InterpolationMode = [System.Drawing.Drawing2D.InterpolationMode]::HighQualityBicubic
    $graphics.DrawImage($image, 0, 0, $newWidth, $newHeight)
    
    $optimizedPath = $imagePath -replace "\.png$", "-optimized.png"
    $newImage.Save($optimizedPath, [System.Drawing.Imaging.ImageFormat]::Png)
    
    $image.Dispose()
    $newImage.Dispose()
    $graphics.Dispose()
    
    return $optimizedPath
}

Write-Host "Starting image optimization..." -ForegroundColor Green

foreach ($image in $images) {
    $imagePath = Join-Path $uploadsPath $image
    $result = Optimize-Image $imagePath $maxSize
    
    if ($result) {
        Write-Host "✅ Optimized: $image" -ForegroundColor Green
    } else {
        Write-Host "⚠️ Failed: $image" -ForegroundColor Yellow
    }
}

# Remove large files
$largeFiles = Get-ChildItem $uploadsPath -Filter "*-1536x*.png" -ErrorAction SilentlyContinue
$largeFiles += Get-ChildItem $uploadsPath -Filter "*-2048x*.png" -ErrorAction SilentlyContinue

foreach ($file in $largeFiles) {
    Remove-Item $file.FullName -Force
}

Write-Host "🗑️ Removed $($largeFiles.Count) large files" -ForegroundColor Cyan
Write-Host "✅ Optimization complete!" -ForegroundColor Green