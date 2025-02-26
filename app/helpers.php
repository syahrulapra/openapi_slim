<?php
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

if (!function_exists('base_path')) {
    function base_path($path = '')
    {
        return  __DIR__ . "/../{$path}";
    }
}

if (!function_exists('database_path')) {
    function database_path($path = '')
    {
        return base_path("database/{$path}");
    }
}

if (!function_exists('checkDB')) {
    function checkDB($args = null)
    {
        $con = mysqli_connect(env('DB_HOST'), env('DB_USER'), env('DB_PASS'));
        $result = mysqli_query($con, "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '" . env('DB_NAME') . "'");
        if($result->num_rows>0) {
            return true;
        }
    
        echo createDatabase();
        return true;
    }
}

if (!function_exists('createDatabase')) {
    function createDatabase()
    {
        $con = mysqli_connect(env('DB_HOST'), env('DB_USER'), env('DB_PASS'));
        $sql = "CREATE DATABASE IF NOT EXISTS " . env('DB_NAME');
        $result = mysqli_query($con, $sql);
        if(!$result) {
            die(mysqli_error($con));
        }
        return "database " . env('DB_NAME') . " created successfully.\n";
    }
}
