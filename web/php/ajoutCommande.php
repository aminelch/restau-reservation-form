<?php
//require 'entites/Client.php';
//$client = new Client();
if (isset($_POST) && ! empty($_POST)){
    extract ($_POST);
}
    json_encode("OK");
//$liste_client= $client->insert()
