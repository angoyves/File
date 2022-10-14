<?php

class ModelDB extends mysqli {

    // single instance of self shared among all instances
    private static $instance = null;
    // db connection config vars
    private $user = "root";
    private $pass = "";
    private $dbName = "model_db";
    private $dbHost = "localhost:3301";
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

// REGION
   public function get_diplome_id_by_lib ($LibelleDiplomeFr, $LibelleDiplomeEn, $SerieOption) {
        $LibelleDiplomeFr = $this->real_escape_string($LibelleDiplomeFr);
		$LibelleDiplomeEn = $this->real_escape_string($LibelleDiplomeEn);
		$SerieOption = $this->real_escape_string($SerieOption);
        $domain = $this->query("SELECT IdDiplome FROM personnes WHERE LibelleDiplomeFr = '"
                        . $LibelleDiplomeFr . "' OR LibelleDiplomeEn = '"
                        . $LibelleDiplomeEn . "'");

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
	
    public function create_diplomes($LibelleDiplomeFr, $LibelleDiplomeEn, $SerieOption) {
        $name = $this->real_escape_string($LibelleDiplomeFr);
        $LibelleDiplomeEn = $this->real_escape_string($LibelleDiplomeEn);
		$SerieOption = $this->real_escape_string($SerieOption);
        $this->query("INSERT INTO diplomes (LibelleDiplomeFr, LibelleDiplomeEn, SerieOption) VALUES ('" . $LibelleDiplomeFr
                . "', '" . $LibelleDiplomeEn . "', '" . $SerieOption . "')");
    }
 
    public function update_diplomes($IdDiplomes, $LibelleDiplomeFr,$LibelleDiplomeEn,$SerieOption) {
        $name = $this->real_escape_string($LibelleDiplomeFr);
        $LibelleDiplomeEn = $this->real_escape_string($LibelleDiplomeEn);
		$SerieOption = $this->real_escape_string($SerieOption);
        $this->query("UPDATE diplomes SET LibelleDiplomeFr = '" . $LibelleDiplomeFr .
                "', LibelleDiplomeEn = '" . $LibelleDiplomeEn .
                "', SerieOption = '" . $SerieOption .
                " WHERE IdDiplomes =" . $IdDiplomes);
    }

    public function get_diplome_by_diplome_id($IdDiplome) {
        return $this->query("SELECT IdDiplome, LibelleDiplomeFr,LibelleDiplomeEn,SerieOption FROM diplomes WHERE IdDiplomes = " . $IdDiplome);
    }
	
    public function get_all_diplomes() {
        return $this->query("SELECT IdDiplome, LibelleDiplomeFr,LibelleDiplomeEn,SerieOption FROM diplomes ORDER BY IdDiplome DESC");
    }

    public function delete_diplome($IdDiplome) {
        $this->query("DELETE FROM Diplomes WHERE IdDiplome = " . $Idiplomes);
    }
}
?>