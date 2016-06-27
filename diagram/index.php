<?php

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
$dbl_margin = filter_input(INPUT_GET, "double", FILTER_VALIDATE_BOOLEAN, array("options" => array("default" => false)));
$color = filter_input(INPUT_GET, "color", FILTER_DEFAULT, array("options" => array("default" => "black")));

$options = array(
    "size" => $size,
    "style" => $style,
    "solid" => $solid,
    "color" => $color,
    "dbl_margin" => $dbl_margin
);

include './diagram.class.php';

$d = new Diagram($fen, $options);

header('Content-type: image/png');
imagepng($d->toImage());

