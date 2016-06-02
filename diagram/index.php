<?php

// introduce into font description
$delta = array(
    "alpha" => 0,
    "alpha2" => -7,
    "aventurer" => 0,
    "berlin" => 0,
    "case" => 0,
    "cheq" => -4,
    "chess7" => 0,
    "goodcompanions" => -7,
    "hastings" => -8,
    "isdiagram" => 0,
    "kingdom" => 0,
    "leipzig" => 0,
    "mark" => 0,
    "marroquin" => 0,
    "maya" => 0,
    "merida" => 0,
    "milenia" => 0,
    "motif" => 0,
    "spsl" => -8,
    "usual" => 0,
);

$fen = filter_input(INPUT_GET, "fen");
if ($fen === false) {
    exit("<b>using</b>:<br />index.php?fen=&lt;FEN&gt;");
}

$size = filter_input(INPUT_GET, 'size', FILTER_VALIDATE_INT, array("options" => array(
        "default" => 30,
        "min_range" => 10,
        "max_range" => 512
        )));
$style = filter_input(INPUT_GET, "style", FILTER_DEFAULT, array("options" => array("default" => "alpha")));
$solid = filter_input(INPUT_GET, "solid", FILTER_VALIDATE_BOOLEAN, array("options" => array("default" => false)));
$color = filter_input(INPUT_GET, "color", FILTER_DEFAULT, array("options" => array("default" => "black")));

if (file_exists("./font-desc/{$style}.php")) {
    include_once("./font-desc/{$style}.php");
} else {
    include_once("./font-desc/alpha.php");
}

//conversion pixel -> millimeter at 72 dpi
function px2mm($px) {
    return $px * 25.4 / 72;
}

//conversion millimeter at 72 dpi -> pixel
function mm2px($mm) {
    return $mm * 72 / 25.4;
}

//conversion pixel -> point
function px2pt($px) {
    return $px * 3 / 4;
}

//conversion point -> pixel
function pt2px($pt) {
    return $pt * 4 / 3;
}

function is_correct_epd($epd) {
    $len = strlen($epd);
    $fields = 0;
    for ($i = 0; $i < $len; $i++) {
        if (strpos("12345678", $epd{$i}) !== false) {
            $fields +=$epd{$i};
        } elseif (strpos("kqrbnpKQRBNPX", $epd{$i}) !== false) {
            $fields++;
        } elseif ($epd{$i} === '/') {
            
        } else {
            $fields +=100;
        }
    }
    return $fields === 64;
}

function fen2board($fen, $solid) {
    global $simbols;
    // cut the tail if exist
    $parts = explode(" ", $fen);
    $epd = $parts[0];

    // fen string verifying
    if (is_correct_epd($epd) === true) {
        $fen = "8/8/8/8/8/8/8/8";
    }
    $len = strlen($epd);

    // building diagram
    $boardline = "";

    $fields = 0;
    for ($i = 0; $i < $len; $i++) {
        if (strpos("kqrbnpKQRBNPX", $epd{$i}) !== false) {
            $posy = $fields >> 3;
            $posx = $fields % 8;

            $index = ($posy % 2 == $posx % 2) ? "0" : "1";
            $boardline .= $simbols[$style][$epd{$i} . $index];
            if (($fields + 1) % 8 === 0) {
                $board[] = ($solid === true) ? strtolower($boardline) : $boardline;
                $boardline = "";
            }
            $fields++;
        } elseif ($epd{$i} > "0" and $epd{$i} < "9") {
            for ($j = 0; $j < $epd{$i}; $j++) {
                $posy = $fields >> 3;
                $posx = $fields % 8;
                if ($solid === true) {
                    $boardline .= $simbols[$style]["-"];
                } else {
                    $boardline .= ($posy % 2 === $posx % 2) ? $simbols[$style]["-"] : $simbols[$style]["+"];
                }
                if (($fields + 1) % 8 === 0) {
                    //$board[] = $boardline;
                    $board[] = ($solid === true) ? strtolower($boardline) : $boardline;
                    $boardline = "";
                }
                $fields++;
            }
        }
    }

    return $board;
}

function board2diag($board, $size, $color, $solid) {
    global $style;
    $diagram = imagecreatetruecolor($size * 8 + 7, $size * 8 + 7);

    $colors = array(
        "black" => imagecolorallocate($diagram, 0, 0, 0),
        "red" => imagecolorallocate($diagram, 255, 0, 0),
        "green" => imagecolorallocate($diagram, 0, 255, 0),
        "blue" => imagecolorallocate($diagram, 0, 0, 255),
        "gray" => imagecolorallocate($diagram, 127, 127, 127),
        "darkred" => imagecolorallocate($diagram, 127, 0, 0),
        "darkgreen" => imagecolorallocate($diagram, 0, 127, 0),
        "darkblue" => imagecolorallocate($diagram, 0, 0, 127),
        "white" => imagecolorallocate($diagram, 255, 255, 255),
        "blackshift" => imagecolorallocate($diagram, 127, 127, 127),
        "redshift" => imagecolorallocate($diagram, 255, 127, 127),
        "greenshift" => imagecolorallocate($diagram, 127, 255, 127),
        "blueshift" => imagecolorallocate($diagram, 127, 127, 255),
        "grayshift" => imagecolorallocate($diagram, 196, 196, 196),
        "darkredshift" => imagecolorallocate($diagram, 196, 127, 127),
        "darkgreenshift" => imagecolorallocate($diagram, 127, 196, 127),
        "darkblueshift" => imagecolorallocate($diagram, 127, 127, 196)
    );

    imagefill($diagram, 0, 0, $colors[$color]);
    imagefilledrectangle(
            $diagram, 2, 2, $size * 8 + 4, $size * 8 + 4, $colors["white"]);

    imagefilledrectangle(
            $diagram, 3, 3, $size * 8 + 3, $size * 8 + 3, $colors[$color]);
    imagefilledrectangle(
            $diagram, 4, 4, $size * 8 + 2, $size * 8 + 2, $colors["white"]);

    if ($solid === true) {
        for ($i = 0; $i != 8; ++$i) {
            for ($j = 0; $j !== 8; ++$j) {
                if ($i % 2 !== $j % 2) {
                    imagefilledrectangle(
                            $diagram, $i * $size + 3, $j * $size + 3, ($i + 1) * $size + 3, ($j + 1) * $size + 3, $colors[$color . "shift"]);
                } else {
                    imagefilledrectangle(
                            $diagram, $i * $size + 3, $j * $size + 3, ($i + 1) * $size + 3, ($j + 1) * $size + 3, $colors["white"]);
                }
            }
        }
    }

    foreach ($board as $index => $line) {
        //imagefttext($diagram, px2pt($size), 0, 0, ($index + 1) * $size, $colors[$color], "./fonts/$style.ttf", $line);
        imagefttext($diagram, px2pt($size), 0, 3, ($index + 1) * $size + 3 + $simbols["delta"], $colors[$color], "./fonts/$style.ttf", $line);
    }
    return $diagram;
}

function fen2diag($fen, $size, $color, $solid) {
    global $style;
    $board = fen2board($fen, $style, $solid);
    $diagram = board2diag($board, $style, $size, $color, $solid);

    return $diagram;
}

$src = fen2diag($fen, $style, $size, $color, $solid);

header('Content-type: image/png');
imagepng($src);
