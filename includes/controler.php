<?php 
		$date = date('Y-m-d H:i:s');
		$commissionIsUnique = true;
		$typecommissionIsEmpty = false;
		$natureIsEmpty = false;
		$regionIsEmpty = false;
		$departementIsEmpty = false;
		$structureIsEmpty = false;
		$localiteIsEmpty = false;
		$fonctionIsEmpty = false;
		
		if (isset($_POST['type_commission_id']) && $_POST['type_commission_id'] == ""){
		$typecommissionIsEmpty = true; }
		if (isset($_POST['nature_id']) && $_POST['nature_id'] == ""){
		$natureIsEmpty = true; }
		if (isset($_POST['region_id']) && $_POST['region_id'] == ""){
		$regionIsEmpty = true; }
		if (isset($_POST['departement_id']) && $_POST['departement_id'] == ""){
		$departementIsEmpty = true; }
		if (isset($_POST['localite_id']) && $_POST['localite_id'] == ""){
		$localiteIsEmpty = true; }
		if (isset($_POST['structure_id']) && $_POST['structure_id'] == ""){
		$structureIsEmpty = true; }
		if (isset($_POST['fonction_id']) && $_POST['fonction_id'] == ""){
		$fonctionIsEmpty = true; }
?>