<?php

abstract class Models_Base {
    protected PDO $connection;

    // initializes a reusable local database connection pooling resource on object creation
    public function __construct() {
        $host = "127.0.0.1";
        $dbname = "team_01";
        $username = "root";
        $password = "";
        $connectionstring = "mysql:host=$host;dbname=$dbname;";
        // instantiates native pdo database connector resource using target driver properties
        $this->connection = new PDO($connectionstring, $username, $password);
    }
}