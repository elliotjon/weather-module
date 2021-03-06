<?php

/**
 * Class IpValidator
 * Validate ip and return result.
*/

namespace Anax\Models;

use Anax\Config\access;

class IpMock extends IpValidator
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

    /**
     * Validate IP-adress
     */
    public function validateIp($ipAdress)
    {
        $accessToken = $this->keys["ipValidator"];
        $stackUrl = 'http://api.ipstack.com/' . $ipAdress . '?access_key=' . $accessToken . '';

        $host = "";
        $stack = "";
        $type = "";
        $valid = "";

        if (filter_var($ipAdress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $host = gethostbyaddr($ipAdress);
            $stack = json_decode('{"latitude":37.4191589355470028976924368180334568023681640625, "longitude":-122.07540893555000138803734444081783294677734375}');
            $type = "IPv4";
            $valid = true;
        } elseif (filter_var($ipAdress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $host = gethostbyaddr($ipAdress);
            $stack = json_decode('{"latitude":37.4191589355470028976924368180334568023681640625, "longitude":-122.07540893555000138803734444081783294677734375}');
            $type = "IPv6";
            $valid = true;
        } else {
            $valid = false;
        }
        
        $data = [
            "ip" => $ipAdress,
            "valid" => $valid,
            "type" => $type,
            "host" => $host,
            "stack" => $stack
        ];
        return $data;
    }

    /**
     * Get current IP-adress
     */
    public function getYourIp($request)
    {
        if (!empty($request->getServer('HTTP_CLIENT_IP'))) {
            $ipAdress = $server('HTTP_CLIENT_IP');
        } elseif (!empty($request->getServer('HTTP_X_FORWARDED_FOR'))) {
            $ipAdress = $request->getServer('HTTP_X_FORWARDED_FOR');
        } else {
            $ipAdress = $request->getServer('REMOTE_ADDR');
        }

        return $ipAdress;
    }
}
