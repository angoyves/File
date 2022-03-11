<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AGIS</title>
<link rel="stylesheet" href="../../css/signin.css" type="text/css">
</head>

<body>
<div id="pswrapper">
  <form id="login" name="login" method="post" action="connexions.php" autocomplete="off">
    <input type="hidden" name="httpPort" value="" />
    <input type="hidden" name="timezoneOffset" value="0" />
    <div class="signon-main"> <img src="../../images/img/logo_minmap.gif" alt="Connexion à AGESCOM" width="250" height="223" class="ps-staticimg" title="Connexion à AGIS" />
      <div class="ps_signinentry expire">
        <div id="ps-img">
          <p class="ps_loginmessagelarge">ATTENTION!!! Votre session est active...!</p>
          <p>Pour plus de sécurité sur ce site, nous bloquons l'acces à une seule connexion active pour un compte.</p>
          <p>Essayez à nouveau de vous connecter  à partir de cette fenêtre du navigateur si la session active a été close dans d'autres  navigateur. Sinon, cliquez directement sur le lien ci-dessous pour</p>
          <p class="ps_loginmessagelarge"><a href="UserAlterConnexion.php?uID=<?php echo $_GET['uID'] ?>" class="ps-button" >Cliquez ici si vous etes le propriétaire de ce compte AGESCOM.</a></p>
        </div>
      </div>
      <footer id="ptfooter" class="ps_footer_text ">Copyright Ministere des Marches Publics. Tous droits réservés.</footer>
    </div>
  </form>
</div>
</body>
</html>