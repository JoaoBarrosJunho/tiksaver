<?php
namespace App\http\tiktok;

use App\classes\leemclasses;
use App\classes\tk_video;

class request{

    

    public $url = null;
    public $title = null;
    public $thumbnail = null;
    public $duration = null;
    public $medias = [];
    public $source = null;
    public $sid = null;
    public $author_id = null;
    public $author_name = null;
    

    public function __construct(string $url) {
        $this->url = $url;
    }


    

    function fetch(){
        $ok =false;
        $message = '';
        $data = '';
        $video = $this->url?urlencode($this->url):$this->url;
        $endpoint = "https://www.tikwm.com/api/?url=".$video;
        $ch = curl_init($endpoint);
    
        curl_setopt_array($ch,[
            CURLOPT_SSL_VERIFYPEER=>false,
            CURLOPT_RETURNTRANSFER=>true,
            CURLOPT_SSL_VERIFYHOST=>false,
            CURLOPT_FOLLOWLOCATION=>true,
            CURLOPT_HTTP_VERSION=>CURL_HTTP_VERSION_1_1,
            CURLOPT_MAXREDIRS=>10
        ]);
    
        $response = curl_exec($ch);
        if(curl_errno($ch)){
            $message =  'Connection error, please try again later or check your internet!';
            leemclasses::newLog("REQUEST_ERROR:".curl_error($ch));
        }else{
            
            $data = json_decode($response);
            if($data->msg=='success'){
                $ok = true;
                $message = $data->msg;
                $this->parseResponse((array)$data->data);
                tk_video::new($this);
            }else{
                $message = 'Invalide video link!';
            }
    
        }
        curl_close($ch);
        return ['ok'=>$ok,'message'=>$message,'data'=>$this];
    }

    private function parseResponse($data){
        if (!empty($data['wmplay'])) {
            $this->title = $data['title'] ?? 'Tiktok Video';
            $this->sid = $data['id']??bin2hex(random_bytes(10));
            if (empty($this->title)) {
                $this->title = $data['author']->nickname . ' TikTok';
            }
            $this->source = 'tiktok';
            $this->thumbnail = $data['cover'];
            $this->duration = $data['duration'];
            $this->author_id = $data['author']->id;
            $this->author_name =$data['author']->nickname;
           
            //no_watermark
            if (!empty($data['play'])) {
                $media = new Media($data['play'], 'hd', 'mp4', true, true);
                $media->size = $this->getSize($media->url);
                $media->setSize();
                $this->medias[] = $media;
            }

           //watermark
            $wmark = new Media($data['wmplay'], 'watermark', 'mp4', true, true);
            $wmark->size= $this->getSize($wmark->url) ;
            $wmark->setSize();
            $this->medias[] = $wmark;

            
            if (!empty($data['music'])) {
                $this->medias[] = new Media($data['music'], '128kbps', 'mp3', false, true);
            }
        }
    }


    private function getSize($url)
    {
        $ch = curl_init();
        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_USERAGENT => tk_video::$userAgent,
            CURLOPT_ENCODING => 'utf-8',
            CURLOPT_AUTOREFERER => false,
            CURLOPT_REFERER => 'https://www.tiktok.com/',
            CURLOPT_CONNECTTIMEOUT => 30,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_MAXREDIRS => 10,
            /**CURLOPT_COOKIEFILE => $this->cookieFile,
            CURLOPT_COOKIEJAR => $this->cookieFile,**/
            CURLOPT_NOBODY => true,
        );
        curl_setopt_array($ch, $options);
        if (defined('CURLOPT_IPRESOLVE') && defined('CURL_IPRESOLVE_V4')) {
            curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        }
        curl_exec($ch);
        //$this->httpCode = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
        $size = -1;
        if (curl_errno($ch) == 0) {
            $size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
        }
        curl_close($ch);
        return $size;
    }
}