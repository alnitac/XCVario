<?php

//$filename = "https://raw.githubusercontent.com/alnitac/XCVario/master/main/SetupMenu.cpp";

$dir = "main/";
$vv = recdir($dir);
$rc = chr(13);
echo($rc);
$ll = array();
foreach ($vv as $file) {
    $ff = fopen($file, "r");
    if (filesize($file) > 0) {
        $tt = fread($ff, filesize($file));
        $ee = extraire('PROGMEM"','"',$tt);
        foreach ($ee as $e) {
            if (!array_search($e, $ll)) {
                $ll[] = $e;
            }
        }
    }
    fclose($ff);
}
//

// generate .pot file
$ff = fopen("source/xcvario.pot", "w");
for ($i = 0; $i< 5; $i++ ) {
    fwrite($ff, "#" . $rc);
}
foreach ($ll as $item) {
    fwrite($ff, "#, c-format" . $rc);
    fwrite($ff, 'msgid "' . $item . '"' . $rc);
    fwrite($ff, 'msgstr ""' . $rc);
}







exit();


$vv = fopen($filename,"r");
$cc = "";
while ($tt = fread($vv,1000)) {
    $cc.= $tt;
}
fclose($vv);
$vv = fopen("C:\\d_xcvario\\xcv.txt","w");
//echo($cc);
$i = 0;
$f = 0;
$n = 0;
$l = strlen($cc);
echo (strlen($cc));
$cr = chr(10) . chr(13);
while ($i < strlen($cc)) {
    $a1 = strpos($cc, 'PROGMEM "', $i) + 9;
    $a2 = strpos($cc, 'PROGMEM"', $i) + 8;
    $a3 = strpos($cc, 'PROGMEM  "', $i) + 10;
    $a4 = strpos($cc, 'addEntry( "', $i) + 11;
    $a5 = strpos($cc, 'SetupMenuValFloat( "', $i) + 20;     // missing 6 values with 2 or more spaces between ( and "
    $a6 = strpos($cc, 'SetupMenuSelect( "', $i) + 18;  // missing 4 values with 2 spaces between ( and "
    $a7 = strpos($cc, 'SetupMenu( "', $i) + 12;  // missing ?

    if ($a1 < 100 && $a2 < 100 && $a3 < 100 && $a4 < 100 && $a5 < 100 && $a6 < 100 && $a7 < 100) exit();

    if ($a1 < 100) $a1 = $l;
    if ($a2 < 100) $a2 = $l;
    if ($a3 < 100) $a3 = $l;
    if ($a4 < 100) $a4 = $l;
    if ($a5 < 100) $a5 = $l;
    if ($a6 < 100) $a6 = $l;
    if ($a7 < 100) $a7 = $l;

    $d = min($a1,$a2,$a3,$a4,$a5,$a6,$a7);

//    echo("Debut : " . $d . $cr);
    $f = strpos($cc, "\"", $d + 1);
//    echo("Fin : " . $f .$cr);
//    $f = 100;
    $c = substr($cc, $d, $f - $d);
    $i = $f + 1;
    $n = $n + 1;
    echo($n . ".Chaine : " . $c . $cr);

    fwrite($vv,$c . chr(13));
//    sleep(0.1);
}
fclose($vv);
exit();

function extraire($deb,$fin,$tex) {
    $vv = array();
    while (true) {
        $tex = strstr($tex, $deb,false);
        if (!$tex) break;
        $tex = substr($tex,strlen($deb));
        $t3 = strstr($tex, $fin, true);
//        $t4 = substr($t3, strlen($deb));
//        echo($t3);
        $vv[] = $t3;
    }
    return $vv;
//    var_dump($vv);
}

function recdir($dir)
{
    $vv = array();
    $d = dir($dir);
    $rc = chr(10).chr(13);
    while (false !== ($entry = $d->read())) {
//        echo($entry).$rc;
        if ($entry == "." or $entry == "..") {
        } else {
            if (is_file($dir.$entry)) {
//                echo($dir.$entry);
                $vv[] = $dir.$entry;
            } else {
//                echo("# " . $dir.$entry ."/" . " #" . $rc);
                if (is_dir($dir .$entry. "/")) {
//                    $xx = array();
                    $xx = recdir($dir . $entry. "/");
//                    var_dump($xx);
                    $vv = array_merge($vv,$xx);
                }
            }
        }
    }
    $d->close();
    return $vv;
}


