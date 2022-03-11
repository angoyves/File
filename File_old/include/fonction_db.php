<?php

class MinmapDB2 extends mysqli {

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
	// FONCTION GLOBAL

    public function get_1_col_lib_by_id($table, $col_lib, $col_id, $value_id) {
        $col_lib = $this->real_escape_string($col_lib);
		$table = $this->real_escape_string($table);
		$col_id = $this->real_escape_string($col_id);
		$domain = $this->query("SELECT " . $col_lib . " FROM " . $table . " WHERE " . $col_id . " = " . $value_id);
        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
	    public function get_2_col_lib_by_id($table, $col_lib1, $col_lib2, $col_id, $value_id) {
        $col_lib1 = $this->real_escape_string($col_lib1);
		$col_lib2 = $this->real_escape_string($col_lib2);
		$table = $this->real_escape_string($table);
		$col_id = $this->real_escape_string($col_id);
		$domain = $this->query("SELECT " . $col_lib1 . ", " . $col_lib2 . " FROM " . $table . " WHERE " . $col_id . " = " . $value_id);
        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }

 
    function format_date_for_sql($date) {
        if ($date == "")
            return null;
        else {
            $dateParts = date_parse($date);
            return $dateParts['year'] * 10000 + $dateParts['month'] * 100 + $dateParts['day'];
        }
    }
}
?>