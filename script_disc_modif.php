<?php
    include("db.php");

    $db = ConnexionBase();

    $request = $db->prepare("SELECT disc_picture FROM disc WHERE disc_id = (:disc_id)");

    $request->bindValue(":disc_id", $_POST["disc_id"], PDO::PARAM_INT);

    $request->execute();

    $pic = $request->fetch();

    $request->closeCursor();

    var_dump($pic);
    var_dump($_POST);

    $disc_id = (isset($_POST["disc_id"]) && $_POST["disc_id"] != "") ? htmlspecialchars(trim($_POST["disc_id"])) : null;

    $title = (isset($_POST["title"]) && $_POST["title"] != "") ? htmlspecialchars(trim($_POST["title"])) : null;

    $artist_id = (isset($_POST["artist"]) && $_POST["artist"] != "") ? htmlspecialchars(trim($_POST["artist"])) : null;

    $year = (isset($_POST["year"]) && $_POST["year"] != "") ? htmlspecialchars(trim($_POST["year"])) : null;

    $genre = (isset($_POST["genre"]) && $_POST["genre"] != "") ? htmlspecialchars(trim($_POST["genre"])) : null;

    $price = (isset($_POST["price"]) && $_POST["price"] != "") ? str_replace([","], ["."], $_POST["price"]) : null;

    $label = (isset($_POST["label"]) && $_POST["label"] != "") ? htmlspecialchars(trim($_POST["label"])) : null;

    $picture = (isset($_FILES["picture"]["name"]) && $_FILES["picture"]["name"] != "") ? $_FILES["picture"] : $pic["disc_picture"];

    if($disc_id == null) {
        header("Location: discs.php");
    }
    if($title == null  || $artist_id == null || $year == null || $genre == null || $price == null || $label == null) {
        header("Location: disc_form.php?disc_id=" . $disc_id);
        exit;
    }

    if($picture != (($picture == $pic["disc_picture"]) ? $picture : $pic["disc_picture"])) {
        move_uploaded_file($picture["tmp_name"], "./img/" . $picture["name"]);
    }


try {
        $requete = $db->prepare("UPDATE disc SET disc_title = :disc_title, disc_year = :disc_year, disc_picture = :disc_picture, disc_label = :disc_label, disc_genre = :disc_genre, disc_price = :disc_price, artist_id = :artist_id WHERE disc_id = :disc_id;");

        $requete->bindValue("disc_title", $title, PDO::PARAM_STR);
        $requete->bindValue("disc_year", $year, PDO::PARAM_INT);
        (($picture == $pic["disc_picture"]) ? $requete->bindValue("disc_picture", $picture, PDO::PARAM_STR) : $requete->bindValue("disc_picture", $picture["name"], PDO::PARAM_STR));
        $requete->bindValue("disc_label", $label, PDO::PARAM_STR);
        $requete->bindValue("disc_genre", $genre, PDO::PARAM_STR);
        $requete->bindValue("disc_price", $price, PDO::PARAM_STR);
        $requete->bindValue("artist_id", $artist_id, PDO::PARAM_INT);
        $requete->bindValue("disc_id", $disc_id, PDO::PARAM_INT);
        $requete->execute();
        
/*
        $requete->execute(array(
            "disc_title" => $title,
            "disc_year" => $year,
            "disc_picture" => (($picture == $pic["disc_picture"]) ? $picture: $picture["name"]),
            "disc_label" => $label,
            "disc_genre" => $genre,
            "disc_price" => $price,
            "artist_id" => $artist_id,
            "disc_id" => $disc_id
        ));
*/
        $requete->closeCursor();
        
    }catch(Exception $e) {
        echo $e->getMessage();
        echo "<br>----------------------------<br>";
        echo "Erreur : " . $requete->errorInfo()[2] . "<br>";
        die("Fin du script (script_artist_modif.php)");
    }

    header("Location: discs.php");
    exit;
?>