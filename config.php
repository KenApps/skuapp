<?php
session_start();
require_once 'lib/lib.php';
$app=new App();
error_reporting(E_ALL ^ E_NOTICE);
class Config
{
    static $confArray;
    public static function read($name)
    {
        return self::$confArray[$name];
    }
    public static function write($name, $value)
    {
        self::$confArray[$name] = $value;
    }
}
Config::write('db.host', 'localhost');
Config::write('db.port', '3306');
Config::write('db.basename', 'sample');
Config::write('db.user', 'root');
Config::write('db.password', 'sasken');
?>