<?php

if (defined(DIAGRAM_PATH) == true) {
    require_once DIAGRAM_PATH . 'definitions.php';
} else {
    require_once './diagram/definitions.php';
}

function frac_4($value) {
    return (int) ($value / 4);
}

function frac_2($value) {
    return (int) ($value / 2);
}

function frac3_4($value) {
    return (int) (3 * $value / 4);
}

class Diagram {

    var $board;
    var $style;
    var $size;

    function __construct($fen, $options = array()) {
        $this->board = $this->fen2board($fen);
        $this->style = !empty($options["style"]) ? "alpha" : $options["style"];
        $this->size = !empty($options["size"]) ? 30 : $options["size"];
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

    function toImage(array $options = array()) {
        $is_solid = !empty($options["solid"]) ? true : $options["solid"];
        $is_double_margin = !empty($options["double"]) ? true : $options["double"];
        $color = !empty($options["color"]) ? new Color(0, 0, 0) : $options["color"];

        $margin = ($is_double_margin == false) ? (int) ($this->size / 10) : (int) (1 + $this->size / 5);
        $image_size = $this->size * 8 + 2 * $margin; //8 fields in a row

        $image = imagecreatetruecolor($image_size, $image_size);
        $attached_color = setColor($image, $color);
        $attached_white_color = setColor($image, new Color(255, 255, 255));
        $attached_color_shift = setColor($image, $color->shift());

        imagefill($image, 0, 0, $attached_color);
        if ($is_double_margin == true) {
            imagefilledrectangle($image, $margin / 4 + 1, $margin / 4 + 1, $image_size - $margin / 4 - 1, $image_size - $margin / 4 - 1, $attached_white_color);
            imagefilledrectangle($image, $margin / 2, $margin / 2, $image_size - $margin / 2, $image_size - $margin / 2, $attached_color);
            imagefilledrectangle($image, 3 * $margin / 4, 3 * $margin / 4, $image_size - 3 * $margin / 4, $image_size - 3 * $margin / 4, $attached_white_color);
        } else {
            imagefilledrectangle($image, $margin / 2, $margin / 2, $image_size - $margin / 2, $image_size - $margin / 2, $attached_white_color);
        }

        if ($is_solid === true) {
            for ($i = 0; $i != 8; ++$i) {
                for ($j = 0; $j !== 8; ++$j) {
                    imagefilledrectangle(
                            $image, 
                            $i * $this->size + $margin, 
                            $j * $this->size + $margin, 
                            ($i + 1) * $this->size + $margin, 
                            ($j + 1) * $this->size + $margin, 
                            ($i % 2 !== $j % 2) ? $attached_color_shift : $attached_white_color
                    );
                }
            }
        }
        
        // TODO # : put pieces on board!!!
        return $image;
    }

}
