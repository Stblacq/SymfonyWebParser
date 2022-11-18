<?php
namespace App\Client;


class WebScrapper
{

    public static function getHtml($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $html = curl_exec($ch);
        return $html;
    }

    public static function getArticlesFromHTML($html){

        $doc = new \DOMDocument();
        @ $doc->loadHTML($html);
        $ps = $doc->getElementsByTagName('p')->lastChild();

        // $divs = $doc->getElementsByTagName('div');
        // $finder = new \DomXPath($doc);
        // $classname = "lenta-item";
        // $nodes = $finder->query("//*[contains(@class, '$classname')]");
        return $ps;
    }


}