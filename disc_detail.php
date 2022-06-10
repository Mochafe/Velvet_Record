<?php
    include("db.php");

    $db = ConnexionBase();

    $disc_id = $_GET["disc_id"];

    $requete = $db->prepare("SELECT * FROM disc JOIN artist ON artist.artist_id = disc.artist_id WHERE disc_id = (:disc_id)");

    $requete->bindValue(":disc_id", $disc_id, PDO::PARAM_INT);

    $requete->execute();

    $disc_detail = $requete->fetch();

    $requete->closeCursor();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">
    <title>Disque détails</title>
</head>
<body>
    <div class="container">
    <h1 class="mt-5">Details</h1>
        <div class="row">
            <div class="col-12 col-lg-6 mt-3">
                <label class="form-label">Title</label>
                <input class="form-control" type="text" value="<?php echo($disc_detail["disc_title"]); ?>" readonly>
            </div>
            <div class="col-12 col-lg-6 mt-3">
                <label class="form-label">Artist</label>
                <input class="form-control" type="text" value="<?php echo($disc_detail["artist_name"]); ?>" readonly>
            </div>
            <div class="col-12 col-lg-6 mt-3">
                <label class="form-label">Year</label>
                <input class="form-control" type="text" value="<?php echo($disc_detail["disc_year"]); ?>" readonly>
            </div>
            <div class="col-12 col-lg-6 mt-3">
                <label class="form-label">Genre</label>
                <input class="form-control" type="text" value="<?php echo($disc_detail["disc_genre"]); ?>" readonly>
            </div>
            <div class="col-12 col-lg-6 mt-3">
                <label class="form-label">Label</label>
                <input class="form-control" type="text" value="<?php echo($disc_detail["disc_label"]); ?>" readonly>
            </div>
            <div class="col-12 col-lg-6 mt-3">
                <label class="form-label">Price</label>
                <input class="form-control" type="text" value="<?php echo($disc_detail["disc_price"]); ?>" readonly>
            </div>
            <div class="col-12 col-lg-6 mt-3">
                <label class="form-label">Picture</label>
                <img src="img/<?php echo($disc_detail["disc_picture"]); ?>" class="w-100">
            </div>
        </div>
        <div class="my-4">
            <a href="disc_form.php?disc_id=<?php echo($disc_id); ?>" class="btn btn-primary">Modifier</a>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-delete">Supprimer</button>
            <a href="discs.php" class="btn btn-primary">Retour</a>
        </div>       
    </div>
    
    <div class="modal fade" id="modal-delete" tabindex="-1" aria-labelledby="modal-delete-label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title" id="modal-delete-label">Supprimer</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h3>Voulez vous vraiment supprimer ce disque ?</h3>
      </div>
      <div class="modal-footer">
        <a href="script_disc_delete.php?disc_id=<?php echo($_GET["disc_id"]) ?>" class="btn btn-danger">Supprimer</a>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Retour</button>  
      </div>
    </div>
  </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>