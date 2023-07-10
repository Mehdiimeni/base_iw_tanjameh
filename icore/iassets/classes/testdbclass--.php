<?php

class Database
{
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $ip;
    private $port;
    private $conn;

    public function __construct(array $array)
    {

        $this->host = base64_decode(base64_decode($array['Host']));
        $this->db_name = base64_decode(base64_decode($array['Database']));
        $this->username = base64_decode(base64_decode($array['User']));
        $this->password = base64_decode(base64_decode($array['Password']));
        $this->ip = base64_decode(base64_decode($array['IP']));
        $this->port = base64_decode(base64_decode($array['Port']));

        $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name;
        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        try {
            $this->conn = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function create($table, $data)
    {
        $columns = implode(", ", array_keys($data));
        $values = ":" . implode(", :", array_keys($data));
        $query = "INSERT INTO $table ($columns) VALUES ($values)";
        
        $stmt = $this->conn->prepare($query);
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function read($table, $conditions = array(), $fetch_style = PDO::FETCH_ASSOC)
    {
        $query = "SELECT * FROM $table";

        if (!empty($conditions)) {
            $query .= " WHERE ";
            $where = array();
            foreach ($conditions as $key => $value) {
                $where[] = "$key = :$key";
            }
            $query .= implode(" AND ", $where);
        }

        $stmt = $this->conn->prepare($query);
        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();

        return $stmt->fetchAll($fetch_style);
    }

    public function update($table, $data, $conditions)
    {
        $set = array();
        foreach ($data as $key => $value) {
            $set[] = "$key = :$key";
        }
        $set_clause = implode(", ", $set);

        $where = array();
        foreach ($conditions as $key => $value) {
            $where[] = "$key = :$key";
        }
        $where_clause = implode(" AND ", $where);

        $query = "UPDATE $table SET $set_clause WHERE $where_clause";

        $stmt = $this->conn->prepare($query);
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($table, $conditions)
    {
        $where = array();
        foreach ($conditions as $key => $value) {
            $where[] = "$key = :$key";
        }
        $where_clause = implode(" AND ", $where);

        $query = "DELETE FROM $table WHERE $where_clause";

        $stmt = $this->conn->prepare($query);
        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}

// Create an instance of the Database class
$db = new Database();

// Insert a new record
$data = array(
    'name' => 'John Doe',
    'email' => 'johndoe@example.com',
    'age' => 25
);
$db->create('users', $data);

// Read records
$users = $db->read('users');
foreach ($users as $user) {
    echo $user['name'] . "<br>";
}

// Update a record
$data = array(
    'age' => 30
);
$conditions = array(
    'id' => 1
);
$db->update('users', $data, $conditions);

// Delete a record
$conditions = array(
    'id' => 1
);
$db->delete('users', $conditions);


public function create($table, $data)
{
    $columns = implode(", ", array_keys($data));
    $values = ":" . implode(", :", array_keys($data));
    $query = "INSERT INTO $table ($columns) VALUES ($values)";
    
    $stmt = $this->conn->prepare($query);
    foreach ($data as $key => $value) {
        $stmt->bindValue(":$key", $value);
    }
    
    if ($stmt->execute()) {
        return $this->conn->lastInsertId();
    } else {
        return false;
    }
}




public function read($table, $conditions = array(), $fetch_style = PDO::FETCH_ASSOC)
{
    $query = "SELECT * FROM $table";

    if (!empty($conditions)) {
        $query .= " WHERE ";
        $where = array();
        foreach ($conditions as $key => $value) {
            $where[] = "$key = :$key";
        }
        $query .= implode(" AND ", $where);
    }

    $stmt = $this->conn->prepare($query);
    foreach ($conditions as $key => $value) {
        $stmt->bindValue(":$key", $value);
    }

    $stmt->execute();

    $result = $stmt->fetchAll($fetch_style);

    return $result ? $result : null;
}

public function update($table, $data, $conditions)
{
    $set = array();
    foreach ($data as $key => $value) {
        $set[] = "$key = :$key";
    }
    $set_clause = implode(", ", $set);

    $where = array();
    foreach ($conditions as $key => $value) {
        $where[] = "$key = :$key";
    }
    $where_clause = implode(" AND ", $where);

    $query = "UPDATE $table SET $set_clause WHERE $where_clause";

    $stmt = $this->conn->prepare($query);
    foreach ($data as $key => $value) {
        $stmt->bindValue(":$key", $value);
    }
    foreach ($conditions as $key => $value) {
        $stmt->bindValue(":$key", $value);
    }

    if ($stmt->execute()) {
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return null;
        }
    } else {
        return false;
    }
}

public function delete($table, $conditions)
{
    $where = array();
    foreach ($conditions as $key => $value) {
        $where[] = "$key = :$key";
    }
    $where_clause = implode(" AND ", $where);

    $query = "DELETE FROM $table WHERE $where_clause";

    $stmt = $this->conn->prepare($query);
    foreach ($conditions as $key => $value) {
        $stmt->bindValue(":$key", $value);
    }

    if ($stmt->execute()) {
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return null;
        }
    } else {
        return false;
    }
}



public function update($table, $data, $conditions)
{
    $set = array();
    foreach ($data as $key => $value) {
        $set[] = "$key = :$key";
    }
    $set_clause = implode(", ", $set);

    $where = array();
    foreach ($conditions as $key => $value) {
        $where[] = "$key = :$key";
    }
    $where_clause = implode(" AND ", $where);

    $query = "UPDATE $table SET $set_clause WHERE $where_clause";

    $stmt = $this->conn->prepare($query);
    foreach ($data as $key => $value) {
        $stmt->bindValue(":$key", $value);
    }
    foreach ($conditions as $key => $value) {
        $stmt->bindValue(":$key", $value);
    }

    if ($stmt->execute()) {
        $rowCount = $stmt->rowCount();
        return $rowCount > 0 ? $rowCount : null;
    } else {
        return false;
    }
}

public function delete($table, $conditions)
{
    $where = array();
    foreach ($conditions as $key => $value) {
        $where[] = "$key = :$key";
    }
    $where_clause = implode(" AND ", $where);

    $query = "DELETE FROM $table WHERE $where_clause";

    $stmt = $this->conn->prepare($query);
    foreach ($conditions as $key => $value) {
        $stmt->bindValue(":$key", $value);
    }

    if ($stmt->execute()) {
        $rowCount = $stmt->rowCount();
        return $rowCount > 0 ? $rowCount : null;
    } else {
        return false;
    }
}



// Update a record
$data = array(
    'age' => 30
);
$conditions = array(
    'id' => 1
);
$affectedRows = $db->update('users', $data, $conditions);

if ($affectedRows !== null) {
    echo "Updated $affectedRows records.";
} else {
    echo "No records found or failed to update.";
}

// Delete a record
$conditions = array(
    'id' => 1
);
$affectedRows = $db->delete('users', $conditions);

if ($affectedRows !== null) {
    echo "Deleted $affectedRows records.";
} else {
    echo "No records found or failed to delete.";
}