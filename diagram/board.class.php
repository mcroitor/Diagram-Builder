<?php

/**
 * this class represents a chess board and realize a set of useful methods
 */
class Board
{

    /**
     *
     * @var string[][]
     */
    public $board;

    public function __construct($fen)
    {
        $this->board = $this->fen2board($fen);
    }

    /**
     * Converts fen to matrix (board)
     * @param string $fen
     * @return string[][]
     */
    public function fen2board($fen)
    {
        $parts = explode(" ", $fen);
        $epd = $parts[0];

        // fen string verifying
        if ($this->is_correct_epd($epd) === true) {
            $epd = "8/8/8/8/8/8/8/8";
        }
        $brd = [];

        $lines = explode("/", $epd);
        for ($i = 0; $i !== 8; ++$i) {
            $brd[$i] = $this->__brd_line($lines[$i]);
        }
        return $brd;
    }

    /**
     * parse one token from fen
     * @param string $line
     * @return string[]
     */
    private function __brd_line($line)
    {
        $brd_line = [];
        $count = 0;
        for ($i = 0; $i < strlen($line); ++$i) {
            if (strpos("12345678", $line[$i]) !== false) {
                $aux = (int) $line[$i];
                while ($aux > 0) {
                    $brd_line[$count] = " ";
                    ++$count;
                    --$aux;
                }
            } else {
                $brd_line[$count] = $line[$i];
                ++$count;
            }
        }
        return $brd_line;
    }

    /**
     * fen / epd correctness validation
     * @param string $epd
     * @return bool
     */
    private function is_correct_epd($epd)
    {
        $len = strlen($epd);
        $fields = 0;
        for ($i = 0; $i < $len; $i++) {
            if (strpos("12345678", $epd[$i]) === true) {
                $fields += $epd[$i];
            } elseif (strpos("kqrbnpKQRBNPX", $epd[$i]) === true) {
                $fields++;
            } elseif ($epd[$i] === '/') {
            } else {
                $fields += 100;
            }
        }
        return $fields === 64;
    }

    /**
     * 
     * @return string
     */
    public function toString()
    {
        $str = "";
        for ($i = 0; $i != 8; ++$i) {
            $str .= implode($this->board[$i]) . "\n";
        }
        return $str;
    }

    /**
     * lines of board
     * @return string[]
     */
    private function lines()
    {
        $l = [];
        for ($i = 0; $i != 8; ++$i) {
            $l[$i] = implode($this->board[$i]);
        }
        return $l;
    }

    /**
     * ASCII board
     * @param string[][] $symbols
     * @return string
     */
    public function ascii($symbols)
    {
        $result = "";
        for ($i = 0; $i !== 8; ++$i) {
            $board_line = [];
            for ($j = 0; $j !== 8; ++$j) {
                if ($this->board[$i][$j] === " ") {
                    $index = ($i % 2 === $j % 2) ? "+" : "-";
                } else {
                    $index = ($i % 2 === $j % 2) ? $this->board[$i][$j] . "0" : $this->board[$i][$j] . "1";
                }

                $board_line[$j] = $symbols[$index];
            }
            $result .= implode($board_line) . "\n";
        }
        return $result;
    }
}
