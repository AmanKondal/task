<?php
class Database
{
    public $conn;

    public function __construct()
    {
        $this->conn = mysqli_connect("localhost", "root", "", "record") or die("Connection failed:" . mysqli_connect_error());
    }

    //Insert Function
    public function insert($table, array $values = array())
    {
        $table_Columns = implode(",", array_keys($values));
        $table_Values = implode("','", $values);
        $sql = "INSERT INTO $table ($table_Columns) VALUES ('$table_Values')";
        if ($this->conn->query($sql)) {
            return $this->conn->insert_id;
        } else {
            return false;
        }
    }
    //Select Function
    public function select($table, $rows = '*', $limit = null, $where = null)
    {
        $sql = "SELECT $rows FROM $table";
        if ($where !== null) {
            $sql .= " WHERE $where";
        }
        if ($limit !== null) {
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 1;
            }
            $start = ($page - 1) * $limit;
            $sql .= " LIMIT 0, $limit";
        }
        $query = $this->conn->query($sql);
        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    //Pagination 
    public function pagination($table, $limit = null, $Where = null)
    {
        if ($limit != null) {
            $sql = "SELECT COUNT(*) FROM $table";
            if ($Where != null) {
                $sql .= " WHERE $Where";
            }
            $query = $this->conn->query($sql);
            $total_record = $query->fetch_array();
            $total_record = $total_record[0];
            $total_page=ceil($total_record/$limit);
            $url=basename($_SERVER['PHP_SELF']);
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 1;
            }
            $output="<ul class='pagination'>";
           if($total_record>$limit){
            for ($i = 1; $i <= $total_page; $i++) {
                $class_name = ($i == $page) ? "active" : "";
                $output .= "<li class='page-item {$class_name}'><a class='page-link'  href='$url?page=$i'>{$i}</a></li>";
            }
        }
            $output.="</ul>";
           return $output;
        } else {
            return false;
        }
    }
    //Update function
    public function update($table, $values = array(), $where = null)
    {
        $args = array();
        foreach ($values as $key => $value) {
            $args[] = "$key='$value'";
        }
        $sql = "UPDATE $table SET" . implode(',', $args);
        if ($where !== null) {
            $sql .= " WHERE $where";
        }
        if ($this->conn->query($sql)) {
            return $this->conn->affected_rows;
        } else {
            return false;
        }
    }

    // Delete function
    public function deleteRecord($table, $id)
    {
        $sql = "DELETE FROM $table WHERE id = '$id'";
        $result = mysqli_query($this->conn, $sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    //Close mysqli    
    public function __destruct()
    {
        mysqli_close($this->conn);
    }
}
