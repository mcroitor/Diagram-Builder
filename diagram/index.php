<?php

$fen = filter_input(INPUT_GET, "fen");
if ($fen === false) {
    exit("<b>using</b>:<br />index.php?fen=&lt;FEN&gt;");
}


$options = array(
    "size" => filter_input(INPUT_GET, 'size', FILTER_VALIDATE_INT),
    "style" => filter_input(INPUT_GET, "style", FILTER_SANITIZE_STRING),
    "solid" => filter_input(INPUT_GET, "solid", FILTER_VALIDATE_BOOLEAN),
    "color" => filter_input(INPUT_GET, "color", FILTER_SANITIZE_STRING),
    "dbl_margin" => filter_input(INPUT_GET, "double", FILTER_VALIDATE_BOOLEAN)
);

require './diagram.class.php';

$d = new Diagram($fen, $options);

header('Content-type: image/png');
imagepng($d->toImage());

