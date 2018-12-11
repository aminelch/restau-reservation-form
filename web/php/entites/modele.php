<?php
abstract class Modele {
    const host="localhost";
    protected $pdo;
    const user="aminelch";   
    const login="demo";
    const bd="restaurant";

    function __construct(){
        $this->pdo=new PDO("mysql:host=".self::host.";dbname=".self::bd,self::user, self::login);
    }

    function __destruct(){
        $this->pdo=null;
    
    }

}
