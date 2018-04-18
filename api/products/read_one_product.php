<?php

// include core configuration
include_once('../../config/core.php');

// include database connection
include_once('../../config/database.php');

// product object
include_once('../../objects/product.php');

// create class instance of database
$database = new Database();
$db = $database->getConnection();
$product = new Product($db);

// read all the products
$product->id = $_POST['prod_id'];
$results = $product->readOne();

// output in json format
echo $results;