<?php

$fen = filter_input(INPUT_GET, "fen", FILTER_DEFAULT, ["options" => ["default" => "8/8/8/8/8/8/8/8"]]);
$text = filter_input(INPUT_GET, "text", FILTER_DEFAULT, ["options" => ["default" => ""]]);

$color = array(
    "black" => "#000",
    "red" => "#f00",
    "green" => "#0f0",
    "blue" => "#00f",
    "gray" => "#888",
    "darkred" => "#800",
    "darkgreen" => "#080",
    "darkblue" => "#008",
    "olive" => "#808000",
    "armygreen" => "#4b5320",
    "indigo" => "#4b0082"
);
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <title>FEN Builder</title>
    <link rel="stylesheet" type="text/css" href="style/normalize.css" />
    <link rel="stylesheet" type="text/css" href="style/skeleton.css" />
    <link rel="stylesheet" type="text/css" href="style/main.css" />
    <script type="text/javascript">
        var font = [];
        <?php
        foreach (glob("./diagram/fonts/*.ttf") as $font) {
            $f = str_replace("./diagram/fonts/", "", $font);
            $f = str_replace(".ttf", "", $f);
            if ($f != "cour") {
                echo "font[font.length] = '{$f}';\n";
            }
        }
        ?>
    </script>
    <script type="text/javascript" src="scripts/main.js"></script>
</head>

