<?php
    $title = (isset($_POST["title"]) && $_POST["title"] != "") ? htmlspecialchars(trim($_POST["title"])) : null;

    $artist_id = (isset($_POST["artist"]) && $_POST["artist"] != "") ? htmlspecialchars(trim($_POST["artist"])) : null;

    $year = (isset($_POST["year"]) && $_POST["year"] != "") ? htmlspecialchars(trim($_POST["year"])) : null;

    $genre = (isset($_POST["genre"]) && $_POST["genre"] != "") ? htmlspecialchars(trim($_POST["genre"])) : null;

    $price = (isset($_POST["price"]) && $_POST["price"] != "") ? str_replace([","], ["."], $_POST["price"]) : null;

    $label = (isset($_POST["label"]) && $_POST["label"] != "") ? htmlspecialchars(trim($_POST["label"])) : null;

    $picture = (isset($_FILES["picture"]["name"]) && $_FILES["picture"]["name"] != "") ? $_FILES["picture"] : null;

    if($title == null  || $artist_id == null || $year == null || $genre == null || $price == null || $picture == null || $label == null) {
        header("Location: disc_new.php");
        exit;
    }

    move_uploaded_file($picture["tmp_name"], "./img/" . $picture["name"]);

    require("db.php");
    $db = ConnexionBase();

    try {

        $requete = $db->prepare("INSERT INTO disc (disc_title, disc_year, disc_picture, disc_label, disc_genre, disc_price, artist_id) VALUES (:disc_title, :disc_year, :disc_picture, :disc_label, :disc_genre, :disc_price, :artist_id)");

        $requete->bindValue(":disc_title", $title, PDO::PARAM_STR);
        $requete->bindValue(":disc_year", $year, PDO::PARAM_INT);
        $requete->bindValue(":disc_picture", $picture["name"], PDO::PARAM_STR);
        $requete->bindValue(":disc_label", $label, PDO::PARAM_STR);
        $requete->bindValue(":disc_genre", $genre, PDO::PARAM_STR);
        $requete->bindValue(":disc_price", $price, PDO::PARAM_STR);
        $requete->bindValue(":artist_id", $artist_id, PDO::PARAM_INT);

        $requete->execute();

        $requete->closeCursor();
        
    } catch(Exception $e) {
        var_dump($requete->queryString);
        var_dump($requete->errorInfo());
        echo "Erreur : " . $requete->errorInfo()[2] . "<br>";
        die("Fin du script (script_disc_ajout.php)");
    }

    header("Location: discs.php");
    exit;
?>