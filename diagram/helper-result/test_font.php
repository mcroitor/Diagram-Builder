<?php

$courierFont =  realpath(__DIR__ . '/../cour.ttf');

function px2pt($px)
{
    return $px * 3 / 4;
}

$w = 32;
$h = 32;
$nr_cols = 16;
$nr_rows = 16;

$fontName = $_GET["font"] ?? "goodcompanions";

$fontFile = __DIR__ . "/../fonts/{$fontName}.ttf";

// create image (5x16) x 16
$image = imagecreatetruecolor(4 * $w * $nr_cols, $h * $nr_rows);
imageresolution($image, 300);
$darkColor = imagecolorallocate($image, 0, 0, 0);
$lightColor = imagecolorallocate($image, 255, 255, 255);
imagefill($image, 0, 0, $lightColor);
for ($i = 0; $i < $nr_cols; ++$i) {
    imageline($image, 4 * $i * $w, 0, 4 * $i * $w, $h * $nr_rows, $darkColor);
}
for ($i = 0; $i < $nr_rows; ++$i) {
    imageline($image, 0, $i * $h, 4 * $w * $nr_cols, $i * $h, $darkColor);
}
// each 5x1 contains {code (3 pos), symbol courier (1 pos), symbol font (1 pos)}
// starts from 32 to 255
for ($i = 32; $i < 256; ++$i) {
    imagefttext(
        $image,
        px2pt($w),
        0,
        4 * intval($i % $nr_cols) * $w,
        intval($i / $nr_cols) * $h,
        $darkColor,
        $courierFont,
        "" . $i
    );
    imagefttext(
        $image,
        px2pt($w),
        0,
        4 * intval($i % $nr_cols) * $w + 3 * $w,
        intval($i / $nr_cols) * $h,
        $darkColor,
        realpath($fontFile),
        "" . chr($i)
    );
}

header('Content-type: image/png');
imagepng($image);
