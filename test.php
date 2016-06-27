<?php
define("DIAGRAM_PATH", "./diagram/");

require_once DIAGRAM_PATH . 'diagram.class.php';

$d = new Diagram("7K/8/k1P4p/8/8/8/8/8/8");

$options = array("double" => true, "solid" => true);

header('Content-type: image/png');
imagepng($d->toImage());
