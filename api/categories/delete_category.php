<?php
// if the form was submitted
if ($_POST) {

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

    $id = $_POST['del_id'];

    echo $category->delete($id) ? "true" : "false";

}

