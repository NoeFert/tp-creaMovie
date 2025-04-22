<?php
//Connexion avec db
$db = new PDO(
    'mysql:host=localhost;dbname=dev_crea',
    'root', 'root',
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);
$response = $db->query('SELECT * FROM my_movies_imdb') ;
$movies_in_DB = $response->fetchALL(PDO::FETCH_ASSOC) ;
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
            flex-direction: column;
            align-items: center;
            padding: 40px;
            gap: 20px;
            background-color: #363636;
            color: #f2f2f2;
            font-family: 'Segoe UI', sans-serif;
            height:100%;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        a {
            color : white ;
            text-decoration : none ;
        }

        ul {
            padding-left: 20px;
        }

        p {
            line-height: 1.6;
        }


        li {
            margin-bottom : 10px;
        }
        a:hover {
            color : yellow ;
        }
        
    </style>
    <title>CREA movies - mes films</title>
</head>
<body>
    <header>
        <p>CREA MOVIES<p>
        <div class="navigation"><a href="my-movies.php">Mes films</a><a href="search.php">Recherche</a></div>
    </header>
    <main>
        <h1>Mes films :</h1>
        <ul>
        <?php
        foreach ($movies_in_DB as $movie) {
            echo '<li><a href=\'movie.php?id=' . $movie['id'] . '\'>' . $movie['title'] . '</a></li>';
        }
        ?>
        </ul>
    </main>
</body>
</html>