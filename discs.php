<?php
    include("db.php");
    $db = ConnexionBase();

    $request = $db->prepare("SELECT * FROM disc JOIN artist ON artist.artist_id = disc.artist_id");
    $request->execute();
    $discs = $request->fetchAll(PDO::FETCH_OBJ);
    //var_dump($discs);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Disques</title>
</head>
<body>
    <div class="container">
        <div class="row mt-5">
            <h1 class="d-block col-6">Liste des disques (<?=count($discs)?>)</h1>
            <a href="disc_new.php" class="btn btn-primary offset-2 col-4 offset-lg-4 col-lg-2 h-50 w-fit">Ajouter</a>
        </div>
        <div class="row g-3">
            <?php foreach($discs as $disc) : ?>            
                <img class="col-6 col-lg-3" src="img/<?= $disc->disc_picture ?>" height="300" width="300">
                <div class="col-6 col-lg-3"><h4><?= $disc->disc_title ?> </h4>
                    <h5><?= $disc->artist_name ?></h5>
                    <h5>Label : </h5><?= $disc->disc_label ?>
                    <h5>Year : </h5><?= $disc->disc_year ?>
                    <h5>Genre : </h5><?= $disc->disc_genre ?>

                    <a href="disc_detail?id=<?= $disc->disc_id ?>" class="btn btn-primary d-block mt-3 w-25">Détails</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>