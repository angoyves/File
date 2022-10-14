<?php

class ComptaDB extends mysqli {

    // single instance of self shared among all instances
    private static $instance = null;
    // db connection config vars
    private $user = "root";
    private $pass = "";
    private $dbName = "compta_db";
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

	public function get_lib_by_id($table, $champ_lib, $champ_id, $value_id) {
		$table = $this->real_escape_string($table);
		$champ_lib = $this->real_escape_string($champ_lib);
		$champ_id = $this->real_escape_string($champ_id);
        $domain = $this->query("SELECT ". $champ_lib ." FROM ". $table ." WHERE ". $champ_id ." = ". $value_id );

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
	
	public function verify_detenteur_credentials($detenteurID) {
        $result = $this->query("SELECT 1 FROM matieres_detenteurs WHERE detenteurs_detenteurID = "
                        . $detenteurID );
        return $result->data_seek(0);
    }
	
	public function update_selected_menu($menuID, $table, $champID) {
		$table = $this->real_escape_string($table);
        $champID = $this->real_escape_string($champID);
        $this->query("UPDATE ". $table ." SET selected = '#' WHERE " . $champID . " =" . $menuID);
    }	
	
	public function delete_value($table, $champID, $valueID) {
		$table = $this->real_escape_string($table);
		$champID = $this->real_escape_string($champID);
        $this->query("DELETE FROM " . $table . " WHERE " . $champID . " = " . $valueID);
    }

}
?>