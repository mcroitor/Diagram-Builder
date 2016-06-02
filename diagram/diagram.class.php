<?php

class Diagram {

    var $board;
    var $style;
    var $size;

    function __construct($fen, $options) {
        $this->board = $this->fen2board($fen);
        $this->style = filter_var($options["style"], FILTER_DEFAULT, array("options" => array("default" => "alpha")));
        $this->size = filter_var($options["size"], FILTER_VALIDATE_INT, array("options" => array(
                "default" => 22,
                "min_range" => 10,
                "max_range" => 512
        )));
    }

    function ascii() {
        return $this->toString();
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
    
    function toString(){
        // TODO #: board to string conversion
        return "";
    }
    function fen2board(){
        
    }
}
