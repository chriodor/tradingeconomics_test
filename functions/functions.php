<?php

function brecho($str) {
    echo "<br>" . $str . "<br>";
}

function print_pr($toPrint) {
    echo "<pre>";
    print_r($toPrint);
    echo "</pre>";
}

function cleanUserString($str) {

    $str = str_replace("\\", "&bsol;", $str);

    $str = strip_tags($str, "<a>");
    //$str = strip_tags($str, "<a><strong><b><i><u><em><br><p>");

    $str = stripslashes($str);

    $str = addslashes($str);

    $str = str_replace('"', "&quot;", $str);
    $str = str_replace("'", "&apos;", $str);

    return $str;
}


function recursivePostArray($array, $keyVal, &$saveArray) {
    if ($keyVal == "post_screen_array") {


        if (is_array($array)) {
            foreach ($array as $key => $value) {
                $saveArray[cleanUserString($key)] = cleanUserString($value);
            }
        }

        return;
    } else {
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                if (is_array($value)) {
                    $retArray = recursivePostArray($value, $key, $saveArray);

                    $saveArray[cleanUserString($keyVal)] = $retArray;
                }
            }

            return $array;
        } else {

            return cleanUserString($array);
        }
    }
}

function alert($str) {
    global $bodyEndScript;
    if ($str != "") {
        $bodyEndScript = "alert('$str');";
    }
}

?>