<body onLoad="genBoard('<?= $fen ?>');">
    <div class="container">

        <h2 align="center">FEN Builder</h2>
        <table class="u-full-width">
            <tr>
                <td>
                    <table id="board">
                        <tr>
                            <td id="a8" class="even">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="b8" class="odd">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="c8" class="even">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="d8" class="odd">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="e8" class="even">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="f8" class="odd">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="g8" class="even">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="h8" class="odd">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                        </tr>
                        <tr>
                            <td id="a7" class="odd">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="b7" class="even">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="c7" class="odd">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="d7" class="even">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="e7" class="odd">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="f7" class="even">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="g7" class="odd">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="h7" class="even">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                        </tr>
                        <tr>
                            <td id="a6" class="even">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="b6" class="odd">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="c6" class="even">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="d6" class="odd">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="e6" class="even">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="f6" class="odd">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="g6" class="even">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="h6" class="odd">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                        </tr>
                        <tr>
                            <td id="a5" class="odd">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="b5" class="even">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="c5" class="odd">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="d5" class="even">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="e5" class="odd">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="f5" class="even">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="g5" class="odd">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="h5" class="even">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                        </tr>
                        <tr>
                            <td id="a4" class="even">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="b4" class="odd">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="c4" class="even">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="d4" class="odd">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="e4" class="even">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="f4" class="odd">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="g4" class="even">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="h4" class="odd">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                        </tr>
                        <tr>
                            <td id="a3" class="odd">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="b3" class="even">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="c3" class="odd">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="d3" class="even">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="e3" class="odd">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="f3" class="even">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="g3" class="odd">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="h3" class="even">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                        </tr>
                        <tr>
                            <td id="a2" class="even">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="b2" class="odd">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="c2" class="even">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="d2" class="odd">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="e2" class="even">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="f2" class="odd">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="g2" class="even">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="h2" class="odd">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                        </tr>
                        <tr>
                            <td id="a1" class="odd">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="b1" class="even">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="c1" class="odd">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="d1" class="even">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="e1" class="odd">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="f1" class="even">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="g1" class="odd">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                            <td id="h1" class="even">
                                <img src="images/blank.png" alt="blank" onClick="set(this);" />
                            </td>
                        </tr>
                    </table>
                </td>
                <td valign="top">
                    <b>Pieces:</b>
                    <table id="pieces">
                        <tr>
                            <td>
                                <img alt="piece" src="images/wk.png" onClick="selectPiece('wk', this);" />
                            </td>
                            <td>
                                <img alt="piece" src="images/wq.png" onClick="selectPiece('wq', this);" />
                            </td>
                            <td>
                                <img alt="piece" src="images/wr.png" onClick="selectPiece('wr', this);" />
                            </td>
                            <td>
                                <img alt="piece" src="images/wb.png" onClick="selectPiece('wb', this);" />
                            </td>
                            <td>
                                <img alt="piece" src="images/wn.png" onClick="selectPiece('wn', this);" />
                            </td>
                            <td>
                                <img alt="piece" src="images/wp.png" onClick="selectPiece('wp', this);" />
                            </td>
                            <td>
                                <img alt="piece" src="images/cross.png" onClick="selectPiece('cross', this);" />
                            </td>
                            <td>
                                <img alt="piece" src="images/blank.png" onClick="selectPiece('blank', this);" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <img alt="piece" src="images/bk.png" onClick="selectPiece('bk', this);" />
                            </td>
                            <td>
                                <img alt="piece" src="images/bq.png" onClick="selectPiece('bq', this);" />
                            </td>
                            <td>
                                <img alt="piece" src="images/br.png" onClick="selectPiece('br', this);" />
                            </td>
                            <td>
                                <img alt="piece" src="images/bb.png" onClick="selectPiece('bb', this);" />
                            </td>
                            <td>
                                <img alt="piece" src="images/bn.png" onClick="selectPiece('bn', this);" />
                            </td>
                            <td>
                                <img alt="piece" src="images/bp.png" onClick="selectPiece('bp', this);" />
                            </td>
                            <td>&nbsp;</td>
                            <td>
                                <img alt="piece" src="images/arrow.png" onClick="movePiece(this);" />
                            </td>
                        </tr>
                    </table>
                    <table id="transform-position">
                        <tr>
                            <td>
                                <img alt="field" src="images/left.png" onClick="transformP('left');" />
                            </td>
                            <td>
                                <img alt="field" src="images/right.png" onClick="transformP('right');" />
                            </td>
                            <td>
                                <img alt="field" src="images/top.png" onClick="transformP('top');" />
                            </td>
                            <td>
                                <img alt="field" src="images/bottom.png" onClick="transformP('bottom');" />
                            </td>
                            <td>
                                <img alt="field" src="images/cw.png" onClick="transformP('cw');" />
                            </td>
                            <td>
                                <img alt="field" src="images/acw.png" onClick="transformP('acw');" />
                            </td>
                            <td>
                                <img alt="field" src="images/switch.png" onClick="transformP('switch');" />
                            </td>
                            <td>
                                <img alt="field" src="images/switch_color.png" onClick="transformP('switch_color');" />
                            </td>
                        </tr>
                    </table>
                    <form>
                        <select name="size" onChange="genLink();" id="size">
                            <?php
                            for ($i = 10; $i < 51; ++$i) {
                                echo "<option" . ($i === 30 ? " selected='selected'" : "") . ">$i</option>";
                            }
                            ?>
                        </select>
                        <select name="style" onChange="genLink();" id="style">
                            <?php
                            foreach (glob("./diagram/fonts/*.ttf") as $font) {
                                $f = str_replace("./diagram/fonts/", "", $font);
                                $f = str_replace(".ttf", "", $f);
                                if ($f != "cour") {
                                    echo "<option>$f</option>";
                                }
                            }
                            ?>
                        </select>
                        <select name="color" id="color" onChange="genLink();">
                            <?php
                            foreach ($color as $key => $value) {
                                echo "<option value='{$key}' style='background-color:{$value};'>{$key}</option>";
                            }
                            ?>
                        </select>
                        <br />
                        <b>FEN:</b><br />
                        <input type="text" name="fen" id="fen" value="<?= $fen ?>" onChange="genBoard(this.value)" />
                        <br /><input type="button" value="clear" onClick="clearAll();" />
                        <input type="button" value="init" onClick="init();" />
                        <input type="button" value="preview" onClick="previewD();" />
                        <br />Solid diagram: <input type="checkbox" name="solid" id="solid" onchange="genLink();" />
                        Double border: <input type="checkbox" name="double" id="double" onchange="genLink();" />
                    </form>
                </td>
                <td style="vertical-align: top;">
                    <h4 style="text-align: center;">preview</h4>
                    <div id="preview">
                        <img src="./diagram/?fen=8/8/8/8/8/8/8/8" alt="fen" />
                    </div><br />
                    <a href="./diagram/?fen=8/8/8/8/8/8/8/8" id="dlink" target="_blank">link to position</a>
                </td>
            </tr>
        </table>

    </div>
</body>

</html>