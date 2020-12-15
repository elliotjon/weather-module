<?php

namespace Anax\View;

/**
 * Template file to render a view.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());



?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <navbar class="navbar">
        <span>
            <a href="<?= url("geo") ?>">Weather</a> |
            <a href="<?= url("geo/json") ?>">Weather JSON</a> |
        </span>
    </navbar>


<h1><?= $title ?></h1>
<main>