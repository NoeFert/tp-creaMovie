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
        a:hover {
            color : lightyellow ;
        }

        /* FORM */
        form {
            text-align: center;
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

        input {
            width: 100%;
            border-radius: 5px;
            border: none;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
        }

        label {
            font-weight: 600;
        }
    </style>
    <title>CREA movies - search</title>
</head>
<body>
    <header>
        <p>CREA MOVIES<p>
        <div class="navigation"><a href="my-movies.php">Mes films</a><a href="search.php">Recherche</a></div>
    </header>
    <main>
        <h1>CREA MOVIES</h1>
        <form method="post" action="results.php" enctype="multipart/form-data">
            <p>
            <label for="searched-name">Quel film cherchez-vous ? </label></br>
            <input type="text" name="searched-name" id="searched-name" value="">
            </p>
            <p>
            <button type="submit">Rechercher</button>
            </p>
        </form>
    </main>
</body>
</html>