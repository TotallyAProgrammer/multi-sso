<?php
#RADIUS Auth function

require_once './vender/dapphp/radius/autoload.php';
use Dapphp\Radius\Radius;



function radiusAuth($username, $password, $configLocation) #, $server, $secret, $nasIP, $nasID)
{
    #date_default_timezone_set("America/Chicago");
    #$nbf = date('U');

    // set server, secret, and basic attributes
  $radiusConfig = parse_ini_file($configLocation); //Config File location
  $client = new Radius();
    $client->setServer($radiusConfig["serverIP"]) // RADIUS server address
   ->setSecret($radiusConfig["secret"]) // Server Secret
   ->setNasIpAddress($radiusConfig["nasIPID"]) // NAS server address
   ->setAttribute(32, $radiusConfig["nasID"]);  // NAS identifier

  // PAP authentication; returns true if successful, false otherwise
    $authenticated = $client->accessRequest($username, $password);

    if ($authenticated === false) {
        #echo sprintf("Access-Request failed with error %d (%s).\n", $client->getErrorCode(), $client->getErrorMessage());
        return false;
    } else {
        return true;
    }
}