<?php

/**
* Render content within an article.
*/

namespace Anax\View;


// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

// Prepare classes
$classes[] = "article";
if (isset($class)) {
    $classes[] = $class;
}

?>

<article <?= classList($classes) ?>>
<form method="post">

<p>
<input type="radio" name="weather" value="future" checked>
    <label>Upcoming weather</label> <br />
  <input type="radio" name="weather" value="past">
    <label>Past weather</label><br /><br />
  <label>Enter Location:</label>
  <input row="1" columns="1" type="text" name="geo" value="<?= $data["ip"] ?>">
  <button name="doCheck">Submit</button>
</p>
<br>
<p>This is the <b><?= $config ?></b> weather forecast for:</p>
<?php if ($exists == true) {?>
    <p>TimeZone:
    <?php if ($config == "future") {
        $location = $data["weatherData"]["data"]->{"timezone"};
    } else {
        $location = $data["weatherData"]["data"][0]->{"timezone"};
    }?>
    <?=$location?>
    </p>
    <p>Location:  <?php if (property_exists($weatherData["mapData"], "display_name")) {?>
        <?= $weatherData["mapData"]->{"display_name"}; ?></p>
                  <?php } ?></p>
<?php } ?>

<table>
    <tr>
        <th>Day</th>
        <th>Date</th>
        <th>Summary</th>
        <th>Temp min (c)</th>
        <th>Temp max (c)</th>
        <th>Wind (m/s)</th>
    </tr>
<?php
if ($exists == true) {
    if ($config == "future") {
    // var_dump($data["weatherData"]["data"]);
        foreach ($data["weatherData"]["data"]->{"daily"}->{"data"} as $daily) { ?>
            <tr>
                <td><?= Date("l", $daily->{"time"}) ?></td>
                <td><?= Date("d/m/Y", $daily->{"time"}) ?></td>
                <td><?= property_exists($daily, "summary") ? $daily->{"summary"} : "-" ?></td>
                <td align="center"><?= round($daily->{"temperatureMin"}) ?></td>
                <td align="center"><?= round($daily->{"temperatureMax"}) ?></td>
                <td align="center"><?= round($daily->{"windSpeed"}) ?></td>
            </tr>
        <?php }
    } else {
        foreach ($data["weatherData"]["data"] as $daily) { ?>
            <tr>
                <td><?= Date("l", $daily->{"daily"}->{"data"}[0]->{"time"}) ?></td>
                <td><?= Date("d/m/Y", $daily->{"daily"}->{"data"}[0]->{"time"}) ?></td>
                <td><?= property_exists($daily->{"daily"}->{"data"}[0], "summary") ? $daily->{"daily"}->{"data"}[0]->{"summary"} : "-" ?></td>
                <td align="center"><?= round($daily->{"daily"}->{"data"}[0]->{"temperatureMin"}) ?></td>
                <td align="center"><?= round($daily->{"daily"}->{"data"}[0]->{"temperatureMax"}) ?></td>
                <td align="center"><?= round($daily->{"daily"}->{"data"}[0]->{"windSpeed"}) ?></td>
            </tr>
        <?php }
    }
} else { ?>
    <tr>
        <td colspan="6" align="center">Something went wrong when trying to curl the weather...</td>
    </tr>
<?php } ?>
</table>

<?php if ($exists == true) { ?>
    <div class="map">
    <h3>Map</h3>
   
    </div>
<div id="map" style="width: 100%; height: 350px;"></div>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
      integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
      crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
      integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
      crossorigin=""></script>
<script type="text/javascript">
    <?= $mapNode ?>
    setTimeout(() => {
        if (latitude && longitude) {
            var map = new L.Map('map');
            L.marker([latitude, longitude]).addTo(map);
            var openStreetMapUrl = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            openStreetMapAttr = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            openStreetMap = new L.TileLayer(openStreetMapUrl, { maxZoom: 18, attribution: openStreetMapAttr });
            map.setView(new L.LatLng(latitude, longitude), 13).addLayer(openStreetMap);
        }
    }, 500);
</script>
<?php } ?>

</article>
