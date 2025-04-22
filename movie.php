<?php
//Récupération de l'id du film
$filmId = $_GET['id'];

//Connexion avec la base de données personnelle
$db = new PDO(
    'mysql:host=localhost;dbname=dev_crea',
    'root', 'root',
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

//Vérifier si le film existe déjà dans la base de donnée par son id
$response = $db->prepare("SELECT * FROM my_movies_imdb WHERE id = :id");
$response->execute([':id' => $filmId]);
$film = $response->fetch(PDO::FETCH_ASSOC);

if ($film) {
    //Film connu -> infos prise dans la base de donnée
    $matchTitre[1] = $film['title'];
    $matchAnnee[3] = $film['annee'];
    $matchImage[1] = $film['image_url'];
    $matchDescription[1] = $film['description'];
    $matchNote[1] = $film['note_IMDb'];
    $maNote = $film['ma_note'];
    $monCommentaire = $film['mon_commentaire'];
    // Acteurs non enregistrés dans la base pour l'instant, je n'ai pas encore trouvé comment stocker un array
    $matchActeurs[1] = []; 
} 
else {
    //Film inconnu -> requête fait sur INDb
    $movieCodeSource = file_get_contents('https://www.imdb.com/fr/title/' .$_GET['id']);

    $titre = preg_match('/<title>([^(]+)\ \(([^\d]+\ )?([\d]{4})\)\ \-\ IMDb/',$movieCodeSource, $matchTitre );
    $annee = preg_match('/<title>([^(]+)\ \(([^\d]+\ )?([\d]{4})\)\ \-\ IMDb/',$movieCodeSource, $matchAnnee );
    $image = preg_match('/\"image\"\:\"([^"]+)/',$movieCodeSource, $matchImage );
    $description = preg_match('/\"description\"\:\"([^"]+)/',$movieCodeSource, $matchDescription );
    $note = preg_match('/\"ratingValue\"\:([0-9]\.[0-9])/',$movieCodeSource, $matchNote );
    $acteurs = preg_match_all('/data-testid=\"title-cast-item__actor\"\ href=\"[^<]*>([^<]*)/', $movieCodeSource, $matchActeurs);
}

//Envoi du film à la base de données (uniquement si le film n'y est pas encore)
if (!$film && isset($_POST['give-note']) && $_POST['give-note'] && isset($_POST['commentaire']) && $_POST['commentaire']) {
    $sql = "INSERT INTO my_movies_imdb (id, title, annee, image_url, description, note_IMDb, ma_note, mon_commentaire) VALUES (:id, :title, :annee, :image_url, :description, :note_IMDb, :ma_note, :mon_commentaire)";
    $response = $db->prepare(
        $sql,
        [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]
    );
    $response->execute([
        ':id' => $_GET['id'], 
        ':title' => $matchTitre[1], 
        ':annee' => $matchAnnee[3], 
        ':image_url' => $matchImage[1], 
        ':description' => $matchDescription[1], 
        ':note_IMDb' => $matchNote[1],
        ':ma_note' => $_POST['give-note'], 
        ':mon_commentaire' => $_POST['commentaire']]);

        echo '<p style="color:green;font-weight:bold;">✅ Film enregistré avec succès !</p>';
}
?>

<html lang="fr" class="">
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex">
    <style class="cp-pen-styles" type="text/css">
        header {
            background-color: #1e1e1e;
            color: white;
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.5);
        }
        header a {
            color : white ;
            text-decoration : none ;
        }
        .navigation {
            display : flex;
            gap : 30px;
        }
        a:hover {
            color : yellow ;
        }

        .hidden {
            display : none;
        }

        /* MAIN */
        main {
            display: flex;
            flex-wrap: wrap;
            padding: 40px;
            gap: 40px;
            background-color: #363636;
            color: #f2f2f2;
            font-family: 'Segoe UI', sans-serif;
            min-height: 100%;
        }

        /*IMAGE*/
        .colonne-image-note {
            flex: 1;
        }

        .affiche {
            width: 80%;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.4);
            margin-bottom: 20px;
        }

        /* FORMULAIRE */
        form {
            background-color: #2a2a2a;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
            max-width: 80%;
        }

        label {
            font-weight: 600;
        }

        textarea, select {
            width: 100%;
            border-radius: 5px;
            border: none;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
        }

        textarea {
            height: 80px;
            resize: vertical;
        }

        button {
            background-color: #ffd700;
            color: black;
            padding: 8px 15px;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #e5c100;
        }

        /* --------- INFOS FILM --------- */
        .colonne-infos-desc {
            flex: 2;
            min-width: 320px;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        h2 {
            margin-top: 30px;
            font-size: 1.4rem;
        }

        ul {
            padding-left: 20px;
        }

        p {
            line-height: 1.6;
        }

        .note-perso {
            margin-top: 50px;
        }
    </style>
    <title>CREA movies - movie</title>
</head>

<body>
    <header>
        <p>CREA MOVIES<p>
        <div class="navigation"><a href="my-movies.php">Mes films</a><a href="search.php">Recherche</a></div>
    </header>
    <main>
        <div class="colonne-main colonne-image-note">
            <?php
                echo '<img class="affiche" src="' .$matchImage[1] .'" alt="affiche du film"/>';
            ?>
            <form method="post" action="movie.php?id=<?= $_GET['id'] ?>" 
            <?php 
                if($film) {
                    echo 'class=\'hidden\'' ; //cache le formulaire si le film a déjà été enregistré dans la db
                }
            ?>>
                <P>
                <label for="give-note">Ma note : </label>
                <select name="give-note" id="give-note">
                    <option value="1">1 étoile</option>
                    <option value="2">2 étoiles</option>
                    <option value="3">3 étoiles</option> 
                    <option value="4">4 étoiles</option> 
                    <option value="5">5 étoiles</option>
                </select>
                </p>
                <p>
                <label for="commentaire">Mon commentaire :</label><br>
                <textarea id="commentaire" name="commentaire"></textarea>
                </p>
                <p>
                <button type="submit">Évaluer</button>
                </p>
            </form>
        </div>

        <div class="colonne-main colonne-infos-desc">
            <?php
            echo '<h1>' . $matchTitre[1] . '</h1>';
            echo '<p>Année : ' . $matchAnnee[3] . '</p>';
            echo '<p>Note sur le site : ' .$matchNote[1] . '</p>';
            echo '<p>Description :<br/>' . $matchDescription[1] . '</p>';
            //Cette section apparait seulement lors de film inconnu de la db. Raison : pas de liste d'acteurs dans la bd actuelle
            if (!$film) { 
                echo '<h2>Acteurs :</h2><ul>';
                foreach ($matchActeurs[1] as $acteur) {
                    echo '<li>' . $acteur . '</li>';
                }
                echo '</ul>';
            }
            //Affiche la note personnelle et le commentaire si le film a déjà été enregistré
            if ($film) {
                echo '<p class="note-perso">Ma note : ' .$maNote . ' étoiles</p>';
                echo '<p>Mon commentaire :<br/> ' .$monCommentaire . '</p>';
            }
            ?>
        </div>

        <?php
        //COMMENTAIRES !!!!!!
        //Cette page doit avoir comme URL : movie.php?id=H009hdhjksk <- c'est l'id du film
        //Exemple d'id : tt6208148 (Blanche-neige) | tt1170358 (La désolation de Smaug)
        ?>
    </main>
</body>
</html>