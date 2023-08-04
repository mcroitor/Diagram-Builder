<?php

$symbols["std"] = array();

$symbols["std"]["8"] = chr(52);
$symbols["std"]["7"] = chr(52);
$symbols["std"]["6"] = chr(52);
$symbols["std"]["5"] = chr(52);
$symbols["std"]["4"] = chr(52);
$symbols["std"]["3"] = chr(52);
$symbols["std"]["2"] = chr(52);
$symbols["std"]["1"] = chr(52);

$symbols["std"]["|"] = chr(54);
$_top = chr(56);
$_bottom = chr(50);
$symbols["std"]["top"] = " "; // "1222222223"; //"!\"\"\"\"\"\"\"\"#";
for ($i = 0; $i != 8; ++$i) {
    $symbols["std"]["top"] .= $_top;
}
$symbols["std"]["bottom"] = " "; //"6777777778";
for ($i = 0; $i != 8; ++$i) {
    $symbols["std"]["bottom"] .= $_bottom;
}
$symbols["std"]["/"] = chr(52);

$symbols["std"]["tl"] = chr(55);
$symbols["std"]["tt"] = chr(56);
$symbols["std"]["tr"] = chr(57);
$symbols["std"]["bl"] = chr(49);
$symbols["std"]["bb"] = chr(50);
$symbols["std"]["br"] = chr(51);

$symbols["std"]["-"] = chr(32);
$symbols["std"]["+"] = chr(48);

$symbols["std"]["a"] = chr(50);
$symbols["std"]["b"] = chr(50);
$symbols["std"]["c"] = chr(50);
$symbols["std"]["d"] = chr(50);
$symbols["std"]["e"] = chr(50);
$symbols["std"]["f"] = chr(50);
$symbols["std"]["g"] = chr(50);
$symbols["std"]["h"] = chr(50);

$symbols["std"]["K0"] = chr(75);
$symbols["std"]["Q0"] = chr(81);
$symbols["std"]["R0"] = chr(82);
$symbols["std"]["B0"] = chr(66);
$symbols["std"]["N0"] = chr(78);
$symbols["std"]["P0"] = chr(80);

$symbols["std"]["K1"] = chr(40);
$symbols["std"]["Q1"] = chr(43);
$symbols["std"]["R1"] = chr(44);
$symbols["std"]["B1"] = chr(39);
$symbols["std"]["N1"] = chr(41);
$symbols["std"]["P1"] = chr(42);

$symbols["std"]["k0"] = chr(107);
$symbols["std"]["q0"] = chr(113);
$symbols["std"]["r0"] = chr(114);
$symbols["std"]["b0"] = chr(98);
$symbols["std"]["n0"] = chr(110);
$symbols["std"]["p0"] = chr(112);

$symbols["std"]["k1"] = chr(34);
$symbols["std"]["q1"] = chr(37);
$symbols["std"]["r1"] = chr(38); //oops!
$symbols["std"]["b1"] = chr(33);
$symbols["std"]["n1"] = chr(35);
$symbols["std"]["p1"] = chr(36);

$symbols["std"]["X0"] = chr(32);
$symbols["std"]["X1"] = chr(48);

$symbols["std"]["delta"] = 0;
