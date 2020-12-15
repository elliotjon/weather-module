<?php

namespace Anax\Models;

use Anax\Config\access;

/**
 * Class Weather
*/
class Weather
{
    private $keys;

    public function setKeys($config)
    {
        $this->keys = $config;
    }

    /**
    * Curl from url
    */

    public function curl($url)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($curl);
        curl_close($curl);

        return $data;
    }

    public function multiCurl($urls)
    {
        $opts = [
            CURLOPT_RETURNTRANSFER => true,
        ];
        $cAll = [];

        $mh = curl_multi_init();

        foreach ($urls as $url) {
            $ch = curl_init("$url");
            curl_setopt_array($ch, $opts);
            curl_multi_add_handle($mh, $ch);
            $cAll[] = $ch;
        }

        $running = null;
        do {
            curl_multi_exec($mh, $running);
        } while ($running);

        foreach ($cAll as $ch) {
            curl_multi_remove_handle($mh, $ch);
        }
        curl_multi_close($mh);

        $response = [];
        foreach ($cAll as $ch) {
            $data = curl_multi_getcontent($ch);
            array_push($response, $data);
        }

        return $response;
    }

    public function getWeather($lat, $long, $geo)
    {
        $urls;
        $accessToken = $this->keys["darkSky"];

        if ($geo == "future") {
            $url = 'https://api.darksky.net/forecast/' . $accessToken . "/" . $lat . "," . $long . "?units=si";
            $data = json_decode($this->curl($url));
        } else {
            $days = 5;
            for ($i = 0; $i < $days; $i++) {
                $timestamp = "-" . $i . " day";
                $time = strtotime($timestamp, time());
                $urls[$i] = 'https://api.darksky.net/forecast/' . $accessToken . "/" . $lat . "," . $long . "," . $time . "?units=si";
            }
            $curlResponse = $this->multiCurl($urls);
            for ($i = 0; $i < $days; $i++) {
                $data[$i] = json_decode($curlResponse[$i]);
            }
        }
        $mapUrl = "https://nominatim.openstreetmap.org/reverse?lat=$lat&lon=$long&email=elliot.nordin@gmail.com&format=json";
        $mapData = json_decode($this->curl($mapUrl));
        $weatherData = [
            "data" => $data,
            "mapData" => $mapData
        ];
        return $weatherData;
    }
}
