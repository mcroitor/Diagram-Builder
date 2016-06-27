<?php

// no sense at this case but let it be.
$fonts = array();

// yeah, this way is more effective, i think
class Color {

    var $red, $green, $blue;

    function __construct($r, $g, $b) {
        $this->red = $r;
        $this->green = $g;
        $this->blue = $b;
    }

    function init($color) {
        $this->red = $color >> 24 & 0xFF;
        $this->green = $color >> 16 & 0xFF;
        $this->blue = $color >> 8 & 0xFF;
        //$this->alpha = $color >>  0 & 0xFF;
    }

    function toString() {
        return "0x00{$this->red}{$this->green}{$this->blue}";
    }

    function shift() {
        return new Color(($this->red + 96) % 255, ($this->green + 96) % 255, ($this->blue + 96) % 255);
    }

}

function setColor($image, Color $color) {
    return imagecolorallocate($image, $color->red, $color->green, $color->blue);
}

$colors = array(
    "black" => new Color(0, 0, 0),
    "red" => new Color(255, 0, 0),
    "green" => new Color(0, 255, 0),
    "blue" => new Color(0, 0, 255),
    "gray" => new Color(127, 127, 127),
    "darkred" => new Color(127, 0, 0),
    "darkgreen" => new Color(0, 127, 0),
    "darkblue" => new Color(0, 0, 127),
    "white" => new Color(255, 255, 255),
    "blackshift" => new Color(127, 127, 127),
    "redshift" => new Color(255, 127, 127),
    "greenshift" => new Color(127, 255, 127),
    "blueshift" => new Color(127, 127, 255),
    "grayshift" => new Color(196, 196, 196),
    "darkredshift" => new Color(196, 127, 127),
    "darkgreenshift" => new Color(127, 196, 127),
    "darkblueshift" => new Color(127, 127, 196)
);
