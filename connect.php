<?php

include "config.php";

if ( ! defined( 'ABSPATH' ) ) {
   exit; // Exit if accessed directly
}

$url = "https://api.duolingo.com/2017-06-30/users/94105502?fields=courses,creationDate,learningLanguage,picture,totalXp,username,streak";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   $duo_headers,
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$data = curl_exec($curl);
curl_close($curl);

?>