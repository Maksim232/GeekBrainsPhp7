<?php

use App\Person\Name;
use App\Blog\User;
include __DIR__ . "/vendor/autoload.php";

//spl_autoload_register('load');

//function load($class_name)
//{
//    $file = str_replace('_', DIRECTORY_SEPARATOR, strtolower($class_name)).'.php';
//    $file = str_replace("\\", "/", $file);
//    if ( ! file_exists($file))
//    {
//        return FALSE;
//    }
//    include $file;
//}
//$faker = Faker\Factory::create('ru_RU');
//
//$name2 = new  Name(
//    $faker->firstName('male'),
//    $faker->lastName()
//);
//$user = new User (1, $name2, 'Logg');
//echo $user;
$name2 = new Name ('Viktor', 'Ivanov');
$user = new User ($name2 ,1, ' Logg ');
echo $user;

