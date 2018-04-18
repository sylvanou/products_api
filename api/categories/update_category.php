<?php
// if the form was submitted
if ($_POST) {

    // include core configuration
    include_once('../../config/core.php');

    // include database connection
    include_once('../../config/database.php');

    // category object
    include_once('../../objects/category.php');

    // create class instance of database
    $database = new Database();
    $db = $database->getConnection();
    $category = new Category($db);

    // set category property values
    $category->name = $_POST['name'];
    $category->description = $_POST['description'];
    $category->id = $_POST['id'];
    
    // create the category
    echo $category->update($category->id) ? "true" : "false";
}

