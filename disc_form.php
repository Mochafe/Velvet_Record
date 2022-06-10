<?php
    include("db.php");

    $db = ConnexionBase();

    $disc_id = $_GET["disc_id"];

    $requete = $db->prepare("SELECT * FROM disc JOIN artist ON artist.artist_id = disc.artist_id WHERE disc_id = (:disc_id)");

    $requete->bindValue(":disc_id", $disc_id, PDO::PARAM_INT);

    $requete->execute();

    $disc_detail = $requete->fetch();

    $requete->closeCursor();

    $requete = $db->prepare("SELECT * FROM artist WHERE artist_id != :artist_id");

    $requete->bindValue(":artist_id", $disc_detail["artist_id"], PDO::PARAM_INT);

    $requete->execute();

    $artists = $requete->fetchAll(PDO::FETCH_OBJ);

    $requete->closeCursor();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">
    <title>Modifier un vinyle</title>
</head>
<body>
<form class="container" action="script_disc_modif.php" enctype="multipart/form-data" method="POST">
    <h1 class="mt-5">Modifier un vinyle</h1>
        <div class="row">
            <div class="col-12 mt-3">
                <label class="form-label">Title</label>
                <input name="title" id="title" class="form-control" type="text" value="<?php echo($disc_detail["disc_title"]); ?>">
            </div>
            <div class="col-12 mt-3">
                <label class="form-label">Artist</label>
                <select name="artist" id="artist" class="form-select">
                    <option value="<?php echo($disc_detail["artist_id"]); ?>"><?php echo($disc_detail["artist_name"]); ?></option>
                    <?php foreach($artists as $artist) : ?>
                        <option value="<?php echo($artist->artist_id) ?>"><?php echo($artist->artist_name) ?></option>
                    <?php endforeach ?>    
                </select>
            </div>
            <div class="col-12 mt-3">
                <label class="form-label">Year</label>
                <input name="year" id="year" class="form-control" type="text" value="<?php echo($disc_detail["disc_year"]); ?>">
            </div>
            <div class="col-12 mt-3">
                <label class="form-label">Genre</label>
                <input name="genre" id="genre" class="form-control" type="text" value="<?php echo($disc_detail["disc_genre"]); ?>">
            </div>
            <div class="col-12 mt-3">
                <label class="form-label">Label</label>
                <input name="label" id="label" class="form-control" type="text" value="<?php echo($disc_detail["disc_label"]); ?>">
            </div>
            <div class="col-12 mt-3">
                <label class="form-label">Price</label>

                <div class="input-group">
                    <input name="price" id="price" class="form-control" type="text" value="<?php echo($disc_detail["disc_price"]); ?>">
                    <span class="input-group-text">$</span>
                </div>
                
            </div>
            <div class="col-12 col-lg-4 mt-3">
                <label class="form-label">Picture</label>
                <input type="file" name="picture" id="picture" class="form-control">
                <img src="img/<?php echo($disc_detail["disc_picture"]); ?>" class="w-100">
            </div>

            <input type="hidden" name="disc_id" id="disc_id" value="<?php echo($disc_detail["disc_id"]) ?>">
        </div>
        <div class="my-4">
            <input type="submit" value="Modifier" class="btn btn-primary">
            <a href="discs.php" class="btn btn-primary">Retour</a>
        </div>
</form>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>