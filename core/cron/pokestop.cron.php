<?php
	
	
// -----------------------------------------------------------------------------------------------------------
// Pokestops datas 
// Total pokestops
// Total lured
// -----------------------------------------------------------------------------------------------------------

$pokestop['timestamp'] = $timestamp;

$req = "SELECT COUNT(*) AS total FROM pokestop WHERE true" . ($citySplit ? $cityLimit : '');
$result = $mysqli->query($req);
$data = $result->fetch_object();

$pokestop['total'] = $data->total;

$req = "SELECT COUNT(*) AS total FROM pokestop WHERE lure_expiration >= UTC_TIMESTAMP()" . ($citySplit ? $cityLimit : '');
$result = $mysqli->query($req);
$data = $result->fetch_object();

$pokestop['lured'] = $data->total;



// Add the datas in file
$stopdatas[] = $pokestop;
file_put_contents($pokestop_file, json_encode($stopdatas));
