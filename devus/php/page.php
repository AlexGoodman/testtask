<?php
/**
 * Created by PhpStorm.
 * User: Alexandr
 * Date: 12.06.2015
 * Time: 23:30
 */

$post = $_POST['url'];

$url = $post;

$ch=curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt ($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$content = curl_exec ($ch);
curl_close($ch);

$string = '';
$arrStart = explode('story-content', $content);
foreach($arrStart as $k => $v){
    if($k != 0){
        $arr = explode('</p>', $v);
        $arr = explode('>', $arr[0], 2);
        $string .= '<p>' . $arr[1] . '</p>';
    }
}

echo json_encode($string);