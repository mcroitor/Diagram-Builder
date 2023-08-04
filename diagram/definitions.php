<?php

const LIBRARY_PATH = __DIR__ . "/";
const DOTS_PER_INCH = 300;
const MM_PER_INCH = 25.4;

$colors = [
    "black" => [0, 0, 0],
    "red" => [255, 0, 0],
    "green" => [0, 255, 0],
    "blue" => [0, 0, 255],
    "gray" => [127, 127, 127],
    "darkred" => [127, 0, 0],
    "darkgreen" => [0, 127, 0],
    "darkblue" => [0, 0, 127],
    "white" => [255, 255, 255],
    "blackshift" => [159, 159, 159],
    "redshift" => [255, 159, 159],
    "greenshift" => [159, 255, 159],
    "blueshift" => [159, 159, 255],
    "grayshift" => [196, 196, 196],
    "darkredshift" => [196, 159, 159],
    "darkgreenshift" => [159, 196, 159],
    "darkblueshift" => [159, 159, 196],
    "olive" => [127, 127, 0],
    "oliveshift" => [196, 196, 159],
    "armygreen" => [75, 83, 32],
    "armygreenshift" => [75 + 127, 83 + 127, 32 + 127],
    "indigo" => [75, 0, 130],
    "indigoshift" => [75 + 127, 0 + 127, 255]
];

$symbols = [];

/**
 * conversion pixel -> millimeter
 * @param float $px
 * @param float $dpi = default 300px
 * @return float
 */
function px2mm($px, $dpi = DOTS_PER_INCH)
{
    return $px * MM_PER_INCH / $dpi;
}

/**
 * conversion millimeter -> pixel
 * @param float $px
 * @param float $dpi = default 300px
 * @return float
 */
function mm2px($mm, $dpi = DOTS_PER_INCH)
{
    return $mm * $dpi / MM_PER_INCH;
}

/**
 * conversion pixel -> point
 * @param float $px
 * @return float
 */
function px2pt($px)
{
    return $px * 3 / 4;
}

/**
 * conversion point -> pixel
 * @param float $px
 * @return float
 */
function pt2px($pt)
{
    return $pt * 4 / 3;
}

/**
 * crop image
 * @param GdImage $img
 * @return GdImage
 */
function crop($img)
{
    //find the size of the borders
    $b_top = 0;
    $b_btm = 0;
    $b_lft = 0;
    $b_rt = 0;

    //top
    for (; $b_top < imagesy($img); ++$b_top) {
        for ($x = 0; $x < imagesx($img); ++$x) {
            if (imagecolorat($img, $x, $b_top) != 0xFFFFFF) {
                break 2; //out of the 'top' loop
            }
        }
    }

    //bottom
    for (; $b_btm < imagesy($img); ++$b_btm) {
        for ($x = 0; $x < imagesx($img); ++$x) {
            if (imagecolorat($img, $x, imagesy($img) - $b_btm - 1) != 0xFFFFFF) {
                break 2; //out of the 'bottom' loop
            }
        }
    }

    //left
    for (; $b_lft < imagesx($img); ++$b_lft) {
        for ($y = 0; $y < imagesy($img); ++$y) {
            if (imagecolorat($img, $b_lft, $y) != 0xFFFFFF) {
                break 2; //out of the 'left' loop
            }
        }
    }

    //right
    for (; $b_rt < imagesx($img); ++$b_rt) {
        for ($y = 0; $y < imagesy($img); ++$y) {
            if (imagecolorat($img, imagesx($img) - $b_rt - 1, $y) != 0xFFFFFF) {
                break 2; //out of the 'right' loop
            }
        }
    }

    //copy the contents, excluding the border
    $newimg = imagecreatetruecolor(
        imagesx($img) - ($b_lft + $b_rt),
        imagesy($img) - ($b_top + $b_btm)
    );
    imageresolution($newimg, DOTS_PER_INCH);

    imagecopy($newimg, $img, 0, 0, $b_lft, $b_top, imagesx($newimg), imagesy($newimg));
    return $newimg;
}

// scan font description folder
function fontDescScan() {
    global $symbols;
    $path = LIBRARY_PATH . "/font-desc/";
    $files = scandir($path);

    foreach($files as $file) {
        if(strstr($file, ".php") !== false && is_file($path . "/{$file}")) {
            include_once $path . "/{$file}";
        }
    }
}

fontDescScan();
