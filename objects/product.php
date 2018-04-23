<?php
class Product {
    // database connection and table name
    private $conn;
    private $table_name = 'products';

    // object properties
    public $id;
    public $name;
    public $price;
    public $description;
    public $category_id;
    public $timestamp;
    
    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        try {
            
            // insert query
            $query = "INSERT INTO products
                SET name=:name, description=:description, price=:price,
                category_id=:category_id, created=:created";

            // prepare statement
            $stmt = $this->conn->prepare($query);

            // sanitize
            $name = htmlspecialchars(strip_tags($this->name));
            $description = htmlspecialchars(strip_tags($this->description));
            $price = htmlspecialchars(strip_tags($this->price));
            $category_id = htmlspecialchars(strip_tags($this->category_id));

            // bind the parameters
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':category_id', $category_id);

            // we need the created variable to know when the record was created
            // also, to comply with strict standards: only variable should be passed
            // by reference
            $created = date('Y-m-d H:i:s');
            $stmt->bindParam(':created', $created);

            // execute the query
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }

        }  // show error if any
        catch(PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
    }
    
    public function readAll() {
        
        // select all data
        $query = "SELECT p.id, p.name, p.description, p.category_id, p.price, c.name as category_name 
         FROM " . $this->table_name . " p
         LEFT JOIN categories c 
         ON p.category_id = c.id
         ORDER BY id DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

       return json_encode($results);
    }

    public function readOne($id) {

        // select the data
        $query = "SELECT p.id, p.name, p.description, p.price, c.name as category_name 
         FROM " . $this->table_name . " p
         LEFT JOIN categories c 
         ON p.category_id = c.id
         WHERE p.id = :id";

         // prepare the query for execution
         $stmt = $this->conn->prepare($query);

         // sanitize id with htmlspecialchars
         $id = htmlspecialchars(strip_tags($id));
         $stmt->bindParam(':id', $id);

         $stmt->execute();

         $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

         return json_encode($results);
    }

    public function update($id) {

        // update product based on id
        $query = "UPDATE products
                    SET name=:name, description=:description, price=:price,
                category_id=:category_id
                WHERE id=:id";

        // prepare statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $name = htmlspecialchars(strip_tags($this->name));
        $description = htmlspecialchars(strip_tags($this->description));
        $price = htmlspecialchars(strip_tags($this->price));
        $category_id = htmlspecialchars(strip_tags($this->category_id));
        $id = htmlspecialchars(strip_tags($this->id));

        // bind the parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        }  else {
            return false;
        }
    }

    public function delete($id) {
        
        // query to delete a product from the db 
        $query = "DELETE FROM products WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        // sanitize
        $id = htmlspecialchars(strip_tags($id));

        // bind the parameter
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        }  else {
            return false;
        }
    }

}