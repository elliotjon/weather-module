<?php

namespace Anax\Models;

/**
 * Class Weather
*/
class WeatherMock extends Weather
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
        if ($geo == "future") {
            $res = '{
                "latitude":37.4191589355470028976924368180334568023681640625,
                "longitude":-122.07540893555000138803734444081783294677734375,
                "timezone":"America\/Los_Angeles",
                "currently":{
                  "time":1608128203,
                  "summary":"Partly Cloudy",
                  "icon":"partly-cloudy-night",
                  "nearestStormDistance":8,
                  "nearestStormBearing":175,
                  "precipIntensity":0,
                  "precipProbability":0,
                  "temperature":6.2400000000000002131628207280300557613372802734375,
                  "apparentTemperature":5.269999999999999573674358543939888477325439453125,
                  "dewPoint":3.939999999999999946709294817992486059665679931640625,
                  "humidity":0.84999999999999997779553950749686919152736663818359375,
                  "pressure":1025,
                  "windSpeed":1.5800000000000000710542735760100185871124267578125,
                  "windGust":2.04000000000000003552713678800500929355621337890625,
                  "windBearing":67,
                  "cloudCover":0.409999999999999975575093458246556110680103302001953125,
                  "uvIndex":0,
                  "visibility":16.092999999999999971578290569595992565155029296875,
                  "ozone":296.6000000000000227373675443232059478759765625
                },
                "minutely":{
                  "summary":"Partly cloudy for the hour.",
                  "icon":"partly-cloudy-night",
                  "data":[
                    {
                      "time":1608128160,
                      "precipIntensity":0,
                      "precipProbability":0
                    },
                    {
                      "time":1608128220,
                      "precipIntensity":0,
                      "precipProbability":0
                    }
                  ]
                },
                "daily":{
                  "summary":"Mixed precipitation throughout the week.",
                  "icon":"rain",
                  "data":[{
                    "time":1608591600,
                    "summary":"Rain in the morning and afternoon.",
                    "icon":"rain",
                    "sunriseTime":1608622620,
                    "sunsetTime":1608647940,
                    "moonPhase":0.28,
                    "precipIntensity":0.35,
                    "precipIntensityMax":1.1545,
                    "precipIntensityMaxTime":1608616740,
                    "precipProbability":0.96,
                    "precipType":"rain",
                    "temperatureHigh":8.88,
                    "temperatureHighTime":1608644880,
                    "temperatureLow":4.33,
                    "temperatureLowTime":1608703200,
                    "apparentTemperatureHigh":5.16,
                    "apparentTemperatureHighTime":1608642540,
                    "apparentTemperatureLow":0.41,
                    "apparentTemperatureLowTime":1608703200,
                    "dewPoint":4.38,
                    "humidity":0.88,
                    "pressure":1005.1,
                    "windSpeed":8.38,
                    "windGust":15.63,
                    "windGustTime":1608653220,
                    "windBearing":212,
                    "cloudCover":0.86,
                    "uvIndex":0,
                    "uvIndexTime":1608635040,
                    "visibility":15.623,
                    "ozone":267,
                    "temperatureMin":4.51,
                    "temperatureMinTime":1608616380,
                    "temperatureMax":8.88,
                    "temperatureMaxTime":1608644880,
                    "apparentTemperatureMin":-0.59,
                    "apparentTemperatureMinTime":1608615660,
                    "apparentTemperatureMax":5.16,
                    "apparentTemperatureMaxTime":1608642540
                  }]
                }
              }';
              $data = json_decode($res);
        } else {
            $res1 = '{
            "latitude":37.4191589355470028976924368180334568023681640625,
            "longitude":-122.07540893555000138803734444081783294677734375,
            "timezone":"America\/Los_Angeles",
            "currently":{
              "time":1608128203,
              "summary":"Partly Cloudy",
              "icon":"partly-cloudy-night",
              "nearestStormDistance":8,
              "nearestStormBearing":175,
              "precipIntensity":0,
              "precipProbability":0,
              "temperature":6.2400000000000002131628207280300557613372802734375,
              "apparentTemperature":5.269999999999999573674358543939888477325439453125,
              "dewPoint":3.939999999999999946709294817992486059665679931640625,
              "humidity":0.84999999999999997779553950749686919152736663818359375,
              "pressure":1025,
              "windSpeed":1.5800000000000000710542735760100185871124267578125,
              "windGust":2.04000000000000003552713678800500929355621337890625,
              "windBearing":67,
              "cloudCover":0.409999999999999975575093458246556110680103302001953125,
              "uvIndex":0,
              "visibility":16.092999999999999971578290569595992565155029296875,
              "ozone":296.6000000000000227373675443232059478759765625
            },
            "minutely":{
              "summary":"Partly cloudy for the hour.",
              "icon":"partly-cloudy-night",
              "data":[
                {
                  "time":1608128160,
                  "precipIntensity":0,
                  "precipProbability":0
                },
                {
                  "time":1608128220,
                  "precipIntensity":0,
                  "precipProbability":0
                }
              ]
            },
            "daily":{
              "summary":"Mixed precipitation throughout the week.",
              "icon":"rain",
              "data":[{
                "time":1608591600,
                "summary":"Rain in the morning and afternoon.",
                "icon":"rain",
                "sunriseTime":1608622620,
                "sunsetTime":1608647940,
                "moonPhase":0.28,
                "precipIntensity":0.35,
                "precipIntensityMax":1.1545,
                "precipIntensityMaxTime":1608616740,
                "precipProbability":0.96,
                "precipType":"rain",
                "temperatureHigh":8.88,
                "temperatureHighTime":1608644880,
                "temperatureLow":4.33,
                "temperatureLowTime":1608703200,
                "apparentTemperatureHigh":5.16,
                "apparentTemperatureHighTime":1608642540,
                "apparentTemperatureLow":0.41,
                "apparentTemperatureLowTime":1608703200,
                "dewPoint":4.38,
                "humidity":0.88,
                "pressure":1005.1,
                "windSpeed":8.38,
                "windGust":15.63,
                "windGustTime":1608653220,
                "windBearing":212,
                "cloudCover":0.86,
                "uvIndex":0,
                "uvIndexTime":1608635040,
                "visibility":15.623,
                "ozone":267,
                "temperatureMin":4.51,
                "temperatureMinTime":1608616380,
                "temperatureMax":8.88,
                "temperatureMaxTime":1608644880,
                "apparentTemperatureMin":-0.59,
                "apparentTemperatureMinTime":1608615660,
                "apparentTemperatureMax":5.16,
                "apparentTemperatureMaxTime":1608642540
              }]
            }
          }';
            $res2 = '{
            "latitude":37.4191589355470028976924368180334568023681640625,
            "longitude":-122.07540893555000138803734444081783294677734375,
            "timezone":"America\/Los_Angeles",
            "currently":{
              "time":1608128203,
              "summary":"Partly Cloudy",
              "icon":"partly-cloudy-night",
              "nearestStormDistance":8,
              "nearestStormBearing":175,
              "precipIntensity":0,
              "precipProbability":0,
              "temperature":6.2400000000000002131628207280300557613372802734375,
              "apparentTemperature":5.269999999999999573674358543939888477325439453125,
              "dewPoint":3.939999999999999946709294817992486059665679931640625,
              "humidity":0.84999999999999997779553950749686919152736663818359375,
              "pressure":1025,
              "windSpeed":1.5800000000000000710542735760100185871124267578125,
              "windGust":2.04000000000000003552713678800500929355621337890625,
              "windBearing":67,
              "cloudCover":0.409999999999999975575093458246556110680103302001953125,
              "uvIndex":0,
              "visibility":16.092999999999999971578290569595992565155029296875,
              "ozone":296.6000000000000227373675443232059478759765625
            },
            "minutely":{
              "summary":"Partly cloudy for the hour.",
              "icon":"partly-cloudy-night",
              "data":[
                {
                  "time":1608128160,
                  "precipIntensity":0,
                  "precipProbability":0
                },
                {
                  "time":1608128220,
                  "precipIntensity":0,
                  "precipProbability":0
                }
              ]
            },
            "daily":{
              "summary":"Mixed precipitation throughout the week.",
              "icon":"rain",
              "data":[{
                "time":1608591600,
                "summary":"Rain in the morning and afternoon.",
                "icon":"rain",
                "sunriseTime":1608622620,
                "sunsetTime":1608647940,
                "moonPhase":0.28,
                "precipIntensity":0.35,
                "precipIntensityMax":1.1545,
                "precipIntensityMaxTime":1608616740,
                "precipProbability":0.96,
                "precipType":"rain",
                "temperatureHigh":8.88,
                "temperatureHighTime":1608644880,
                "temperatureLow":4.33,
                "temperatureLowTime":1608703200,
                "apparentTemperatureHigh":5.16,
                "apparentTemperatureHighTime":1608642540,
                "apparentTemperatureLow":0.41,
                "apparentTemperatureLowTime":1608703200,
                "dewPoint":4.38,
                "humidity":0.88,
                "pressure":1005.1,
                "windSpeed":8.38,
                "windGust":15.63,
                "windGustTime":1608653220,
                "windBearing":212,
                "cloudCover":0.86,
                "uvIndex":0,
                "uvIndexTime":1608635040,
                "visibility":15.623,
                "ozone":267,
                "temperatureMin":4.51,
                "temperatureMinTime":1608616380,
                "temperatureMax":8.88,
                "temperatureMaxTime":1608644880,
                "apparentTemperatureMin":-0.59,
                "apparentTemperatureMinTime":1608615660,
                "apparentTemperatureMax":5.16,
                "apparentTemperatureMaxTime":1608642540
              }]
            }
          }';
            $data[0] = json_decode($res1);
            $data[1] = json_decode($res2);
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
