<?php

//KENDİ KEYİNİZİ ALMAK İÇİN

//1. Google Developers Console'a Git
// https://console.cloud.google.com/

//2. Yeni bir proje oluştur veya mevcut bir projeyi seç
//3. "APIs & Services" → "Library" (API Kitaplığı) sekmesine git
//4. YouTube Data API v3 arat ve etkinleştir
//5. "Credentials" sekmesine git
//6. “+ Create Credentials” → API Key seç
//7. API keyini kopyala ve your_key yerine yapıştır.

function youtubeImage($video_link){
    $pattern_embed = '/embed\/([\w-]+)/';
    $pattern_watch = '/v=([\w-]+)/';
    $pattern_short = '/youtu\.be\/([\w-]+)/';
    
    if (preg_match($pattern_embed, $video_link, $matches)) {
        $video_id = $matches[1];
    } elseif (preg_match($pattern_watch, $video_link, $matches)) {
        $video_id = $matches[1];
    } elseif (preg_match($pattern_short, $video_link, $matches)) {
        $video_id = $matches[1];
    }

    $key = "your_key";

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://www.googleapis.com/youtube/v3/videos?part=snippet&id='.$video_id.'&key='.$key,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $respe = json_decode($response, true);
    $resim = "";
    if(isset($respe['items'][0]['snippet']['thumbnails']['maxres']["url"])){
        $resim = $respe['items'][0]['snippet']['thumbnails']['maxres']["url"];
    }elseif(isset($respe['items'][0]['snippet']['thumbnails']['standard']["url"])){
        $resim = $respe['items'][0]['snippet']['thumbnails']['standard']["url"];
    }elseif(isset($respe['items'][0]['snippet']['thumbnails']['high']["url"])){
        $resim = $respe['items'][0]['snippet']['thumbnails']['high']["url"];
    }elseif(isset($respe['items'][0]['snippet']['thumbnails']['medium']["url"])){
        $resim = $respe['items'][0]['snippet']['thumbnails']['medium']["url"];
    }elseif(isset($respe['items'][0]['snippet']['thumbnails']['default']["url"])){
        $resim = $respe['items'][0]['snippet']['thumbnails']['default']["url"];
    }
    return $resim;
}
?>


<img src="<?=youtubeImage('https://www.youtube.com/watch?v=aLVVFfJntHU')?>">
