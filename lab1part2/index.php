<?php
require_once("vendor/autoload.php");

ini_set('memory_limit', '-1');
$weather = new Weather();
$egyptian_cities = $weather->get_cities();
if (isset($_POST["egy_city"])) {
    $weather_data =  $weather->get_weather($_POST['egy_city']);
    foreach ($weather_data as $key => $value) {
        if ($key === 'name') echo '<h2>' . $value . ' weather status' . '</h2>';
    }
    $weather->get_current_time();

    foreach ($weather_data as $key => $value) {
        if ($key === "weather") {
            foreach ($value as $k => $val) {
                if ($k === 0) {
                    foreach ($val as $key => $v) {
                        if ($key === "description") echo $v . '<br>';
                    }
                }
            }
        }
        if ($key === 'main' || $key === 'wind') {
            foreach ($value as $ke => $v) {
                if ($ke === "temp") echo $ke . " : " . $v-273.15 . "<br>";
                if ($ke === "humidity") echo $ke . " : " . $v . "% <br>";
                if ($ke === 'speed')  echo $key . " : " . $v . "Km/h <br>";
            }
        }
    }
}
?>
<html>

<head>
    <meta charset="UTF-8">
    <title></title>
</head>

<body>
    <?php
    echo '<form action="#" method="POST">';
    echo "<select name='egy_city'>";
    foreach ($egyptian_cities as $key => $value) {
        foreach ($value as $k => $val) {
            if ($k === "id") {
                $cityid = $val;
            }
            if ($k === "name") {
                echo "<option value='$cityid' >$val</option>";
            }
        }
    }    echo "</select>";
    echo '<button type="submit">submit</button>';
    echo "</form>";
    ?>

</body>

</html>