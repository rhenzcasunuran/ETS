<?php
// Get the absolute path to the directory containing this script
$scriptPath = dirname(__FILE__);

// Set the working directory to the parent directory
chdir($scriptPath . '/../');

// Load environment variables from a separate configuration file
$config = parse_ini_file('config/googlecalendarapi.ini', true);

$CLIENT_ID = $config['GoogleAPI']['CLIENT_ID'];
$API_KEY = $config['GoogleAPI']['API_KEY'];
$DISCOVERY_DOC = $config['GoogleAPI']['DISCOVERY_DOC'];
$SCOPES = $config['GoogleAPI']['SCOPES'];
?>
