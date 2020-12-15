<?php

namespace Anax\Controller;

use Anax\Models;
use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

/**
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class GeoWeatherController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    private $darksky;
    private $ipValidator;

    public function initialize()
    {
        $this->darksky = $this->di->get("apiWeather");
        $this->ipValidator = $this->di->get("apiIpValidator");
    }

    public function indexActionGet()
    {
        $title = "Weather forecast";
        $page = $this->di->get("page");
        $request = $this->di->get("request");

        $data = [
            "title" => $title,
            "ip" => $request->getServer("REMOTE_ADDR", ""),
            "content" => ""
        ];
        $page->add("anax/weather/header", $data);
        $page->add("anax/weather/index", $data);
        $page->add("anax/weather/footer", $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    public function indexActionPost()
    {
        $title = "Weather forecast";
        $page = $this->di->get("page");
        $request = $this->di->get("request");
        $location = $request->getPost("geo");
        $config = $request->getPost("weather");

        $data = $this->ipValidator->validateIp($location);
        $lat = "";
        $long = "";

        if ($data["valid"] == true) {
            $lat = $data["stack"]->{"latitude"};
            $long = $data["stack"]->{"longitude"};
            $weatherData = $this->darksky->getWeather($lat, $long, $config);

            $exists = true;
        } else {
            $splitLocation = explode(",", $location);
            if (count($splitLocation) == 2) {
                $lat = trim($splitLocation[0]);
                $long = trim($splitLocation[1]);
            }
            if (count($splitLocation) == 2 && is_numeric($lat) && is_numeric($long)) {
                if ($lat <= 90 && $lat >= -90 && $long >= -180 && $long <= 180) {
                    $weatherData = $this->darksky->getWeather($lat, $long, $config);
                    $exists = true;
                } else {
                    $weatherData = "";
                    $exists = false;
                }
            } else {
                $weatherData = "";
                $exists = false;
            }
        }

        if ($exists == true) {
            $mapNode = "var latitude = $lat; var longitude = $long;";
        } else {
            $mapNode = "";
        }

        $data = [
            "title" => $title,
            "weatherData" => $weatherData,
            "config" => $config,
            "exists" => $exists,
            "ip" => $location,
            "mapNode" => $mapNode
        ];
        $page->add("anax/weather/header", $data);
        $page->add("anax/weather/show", $data);
        $page->add("anax/weather/footer", $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * Action for REST API
     * GET mountpoint geo/json
     *
     * @return object
     */
    public function jsonAction(): object
    {
        $title = "Weather forecast in JSON";
        $request = $this->di->get("request");
        $page = $this->di->get("page");

        $data = [
            "title" => $title,
            "ip" => $request->getServer("REMOTE_ADDR", ""),
            "content" => ""
        ];

        $page->add("anax/weather/header", $data);
        $page->add("anax/weather/index", $data);
        $page->add("anax/weather/footer", $data);

        return $page->render($data);
    }

     /**
     * POST mountpoint ip/json
     *
     * @return object
     */
    public function jsonActionPOST()
    {
        $request = $this->di->get("request");
        $location = $request->getPost("geo");
        $config = $request->getPost("weather");

        $data = $this->ipValidator->validateIp($location);
        $lat = "";
        $long = "";

        if ($data["valid"] == true) {
            $lat = $data["stack"]->{"latitude"};
            $long = $data["stack"]->{"longitude"};
            $weatherData = $this->darksky->getWeather($lat, $long, $config);

            $exists = true;
        } else {
            $splitLocation = explode(",", $location);
            if (count($splitLocation) == 2) {
                $lat = trim($splitLocation[0]);
                $long = trim($splitLocation[1]);
            }
            if (count($splitLocation) == 2 && is_numeric($lat) && is_numeric($long)) {
                if ($lat <= 90 && $lat >= -90 && $long >= -180 && $long <= 180) {
                    $weatherData = $this->darksky->getWeather($lat, $long, $config);
                    $exists = true;
                } else {
                    $weatherData = "";
                    $exists = false;
                }
            } else {
                $weatherData = "";
                $exists = false;
            }
        }

        return json_encode($weatherData);
    }


    /**
     * Adding an optional catchAll() method will catch all actions sent to the
     * router. You can then reply with an actual response or return void to
     * allow for the router to move on to next handler.
     * A catchAll() handles the following, if a specific action method is not
     * created:
     * ANY METHOD mountpoint/**
     *
     * @param array $args as a variadic parameter.
     *
     * @return mixed
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function catchAll(...$args)
    {
        // Deal with the request and send an actual response, or not.
        //return __METHOD__ . ", \$db is {$this->db}, got '" . count($args) . "' arguments: " . implode(", ", $args);
        return;
    }
}
