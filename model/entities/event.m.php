<?php

require_once "entity.m.php";

class event {

    use Entity;

    private string $TriggerSongName = "";
    private string $TriggerSongArtist = "";
    private string $SongName = "";
    private string $SongArtist = "";
    private string $SongImage = "";



    public function getTriggerSongName()
    {
        return $this->TriggerSongName;
    }

    public function setTriggerSongName($TriggerSongName)
    {
        $this->TriggerSongName = $TriggerSongName;

    }


    public function getTriggerSongArtist()
    {
        return $this->TriggerSongArtist;
    }


    public function setTriggerSongArtist($TriggerSongArtist)
    {
        $this->TriggerSongArtist = $TriggerSongArtist;
    }

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

    public function __toString()
    {
        return "TriggerSongName: " . $this->TriggerSongName . " TriggerSongArtist: " . $this->TriggerSongArtist . " SongName: " . $this->SongName . " SongArtist: " . $this->SongArtist . " SongImage: " . $this->SongImage;
    }
}
