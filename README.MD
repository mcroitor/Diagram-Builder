Diagram Builder is dedicated to construct chess diagrams with different 
properties, such as size, style and color.

Just unpack on your server and run index.php! 
__Attnetion:__ sure, you need to have a PHP interpreter installed :)

* Recommended versions PHP: 7.*
* GD2 extentions enabled

Example of diagram builder is presented at http://endgame.md/builder/

Diagram Builder is used on:
 * ChessStar -- https://www.chessstar.com/others/croitor/
 * ChessblogYG -- http://9148.od.ua/nabor-diagramm/

Next chess fonts has not implemented yet from different motives:
 * alfochess
 * chessole
 * chs020
 * condfont
 * harlfont
 * linefont
 * magnfont
 * piratdia

You can check if your font can be used for diagram building. Put your font in
**diagram/fonts** directory and execute **diagram/helper-result/helper.php**. In directory 
**diagram/helper-result** will be created images (character map) for each font 
from **diagram/fonts** directory.

## known bugs / features

__This is not a bug, this is a feature!__

 * When you use _solid_ option, pieces has the same inner color as dark fields.
This is not a bug, this is a constructive problem related with TTF fonts. Diagram
creation is based at font, font is just a lot of shapes, basically drowed by black.
 * ~~_Good Companions_ -- nice font, but need to be offset fixed.~~