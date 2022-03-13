<?php

class MinmapDB extends mysqli {

    // single instance of self shared among all instances
    private static $instance = null;
    // db connection config vars
    // private $user = "phpuser";
    // private $pass = "phpuserpw";
    // private $dbName = "wishlist";
    // private $dbHost = "localhost";
    // private $con = null;
	
    // db connection config vars
    private $user = "root";
    private $pass = "";
    private $dbName = "fichier_db";
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

    public function get_wisher_id_by_name($name) {
        $name = $this->real_escape_string($name);
        $wisher = $this->query("SELECT id FROM users WHERE user_login = '"
                        . $name . "'");

        if ($wisher->num_rows > 0){
            $row = $wisher->fetch_row();
            return $row[0];
        } else
            return null;
    }
    public function get_user_id_by_name($name) {
        $name = $this->real_escape_string($name);
        $wisher = $this->query("SELECT id FROM users WHERE user_login = '"
                        . $name . "'");

        if ($wisher->num_rows > 0){
            $row = $wisher->fetch_row();
            return $row[0];
        } else
            return null;
    }
	
    public function get_compte_id_by_id($numero_compte, $cle) {
        $name = $this->real_escape_string($numero_compte);
        $surname = $this->real_escape_string($cle);		
        $user = $this->query("SELECT personne_id FROM rib WHERE numero_compte = '"
                        . $numero_compte . "' AND cle = '" . $cle . "'");

        if ($user->num_rows > 0){
            $row = $user->fetch_row();
            return $row[0];
        } else
            return null;
    }	

    public function get_wishes_by_wisher_id($wisherID) {
        return $this->query("SELECT id, description, due_date FROM wishes WHERE wisher_id=" . $wisherID);
    }

    public function create_wisher($name, $password) {
        $name = $this->real_escape_string($name);
        $password = $this->real_escape_string($password);
        $this->query("INSERT INTO wishers (name, password) VALUES ('" . $name
                . "', '" . $password . "')");
    }

    public function verify_wisher_credentials($name, $password) {
        $name = $this->real_escape_string($name);
        $password = $this->real_escape_string($password);
        $result = $this->query("SELECT 1 FROM users WHERE user_login = '"
                        . $name . "' AND user_password = '" . $password . "' AND display = 1");
        return $result->data_seek(0);
    }
    public function verify_user_credentials($name, $surname) {
        $name = $this->real_escape_string($name);
        $surname = $this->real_escape_string($surname);
        $result = $this->query("SELECT 1 FROM personnes WHERE personne_nom = '"
                        . $name . "' AND personne_prenom = '" . $surname . "'");
        return $result->data_seek(0);
    }

    function insert_wish($wisherID, $description, $duedate) {
        $description = $this->real_escape_string($description);
        if ($this->format_date_for_sql($duedate)==null){
           $this->query("INSERT INTO wishes (wisher_id, description)" .
                " VALUES (" . $wisherID . ", '" . $description . "')");
        } else
        $this->query("INSERT INTO wishes (wisher_id, description, due_date)" .
                " VALUES (" . $wisherID . ", '" . $description . "', "
                . $this->format_date_for_sql($duedate) . ")");
    }
    
    function format_date_for_sql($date) {
        if ($date == "")
            return null;
        else {
            $dateParts = date_parse($date);
            return $dateParts['year'] * 10000 + $dateParts['month'] * 100 + $dateParts['day'];
        }
    }

    public function update_wish($wishID, $description, $duedate) {
        $description = $this->real_escape_string($description);
        $this->query("UPDATE wishes SET description = '" . $description .
                "', due_date = " . $this->format_date_for_sql($duedate)
                . " WHERE id =" . $wishID);
    }
/*    public function update_wish($wishID, $duedate) {
        $description = $this->real_escape_string($description);
        $this->query("UPDATE users SET due_date = " . $this->format_date_for_sql($duedate)
                . " WHERE user_id =" . $wishID);
    }*/

    public function update_personnes($personne_id, $user_id, $personne_nom, $personne_prenom, $personne_phone, $personne_date_nais, $dateUpdate) {
        $personne_nom = $this->real_escape_string($personne_nom);
        $personne_prenom = $this->real_escape_string($personne_prenom);
        $personne_phone = $this->real_escape_string($personne_phone);
        $this->query("UPDATE personnes SET user_id = " . $user_id . ", personne_nom = '" . $personne_nom .
                "', personne_prenom = '" . $personne_prenom . "', personne_telephone = '" . $personne_phone . "', personne_date_nais = " 
				. $this->format_date_for_sql($personne_date_nais) . ", dateUpdate = " . $this->format_date_for_sql($dateUpdate)
                . " WHERE personne_id =" . $personne_id);
    }
    public function update_rib($personne_id, $banque_code, $agence_code, $numero_compte, $cle, $dateUpdate) {
        $banque_code = $this->real_escape_string($banque_code);
        $agence_code = $this->real_escape_string($agence_code);
        $numero_compte = $this->real_escape_string($numero_compte);
        $cle = $this->real_escape_string($cle);
        $this->query("UPDATE rib SET banque_code = '" . $banque_code .
                "', agence_code = '" . $agence_code . "', agence_cle = '" . $banque_code . $agence_code . "', numero_compte = '" . $numero_compte . "', cle = '" 
				. $cle . "', dateUpdate = " . $this->format_date_for_sql($dateUpdate)
                . " WHERE personne_id =" . $personne_id);
    }

    public function get_wish_by_wish_id($wishID) {
        return $this->query("SELECT id, description, due_date FROM wishes WHERE id = " . $wishID);
    }

    public function delete_wish($wishID) {
        $this->query("DELETE FROM wishes WHERE id = " . $wishID);
    }
    public function get_user_groupe_by_name($name) {
        $name = $this->real_escape_string($name);
        $domain = $this->query("SELECT user_groupe_id FROM users WHERE user_login = '"
                        . $name . "'");

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }

}

?>