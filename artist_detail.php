

<?php
    // On se connecte à la BDD via notre fichier db.php :
    require "db.php";
    $db = connexionBase();

    // On récupère l'ID passé en paramètre :
    $id = $_GET["id"];

    // On crée une requête préparée avec condition de recherche :
    $requete = $db->prepare("SELECT * FROM artist WHERE artist_id=?");
    // on ajoute l'ID du disque passé dans l'URL en paramètre et on exécute :
    $requete->execute(array($id));

    // on récupère le 1e (et seul) résultat :
    $myArtist = $requete->fetch(PDO::FETCH_OBJ);
    //var_dump($myArtist);
    // on clôt la requête en BDD
    $requete->closeCursor();
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <title>PDO - Détail</title>
    </head>
    <body>
        <table class="table table-bordered">
        <?php
        //href=script_artist_delete.php?id=$myArtist->artist_id
            if($myArtist) {
                echo("<tr><td class=\"text-center\">Artiste N°</td><td>$myArtist->artist_id</td></tr>");
                echo("<tr><td class=\"text-center\">Nom de l'artiste</td><td>$myArtist->artist_name</td></tr>");
                echo("<tr><td class=\"text-center\">Site Internet</td><td>$myArtist->artist_url</td></tr></table>");
                echo("<a class=\"btn btn-primary m-3\" href=artist_form.php?id=$myArtist->artist_id>Modifier</a>");
                echo("<a class=\"btn btn-primary m-3\" href=\"#delete-offcanvas\" data-bs-toggle=\"offcanvas\" role=\"button\" aria-controls=\"offcanvas-delete\">Supprimer</a>");
            } else {
                echo("<h1>Artiste inconnue</h1>");
            }
        ?>

        <div class="offcanvas offcanvas-bot align-self-center rounded-3" tabindex="-1" id="delete-offcanvas" aria-labelledby="offcanvas-deleteLabel">
            <div class="offcanvas-header">
              <h3 class="offcanvas-title" id="offcanvas-deleteLabel">Voulez vous vraiment supprimer cette artiste ?</h3>
              <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>                
            <div class="offcanvas-body">
                <div class="text-center">
                <a class="btn btn-primary" href="script_artist_delete.php?id=<?= $myArtist->artist_id ?>">Oui</a>
                <button class="btn btn-primary" data-bs-dismiss="offcanvas">Non</button>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>