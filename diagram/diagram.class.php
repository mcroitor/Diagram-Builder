<?php

include_once __DIR__ . "/definitions.php";
include_once __DIR__ . "/board.class.php";

/**
 * The chess diagram generator from fen / epd string
 */
class Diagram
{
    public const FIELD_SIZE = 30;

    /**
     * Board definition
     * @var Board
     */
    private $board;

    /**
     * Board style, is equivalent with chess font name
     * @var string
     */
    private $style;

    /**
     * solid or hatched board
     * @var bool
     */
    private $solid;

    /**
     * single or double margin of board
     * @var type bool
     */
    private $doubledMargin;

    /**
     * color of diagram
     * @var string
     */
    private $color;

    /**
     * field dimension
     * @var int
     */
    private $fieldSize;

    /**
     * chess piece representation, defined by <i>style</i>
     * @var string[]
     */
    private $symbols;

    private $margin;
    private $border;
    private $size;

    public function __construct($fen, $options = [])
    {
        $this->board = new Board($fen);
        $this->style = empty($options["style"]) ? "alpha" : $options["style"];
        $this->fieldSize = empty($options["size"]) ? self::FIELD_SIZE : $options["size"];
        $this->color = empty($options["color"]) ? "black" : $options["color"];
        $this->solid = empty($options["solid"]) ? false : $options["solid"];
        $this->doubledMargin = empty($options["doubledMargin"]) ? false : $options["doubledMargin"];

        $this->size = 8 * $this->fieldSize;
        $this->border = (int) ($this->fieldSize / 40) + 1;
        $this->margin = $this->border + 1;
        $this->margin *= ($this->doubledMargin === true) ? 3 : 1;
        $this->size += 2 * $this->margin;


        global $symbols;
        if (!file_exists( FONT_DESC_PATH . "/{$this->style}.php")) {
            $this->style = "alpha";
        }
        $this->symbols = $symbols[$this->style];
    }

    /**
     * ASCII board representation
     * @return string
     */
    public function ascii()
    {
        return $this->board->ascii($this->symbols);
    }

    /**
     * returns true color image
     * @return GdImage
     */
    public function toImage()
    {
        $d = imagecreatetruecolor($this->size + 1, $this->size + 1); // +1 fix
        $darkColor = imagecolorallocate(
            $d,
            COLOR[$this->color][0],
            COLOR[$this->color][1],
            COLOR[$this->color][2]
        );
        $lightColor = imagecolorallocate(
            $d,
            COLOR[$this->color . "shift"][0],
            COLOR[$this->color . "shift"][1],
            COLOR[$this->color . "shift"][2]
        );
        $whiteColor = imagecolorallocate(
            $d,
            COLOR["white"][0],
            COLOR["white"][1],
            COLOR["white"][2]
        );

        imagefill($d, 0, 0, $darkColor);
        imagefilledrectangle(
            $d,
            $this->border,
            $this->border,
            $this->size - $this->border,
            $this->size - $this->border,
            $whiteColor
        );

        if ($this->doubledMargin === true) {
            imagefilledrectangle(
                $d,
                2 * $this->border,
                2 * $this->border,
                $this->size - 2 * $this->border,
                $this->size - 2 * $this->border,
                $darkColor
            );
            imagefilledrectangle(
                $d,
                3 * $this->border,
                3 * $this->border,
                $this->size - 3 * $this->border,
                $this->size - 3 * $this->border,
                $whiteColor
            );
        }

        if ($this->solid) {
            for ($i = 0; $i != 8; ++$i) {
                for ($j = 0; $j !== 8; ++$j) {
                    if ($i % 2 !== $j % 2) {
                        imagefilledrectangle(
                            $d,
                            $i * $this->fieldSize + $this->margin,
                            $j * $this->fieldSize + $this->margin,
                            ($i + 1) * $this->fieldSize + $this->margin,
                            ($j + 1) * $this->fieldSize + $this->margin,
                            $lightColor
                        );
                    } else {
                        imagefilledrectangle(
                            $d,
                            $i * $this->fieldSize + $this->margin,
                            $j * $this->fieldSize + $this->margin,
                            ($i + 1) * $this->fieldSize + $this->margin,
                            ($j + 1) * $this->fieldSize + $this->margin,
                            $whiteColor
                        );
                    }
                }
            }
        }

        $fix = px2pt($this->symbols["delta"] * $this->fieldSize);
        for ($i = 0; $i != 8; ++$i) {
            for ($j = 0; $j != 8; ++$j) {
                $index = ($i % 2 === $j % 2 || $this->solid) ? "0" : "1";
                $char = $this->board->board[$i][$j];
                if ($char === " ") {
                    $char = ($index === "0") ? $this->symbols["-"] : $this->symbols["+"];
                } else {
                    $char = $this->symbols[$char . $index];
                }
                imagefttext(
                    $d,
                    px2pt($this->fieldSize),
                    0,
                    $j * $this->fieldSize + $this->margin,
                    ($i + 1) * $this->fieldSize + $this->margin + (int)$fix,
                    $darkColor,
                    FONTS_PATH . "{$this->style}.ttf",
                    $char
                );
            }
        }
        return crop($d);
    }
}
