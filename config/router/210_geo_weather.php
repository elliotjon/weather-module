<?php

/**
 * A controller class.
 */

return [
    "routes" => [
        [
            "info" => "Weather Controller.",
            "mount" => "geo",
            "handler" => "\Anax\Controller\GeoWeatherController",
        ],
    ]
];
