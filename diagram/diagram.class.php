<?php

$colors = array(
    "black" => array(0, 0, 0),
    "red" => array(255, 0, 0),
    "green" => array(0, 255, 0),
    "blue" => array(0, 0, 255),
    "gray" => array(127, 127, 127),
    "darkred" => array(127, 0, 0),
    "darkgreen" => array(0, 127, 0),
    "darkblue" => array(0, 0, 127),
    "white" => array(255, 255, 255),
    "blackshift" => array(127, 127, 127),
    "redshift" => array(255, 127, 127),
    "greenshift" => array(127, 255, 127),
    "blueshift" => array(127, 127, 255),
    "grayshift" => array(196, 196, 196),
    "darkredshift" => array(196, 127, 127),
    "darkgreenshift" => array(127, 196, 127),
    "darkblueshift" => array(127, 127, 196)
);

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

class Board {

    var $board;

    function __construct($fen) {
        $this->board = $this->fen2board($fen);
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

    function lines() {
        $l = array();
        for ($i = 0; $i != 8; ++$i) {
            $l[$i] = implode($this->board[$i]);
        }
        return $l;
    }

    function ascii($simbols) {
        $result = "";
        for ($i = 0; $i !== 8; ++$i) {
            $board_line = array();
            for ($j = 0; $j !== 8; ++$j) {
                if ($this->board[$i][$j] === " ") {
                    $index = ($i % 2 === $j % 2) ? "+" : "-";
                } else {
                    $index = ($i % 2 === $j % 2) ? $this->board[$i][$j] . "0" : $this->board[$i][$j] . "1";
                }

                $board_line[$j] = $simbols[$index];
            }
            $result .= implode($board_line) . "\n";
        }
        return $result;
    }

}

class Diagram {

    var $board;
    var $style, $solid, $dbl_margin, $color, $size;
    var $simbols;
    var $m, $b, $s;

    function __construct($fen, $options = array()) {
        $this->board = new Board($fen);
        $this->style = empty($options["style"]) ? "alpha" : $options["style"];
        $this->size = empty($options["size"]) ? 30 : $options["size"];
        $this->color = empty($options["color"]) ? "black" : $options["color"];
        $this->solid = empty($options["solid"]) ? false : $options["solid"];
        $this->dbl_margin = empty($options["dbl_margin"]) ? false : $options["dbl_margin"];

        $this->s = 8 * $this->size;
        $this->b = (int) ($this->size / 20) + 1;
        $this->m = $this->b + 1;
        $this->m *= ($this->dbl_margin === true) ? 2 : 1;
        $this->s += 2 * $this->m;

        
        global $simbols;
        if (!file_exists("./font-desc/{$this->style}.php")) {
            $this->style = "alpha";
        }
        include_once("./font-desc/{$this->style}.php");
        $this->simbols = $simbols[$this->style];
    }

    function ascii() {
        return $this->board->ascii($this->simbols);
    }

    function toImage() {
        global $colors;

        $d = imagecreatetruecolor($this->s + 1, $this->s + 1); // +1 fix
        $dark_color = imagecolorallocate(
                $d, $colors[$this->color][0], $colors[$this->color][1], $colors[$this->color][2]);
        $light_color = imagecolorallocate(
                $d, $colors[$this->color . "shift"][0], $colors[$this->color . "shift"][1], $colors[$this->color . "shift"][2]);
        $white_color = imagecolorallocate(
                $d, $colors["white"][0], $colors["white"][1], $colors["white"][2]);

        imagefill($d, 0, 0, $dark_color);
        imagefilledrectangle(
                $d, $this->b, $this->b, $this->s - $this->b, $this->s - $this->b, $white_color);

        if ($this->dbl_margin === true) {
            imagefilledrectangle(
                    $d, 2 * $this->b, 2 * $this->b, $this->s - 2 * $this->b, $this->s - 2 * $this->b, $dark_color);
            imagefilledrectangle(
                    $d, 3 * $this->b, 3 * $this->b, $this->s - 3 * $this->b, $this->s - 3 * $this->b, $white_color);
        }

        if ($this->solid == true) {
            for ($i = 0; $i != 8; ++$i) {
                for ($j = 0; $j !== 8; ++$j) {
                    if ($i % 2 !== $j % 2) {
                        imagefilledrectangle(
                                $d, $i * $this->size + $this->m, $j * $this->size + $this->m, ($i + 1) * $this->size + $this->m, ($j + 1) * $this->size + $this->m, $light_color);
                    } else {
                        imagefilledrectangle(
                                $d, $i * $this->size + $this->m, $j * $this->size + $this->m, ($i + 1) * $this->size + $this->m, ($j + 1) * $this->size + $this->m, $white_color);
                    }
                }
            }
        }

        for ($i = 0; $i != 8; ++$i) {
            for ($j = 0; $j != 8; ++$j) {
                $index = ($i % 2 === $j % 2) ? "0" : "1";
                $char = $this->board->board[$i][$j];
                if ($char === " ") {
                    $char = ($index === "0") ? $this->simbols["-"] : $this->simbols["+"];
                } else {
                    $char = $this->simbols[$char . $index];
                }
                imagefttext($d, px2pt($this->size), 0, $j * $this->size + $this->m, ($i+1) * $this->size + $this->m, $dark_color, "./fonts/{$this->style}.ttf", $char);
            }
        }
        return $d;
    }

}
