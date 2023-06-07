<?php

use Mp3StreamTitle\Mp3StreamTitle;

class controller
{

    private $context = array();
    private $LoadTemplate = true;

    public function run($aktion)
    {
        $this->$aktion();
        $this->generatePage($aktion);
    }

    private function home()
    {

        $this->addContext("SongHistory", Song::getHistory(true));
    }

    private function history()
    {
        if (!H_EN) {
            header('Location: index.php');
        }
    }

    private function songimage()
    {

        $this->LoadTemplate = false;

        if ($_GET) {
            $t = filter_input(INPUT_GET, "t");
            $Song = Song::find($t);

            if ($Song) {
                #header('Content-Type: image/png');

                readfile($Song->getSongImage());

                echo $Song->getSongImage();
            } else {
                http_response_code(404);
            }
        }
    }

    private function daemon()
    {
        //Disable Template
        $this->LoadTemplate = false;
        $SongAndArtist = "";

        $q = filter_input(INPUT_GET, 'q');

        if ($q == "history") {

            $SongHistory = Song::getHistory(false, true);
        

            $mp3streamtitle = new Mp3StreamTitle();


            $SongAndArtist = utf8_encode(mb_convert_encoding(strval($mp3streamtitle->sendRequest(StationStreamURL)), 'ISO-8859-1'));
            $match = false;
            //Check if is Valid
            if ($SongAndArtist === 0) {
                Functions::WriteLog("Cannot reach Icecast server, please check your configurations");
            }

            if (!preg_match('/ - /', $SongAndArtist) || !is_string($SongAndArtist) || empty($SongAndArtist)) {  
                $match = true;
            }

            //Check if is Ignored
            if (RE_EN) {
                foreach (RE_IGONORE_DATA as $pattern) {
                    if (preg_match($pattern, $SongAndArtist)) {
                        $match = true;
                    }
                }
            }
            


            if (!$match) {
                $SongSplit = explode(" - ", $SongAndArtist);

                $Song = new song();
                if (MD_ORIENTATION == 0) {
                    $Song->setSongArtist($SongSplit[0]);
                    $Song->setSongName($SongSplit[1]);
                } elseif (MD_ORIENTATION == 1) {
                    $Song->setSongArtist($SongSplit[1]);
                    $Song->setSongName($SongSplit[0]);
                } else {
                    Functions::WriteLog("Metadata: Wrong insert please check in config");
                }
                $Song->setSongImage(Functions::GetSongImage($Song));
                $Song->setSongPlayed(time());

                if (EV_EN) {
                    foreach (EV_LST as $EventArray) {
                        $Event = new event($EventArray);

                        if ((($Event->getTriggerSongArtist() == $Song->getSongArtist()) && ($Event->getTriggerSongName() == $Song->getSongName())) || (($Event->getTriggerSongArtist() == $Song->getSongName()) && ($Event->getTriggerSongName() == $Song->getSongArtist()))) {
                            $Song->setSongName($Event->getSongName());
                            $Song->setSongArtist($Event->getSongArtist());
                            $Song->setSongImage($Event->getSongImage());
                        }
                    }
                }

                if (!empty($SongHistory)) {
                    $LastSong = new song(array_values($SongHistory)[0]);

                    if (strcmp($Song->getSongArtist(), $LastSong->getSongArtist()) !== 0 || strcmp($Song->getSongName(), $LastSong->getSongName()) !== 0) {
                        if (count($SongHistory) <= H_SIZE) {
                            array_unshift($SongHistory, $Song->toArray());
                        } else {
                            array_pop($SongHistory);
                            array_unshift($SongHistory, $Song->toArray());
                        }
                    }
                } else {
                    array_push($SongHistory, $Song->toArray());
                    
                }

            
                Song::SetHistory($SongHistory);
            }

            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(Song::getHistory());
        } elseif ($q == "info") {

            header('Content-Type: application/json; charset=utf-8');

            $info = new stdClass();
            $info->StationName = StationName;
            $info->StationSlogan = StationSlogan;
            $info->StationLogo = StationLogo;
            $info->StationWebsite = StationWebsite;
            $info->StationStreamURL = StationStreamURL;


            echo json_encode($info);


        }
    }



    private function addContext($key, $value)
    {
        $this->context[$key] = $value;
    }

    private function generatePage($template)
    {
        extract($this->context);


        if ($this->LoadTemplate) {
            require_once 'view/snippets/header.v.html';
            require_once 'view/' . $template . ".v.html";
            require_once 'view/snippets/footer.v.html';
        }
    }
}
