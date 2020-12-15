<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

// Prepare classes
$classes[] = "article";
if (isset($class)) {
    $classes[] = $class;
}


?>
<article <?= classList($classes) ?>>
<p>In this page you can enter a location and get the weather forecast. The location can be a geographical position or an ip-adress.</p>

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
</article>
