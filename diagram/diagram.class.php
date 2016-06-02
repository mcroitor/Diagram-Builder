<?php

class Diagram {

    var $board;
    var $style;
    var $size;

    function __construct($fen, $options = array()) {
        $o = filter_var($options, FILTER_DEFAULT, array("options" => array(
                "default" => array("style" => "alpha", "size" => 30)
        )));
        $this->board = $this->fen2board($fen);
        $this->style = filter_var($o["style"], FILTER_DEFAULT, array("options" => array("default" => "alpha")));
        $this->size = filter_var($o["size"], FILTER_VALIDATE_INT, array("options" => array(
                "default" => 30,
                "min_range" => 10,
                "max_range" => 512
        )));
    }

    function ascii($s) {
        $str = $s["top"] . "\n";
        for ($i = 0; $i !== 8; ++$i) {
            $str .= $s["|"];
            for ($j = 0; $j !== 8; ++$j) {
                if ($this->board[$i][$j] == " ") {
                    $index = ($i % 2 === $j % 2) ? "+" : "-";
                } else {
                    $index = ($i % 2 === $j % 2) ? $this->board[$i][$j] . "0" : $this->board[$i][$j] . "1";
                }

                $str .= $s[$index];
            }
            $str .= $s["/"] . "\n";
        }
        $str .= $s["bottom"];
        return $str;
    }

    private function is_correct_epd($epd) {
        $len = strlen($epd);
        $fields = 0;
        for ($i = 0; $i < $len; $i++) {
            if (strpos("12345678", $epd{$i}) === true) {
                $fields +=$epd{$i};
            } elseif (strpos("kqrbnpKQRBNPX", $epd{$i}) === true) {
                $fields++;
            } elseif ($epd{$i} === '/') {
                
            } else {
                $fields +=100;
            }
        }
        return $fields === 64;
    }

    function toString() {
        $str = "";
        for ($i = 0; $i != 8; ++$i) {
            $str .= implode($this->board[$i]) . "\n";
        }
        return $str;
    }

    function fen2board($fen) {
        $parts = explode(" ", $fen);
        $epd = $parts[0];

        // fen string verifying
        if ($this->is_correct_epd($epd) === true) {
            $epd = "8/8/8/8/8/8/8/8";
        }
        $brd = array();

        $lines = explode("/", $epd);
        for ($i = 0; $i !== 8; ++$i) {
            $brd[$i] = $this->__brd_line($lines[$i]);
        }
        return $brd;
    }

    private function __brd_line($line) {
        $brd_line = array();
        $count = 0;
        for ($i = 0; $i < strlen($line); ++$i) {
            if (strpos("12345678", $line{$i}) !== false) {
                $aux = (int) $line{$i};
                while ($aux > 0) {
                    $brd_line[$count] = " ";
                    ++$count;
                    --$aux;
                }
            } else {
                $brd_line[$count] = $line{$i};
                ++$count;
            }
        }
        return $brd_line;
    }

    function toImage(array $options) {
        $is_solid = filter_var($options["solid"], FILTER_VALIDATE_BOOLEAN, array("options" => array("default" => false)));
        $is_double = filter_var($options["double"], FILTER_VALIDATE_BOOLEAN, array("options" => array("default" => false)));
    }

}
