<?php
class dataBase
{

    private $host = 'localhost';
    private $dbname = 'record';
    private $username = 'root';
    private $password = '';
    public $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
    // Login Code
    public function loginSession()
{
    session_start();
    if (!isset($_SESSION['email'])) {
        header("location: ../../index.php");
        exit;
    }
}

    public function noLoginSession()
    {
        session_start();
        if (isset($_SESSION['email'])) {
            if ($_SESSION['type'] == 1) {
                header("location: login.php");
            } elseif ($_SESSION['type'] == 0) {
                header("location: index.php");
            }
        }
    }
    // Login User Function
    public function loginUser($email, $password)
    {
        $sql = "SELECT * FROM user WHERE email=? AND password=?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email, $password]);
        $result = $stmt->fetch();
        $stmt->closeCursor();
        return $result;
    }

    // Select user 
    public function selectAllUser($limit = null, $page = 1)
    {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT * FROM user LIMIT ?, ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $offset, PDO::PARAM_INT);
        $stmt->bindValue(2, $limit, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    // user Data
    public function userData($id = null)
    {
        $sql = "SELECT * FROM user WHERE uid=?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? $data : null;
    }

    // Search user
    public function searchUser($keyword, $limit = null)
    {
        if ($limit !== null) {
            $searchSql = "SELECT * FROM user WHERE f_name LIKE ? LIMIT ?";
            $stmt = $this->pdo->prepare($searchSql);
            $stmt->bindValue(1, "%$keyword%", PDO::PARAM_STR);
            $stmt->bindValue(2, $limit, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result ? $result : false;
        } else {
            return false;
        }
    }

    // Count Totall Record
    public function getTotalRecords($columns = null, $keyword = null)
    {
        if ($columns !== null && $keyword !== null) {
            $conditions = array();
            foreach ($columns as $column) {
                $conditions[] = "$column LIKE '%$keyword%'";
            }
            $whereClause = implode(" OR ", $conditions);
            $sql = "SELECT COUNT(*) AS total FROM user WHERE $whereClause";
        } else {
            $sql = "SELECT COUNT(*) AS total FROM user";
        }
        $query = $this->pdo->query($sql);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    // update Function 
    public function updateUser($values = array(), $condition)
    {
        if (empty($values)) {
            return false;
        }
        $setClause = implode(', ', array_map(function ($key) {
            return "$key = :$key";
        }, array_keys($values)));
        $sql = "UPDATE user SET $setClause WHERE $condition";
        $stmt = $this->pdo->prepare($sql);
        foreach ($values as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $query = $stmt->execute();
        if ($query) {
            return $stmt->rowCount();
        } else {
            return false;
        }
    }

    // Your existing code...
    public function getUsersSorted($order, $limit)
    {
        $order = strtoupper($order);
        if ($order !== 'ASC' && $order !== 'DESC') {
            throw new InvalidArgumentException("Invalid order '$order'.");
        }
        $sql = "SELECT * FROM `user` ORDER BY f_name $order limit $limit";
        $stmt = $this->pdo->query($sql);
        if (!$stmt) {
            throw new RuntimeException("Failed to execute query.");
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Delete user
    public function deleteUser($id)
    {
        $sql = "DELETE FROM user WHERE uid = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }
    
}
