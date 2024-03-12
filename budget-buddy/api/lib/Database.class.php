<?php

class Database
{
    static $db;
    public static function getConnection()
    {
        $config_json = file_get_contents(
            $_SERVER["DOCUMENT_ROOT"] . "/../API-conf.json"
        );
        $config = json_decode($config_json, true);
        if (Database::$db != null) {
            return Database::$db;
        } else {
            Database::$db = mysqli_connect("db", "root", "example", "apis");
            if (!Database::$db) {
                die("Connection failed: " . mysqli_connect_error());
            } else {
                return Database::$db;
            }
        }
    }
}
