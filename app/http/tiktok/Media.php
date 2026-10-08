<?php

namespace App\http\tiktok;


class Media
{

    public $url = null;
    public $quality = null;
    public $extension = null;
    public $size = null;
    public $size_formated = null;
    public $videoAvailable = null;
    public $audioAvailable = null;
    public $chunked = false;
    public $cached = false;

    public function __construct($url, $quality, $extension, $videoAvailable, $audioAvailable)
    {

        $this->url = $url;
        $this->quality = $quality;
        $this->extension = $extension;
        $this->videoAvailable = $videoAvailable;
        $this->audioAvailable = $audioAvailable;
    }


    public function setSize()
    {
        if ($this->size) {
            $fsize = $this->size / 1048576;
            $this->size_formated = number_format($fsize, 2);
        };
    }
}
