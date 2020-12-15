<?php

/**
 * Configuration file for DI Weather
 */

return [
    // Services to add to the container.
    "services" => [
        "apiWeather" => [
            "shared" => true,
            "callback" => function () {
                $weatherModel = new \Anax\Models\Weather();

                // Load the configuration files
                $cfg = $this->get("configuration");
                $config = $cfg->load("access.php");
                $weatherModel->setKeys($config['config']);
                return $weatherModel;
            }
        ],
    ],
];
