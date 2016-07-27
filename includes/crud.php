<?php

require_once(LIB_PATH.DS."config.php");


class Crud
{

    private $db;
    protected $table;
    protected $db_fields;

    public function __construct() {
        if (!isset($this->db)) {
            try {
                $opt = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_EMULATE_PREPARES => false);
                $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHAR;
                $this->db = new PDO($dsn, DB_USER, DB_PASS, $opt);
            } catch (PDOException $e) {
                die("Failed to connect with MySQL: " . $e->getMessage());
            }
        }
    }

    public function find_all(){

        $sql="SELECT * FROM ".$this->table;
        $query = $this->db->query($sql);
        $data = $query->fetchAll(PDO::FETCH_OBJ);
        return !empty($data)? $data:false;
    }

    public function getRows($conditions = array()){
        $sql = 'SELECT ';
        $sql .= array_key_exists("select",$conditions)?$conditions['select']:'*';
        $sql .= ' FROM '.$this->table;
        if(array_key_exists("where",$conditions)){
            $sql .= ' WHERE ';
            $i = 0;
            foreach($conditions['where'] as $key => $value){
                $pre = ($i > 0)?' AND ':'';
                $sql .= $pre.$key." = '".$value."'";
                $i++;
            }
        }

        if(array_key_exists("order_by",$conditions)){
            $sql .= ' ORDER BY '.$conditions['order_by'];
        }

        if(array_key_exists("limit",$conditions) && array_key_exists("offset",$conditions)){
            $sql .= ' LIMIT '.$conditions['limit'].' OFFSET '.$conditions['offset'];
        }elseif(array_key_exists("limit",$conditions) && !array_key_exists("offset",$conditions)){
            $sql .= ' LIMIT '.$conditions['limit'];
        }

        $query = $this->db->prepare($sql);
        $query->execute();

        if(array_key_exists("return_type",$conditions) && $conditions['return_type'] != 'all'){
            switch($conditions['return_type']){
                case 'count':
                    $data = $query->rowCount();
                    break;
                case 'single':
                    $data = $query->fetch(PDO::FETCH_OBJ);
                    break;
                default:
                    $data = '';
            }
        }else{
            if($query->rowCount() > 0){
                $data = $query->fetchAll(PDO::FETCH_OBJ);
            }
        }
        return !empty($data)?$data:false;
    }


    public function find_by_id($id=0){

        $sql = "SELECT * FROM ".$this->table." WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array(":id"=>$id));
        $data = $stmt->fetch(PDO::FETCH_OBJ);
        return $data;
    }

    protected function attributes() {
        $attributes = array();
        foreach($this->db_fields as $field) {
            if(property_exists($this, $field)) {
                $attributes[$field] = $this->$field;
            }
        }
        return $attributes;
    }

    public function save() {
        return isset($this->id) ? $this->update() : $this->insert();
    }

    public function insert(){
        $data = $this->attributes();
        $columnString = implode(',', array_keys($data));
        $valueString = ":".implode(',:', array_keys($data));
        $sql = "INSERT INTO " .$this->table." (".$columnString.") VALUES (".$valueString.")";
        $query = $this->db->prepare($sql);
        foreach($data as $key=>$val){
            $query->bindValue(':'.$key, $val);
        }
        $insert = $query->execute();
        return $insert ? $this->db->lastInsertId() : false;
    }

    public function update(){

        $attributes = $this->attributes();

        $attribute_pairs = array();
        foreach($attributes as $key => $value) {
            $attribute_pairs[] = "{$key}='{$value}'";
        }

        $sql = "UPDATE ".$this->table." SET ";
        $sql .= join(", ", $attribute_pairs);
        $sql .= " WHERE id=". $this->id;
        $query = $this->db->prepare($sql);
        $update = $query->execute();
        return $update?$query->rowCount():false;
    }

    public function delete() {

        $stmt = $this->db->prepare("DELETE FROM ".$this->table." WHERE id=:id");
        $stmt->bindParam(":id",$this->id);
        return $result = $stmt->execute() ? true : false;

    }
}

$db = new Crud();
