<?php
function GetRequest($theType, $theNumber, $theMatiere, $theState)  
{

  switch ($theType) {
	case 0:
	if ((isset($theState) && theState != NULL) && (isset($theMatiere) && $theMatiere != NULL)){
			$query = sprintf("SELECT personnes.personne_nom, personnes.personne_prenom, structures.structure_lib, matieres.TypesMatieres_typesMatiereID, matieres.matiereDesignation, matieres.matiereDescription,  matierespardetenteurs.* FROM matierespardetenteurs, personnes, matieres, structures WHERE matierespardetenteurs.personnes_personneID = personnes.personne_id AND matierespardetenteurs.matieres_matiereID = matieres.matiereID AND personnes.display = 1 AND personnes.structure_id = structures.structure_id AND matierespardetenteurs.matieres_matiereID = %s AND etat = %s ORDER BY matiereDetenteurID ASC", GetSQLValueString($theMatiere, "int"), GetSQLValueString($theState, "text"));
	} else if (isset($theMatiere) && $theMatiere != NULL){
			$query = sprintf("SELECT personnes.personne_nom, personnes.personne_prenom, structures.structure_lib, matieres.TypesMatieres_typesMatiereID, matieres.matiereDesignation, matieres.matiereDescription,  matierespardetenteurs.* FROM matierespardetenteurs, personnes, matieres, structures WHERE matierespardetenteurs.personnes_personneID = personnes.personne_id AND matierespardetenteurs.matieres_matiereID = matieres.matiereID AND personnes.display = 1 AND personnes.structure_id = structures.structure_id AND matierespardetenteurs.matieres_matiereID = %s ORDER BY matiereDetenteurID ASC", GetSQLValueString($theMatiere, "int"));
	} else if (isset($theState) && theState != NULL){
			$query = sprintf("SELECT personnes.personne_nom, personnes.personne_prenom, structures.structure_lib, matieres.TypesMatieres_typesMatiereID, matieres.matiereDesignation, matieres.matiereDescription,  matierespardetenteurs.* FROM matierespardetenteurs, personnes, matieres, structures WHERE matierespardetenteurs.personnes_personneID = personnes.personne_id AND matierespardetenteurs.matieres_matiereID = matieres.matiereID AND personnes.display = 1 AND personnes.structure_id = structures.structure_id AND etat = %s ORDER BY matiereDetenteurID ASC", GetSQLValueString($theState, "text"));
	} else {
	$query = "SELECT personnes.personne_nom, personnes.personne_prenom, structures.structure_lib, matieres.TypesMatieres_typesMatiereID, matieres.matiereDesignation, matieres.matiereDescription,  matierespardetenteurs.* FROM matierespardetenteurs, personnes, matieres, structures WHERE matierespardetenteurs.personnes_personneID = personnes.personne_id AND matierespardetenteurs.matieres_matiereID = matieres.matiereID AND personnes.display = 1 AND personnes.structure_id = structures.structure_id ORDER BY matiereDetenteurID ASC";	
	}
	break;
	case 1:
	if ((isset($theState) && theState != NULL) && (isset($theMatiere) && $theMatiere != NULL)){
			$query = sprintf("SELECT personnes.personne_nom, personnes.personne_prenom, structures.structure_lib, matieres.TypesMatieres_typesMatiereID, matieres.matiereDesignation, matieres.matiereDescription,  matierespardetenteurs.* FROM matierespardetenteurs, personnes, matieres, structures WHERE matierespardetenteurs.personnes_personneID = personnes.personne_id AND matierespardetenteurs.matieres_matiereID = matieres.matiereID AND personnes.display = 1 AND personnes.structure_id = structures.structure_id AND matieres.TypesMatieres_typesMatiereID = %s AND matierespardetenteurs.matieres_matiereID = %s AND etat = %s ORDER BY matiereDetenteurID ASC", GetSQLValueString($theNumber, "int"), GetSQLValueString($theMatiere, "int"), GetSQLValueString($theState, "text"));
			
	} else if (isset($theMatiere) && $theMatiere != NULL){
			$query = sprintf("SELECT personnes.personne_nom, personnes.personne_prenom, structures.structure_lib, matieres.TypesMatieres_typesMatiereID, matieres.matiereDesignation, matieres.matiereDescription,  matierespardetenteurs.* FROM matierespardetenteurs, personnes, matieres, structures WHERE matierespardetenteurs.personnes_personneID = personnes.personne_id AND matierespardetenteurs.matieres_matiereID = matieres.matiereID AND personnes.display = 1 AND personnes.structure_id = structures.structure_id AND matieres.TypesMatieres_typesMatiereID = %s AND matierespardetenteurs.matieres_matiereID = %s ORDER BY matiereDetenteurID ASC", GetSQLValueString($theNumber, "int"), GetSQLValueString($theMatiere, "int"));
			
	} else if (isset($theState) && theState != NULL){
			$query = sprintf("SELECT personnes.personne_nom, personnes.personne_prenom, structures.structure_lib, matieres.TypesMatieres_typesMatiereID, matieres.matiereDesignation, matieres.matiereDescription,  matierespardetenteurs.* FROM matierespardetenteurs, personnes, matieres, structures WHERE matierespardetenteurs.personnes_personneID = personnes.personne_id AND matierespardetenteurs.matieres_matiereID = matieres.matiereID AND personnes.display = 1 AND personnes.structure_id = structures.structure_id AND matieres.TypesMatieres_typesMatiereID = %s AND etat = %s ORDER BY matiereDetenteurID ASC", GetSQLValueString($theNumber, "int"), GetSQLValueString($theState, "text"));
	} else {
	$query = sprintf("SELECT personnes.personne_nom, personnes.personne_prenom, structures.structure_lib, matieres.TypesMatieres_typesMatiereID, matieres.matiereDesignation, matieres.matiereDescription,  matierespardetenteurs.* FROM matierespardetenteurs, personnes, matieres, structures WHERE matierespardetenteurs.personnes_personneID = personnes.personne_id AND matierespardetenteurs.matieres_matiereID = matieres.matiereID AND personnes.display = 1 AND personnes.structure_id = structures.structure_id AND matieres.TypesMatieres_typesMatiereID = %s ORDER BY matiereDetenteurID ASC", GetSQLValueString($theNumber, "int"));	
	}
	break;
	case 3:

	break;
	case 4:

	break;
	case 5:

	break;

  }
  return $query;
}
?>