<?php

class MinmapDB extends mysqli {

    // single instance of self shared among all instances
    private static $instance = null;
    // db connection config vars
    private $user = "root";
    private $pass = "";
    private $dbName = "fichier_db8";
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
// MOIS

    public function get_mois_lib($month) {
        $month = $this->query("SELECT lib_mois
									FROM mois
									WHERE mois_id = ". $month);

        if ($month->num_rows > 0){
            $row = $month->fetch_row();
            return $row[0];
        } else
            return null;
    }
	
// PARAMETRES
    public function get_retenu($year) {
        $domain = $this->query("SELECT retenu
									FROM params
									WHERE exercice = ". $year);

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
// REGION
	public function get_region_lib_by_region_id($region_id) {
        $domain = $this->query("SELECT region_lib FROM regions WHERE region_id = ". $region_id );

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
	public function get_region_id_by_localite_id($localite_id) {
        $domain = $this->query("SELECT region_id FROM localites WHERE localite_id = ". $localite_id );

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
	public function get_localite_id_by_region_id($region_id ) {
        $domain = $this->query("SELECT localite_id FROM localites WHERE type_localite_id = 1 AND region_id = ". $region_id );

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
// TYPE LOCALITE 
	public function get_lib_by_id($table, $champ_lib, $champ_id, $value_id) {
		$table = $this->real_escape_string($table);
		$champ_lib = $this->real_escape_string($champ_lib);
		$champ_id = $this->real_escape_string($champ_id);
        $domain = $this->query("SELECT '". $champ_lib ."' FROM '". $table ."' WHERE '". $champ_id ."' = ". $value_id );

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
	public function get_type_localte_lib_by_type_localite_id($type_localite_id) {;
        $domain = $this->query("SELECT type_localite_lib FROM type_localites WHERE type_localite_id = ". type_localite_id );

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
// TYPE_PERSONNES
    public function get_type_personne_lib_by_id($type_personne_id) {
        $domain = $this->query("SELECT type_personne_lib
									FROM type_personnes
									WHERE type_personne_id = ". $type_personne_id);

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
// PERSONNES
	public function get_if_person_add_commission_by_pers_id($personne_id) {
        $domain = $this->query("SELECT add_commission FROM personnes WHERE personnes.personne_id = ". $personne_id );

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
	/*public function verify_person_add_commission($commission, $personne) {
        $result = $this->query("SELECT 1 FROM personnes WHERE add_commission = '2' AND commissions_commission_id = "
                        . $commission . " AND personnes_personne_id = " . $personne );
        return $result->data_seek(0);
    }*/
	public function activ_or_desactiv_person_add_commission_by_pers_id($personne_id, $add_commission, $duedate) {
		$add_commission = $this->real_escape_string($add_commission);
        $this->query("UPDATE personnes SET add_commission = '" . $add_commission . "', display = '1', dateUpdate = " . $this->format_date_for_sql($duedate)
					 . " WHERE personne_id = ". $personne_id);
    }
	public function update_person_structure_by_pers_id($personne_id, $structure, $duedate) {
        $this->query("UPDATE personnes SET structure_id = " . $structure . ", display = '1', dateUpdate = " . $this->format_date_for_sql($duedate)
					 . " WHERE personne_id = ". $personne_id);
    }
	public function activ_or_desactiv_person_add_rep_by_pers_id($personne_id, $add_rep, $duedate) {
		$add_rep = $this->real_escape_string($add_rep);
        $this->query("UPDATE personnes SET add_rep = '" . $add_rep . "', display = '1', dateUpdate = " . $this->format_date_for_sql($duedate)
					 . " WHERE personne_id = ". $personne_id);
    }
	public function activ_or_desactiv_person_display_by_pers_id($personne_id, $display, $duedate) {
		$display = $this->real_escape_string($display);
        $this->query("UPDATE personnes SET display = '". $display ."', dateUpdate = " . $this->format_date_for_sql($duedate)
					 . " WHERE personne_id = ". $personne_id);
    }
	
	public function update_person_appur($Personne_id, $duedate) {
        $this->query("UPDATE personnes SET add_appur = 0 , dateUpdate = " . $this->format_date_for_sql($duedate)
					 . " WHERE user_id = " . $Personne_id);
    }
	
	public function get_person_id_by_name_and_cpte($firstname, $num_cpte) {
        $firstname = $this->real_escape_string($firstname);
		$num_cpte = $this->real_escape_string($num_cpte);
        $domain = $this->query("SELECT personnes.personne_id FROM personnes, rib WHERE personnes.personne_id = rib.personne_id 
							   AND personne_nom = '". $firstname . "' AND numero_compte = '". $num_cpte . "'");

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
	
	public function get_person_add_appur($personne_id) {
        $domain = $this->query("SELECT add_appur FROM personnes WHERE personne_id = " . $personne_id);

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
	
    public function get_personne_id_by_matricule($matricule) {
        $name = $this->real_escape_string($matricule);
        $domain = $this->query("SELECT personne_id FROM personnes WHERE personne_matricule = '"
                        . $matricule . "'");

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
	
    public function get_personne_id_by_name_and_structure($name, $structure) {
        $name = $this->real_escape_string($name);
        $domain = $this->query("SELECT personne_id FROM personnes WHERE personne_nom = '"
                        . $name . "' AND structure_id = " . $structure );

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
	
	public function get_personne_name_by_person_id($personne_id) {
        $domain = $this->query("SELECT personne_nom, personne_prenom FROM personnes WHERE personne_id = "
                        . $personne_id );

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0] . " " . $row[1];
        } else
            return null;
    }

// ETATS

    public function create_etats($commission_id, $periode_debut, $periode_fin, $annee, $dateCreation, $display, $user_id) {
        $periode_debut= $this->real_escape_string($periode_debut);
		$periode_fin= $this->real_escape_string($periode_fin);
		$annee= $this->real_escape_string($annee);
		$display= $this->real_escape_string($display);
		$dateCreation= $this->real_escape_string($dateCreation);
        $this->query("INSERT INTO etats (commission_id, periode_debut, periode_fin, annee, dateCreation, display, user_id) VALUES (".$commission_id.", '".$periode_debut."', '".$periode_fin."', '".$annee."', '".$dateCreation."', '".$display."', ".$user_id.")");
    }
	
	public function get_etat_id_by_date($dateCreation) {
		$dateCreation= $this->real_escape_string($dateCreation);
        $domain = $this->query("SELECT etat_id FROM etats WHERE dateCreation = '"
                        . $dateCreation . "'" );

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0] . " " . $row[1];
        } else
            return null;
    }
	
// MEMBRES

	public function get_commission_id_by_person_id($personne_id) {
        $domain = $this->query("SELECT commissions_commission_id FROM membres WHERE personnes_personne_id = "
                        . $personne_id );

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0] . " " . $row[1];
        } else
            return null;
    }
	public function activ_or_desactiv_membre_display_by_person_id($Personne_id, $display, $duedate, $commission_id) {
		$display = $this->real_escape_string($display);
        $this->query("UPDATE membres SET display='" . $display . "', dateUpdate = " . $this->format_date_for_sql($duedate)
					 . " WHERE commissions_commission_id = " . $commission_id 
					 . " AND fonctions_fonction_id='40' AND personnes_personne_id = " . $Personne_id);
    }
	
	
    public function create_membre($commission_id, $fonction_id, $personne_id, $montant, $dateCreation, $user_id) {
        $montant= $this->real_escape_string($montant);
        $this->query("INSERT INTO membres (commissions_commission_id, fonctions_fonction_id, personnes_personne_id, montant, checboxName, position, dateCreation, display, user_id) VALUES (". $commission_id .", ". $fonction_id .", ". $personne_id .", '". $montant ."', 'un', '1', '". $dateCreation ."', '1', ". $user_id .")");
    }
    public function update_membre($commission_id, $fonction_id, $personne_id, $montant, $dateUpdate, $user_id) {
        $montant= $this->real_escape_string($montant);
        $this->query("UPDATE membres SET fonctions_fonction_id = ". $fonction_id .", montant = '". $montant ."',
					 dateUpdate = " . $this->format_date_for_sql($duedate) 
					 ."', display = 1, user_id = ". $user_id ."
					 WHERE commissions_commission_id = ". $commission_id 
					 ." AND personnes_personne_id = ". $personne_id );
    }
			
							   
// DESACTIVATE
 
    public function update_desactive($table, $colonne_id, $col_desactive, $date, $record_id) {
		$colonne_id = $this->real_escape_string($colonne_id);
		$table = $this->real_escape_string($table);
		$col_desactive = $this->real_escape_string($col_desactive);
        $this->query("UPDATE " . $table . " SET " . $col_desactive . " = 0 
					 , dateUpdate = " . $this->format_date_for_sql($date) .
					 " WHERE " . $colonne_id . " = " . $record_id);
    }
// REINIT PASSWORD
    public function reinit_password($table, $colonne_id, $col, $date, $record_id) {
		$colonne_id = $this->real_escape_string($colonne_id);
		$table = $this->real_escape_string($table);
		$col = $this->real_escape_string($col);
        $this->query("UPDATE " . $table . " SET " . $col . " =  'c4ca4238a0b923820dcc509a6f75849b'
					 , dateUpdate = " . $this->format_date_for_sql($date) .
					 " WHERE " . $colonne_id . " = " . $record_id);
    }
// UPDATE USER
    public function update_($table, $colonne_id, $col, $date, $record, $record_id) {
		$colonne_id = $this->real_escape_string($colonne_id);
		$table = $this->real_escape_string($table);
		$col = $this->real_escape_string($col);
		$record = $this->real_escape_string($record);
        $this->query("UPDATE " . $table . " SET " . $col . " = " . $record . "
					 , dateUpdate = " . $this->format_date_for_sql($date) .
					 " WHERE " . $colonne_id . " = " . $record_id);
    }
// ACTIVATE
 
    public function update_active($table, $colonne_id, $col_to_display, $record_id) {  
		$table = $this->real_escape_string($table); 
		$col_to_display = $this->real_escape_string($col_to_display); 
		$colonne_id = $this->real_escape_string($colonne_id);
        $this->query("UPDATE users SET user_connected = 1 
					 , dateUpdate = " . $this->format_date_for_sql(date()). 
					 " WHERE user_id = " . $record_id);
    }

    public function update_actives($table, $colonne_id, $col_desactive, $date, $record_id) {
		$colonne_id = $this->real_escape_string($colonne_id);
		$table = $this->real_escape_string($table);
		$col_desactive = $this->real_escape_string($col_desactive);
        $this->query("UPDATE " . $table . " SET " . $col_desactive . " = 1 
					 , dateUpdate = " . $this->format_date_for_sql($date) .
					 " WHERE " . $colonne_id . " = " . $record_id);
    }
// FONCTION
    public function get_user_connexion($user_id) {
        $domain = $this->query("SELECT user_connected
									FROM users
									WHERE user_id = ". $user_id);

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
// FONCTION DE CONTROLE DES MOIS DANS LA TABLE APPUREMENT
    public function get_month_apurement($year, $commission, $month) {
        $domain = $this->query("SELECT user_connected
									FROM users
									WHERE user_id = ". $user_id);

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }

    public function verify_appurement_credentials($rib) {
        $rib = $this->real_escape_string($rib);
        $result = $this->query("SELECT 1 FROM appurements WHERE rib_beneficiaire = '" . $rib . "'");
        return $result->data_seek(0);
    }
	public function verify_person_credentials($name) {
        $name = $this->real_escape_string($name);
        $result = $this->query("SELECT 1 FROM personnes WHERE personne_nom LIKE '" . $name . "%'");
        return $result->data_seek(0);
    }
	public function verify_table_credentials($table, $champ, $text) {
        $table = $this->real_escape_string($table);
		$champ = $this->real_escape_string($champ);
		$text = $this->real_escape_string($text);
        $result = $this->query("SELECT distinct(1) FROM " . $table . " WHERE " . $champ . " LIKE '%" . $text . "%'");
        return $result->data_seek(0);
    }
	
	public function verify_rib_credentials($rib) {
        $rib = $this->real_escape_string($rib);
        $result = $this->query("SELECT 1 FROM rib WHERE concat(rib.banque_code, rib.agence_code, rib.numero_compte, rib.cle) = '" . $rib . "'");
        return $result->data_seek(0);
    }
	public function verify_personne_rib_credentials($personne_id) {
        $result = $this->query("SELECT 1 FROM rib WHERE personne_id = " . $personne_id);
        return $result->data_seek(0);
    }

    public function verify_appurement_credentials_2($comID, $rib, $m1ID, $m2ID, $aID) {
        $rib = $this->real_escape_string($rib);
		$m1ID = $this->real_escape_string($m1ID);
		$m2ID = $this->real_escape_string($m2ID);
		$aID = $this->real_escape_string($aID);
        $result = $this->query("SELECT 1 FROM rib, sessions, appurements 
		WHERE membres_personnes_personne_id = rib.personne_id 
		AND concat(rib.agence_cle, rib.numero_compte, rib.cle) = appurements.rib_beneficiaire 
		AND sessions.mois between '" . $m1ID . "' AND '" . $m2ID 
		. "' AND sessions.annee = '" . $aID 
		. "' AND sessions.membres_commissions_commission_id = " . $comID
		. "	AND concat(rib.agence_cle, rib.numero_compte, rib.cle) = '" . $rib 
		. "' GROUP BY membres_personnes_personne_id");
        return $result->data_seek(0);
    }
	
    public function get_montant_appurement_by_rib($rib, $commission_id, $annee) {
		$rib = $this->real_escape_string($rib);
		$annee = $this->real_escape_string($annee);
        $domain = $this->query("SELECT sum(montant)
									FROM appurements
									WHERE rib_beneficiaire = '". $rib 
									. "' AND commission_id = " . $commission_id 
									. " AND annee = '" . $annee . "'" );

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
// FONCTION
    public function get_fonction_lib_by_id($fonction_id) {
        $domain = $this->query("SELECT fonction_lib
									FROM fonctions
									WHERE fonction_id = ". $fonction_id);

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
// STRUCTURES
	public function get_structure_lib_by_structure_id($structure_id) {
        $domain = $this->query("SELECT code_structure FROM structures WHERE structure_id = " . $structure_id );

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
	public function get_structure_lib_by_id($structure_id) {
        $domain = $this->query("SELECT structure_lib FROM structures WHERE structure_id = " . $structure_id );

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
// SOUS GROUPE
	public function get_sous_groupe_lib_by_id($sous_groupe_id) {
        $domain = $this->query("SELECT sous_groupe_lib FROM sous_groupes WHERE sous_groupe_id = " . $sous_groupe_id );

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
// COMMENTAIRES
    public function get_nbre_commentaire_non_lu($userID) {
        $commission = $this->query("SELECT count(comment_id)
									FROM commentaires
									WHERE notation = 0
									AND destinataire_id = ". $userID);

        if ($commission->num_rows > 0){
            $row = $commission->fetch_row();
            return $row[0];
        } else
            return null;
    }

// DOMAINES
    public function get_domaine_lib_by_id($domaine_id) {
        $domain = $this->query("SELECT domaine_lib
									FROM domaines_activites
									WHERE domaine_id = ". $domaine_id);

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
// ORDRE DE VIREMENT
   public function get_ref_dossier_id_by_lib($ref_dossier) {
	    $ref_dossier = $this->real_escape_string($ref_dossier); 
        $domain = $this->query("SELECT ref_dossier
									FROM ordre_virements
									WHERE ref_dossier = '". $ref_dossier ."'");

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
//SESSIONS
    public function update_session_person_day($nbre_jours, $jour, $duedate, $mois, $annee, $commission_id, $personne_id) { 
		$nbre_jours = $this->real_escape_string($nbre_jours);
		$jour = $this->real_escape_string($jour); 
		$mois = $this->real_escape_string($mois); 
		$annee = $this->real_escape_string($annee); 
        $this->query("UPDATE sessions SET nombre_jour = '" . $nbre_jours
					 . "', jour = '" . $jour
					 . "', dateUpdate = " . $this->format_date_for_sql($duedate). 
					 " WHERE membres_commissions_commission_id = " . $commission_id .
					 " AND mois = '" . $mois .
					 "' AND annee = '" . $annee .
					 "' AND membres_personnes_personne_id = " . $personne_id);
    }
    public function update_session_appurement($mois, $annee, $commission_id, $personne_id) {  
		$mois = $this->real_escape_string($mois); 
		$annee = $this->real_escape_string($annee); 
        $this->query("UPDATE sessions SET etat_appur = 1 
					 , dateUpdate = " . $this->format_date_for_sql(date()). 
					 " WHERE membres_commissions_commission_id = " . $commission_id .
					 " AND mois = '" . $mois .
					 "' AND annee = '" . $annee .
					 "' AND membres_personnes_personne_id = " . $personne_id);
    }	
    public function get_session_appurement($annee, $commission_id, $personne_id) {   
		$annee = $this->real_escape_string($annee); 
        $domain = $this->query("SELECT sum(nombre_jour * montant) as totals FROM sessions, personnes, membres
						WHERE sessions.membres_personnes_personne_id = personnes.personne_id
						AND sessions.membres_personnes_personne_id = membres.personnes_personne_id
						AND etat_appur = 1
						AND annee = '" . $annee .
						"' AND membres_commissions_commission_id= " . $commission_id . 
						" AND membres_personnes_personne_id= " . $personne_id);
		
	    if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
	 public function get_session_by_periode($Year, $Month1, $Month2, $Commission_id, $Personne_id) {   
		$Year = $this->real_escape_string($Year); 
		$Month1 = $this->real_escape_string($Month1); 
		$Month2 = $this->real_escape_string($Month2); 
        $domain = $this->query("SELECT sum(nombre_jour) FROM sessions
						WHERE etat_validation = 2 AND etat_appur = 0 AND annee = '" . $Year .
						"' AND mois BETWEEN '". $Month1 . 
						"' AND '" . $Month2 . 
						"' AND membres_commissions_commission_id = ". $Commission_id .
						"  AND membres_personnes_personne_id = ". $Personne_id );
		
	    if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
// COMMISSIONS
	 function get_count_commission_dep_by_regional_commission_id($commission_parent) {
		//$champ = $this->real_escape_string($champ);
        $domain = $this->query("SELECT count(commission_id) FROM commissions WHERE type_commission_id = 4 AND commission_parent = " . $commission_parent );

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
	 
	 function get_sum_indemnite_by_commission_id($commission_id, $annee, $mois1, $mois2) {
		$annee = $this->real_escape_string($annee);
		$mois1 = $this->real_escape_string($mois1);
		$mois2 = $this->real_escape_string($mois2);
        $domain = $this->query("SELECT sum(Nombre_jour * montant) FROM sessions, membres, commissions
								WHERE membres_commissions_commission_id = commissions_commission_id
								AND membres_personnes_personne_id = personnes_personne_id
								AND membres_fonctions_fonction_id = fonctions_fonction_id
								AND membres_commissions_commission_id= commission_id
								AND commissions_commission_id = commission_id
								AND sessions.annee = '" . $annee . "'
								AND (sessions.mois BETWEEN '" . $mois1 . "' AND '" . $mois2 . "')
								AND ( membres_commissions_commission_id = ".$commission_id." OR commission_parent = ".$commission_id.")");

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
	
	public function get_commission_id_by_localite_id($localite_id){
        $domain = $this->query("SELECT commission_id FROM commissions WHERE localite_id = " . $localite_id );

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }


	 function get_commission_lib_by_commission_id($commission_id) {
		//$champ = $this->real_escape_string($champ);
        $domain = $this->query("SELECT commission_lib FROM commissions WHERE commission_id = " . $commission_id );

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }

    public function get_montant_commission($commissionID) {
        $commission = $this->query("SELECT sum(nombre_jour * montant) as total 
						FROM sessions, membres
						WHERE membres_commissions_commission_id = commissions_commission_id 
						AND membres_personnes_personne_id = personnes_personne_id
						AND mois between 01 AND 12
						AND annee = 2015 
						AND (membres_fonctions_fonction_id between 1 and 3 OR membres_fonctions_fonction_id = 40)
						AND membres_commissions_commission_id = "
                        . $commissionID);

        if ($commission->num_rows > 0){
            $row = $commission->fetch_row();
            return $row[0];
        } else
            return null;
    }
    public function get_montant_sous_commission($commissionID) {
        $commission = $this->query("SELECT sum(nombre_jour * montant) as total 
						FROM sessions, membres, commissions
						WHERE membres_commissions_commission_id = commissions_commission_id 
						AND membres_personnes_personne_id = personnes_personne_id
						AND membres_commissions_commission_id = commission_id
						AND mois between 01 AND 12
						AND annee = 2015 
						AND (membres_fonctions_fonction_id between 1 and 3 OR membres_fonctions_fonction_id = 141)
						AND commission_parent ="
                        . $commissionID);

        if ($commission->num_rows > 0){
            $row = $commission->fetch_row();
            return $row[0];
        } else
            return null;
    }
    public function get_montant_commissions($commission_id, $annee, $mois1, $mois2) {
		$annee = $this->real_escape_string($annee);
		$mois1 = $this->real_escape_string($mois1);
		$mois2 = $this->real_escape_string($mois2);
		$commission = $this->query("SELECT sum(nombre_jour * montant) as total
						FROM commissions, membres, personnes,  fonctions, sessions, rib
						WHERE membres.commissions_commission_id = commissions.commission_id
						AND membres.personnes_personne_id = personnes.personne_id
						AND membres.fonctions_fonction_id = fonctions.fonction_id
						AND personnes.personne_id = rib.personne_id
						AND sessions.membres_commissions_commission_id = membres.commissions_commission_id
						AND sessions.membres_personnes_personne_id = membres.personnes_personne_id
						AND membres.fonctions_fonction_id BETWEEN 1 AND 3
						AND sessions.etat_validation = 2
						AND sessions.annee = '" . $annee . "'
						AND (sessions.mois BETWEEN '" . $mois1 . "' AND '" . $mois2 . "')
						AND membres_commissions_commission_id = ". $commission_id );

        if ($commission->num_rows > 0){
            $row = $commission->fetch_row();
            return $row[0];
        } else
            return null;
    }
    public function get_montant_sous_commissions($commission_id, $annee, $mois1, $mois2) {
		$annee = $this->real_escape_string($annee);
		$mois1 = $this->real_escape_string($mois1);
		$mois2 = $this->real_escape_string($mois2);
		$commission = $this->query("SELECT  sum(nombre_jour * montant) as total
						FROM sessions, membres, commissions, personnes
						WHERE sessions.membres_commissions_commission_id = membres.commissions_commission_id 
						AND sessions.membres_personnes_personne_id = membres.personnes_personne_id
						AND commissions.commission_id = membres.commissions_commission_id
						AND personnes.personne_id = membres.personnes_personne_id
						AND personnes.display = '1'
						AND sessions.annee = '" . $annee . "'
						AND (sessions.mois BETWEEN '" . $mois1 . "' AND '" . $mois2 . "')
						AND commission_parent = ". $commission_id );

        if ($commission->num_rows > 0){
            $row = $commission->fetch_row();
            return $row[0];
        } else
            return null;
    }
    public function get_montant_representants($commission_id, $annee, $mois1, $mois2) {
		$annee = $this->real_escape_string($annee);
		$mois1 = $this->real_escape_string($mois1);
		$mois2 = $this->real_escape_string($mois2);
		$commission = $this->query("SELECT sum(nombre_jour * montant) as total
						FROM commissions, membres, personnes,  fonctions, sessions, rib
						WHERE membres.commissions_commission_id = commissions.commission_id
						AND membres.personnes_personne_id = personnes.personne_id
						AND membres.fonctions_fonction_id = fonctions.fonction_id
						AND personnes.personne_id = rib.personne_id
						AND sessions.membres_commissions_commission_id = membres.commissions_commission_id
						AND sessions.membres_personnes_personne_id = membres.personnes_personne_id
						AND membres.fonctions_fonction_id = 40
						AND sessions.annee = '" . $annee . "'
						AND (sessions.mois BETWEEN '" . $mois1 . "' AND '" . $mois2 . "')
						AND membres_commissions_commission_id = ". $commission_id );

        if ($commission->num_rows > 0){
            $row = $commission->fetch_row();
            return $row[0];
        } else
            return null;
    }
    public function get_montant_indemnite_minmap($annee, $mois1, $mois2, $fonction) {
		$annee = $this->real_escape_string($annee);
		$mois1 = $this->real_escape_string($mois1);
		$mois2 = $this->real_escape_string($mois2);
		$commission = $this->query("SELECT sum(nombre_jour * montant) as total
						FROM commissions, membres, personnes,  fonctions, sessions, rib
						WHERE membres.commissions_commission_id = commissions.commission_id
						AND membres.personnes_personne_id = personnes.personne_id
						AND membres.fonctions_fonction_id = fonctions.fonction_id
						AND personnes.personne_id = rib.personne_id
						AND sessions.membres_commissions_commission_id = membres.commissions_commission_id
						AND sessions.membres_personnes_personne_id = membres.personnes_personne_id
						AND membres.fonctions_fonction_id = " . $fonction . "
						AND sessions.etat_validation = 2
						AND sessions.annee = '" . $annee . "'
						AND (sessions.mois BETWEEN '" . $mois1 . "' AND '" . $mois2 . "')");

        if ($commission->num_rows > 0){
            $row = $commission->fetch_row();
            return $row[0];
        } else
            return null;
    }
// FIN COMMISSIONS
    public function get_user_name_by_id($id) {
        $domain = $this->query("SELECT user_name FROM users WHERE user_id ="
                        . $id);

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
    public function get_user_id_by_name($name) {
        $name = $this->real_escape_string($name);
        $domain = $this->query("SELECT user_id FROM users WHERE user_login = '"
                        . $name . "'");

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
	
    public function get_user_name($iser_id) {
        $domain = $this->query("SELECT concat(user_name, ' ', user_lastname) FROM users WHERE user_id = "
                        . $iser_id );

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
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
    public function get_user_groupe_by_user_login($login) {
        $login = $this->real_escape_string($login);
        $wisher = $this->query("SELECT user_groupe_id FROM users WHERE user_login = '". $login . "'");

        if ($wisher->num_rows > 0){
            $row = $wisher->fetch_row();
            return $row[0];
        } else
            return null;
    }
    public function get_user_groupe_name_by_group_id($group_id){
        $domain = $this->query("SELECT user_groupe_lib FROM user_groupes WHERE user_groupe_id = "
                        . $group_id);

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
	
    public function get_user_rib_by_id($user_id) {
        //$name = $this->real_escape_string($name);
        $wisher = $this->query("SELECT concat(banque_code,agence_code, numero_compte, cle) FROM rib WHERE personne_id = "
                        . $user_id );

        if ($wisher->num_rows > 0){
            $row = $wisher->fetch_row();
            return $row[0];
        } else
            return null;
    }
    public function update_users_display($user_id, $duedate) {
        $this->query("UPDATE users SET display = 0
					 , dateUpdate = " . $this->format_date_for_sql($duedate)
					 . " WHERE user_id = " . $user_id);
    }
    public function get_user_date_last_login($user_id) {
        //$name = $this->real_escape_string($name);
        $user = $this->query("SELECT date_last_login FROM users WHERE user_id = "
                        . $user_id );

        if ($user->num_rows > 0){
            $row = $user->fetch_row();
            return $row[0];
        } else
            return null;
    }
    public function get_user_groupe($user_groupe_id) {
        //$name = $this->real_escape_string($name);
    $user_groupe = $this->query("SELECT user_groupe_lib FROM user_groupes WHERE user_groupe_id = "
            . $user_groupe_id );

        if ($user_groupe->num_rows > 0){
            $row = $user_groupe->fetch_row();
            return $row[0];
        } else
            return null;
    }
    public function get_compteur_by_name($name) {
        $name = $this->real_escape_string($name);
        $wisher = $this->query("SELECT compteur FROM users WHERE user_login = '"
                        . $name . "'");

        if ($wisher->num_rows > 0){
            $row = $wisher->fetch_row();
            return $row[0];
        } else
            return null;
    }
	public function get_count_member_by_commission_id($commission_id) {
		$commission_id = $this->real_escape_string($commission_id);
        $domain = $this->query("SELECT count(personnes_personne_id) FROM membres
		WHERE commissions_commission_id = '". $commission_id . "'" );
        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
	public function get_membre_fonction_by_personne_id($personne_id) {
        $domain = $this->query("SELECT fonctions_fonction_id FROM membres 
							   WHERE personnes_personne_id = ". $personne_id );

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }

	public function get_localite_id_by_count_id($count, $value) {
        $domain = $this->query("SELECT localite_id FROM localites WHERE type_localite = ". $value . " AND localite_id = ". $count );

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
	public function get_commission_parent_id_by_commission_id($commission_id) {
        $domain = $this->query("SELECT commission_parent FROM commissions WHERE commission_id = " . $commission_id );

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
	public function get_type_id_by_commission_id($commission_id) {
        $domain = $this->query("SELECT type_commission_id FROM commissions WHERE commission_id = " . $commission_id );

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
	
	public function valid_membre_commission($commission_id) {
        $domain = $this->query("SELECT commission_id, commissions_commission_id, personne_nom, personne_id, personne_prenom, fonction_lib, checboxName, 
							   position, fonctions_fonction_id
							   FROM commissions, membres, fonctions, personnes
							   WHERE membres.commissions_commission_id = commissions.commission_id   
							   AND fonctions_fonction_id = fonctions.fonction_id   
							   AND personnes_personne_id = personne_id  
							   AND membres.fonctions_fonction_id BETWEEN 1 AND 3 
							   AND personnes.display = 1
							   AND personnes.add_commission = 2
							   AND commissions_commission_id = " . $commission_id );

        if ($domain->num_rows > 0){
            return 1;
        } else
            return 0;
    }
	
	public function get_structure_id_by_personne_id($personne_id) {
        $domain = $this->query("SELECT structure_id FROM personnes WHERE personne_id = " . $personne_id );

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
	public function get_jour_dossier_by_dossier_id($dossier_id) {
        $domain = $this->query("SELECT dossiers_jour FROM dossiers WHERE dossier_id = " . $dossier_id );

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }

	public function get_dossier_ref_by_value($commission_id, $mois, $annee) {
		$mois = $this->real_escape_string($mois);
		$annee = $this->real_escape_string($annee);
        $domain = $this->query("SELECT dossier_ref FROM sessions, dossiers WHERE sessions.dossiers_dossier_id = dossiers.dossier_id 
						 AND membres_commissions_commission_id =" . $commission_id . " AND sessions.mois ='" . $mois . "' AND sessions.annee = '" . $annee . "'" );

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
	public function get_dossier_ref_by_dossier_id($dossier_id) {
		$mois = $this->real_escape_string($mois);
		$annee = $this->real_escape_string($annee);
        $domain = $this->query("SELECT dossier_ref FROM dossiers 
		WHERE dossier_id = " . $dossier_id );

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
	
	public function get_structure_id_by_count_id($structure, $value) {
        $domain = $this->query("SELECT structure_id FROM structures WHERE structure_id = " . $structure . " AND minister = " . $value );

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
	
    public function get_wisher_id_by_name($firstname, $lastname) {
        $firstname = $this->real_escape_string($firstname);
		$lastname = $this->real_escape_string($lastname);
        $domain = $this->query("SELECT personne_id FROM personnes WHERE personne_nom = '"
                        . $firstname . "' AND personne_prenom = '"
                        . $lastname . "'");

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
    public function get_user_group_id_by_user_id($user_id) {
        $domain = $this->query("SELECT user_groupe_id FROM users WHERE user_id = "
                        . $user_id );

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
    public function get_session_id_by_value($year, $month, $commission_id) {
        $year = $this->real_escape_string($year);
		$month = $this->real_escape_string($month);
        $domain = $this->query("SELECT count(membres_commissions_commission_id) as total FROM sessions WHERE mois = '" 
							   . $month . "' AND annee = '" 
							   . $year . "' AND membres_commissions_commission_id = " 
							   . $commission_id );

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
    public function get_count_id_by_localite_id($localite_id, $type_id, $nature_id) {
        $domain = $this->query("SELECT count(commission_id) FROM commissions WHERE localite_id = " 
							   . $localite_id . " AND type_commission_id = " . $type_id . " AND nature_id = " . $nature_id);

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
    public function get_count_sous_commission_by_commission_id($commission_id) {
        $domain = $this->query("SELECT count(commission_id) FROM commissions WHERE commission_parent = " . $commission_id);

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
    public function get_count_session_id_by_commission_id($commission_id) {
        $domain = $this->query("SELECT distinct(mois) FROM sessions WHERE membres_commissions_commission_id = " . $commission_id);

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
    public function get_count_sous_commission_id($commission_id) {
        $domain = $this->query("SELECT count(commission_id) FROM commissions WHERE commission_parent = " . $commission_id);

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
    public function get_nombre_jour_by_values($commission_id, $personne_id, $month, $year) {
		$year = $this->real_escape_string($year);
		//$month = $this->real_escape_string($month);
        $domain = $this->query("SELECT nombre_jour FROM sessions WHERE sessions.membres_personnes_personne_id = " . $personne_id 
							   . " AND sessions.membres_commissions_commission_id = " . $commission_id . " AND sessions.mois = " . $month 
							   . " AND sessions.annee = '" . $year 
							   . "' AND etat_validation = 2 AND etat_appur = 0 ");

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
    
	    public function get_ref_dossier($ref_dossier) {
		$ref_dossier = $this->real_escape_string($ref_dossier);
        $domain = $this->query("SELECT ref_dossier FROM ordre_virements WHERE ref_dossier = '" . $ref_dossier . "'");

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
	    public function get_nombre_jour_sCom_by_values($commission_id, $personne_id, $month, $year) {
		$year = $this->real_escape_string($year);
		//$month = $this->real_escape_string($month);
        $domain = $this->query("SELECT count(sessions.Nombre_jour) FROM sessions, commissions 
								WHERE sessions.membres_commissions_commission_id = commissions.commission_id
								AND commissions.commission_parent = " . $commission_id 
								. " AND sessions.membres_personnes_personne_id = " . $personne_id 
								. " AND sessions.mois = " . $month 
								. " AND sessions.annee = '" . $year 
								. "'");

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
    public function get_somme_nombre_jour_by_values($commission_id, $personne_id, $month1, $month2, $year) {
		$year = $this->real_escape_string($year);
		//$month = $this->real_escape_string($month);
        $domain = $this->query("SELECT sum(nombre_jour) FROM sessions WHERE sessions.membres_personnes_personne_id = " . $personne_id 
							   . " AND sessions.membres_commissions_commission_id = " . $commission_id . " AND sessions.mois between " . $month1 
							   . " AND ". $month2 
							   .  "AND sessions.annee = '" . $year . "'");

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }

    public function get_localite_lib_by_localite_id($localite_id) {
        $domain = $this->query("SELECT localite_lib FROM localites WHERE localite_id = " 
							   . $localite_id );

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
    public function get_value_by_value_id($value_id) {		
        $domain = $this->query("SELECT structure_lib FROM structures WHERE structure_id = "
                        . $value_id );

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
    public function get_type_commission_lib_by_commission_id($type_commission_id) {
        $domain = $this->query("SELECT type_commission_lib FROM type_commissions WHERE type_commission_id = " 
							   . $type_commission_id );

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
    public function get_nature_lib_by_nature_id($nature_id) {
        $domain = $this->query("SELECT lib_nature FROM natures WHERE nature_id = " 
							   . $nature_id );

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }

	public function get_fonction_lib_by_fonction_id($fonction_id) {
        $domain = $this->query("SELECT fonction_lib FROM fonctions WHERE fonction_id = "
                        . $fonction_id );

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
    public function get_localite_id_by_commission_id($commission_id) {
        $domain = $this->query("SELECT localite_id FROM commissions WHERE commission_id = " . $commission_id );

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
    public function get_dossier_id_by_reference($reference) {
        $reference = $this->real_escape_string($reference);
        $domain = $this->query("SELECT dossier_id FROM dossiers WHERE dossier_ref = '"
                        . $reference . "'");

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
    public function get_nombre_sous_commissions($commission_id) {
        $domain = $this->query("SELECT count(commission_id) FROM commissions WHERE commission_parent = "
                        . $commission_id );

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
    public function get_value_id_by_value($value_id, $table, $search_value, $value) {
        $name = $this->real_escape_string($value);
        $domain = $this->query("SELECT " . $value_id . " FROM " . $table . " WHERE " . $search_value . " = '"
                        . $value . "'");

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
	function afficher_etat_valide($comID, $mID, $aID) {
        $mID = $this->real_escape_string($mID);
		$aID = $this->real_escape_string($aID);
	    $domain = $this->query("SELECT etat_validation FROM sessions WHERE mois= '" . $mID 
							   . "' AND annee= '" . $aID 
							   . "' AND membres_commissions_commission_id = " . $comID);

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
	function afficher_etat_control($comID, $mID, $aID) {
        $mID = $this->real_escape_string($mID);
		$aID = $this->real_escape_string($aID);
	    $domain = $this->query("SELECT userControlate FROM sessions WHERE mois= '" . $mID 
							   . "' AND annee= '" . $aID 
							   . "' AND membres_commissions_commission_id = " . $comID);

        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
    public function get_wishes_by_wisher_id($wisherID) {
        return $this->query("SELECT id, description, due_date FROM wishes WHERE wisher_id=" . $wisherID);
    }
    public function get_month_by_month_id($monthID) {
		$monthID = $this->real_escape_string($monthID);
        $domain = $this->query("SELECT lib_mois FROM mois WHERE mois_id = '" . $monthID . "'" );
        if ($domain->num_rows > 0){
            $row = $domain->fetch_row();
            return $row[0];
        } else
            return null;
    }
    public function get_person_by_value($personne_matricule, $personne_nom) {
        return $this->query("SELECT person_id FROM personnes WHERE personne_matricule =" . $personne_matricule . " AND personne_nom like " . $personne_nom);
    }

    public function create_wisher($name, $password) {
        $name = $this->real_escape_string($name);
        $password = $this->real_escape_string($password);
        $this->query("INSERT INTO wishers (name, password) VALUES ('" . $name
                . "', '" . $password . "')");
    }

  /*  public function create_listing_action($UserId, $PageLink, $ModificationType, $DateCreation) {
        $PageLink = $this->real_escape_string($PageLink);
		$ModificationType = $this->real_escape_string($ModificationType);
        $this->query("INSERT INTO listing_action (UserId, PageLink, ModificationType, DateCreation) VALUES (" . $UserId . ", '" 
				. $PageLink . "', '" 
				. $ModificationType . "', " 
				. $this->format_date_for_sql($DateCreation) . ")");
    }*/
	
    public function create_listing_action($UserId, $PageLink, $ModificationType, $DateUpdate) {		
		$PageLink = $this->real_escape_string($PageLink); 
		$ModificationType = $this->real_escape_string($ModificationType);
		
        $this->query("INSERT INTO listing_action (UserId, PageLink, ModificationType, DateUpdate) VALUES (" 
		. $UserId .", '" 
		.$PageLink. "', '".$ModificationType."', " 
		. $this->format_date_for_sql($DateUpdate) .")");
    }
	
    public function create_representant($commission_id, $dossier_id, $nombre_dossier, $count, $month, $year, $personne_id, $fonction_id, $variable, $DATE, $display) {		
        $month = $this->real_escape_string($month);
        $year = $this->real_escape_string($year);
        $variable = $this->real_escape_string($variable);		
        $display = $this->real_escape_string($display);			
        $this->query("INSERT INTO sessions (membres_commissions_commission_id, dossiers_dossier_id, nombre_dossier, nombre_jour, mois, annee, membres_personnes_personne_id, membres_fonctions_fonction_id, jour, dateCreation, display) VALUES (" . $commission_id . ", " . $dossier_id . ", " . $nombre_dossier . ", " . $count . ", '" . $month . "', '" . $year . "', " . $personne_id . ", " . $fonction_id . ", '" . $variable . "', " . $this->format_date_for_sql($DATE) . ", '" . $display . "')");
    }
    public function verify_wisher_credentials($name, $password) {
        $name = $this->real_escape_string($name);
        $password = $this->real_escape_string($password);
        $result = $this->query("SELECT 1 FROM users WHERE name = '"
                        . $name . "' AND password = '" . $password . "'");
        return $result->data_seek(0);
    }
    public function verify_session_credentials($commission, $month, $year) {
        $commission = $this->real_escape_string($commission);
        $month = $this->real_escape_string($month);
        $year = $this->real_escape_string($year);
        $result = $this->query("SELECT 1 FROM sessions WHERE membres_commissions_commission_id = '"
                        . $commission . "' AND mois = '" . $month . "' AND annee = '" . $year . "'");
        return $result->data_seek(0);
    }
    public function verify_commissions_representant($commission_id, $personne_id) {
        $result = $this->query("SELECT 1 FROM membres WHERE commissions_commission_id = "
                        . $commission_id . " AND personnes_personne_id = " . $personne_id );
        return $result->data_seek(0);
    }
    public function verify_membres_by_person_id($personne_id) {
        $result = $this->query("SELECT 1 FROM membres WHERE personnes_personne_id = " . $personne_id );
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
	
    public function update_comment($comment_id, $duedate) {
        $this->query("UPDATE commentaires SET notation = '1'
				, dateUpdate = " . $this->format_date_for_sql($duedate)
                . " WHERE comment_id =" . $comment_id);
    }
    public function update_users_connected($user_connected, $user_id) {
		$user_connected = $this->real_escape_string($user_connected);
        $this->query("UPDATE users SET user_connected = '" . $user_connected . 
				"' WHERE user_id =" . $user_id);
    }
    public function update_wish($wishID, $description, $duedate) {
        $description = $this->real_escape_string($description);
        $this->query("UPDATE wishes SET description = '" . $description .
                "', due_date = " . $this->format_date_for_sql($duedate)
                . " WHERE id =" . $wishID);
    }

    public function update_users_compteur($compteur, $user_id, $duedate) {
        $this->query("UPDATE users SET compteur = " . $compteur
					 . ", dateUpdate = " . $this->format_date_for_sql($duedate)
					 . " WHERE user_id = " . $user_id);
    }

    public function get_wish_by_wish_id($wishID) {
        return $this->query("SELECT id, description, due_date FROM wishes WHERE id = " . $wishID);
    }

    public function delete_wish($wishID) {
        $this->query("DELETE FROM wishes WHERE id = " . $wishID);
    }
	
	public function delete_record($table, $champ, $recordID) {
		$table = $this->real_escape_string($table);
		$champ = $this->real_escape_string($champ);
        $this->query("DELETE FROM " . $table . " WHERE " . $champ . " = " . $recordID);
    }
	
    public function update_record($table, $col_name, $col_name1, $date, $record_id, $record_id1) {
		$col_name = $this->real_escape_string($col_name);
		$col_name1 = $this->real_escape_string($col_name1);
		$table = $this->real_escape_string($table);
        $this->query("UPDATE " . $table . " SET " . $col_name . " = " . $record_id . " 
					 , dateUpdate = " . $this->format_date_for_sql($date) .
					 " WHERE " . $col_name1 . " = " . $record_id1);
	}

//------------------ personnes--------------
    function insert_personne($personne_matricule,$personne_nom,$personne_prenom,$personne_grade,$domaine_id,$personne_telephone,$structure_id,$sous_groupe_id,$fonction_id,$type_personne_id,$user_id,$dateCreation,$display) {
					   
		$personne_matricule = $this->real_escape_string($personne_matricule);
		$personne_nom = $this->real_escape_string($personne_nom);
		$personne_prenom = $this->real_escape_string($personne_prenom);
		$personne_grade = $this->real_escape_string($personne_grade);
		$personne_telephone = $this->real_escape_string($personne_telephone);
		$display = $this->real_escape_string($display);

        if ($this->format_date_for_sql($dateCreation)==null){
        $this->query("INSERT INTO personnes (personne_matricule, personne_nom, personne_prenom, personne_grade, domaine_id, personne_telephone, structure_id, sous_groupe_id, fonction_id, type_personne_id, user_id, display)" .
			 " VALUES ('" . $personne_matricule . "', '" . personne_nom . "', '" . personne_prenom . "', '" . personne_grade . "', " . domaine_id . ", '" 
						  . personne_telephone . "', " . structure_id . ", " . sous_groupe_id . ", " . fonction_id . ", " . type_personne_id . ", " 
						  . user_id . ", '" . display . "')");
        } else
        $this->query("INSERT INTO personnes (personne_matricule, personne_nom, personne_prenom, personne_grade, domaine_id, personne_telephone, structure_id, sous_groupe_id, fonction_id, type_personne_id, user_id, date_creation, display)" .
			 " VALUES ('" . $personne_matricule . "', '" . personne_nom . "', '" . personne_prenom . "', '" . personne_grade . "', " . domaine_id . ", '" 
					   . personne_telephone . "', " . structure_id . ", " . sous_groupe_id . ", " . fonction_id . ", " . type_personne_id . ", " 
					   . user_id . ", ". $this->format_date_for_sql($dateCreation) . ", '" . display . "')");

    }

    function verify_personne_id($personne_id) {
        $result = $this->query("SELECT 1 FROM personnes WHERE personne_id = ". $personne_id );
        return $result->data_seek(0);
    }
//------------ Table RIB ----------------------

    function update_rib($bank_code, $agence_code, $num_compte, $cle, $personne_id, $duedate) {
        $bank_code = $this->real_escape_string($bank_code);
		$agence_code = $this->real_escape_string($agence_code);
		$num_compte = $this->real_escape_string($num_compte);
		$cle = $this->real_escape_string($cle);
        $this->query("UPDATE rib SET banque_code = '" . $bank_code 
				. "', agence_cle = '" . $bank_code . $agence_code 
				. "', agence_code = '" . $agence_code 
				. "', numero_compte = '" . $num_compte 
				. "', cle = '" . $cle 
				. "', dateUpdate = " . $this->format_date_for_sql($duedate)
                . " WHERE personne_id =" . $personne_id);
    }
	
    function insert_rib($personne_id, $personne_matricule, $agence_cle, $banque_code, $agence_code, $numero_compte, $user_id, $cle, $dateCreation) {

					   $personne_matricule = $this->real_escape_string($personne_matricule);
					   $agence_cle = $this->real_escape_string($agence_cle);
                       $banque_code = $this->real_escape_string($banque_code);
                       $agence_code = $this->real_escape_string($agence_code);
                       $numero_compte = $this->real_escape_string($numero_compte);
                       $cle = $this->real_escape_string($cle);
					   

        if ($this->format_date_for_sql($dateCreation)==null){
        $this->query("INSERT INTO rib (personne_id, personne_matricule, agence_cle, banque_code, agence_code, numero_compte, user_id, cle)" . 
			   " VALUES (" . $personne_id . ", '" . $personne_matricule . "',  '" . $agence_cle . "',  '" . $banque_code . "',  '" . $agence_code . "',  '" 
						   . $numero_compte . "', " .$user_id . ",  '" . $cle . "')");
        } else
        $this->query("INSERT INTO rib (personne_id, agence_cle, banque_code, agence_code, numero_compte, user_id, cle, date_creation)" . 
			   " VALUES (" . $personne_id . ", '" . $personne_matricule . "',  '" . $agence_cle . "',  '" . $banque_code . "',  '" . $agence_code . "',  '" 
						   . $numero_compte . "', " .$user_id . ",  '" . $cle . "', ". $this->format_date_for_sql($dateCreation) . ")");
		}

function insert_rib_by_person_id($personne_id, $banque_code, $agence_code, $numero_compte, $cle, $user_id,  $dateCreation) {

                       $banque_code = $this->real_escape_string($banque_code);
                       $agence_code = $this->real_escape_string($agence_code);
                       $numero_compte = $this->real_escape_string($numero_compte);
                       $cle = $this->real_escape_string($cle);
					   
        $this->query("INSERT INTO rib (personne_id, banque_code, agence_code, numero_compte, cle, user_id, date_creation)" . 
			   " VALUES (" . $personne_id . ", '" . $banque_code . "',  '" . $agence_code . "',  '" 
						   . $numero_compte . "', " .$user_id . ",  '" . $cle . "', ". $this->format_date_for_sql($dateCreation) . ")");
		}
//-------------------- Table Session ----------------
    function insert_sessions($membres_commissions_commission_id, $dossiers_dossier_id, $nombre_dossier, $nombre_jour, $mois, $annee, $membres_personnes_personne_id, $membres_fonctions_fonction_id, $jour, $dateCreation, $user_id, $display) {
					   
					   $mois = $this->real_escape_string($personne_matricule);
					   $annee = $this->real_escape_string($personne_matricule);
					   $jour = $this->real_escape_string($personne_matricule);
					   $display = $this->real_escape_string($personne_matricule);

        if ($this->format_date_for_sql($dateCreation)==null){
        $this->query("INSERT INTO sessions (membres_commissions_commission_id, dossiers_dossier_id, nombre_dossier, nombre_jour, mois, annee, membres_personnes_personne_id, membres_fonctions_fonction_id, $jour, user_id, display)" . 
		" VALUES (" . $membres_commissions_commission_id . ", " . $dossiers_dossier_id . ", " . $nombre_dossier . ", " . $nombre_jour . ", '" . $mois . 
				  "', '" . $annee . "', " . $membres_personnes_personne_id . ", " . $membres_fonctions_fonction_id . ", '" . $jour . 
				  "', " . $user_id . ", '" . $display . "')");
        } else
        $this->query("INSERT INTO sessions (membres_commissions_commission_id, dossiers_dossier_id, nombre_dossier, nombre_jour, mois, annee, membres_personnes_personne_id, membres_fonctions_fonction_id, $jour, dateCreation, user_id, display)" . 
		" VALUES (" . $membres_commissions_commission_id . ", " . $dossiers_dossier_id . ", " . $nombre_dossier . ", " . $nombre_jour . ", '" . $mois . 
				  "', '" . $annee . "', " . $membres_personnes_personne_id . ", " . $membres_fonctions_fonction_id . ", '" . $jour . 
				  "', ". $this->format_date_for_sql($dateCreation) . ", " . $user_id . ", '" . $display . "')");
    }

}
//------------------------------------table listing_action----------------------
   function insert_listing_action($UserId, $PageLink, $ModificationType, $duedate) {
        $PageLink = $this->real_escape_string($PageLink);
		$ModificationType = $this->real_escape_string($ModificationType);
        if ($this->$duedate==null){
           $this->query("INSERT INTO listing_action (UserId, PageLink, ModificationType)" .
                " VALUES (" . $UserId . ", '" . $PageLink . "', '" . $ModificationType . "')");
        } else
        $this->query("INSERT INTO listing_action (UserId, PageLink, ModificationType, due_date)" .
                " VALUES (" . $UserId . ", '" . $PageLink . "', '" . $ModificationType . "', "
                . $this->format_date_for_sql($duedate) . ")");
    }
	
	function create_listing_action($UserId, $PageLink, $ModificationType, $DateCreation) {
        $PageLink = $this->real_escape_string($PageLink);
		$ModificationType = $this->real_escape_string($ModificationType);
        $this->query("INSERT INTO listing_action (UserId, PageLink, ModificationType, DateUpdate) VALUES (" . $UserId . ", '" 
				. $PageLink . "', '" 
				. $ModificationType . "', " 
				. $this->format_date_for_sql($DateCreation) . ")");
    }
?>