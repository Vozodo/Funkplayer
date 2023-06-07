<?php
//STATION SETTINGS
define("StationName", "s_name");
define("StationSlogan", "s_slogan");
define("StationLogo", "view/img/Default_Logo.png");
define("StationWebsite", "s_website");
define("StationStreamURL", "https://stream.domain.tld/");



/*
* Metadata orientation, type:
* 0 => ARTIST - SONG
* 1 => SONG - ARTIST
*/
define("MD_ORIENTATION", 0);


//METADATA FILTER - RegEx
define("RE_EN", true); //Enable RegEx Filter 
define("RE_IGONORE_DATA", array("/Radio Sample/", "/Sample Radio/")); //Ignore Title 



/*
* Metadate Image provider, type;
* itunes => For images on Itunes
* musicbrainz => For images on Musicbrainz
*/
define("MD_IMAGE_PROVIDER", "itunes");

//HISTORY SETTINGS
define("H_EN", true); //Enable history 
define("H_SIZE", 20); // Amount in history

//OWN IMAGES
/*
* Enter your own images
* If the Api can't find any images for the respective artist, you can enable the use of your own images from your own archive.
* ----
* To use this function, activate it and store your images in the folder "model/cover_img". Save them WITH CAPITAL LETTERS and REPLACE SPACES WITH UNDERSCORE.
* For example:
* ADELE.jpg
* IMAGINE_DRAGONS.png
*/ 
define("IM_EN", true); //Enables the Own images

/*
* Define the URL of the Funkplayer Image API
* Enter the Full Address to the index.php
*/
define("IM_EX_EN", false); //Enables External Image API
define("IM_EX_URL", "http://localhost/image_api/index.php");


//EVENT HANDLING
define("EV_EN", true); //Enable Event Handling
//Triggers
$Events = array(
    //Sample Trigger
    array(
        'TriggerSongName' => "SampleTriggerSongName",
        'TriggerSongArtist' => "SampleTriggerSongArtist",
        'SongName' => "SongName",
        'SongArtist' => "SongArtist",
        'SongImage' => "view/img/Default_Logo.png",
    )


);

define("EV_LST", $Events);


//ERROR REPORT
#ini_set('display_errors', 1);
#ini_set('display_startup_errors', 1);
#error_reporting(E_ALL);

//