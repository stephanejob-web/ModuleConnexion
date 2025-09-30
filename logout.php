<?php
// logout.php
session_start();
session_unset();  // supprime toutes les variables de session
session_destroy(); // détruit la session
header('Location: login.php'); // redirige vers la page de login
exit;
