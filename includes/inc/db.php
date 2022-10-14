<?php

class MyDB extends mysqli {

    // single instance of self shared among all instances
    private static $instance = null;
    // db connection config vars
    private $user = "root";
    private $pass = "";
    private $dbName = "fichier_db8";
    private $dbHost = "localhost";
    private $con = null;

    //This method must be static, and must return an instance of the object if the object
    //does not already exist.
    public static function getInstance() {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    // The clone and wakeup methods prevents external instantiation of copies of the Singleton class,
    // thus eliminating the possibility of duplicate objects.
    public function __clone() {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

    public function __wakeup() {
        trigger_error('Deserializing is not allowed.', E_USER_ERROR);
    }

    // private constructor
    private function __construct() {
        parent::__construct($this->dbHost, $this->user, $this->pass, $this->dbName);
        if (mysqli_connect_error()) {
            exit('Connect Error (' . mysqli_connect_errno() . ') '
                    . mysqli_connect_error());
        }
        parent::set_charset('utf-8');
    }
	public function getLibById($table, $champLib, $champId, $valueId) {
        $domain = $this->query("SELECT '".$champLib."' FROM '".$table."' WHERE '".$champId."' = " 
							   . $valueId );

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
	public function getCommissionLibById($valueId) {
        $domain = $this->query("SELECT commission_lib FROM commissions WHERE commission_lib = " 
							   . $valueId );

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
	public function GetMenuByObjId($ProgramId, $ObjId) {
        $domain = $this->query("SELECT MenuLibFr FROM Menu WHERE ProgramId = '"
							   .$ProgramId."' AND ObjId = '".$ObjId."'" );

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
	/*public function GetMenuByObjId($value1) {
		$value1 = $this->real_escape_string($value1);
        $domain = $this->query("SELECT MenuLibFr FROM Menus WHERE ObjId = '".$value1."'");

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }*/
    public function get_value_by_value_id($value_id) {		
        $domain = $this->query("SELECT structure_lib FROM structures WHERE structure_id = "
                        . $value_id );

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
}
?>