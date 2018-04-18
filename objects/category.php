<?php
class Category
{
    // database connection and table name
    private $conn;
    private $table_name = 'categories';

    // object properties
    public $id;
    public $name;
    public $description;
    public $timestamp;


    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        try {
            
            // insert query
            $query = "INSERT INTO " . $this->table_name .
                     " SET name=:name, description=:description, created=:created";

            // prepare statement
            $stmt = $this->conn->prepare($query);

            // sanitize
            $name = htmlspecialchars(strip_tags($this->name));
            $description = htmlspecialchars(strip_tags($this->description));

            // bind the parameters
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);

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
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
    }

    public function readAll()
    {
        
        // select all data
        $query = "SELECT *
         FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($results);
    }

    public function readOne()
    {

        // select the data
        $query = "SELECT p.id, p.name, p.description, p.price, c.name as category_name 
         FROM " . $this->table_name . " p
         LEFT JOIN categories c 
         ON p.category_id = c.id
         WHERE p.id = :id";

         // prepare the query for execution
        $stmt = $this->conn->prepare($query);

         // sanitize id with htmlspecialchars
        $id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $id);

        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($results);
    }

    public function update($id)
    {

        // update category based on id
        $query = "UPDATE categories 
        SET name=:name, description=:description 
                 WHERE id=:id";

        // prepare statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $name = htmlspecialchars(strip_tags($this->name));
        $description = htmlspecialchars(strip_tags($this->description));
        $id = htmlspecialchars(strip_tags($this->id));

        // bind the parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($id)
    {
        
        // query to delete a product from the db 
        $query = "DELETE FROM categories WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        // sanitize
        $id = htmlspecialchars(strip_tags($id));

        // bind the parameter
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

}