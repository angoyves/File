<?
/*  S R I P T S    U S U E L S    D E    " T R A V A I L "  */

function language_redirection_manager(){
	$lg = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
	$location = 'location:';
	$lang_tab = array('fr','en');
	
	if (in_array($lg, array('fr','en'))) {
		$location .= $lg.'/';
	}
	else $location .= 'fr';
	
	header($location);
}
?>