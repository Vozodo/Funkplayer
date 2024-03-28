<?php

require_once "entity.m.php";

class song
{

    use Entity;


    private string $SongName = "";
    private string $SongArtist = "";
    private string $SongImage = "";
    private int $SongPlayed = 0;



    public function getSongName()
    {
        return $this->SongName;
    }


    public function setSongName($SongName)
    {
        $this->SongName = $SongName;
    }

    public function getSongArtist()
    {
        return $this->SongArtist;
    }

    public function setSongArtist($SongArtist)
    {
        $this->SongArtist = $SongArtist;
    }


    public function getSongImage()
    {
        return $this->SongImage;
    }

    public function setSongImage($SongImage)
    {
        $this->SongImage = $SongImage;
    }


    public function getSongPlayed()
    {
        return $this->SongPlayed;
    }

    public function __toString()
    {
        return "Songname: " . $this->getSongName() . " Songartist: " . $this->getSongArtist() . " SongPlayed: " . $this->getSongPlayed();
    }


    public function setSongPlayed($SongPlayed)
    {
        $this->SongPlayed = $SongPlayed;
    }

    public static function getHistory(bool $AsObject = false, bool $FullLink = false) {

        $file = "model/json/history.json";

        $History = array();

		$Songs = array();
		$file = file_get_contents($file);
		if ($file || !empty($file) || file_exists($file)) {
			$Songs = json_decode($file, JSON_OBJECT_AS_ARRAY);
		}

		if ($AsObject && !$FullLink) {
			foreach ($Songs as $Song) {
				$Song = new song($Song);
				$Song->setSongImage("index.php?a=songimage&t==" . $Song->getSongPlayed());
				$History[] = $Song;
			}
		} elseif (!$AsObject && !$FullLink) {
			foreach ($Songs as $Song) {
				$Song = new song($Song);
				$Song->setSongImage("index.php?a=songimage&t=" . $Song->getSongPlayed());
				$History[] = $Song->toArray();
			}
		} elseif ($AsObject && $FullLink) {
			foreach ($Songs as $Song) {
				$Song = new song($Song);
				$History[] = $Song;
			}
		} elseif (!$AsObject && $FullLink) {
			foreach ($Songs as $Song) {
				$Song = new song($Song);
				$History[] = $Song->toArray();
			}
		}

		return $History;

    }

    public static function setHistory(array $History) {
        $json = "model/json/history.json";

		$file = file_get_contents($json);
		if ($file || !empty($file) || file_exists($json)) {
			file_put_contents($json, json_encode($History));
		} else {
			Functions::WriteLog("SetHistory: " . $json . " not found for the History, create one");
			file_put_contents($json, json_encode(array()));
		}
    }

    public static function find($SongPlayed) {

        $file = "model/json/history.json";

        $Songs = json_decode(file_get_contents($file), JSON_OBJECT_AS_ARRAY);

        foreach ($Songs as $Song) {
            $Song = new song($Song);
            if ($Song->getSongPlayed() == $SongPlayed) {
                return $Song;
            }
         }
    }
}
