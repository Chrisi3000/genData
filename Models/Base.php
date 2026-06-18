<?php

abstract class Models_Base {
    protected PDO $connection;

    public function __construct() {
        $host = "127.0.0.1";
        $dbname = "team_01";
        $username = "root";
        $password = "";
        $connectionstring = "mysql:host=$host;dbname=$dbname;";
        $this->connection = new PDO($connectionstring, $username, $password);
    }
}