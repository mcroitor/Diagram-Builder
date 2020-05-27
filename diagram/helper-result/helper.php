<?php

$courier_font =  realpath('../cour.ttf');

function px2pt($px) {
    return $px * 3 / 4;
}

$w = 24;
$h = 24;
$nr_cols = 16;
$nr_rows = 16;

foreach (glob("../fonts/*.ttf") as $font) {
    $font_name = str_replace("../fonts/", "", $font);
    $font_name = str_replace(".ttf", "", $font_name);
    // create image (5x16) x 16
    $image = imagecreatetruecolor(4 * $w * $nr_cols, $h * $nr_rows);
    $dark_color = imagecolorallocate($image, 0, 0, 0);
    $light_color = imagecolorallocate($image, 255, 255, 255);
    imagefill($image, 0, 0, $light_color);
    for ($i = 0; $i < $nr_cols; ++$i) {
        imageline($image, 4 * $i * $w, 0, 4 * $i * $w, $h * $nr_rows, $dark_color);
    }
    for ($i = 0; $i < $nr_rows; ++$i) {
        imageline($image, 0, $i * $h, 4 * $w * $nr_cols, $i * $h, $dark_color);
    }
    // each 5x1 contains {code (3 pos), symbol courier (1 pos), symbol font (1 pos)}
    // starts from 32 to 255
    for ($i = 32; $i < 256; ++$i) {
        imagefttext($image
                , px2pt($w)
                , 0
                , 4 * intval($i % $nr_cols) * $w
                , intval($i / $nr_cols) * $h
                , $dark_color
                , $courier_font
                , $i);
        imagefttext($image
                , px2pt($w)
                , 0
                , 4 * intval($i % $nr_cols) * $w + 2 * $w
                , intval($i / $nr_cols) * $h
                , $dark_color
                , $courier_font
                , chr($i));
        imagefttext($image
                , px2pt($w)
                , 0
                , 4 * intval($i % $nr_cols) * $w + 3 * $w
                , intval($i / $nr_cols) * $h
                , $dark_color
                , realpath("../fonts/{$font_name}.ttf")
                , chr($i));
    }

    $file_location = "./{$font_name}.png";
    imagepng($image, $file_location, 0, NULL);
    echo "template created for font <a href='{$file_location}'><b>{$font_name}</b></a><br />";
}

