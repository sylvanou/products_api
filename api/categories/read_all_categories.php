<?php
// include core configuration
include_once('../../config/core.php');

// include database connection
include_once('../../config/database.php');

// product object
include_once('../../objects/category.php');

// create class instance of database
$database = new Database();
$db = $database->getConnection();
$category = new Category($db);

// read all the products
$results = $category->readAll();

// output in json format
echo $results;