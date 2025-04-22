<?php
if (isset($_POST['searched-name'])) {
    $search = $_POST['searched-name'];
} else {
    $search = '';
}


if ($search) {
    $searchEncoded = urlencode($search);
    $url = "https://www.imdb.com/find?q=$searchEncoded";

    $findCodeSource = file_get_contents($url);

    // On extrait les liens vers les films
    $results = preg_match_all('/<a[^>]*href="\/title\/(tt\d+)[^"]*"[^>]*>([^<]+)<\/a>/', $findCodeSource, $matchResults);

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
            margin-top : 60px;
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
    <title>CREA movies - results</title>
</head>
<body>
    <header>
        <p>CREA MOVIES<p>
        <div class="navigation"><a href="my-movies.php">Mes films</a><a href="search.php">Recherche</a></div>
    </header>
    <main>
        <h1>Résultat :</h1>
        <?php
        echo '<ul>';
        foreach ($matchResults[1] as $index => $id) {
            $title = $matchResults[2][$index];
            echo '<li><a href="movie.php?id=' . htmlspecialchars($id) . '">' . htmlspecialchars($title) . '</a></li>';
        }
        echo '</ul>';

        //requête example : indb.com/find/?q=batman
        ?>
    </main>
</body>
</html>