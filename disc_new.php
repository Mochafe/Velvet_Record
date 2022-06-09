<?php
    include("db.php");
    $db = ConnexionBase();
    $request = $db->prepare("SELECT artist_name, artist_id FROM artist");
    $request->execute();
    $artists = $request->fetchAll(PDO::FETCH_OBJ);
    //var_dump($artists);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">
    <title>Nouveau Disque</title>
</head>
<body>
    <form action="script_disc_ajout.php" method="post" class="container">
        <h1 class="mt-5">Ajouter un vinyle</h1>

        <label for="title" class="form-label mt-3">Title</label>
        <input type="text" name="title" id="title" placeholder="Enter title" class="form-control">

        <label for="artist" class="form-label mt-3">Artist</label>
        <select name="artist" id="artist" class="form-select">
            <option selected>Select artist</option>
            <?php foreach($artists as $artist) : ?>
                <option value="<?= $artist->artist_id ?>"><?= $artist->artist_name ?></option>
            <?php endforeach ?>
        </select>

        <label for="year" class="form-label mt-3">Year</label>
        <input type="text" name="year" id="year" class="form-control" placeholder="Enter year">

        <label for="genre" class="form-label mt-3">Genre</label>
        <input type="text" name="genre" id="genre" class="form-control" placeholder="Enter genre (Rock, Pop, Prog...)">

        <label for="label" class="form-label mt-3">Label</label>
        <input type="text" name="label" id="label" class="form-control" placeholder="Enter label (EMI, Warner, PolyGram, Univers sale...)">

        <label for="price" class="form-label mt-3">Price</label>
        <div class="input-group">
        <input type="text" name="price" id="price" class="form-control">
        <span class="input-group-text">$</span>
        </div>

        <label for="picture" class="form-label mt-3">Picture</label>
        <input type="file" name="picture" id="picture" accept="image/jpeg, image/png" class="form-control">

        <input type="submit" value="Ajouter" class="btn btn-primary mt-3">
        <a href="discs.php" class="btn btn-primary mt-3">Retour</a>

    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>