<?php

use App\classes\tk_video;
use App\classes\urilize;

$video_id = $_GET['sid'] ?? 'none';
define("VD_MEDIA", $_GET['media'] ?? 0);
$video = tk_video::find("video_id='$video_id'", 'id DESC', 1)[0] ?? null;

function getMediaLink($data)
{

    if ($data) {
        $video_object = json_decode($data->video_data);
        $media_data = $video_object->medias[VD_MEDIA] ?? null;
        if ($media_data) {
            $media_url = $media_data->url ?? URI_NAME . "/assets/media/no-image.png";
            
            
            $media_extension = $media_data->extension ?? 'png';

            $media_name = strtolower(urilize::text(SITE_TITLE))."_".$data->video_id . "." . $media_extension;
            startDownload($media_url, $media_name , $media_extension);
        } else {
            return null;
        }
    } else {
        return null;
    }
}

function startDownload($url, $name, $format)
{

    // Obtém o nome do arquivo a partir da URL
    $nomeArquivo = $name;

    // Força o download
    $content_type = getContentType($format);
    header('Content-Type: ' . $content_type);
    header('Content-Disposition: attachment; filename="' . $nomeArquivo . '"');
    header('Accept-Ranges: bytes');

    // Abre o arquivo remoto
    $handle = fopen($url, 'rb');
    if ($handle) {
        while (!feof($handle)) {
            echo fread($handle, 1024 * 8); // Lê e envia o arquivo em pedaços
            flush(); // Libera o buffer de saída para evitar consumo excessivo de memória
        }
        fclose($handle);
    }

    exit;
}

function getContentType($format){
    $formats = ['mp4'=>'video/mp4','mp3'=>'audio/mp3','png'=>'image/png'];
    return $formats[$format]??$formats['mp4'];
}

getMediaLink($video);
