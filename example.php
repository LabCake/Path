<?php

include_once "Path.php";

// Resolve root path of this file
$root = LabCake\Path::resolve(\LabCake\Path::dirname(__FILE__)); // return example: /var/www/

// Resolve test folder path
$test_folder = \LabCake\Path::resolve($root, "test"); // return example: /var/www/test/

if (!\LabCake\Path::exists($test_folder)) // Check if test folder exists
    \LabCake\Path::mkdir($test_folder); //Creates the /var/www/test folder if allowed