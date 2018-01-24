<?php

/* * *
*
* /core/process/data.loader.php
* /core/process/aru.php
* /core/cron/crontabs.include.php
*
* * */

$cities = new stdClass();
$cityID = false;
$citySplit = false;
$limit = '';

$req = "SELECT city_id, name, lat, lon, radius_m FROM zlasu_cities WHERE city_id>0 ORDER BY name";
$result = $mysqli->query($req);

while ($data = $result->fetch_object()) {
	$id = $data->city_id;
	$cities->$id = new stdClass();
	$cities->$id->id = $data->city_id;
	$cities->$id->name = $data->name;
	$cities->$id->nameHash = sha1($data->name.$data->city_id.$data->radius_m);
	$cities->$id->lat = $data->lat;
	$cities->$id->long = $data->lon;
	$cities->$id->radius = $data->radius_m;
}

if ($_COOKIE["city"]) {
	foreach ($cities as $k => $v) {
		if ($v->nameHash == $_COOKIE["city"]) {
			$cityID = $k;
		}
	}
}

if ($cityID) {
	$citySplit = true;
	$lat_dev  = $cities->$cityID->radius / 1000 * 0.008993075;
	$long_dev = $cities->$cityID->radius / 1000 * 0.014654;
	$limit = " AND latitude > " . ($cities->$cityID->lat - $lat_dev) . " AND latitude < " . ($cities->$cityID->lat + $lat_dev) . " AND longitude > " . ($cities->$cityID->long - $long_dev) . " AND longitude < " . ($cities->$cityID->long + $long_dev) . " ";
	$cityName = $cities->$cityID->name;
	$mapCenter = array("lat"=>$cities->$cityID->lat, "long"=>$cities->$cityID->long);
}
else {
	$cityName = "Polska";
	$mapCenter = false;
}

$selectCity = '
<span class="menu-select">
	choose city: <select class="change-city">
		<option value="all">all cities</option>
';
foreach ($cities as $k => $v) {
	$selected = ($k === $cityID) ? " selected" : "";
	$selectCity .= '		<option value="'.$v->nameHash.'"'.$selected.'>'.$v->name.'</option>'.PHP_EOL;
}
$selectCity .= '	</select>
</span>
';