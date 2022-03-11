// JavaScript Document

	//·Î±×¾Æ¿ô :: Logout
	function fn_logOut() {
		util_confirmAlert("Etes-vous sur de vouloir deconnecter?", "submitLogout()");
	}
	function submitLogout() {
		window.top.location.href = "../CtrL/UserLogOutCtrl.php?doLogout=true";
	}
