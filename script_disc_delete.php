<?php
if(!isset($_GET["disc_id"]) || intval($_GET["disc_id"]) <= 0) GOTO redirection;

require("db.php");
$db = ConnexionBase();

try {
    $request = $db->prepare("DELETE FROM disc WHERE disc_id = ?");
    $request->execute(array($_GET["disc_id"]));
    $request->closeCursor();
} catch(Exception $e) {
    echo $e->getMessage();
    echo "<br>----------------------------<br>";
    echo "Erreur : " . $requete->errorInfo()[2] . "<br>";
    die("Fin du script (script_disc_delete.php)");
}

redirection:
header("Location: discs.php");
exit;
?>