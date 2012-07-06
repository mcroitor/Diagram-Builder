<?php

if (!isset($_GET["fen"])) {
    exit("<b>using</b>:<br />index.php?fen=&lt;FEN&gt;");
}

$size = (isset($_GET["size"]) && ((int) $_GET["size"]) > 0) ? $_GET["size"] : 22;
$style = isset($_GET["style"]) ? $_GET["style"] : "alpha";

$color = isset($_GET["color"]) ? $_GET["color"] : "black";

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

function fen2board($fen, $style = "alpha") {
    $alpha = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h');
    $num = array('1', '2', '3', '4', '5', '6', '7', '8');
    if (file_exists("./font-desc/{$style}.php"))
        require_once("./font-desc/{$style}.php");
    else
        require_once("./font-desc/alpha.php");

    // cut the tail if exist
    $parts = explode(" ", $fen);
    $fen = $parts[0];
    $len = strlen($fen);
    // fen string verifying
    $fields = 0;
    for ($i = 0; $i < $len; $i++) {
        if (strpos("12345678", $fen{$i}) !== false)
            $fields +=$fen{$i};
        elseif (strpos("kqrbnpKQRBNPX", $fen{$i}) !== false)
            $fields++;
        elseif ($fen{$i} === '/') {
            
        }
        else
            $fields +=100;
    }
    if ($fields > 64) {
        $fen = "8/8/8/8/8/8/8/8";
        $len = strlen($fen);
    }

    // building diagram
    $board = array($simbols[$style]["top"]);
    $boardline = "";

    $fields = 0;
    for ($i = 0; $i < $len; $i++) {
        if (strpos("kqrbnpKQRBNPX", $fen{$i}) !== false) {
            $posy = $fields >> 3;
            $posx = $fields % 8;

            $index = ($posy % 2 == $posx % 2) ? "0" : "1";
            $boardline .= $simbols[$style][$fen{$i} . $index];
            if (($fields + 1) % 8 == 0) {
                $board[] = $simbols[$style][$num[$posy]] . $boardline . $simbols[$style]["|"];
                $boardline = ""; //"I"
            }
            $fields++;
        } elseif ($fen{$i} > "0" and $fen{$i} < "9") {
            for ($j = 0; $j < $fen{$i}; $j++) {
                $posy = $fields >> 3;
                $posx = $fields % 8;
                $boardline .= ($posy % 2 == $posx % 2) ? $simbols[$style]["-"] : $simbols[$style]["+"];
                if (($fields + 1) % 8 == 0) {

                    $board[] = $simbols[$style][$num[$posy]] . $boardline . $simbols[$style]["|"];
                    $boardline = "";
                }
                $fields++;
            }
        }
    }

    $board[] = $simbols[$style]["bottom"];
    return $board;
}

function board2diag($board, $style, $size, $color) {
    $delta = ($style == "spsl" or $style == "alpha2") ? $size / 2 : 0;
    $diagram = imagecreatetruecolor($size * 10, $size * 10 + $delta);

    $colors = array(
        "black"     => imagecolorallocate($diagram, 0, 0, 0),
        "red"       => imagecolorallocate($diagram, 255, 0, 0),
        "green"     => imagecolorallocate($diagram, 0, 255, 0),
        "blue"      => imagecolorallocate($diagram, 0, 0, 255),
        "gray"      => imagecolorallocate($diagram, 127, 127, 127),
        "darkred"   => imagecolorallocate($diagram, 127, 0, 0),
        "darkgreen" => imagecolorallocate($diagram, 0, 127, 0),
        "darkblue"  => imagecolorallocate($diagram, 0, 0, 127),
        "white"     => imagecolorallocate($diagram, 255, 255, 255)
    );

    imagefill($diagram, 0, 0, $colors["white"]);
    if (!file_exists("./fonts/$style.ttf"))
        $style = "alpha";
    foreach ($board as $index => $line) {
        imagefttext($diagram, px2pt($size), 0, 0, ($index + 1) * $size, $colors[$color], "./fonts/$style.ttf", $line);
    }
    return $diagram;
}

function fen2diag($fen, $style = "alpha", $size = 23, $color = "black") {
    $board = fen2board($fen, $style);
    $diagram = board2diag($board, $style, $size, $color);
    return $diagram;
}

$src = fen2diag($_GET["fen"], $style, $size, $color);

header('Content-type: image/png');
imagepng($src);
?>
