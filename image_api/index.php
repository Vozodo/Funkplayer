<?php
//Settings
define("Enable", true);
define("CoverFolder", "covers/");


// ----------------- DO NOT EDIT ----------------- //
$CoverImg = false;

if (Enable) {
    $artist = trim(filter_input(INPUT_GET, "artist"));

    $CoverImages = glob(CoverFolder . str_replace(" ", "_", strtoupper($artist)) . ".{jpg,png,gif}", GLOB_BRACE);

    $CoverImg = reset($CoverImages);
    if (!empty($CoverImg) && $CoverImg) {
        header('Content-Type: image/'. pathinfo($CoverImg)['extension']);
        readfile($CoverImg);
    } else {
        http_response_code(404);
    }

} else {
    http_response_code(404);
}


?>