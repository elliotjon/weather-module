<?php
/**
 * Configuration file for DI IpValidator
 */
return [
    // Services to add to the container.
    "services" => [
        "apiIpValidator" => [
            "shared" => true,
            "callback" => function () {
                $IpModel = new \Anax\Models\IpValidator();

                // Load the configuration files
                $cfg = $this->get("configuration");
                $config = $cfg->load("access.php");
                $IpModel->setKeys($config['config']);
                return $IpModel;
            }
        ],
    ],
];
