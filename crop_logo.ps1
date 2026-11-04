Add-Type -AssemblyName System.Drawing
$imgPath = (Resolve-Path "public/assets/images/nucelora-logo.png").Path
$bmp = [System.Drawing.Bitmap]::new($imgPath)

$minX = $bmp.Width
$minY = $bmp.Height
$maxX = 0
$maxY = 0

for ($y = 0; $y -lt $bmp.Height; $y++) {
    for ($x = 0; $x -lt $bmp.Width; $x++) {
        $c = $bmp.GetPixel($x, $y)
        # Check if non-white
        if ($c.A -gt 20 -and ($c.R -lt 245 -or $c.G -lt 245 -or $c.B -lt 245)) {
            if ($x -lt $minX) { $minX = $x }
            if ($x -gt $maxX) { $maxX = $x }
            if ($y -lt $minY) { $minY = $y }
            if ($y -gt $maxY) { $maxY = $y }
        }
    }
}

Write-Output "Found: minX=$minX, minY=$minY, maxX=$maxX, maxY=$maxY"

# Add small padding
$pad = 12
$cropX = [Math]::Max(0, $minX - $pad)
$cropY = [Math]::Max(0, $minY - $pad)
$cropW = [Math]::Min($bmp.Width - $cropX, ($maxX - $minX) + ($pad * 2))
$cropH = [Math]::Min($bmp.Height - $cropY, ($maxY - $minY) + ($pad * 2))

$rect = [System.Drawing.Rectangle]::new($cropX, $cropY, $cropW, $cropH)
$cropped = $bmp.Clone($rect, $bmp.PixelFormat)

$outPath = Resolve-Path "public/assets/images"
$cropped.Save("$outPath/nucelora-logo-cropped.png", [System.Drawing.Imaging.ImageFormat]::Png)

$bmp.Dispose()
$cropped.Dispose()
Write-Output "Saved cropped logo successfully: cropW=$cropW, cropH=$cropH"
