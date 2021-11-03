<?php

$result = array();

foreach (explode("\n", file_get_contents($argv[1])) as $row) {

    if (empty($row)) break;
    $value = split_row($row);
    $binResults = file_get_contents('https://lookup.binlist.net/' .$value[0]);
    if (!$binResults)
        die('error!');
    $r = json_decode($binResults);
    $isEu = isEu($r->country->alpha2);

    $rate = @json_decode(file_get_contents('https://api.exchangeratesapi.io/latest'), true)['rates'][$value[2]];
    if ($value[2] == 'EUR' or $rate == 0) {
        $amntFixed = round($value[1], 2);
    }
    if ($value[2] != 'EUR' or $rate > 0) {  
        $amntFixed = round($value[1] / $rate, 2);
    }
    
    array_push($result, $amntFixed * ($isEu == 'yes' ? 0.01 : 0.02));
    echo $amntFixed * ($isEu == 'yes' ? 0.01 : 0.02);
    print "\n";
}

function split_row($row) {
    $p = explode(",",$row);
    echo strval($p[0]);
    echo $p[1];
    $p2 = explode(':', $p[0]);
    $value[0] = trim($p2[1], '"');
    $p2 = explode(':', $p[1]);
    $value[1] = trim($p2[1], '"');
    $p2 = explode(':', $p[2]);
    $value[2] = trim($p2[1], '"}');
    return $value;
}

function isEu($c) {
    $result = false;
    $tableau = array('AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK','EE', 'ES','FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PO', 'PT', 'RO', 'SE', 'SI', 'SK');
    switch($c) {
        case in_array($c, $tableau):
            $result = 'yes';
            return $result;
        default:
            $result = 'no';
    }
    return $result;
}