<?php
class DB
{
    private $_host = "127.0.0.1";
    private $_dbname = "SISekolah";
    private $_username = "root";
    private $_password = "";

    private $_pdo;
    private static $_instance = null;
    private $_column = "*";
    private $_orderBy = "";
    private $_count = 0;

    private function __construct()
    {
        try {
            $dsn = "mysql:host=$this->_host;dbname=$this->_dbname";
            $this->_pdo = new PDO($dsn, $this->_username, $this->_password);
        } catch (PDOException $e) {
            die("Koneksi / Query bermasalah: ".$e->getMessage()." (".$e->getCode().")");
        }
    }

    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new DB();
        }

        return self::$_instance;
    }

    public function runQuery($query, $bindValue = [])
    {
        try {
            $stmt = $this->_pdo->prepare($query);
            $stmt->execute($bindValue);
        } catch (PDOException $e) {
            die("Koneksi / Query bermasalah: ".$e->getMessage()." (".$e->getCode().")");
        }

        return $stmt;
    }

    public function getQuery($query, $bindValue = [])
    {
        return $this->runQuery($query, $bindValue)->fetchAll(PDO::FETCH_OBJ);
    }

    public function get($tableName, $condition = "", $bindValue = [])
    {
        $query = "SELECT {$this->_column} FROM $tableName $condition {$this->_orderBy}";
        $this->_column = "*";
        $this->_orderBy = "";

        return $this->getQuery($query, $bindValue);
    }

    public function select($columnName)
    {
        $this->_column = $columnName;
        return $this;
    }

    public function orderBy($columnName, $sortType = "ASC")
    {
        $this->_orderBy = "ORDER BY $columnName $sortType";
        return $this;
    }

    public function getWhere($tableName, $condition)
    {
        $whereStr = "WHERE {$condition[0]} {$condition[1]} ?";
        return $this->get($tableName, $whereStr, [$condition[2]]);
    }

    public function getWhereOnce($tableName, $condition)
    {
        $result = $this->getWhere($tableName, $condition);

        if (!empty($result)) {
            return $result[0];
        } else {
            return false;
        }
    }

    public function getLike($tableName, $coloumnName, $search)
    {
        $queryLike = "WHERE {$coloumnName} LIKE ?";
        return $this->get($tableName, $queryLike, [$search]);
    }
    
    public function check($tableName, $coloumnName, $value)
    {
        $queryCheck = "SELECT * FROM {$tableName} WHERE {$coloumnName} = ?";
        return $this->runQuery($queryCheck, [$value])->rowCount();
    }

    public function insert($tableName, $data)
    {
        $dataKeys = array_keys($data);
        $dataValues = array_values($data);
        $strPreper = str_repeat("?,", count($data)-1)."?";

        $queryInsert = "INSERT INTO {$tableName} (".implode(",", $dataKeys).") VALUES ({$strPreper});";
        
        $this->_count = $this->runQuery($queryInsert, $dataValues)->rowCount();

        return true;
    }

    public function update($tableName, $data, $condition)
    {
        $dataKeys = array_keys($data);
        $dataValues = array_values($data);
        $dataValues[] = $condition[2];

        $strPreper = implode(" = ?, ", $dataKeys) . " = ? ";
        $queryUpdate = "UPDATE {$tableName} SET {$strPreper} WHERE {$condition[0]} {$condition[1]} ?";

        $this->_count =  $this->runQuery($queryUpdate, $dataValues)->rowCount();
        return true;
    }

    public function delete($tableName, $condition)
    {
        $queryDelete = "DELETE FROM {$tableName} WHERE {$condition[0]} {$condition[1]} ?";

        $this->_count = $this->runQuery($queryDelete, [$condition[2]])->rowCount();
        return true;
    }
    
    public function count()
    {
        return $this->_count;
    }
}
