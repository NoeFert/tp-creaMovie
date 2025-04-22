# tp-creaMovie

//TRAVAIL
Travail pratique - entrainement au PHP. Travail solitaire.

//FONCTIONNEMENT
Le fichier **search.php** affiche un formulaire (input pour entrer le nom du film recherché) menant à results.php.

**Resuls.php** fait une requête sur INDb et montre les titres de films correspondant à la chercher. Chaque titre est un lien vers Movie.php?id=id correspondant.

**Movie.php** affiche les détails du film en faisant une requête sur INDb. 
- En cas de film inconnu de la base de donnée my_movie_indb, cette page possède un formulaire qui permet d'inscrire une note personnelle et un commentaire sur le film. En envoyant ce formulaire, le film et ses données sont enregistrée dans la base de donnée.
- En cas de film connu de la base de donnée, le formulaire n'est pas pas présent et la note personnelle ainsi que le commentaire sont visible à la place. Les données du film sont aussi téléchargé depuis la base de donnée sans faire de requête sur INDb.

**my-movies.php** montre une liste de tout les films actuellement enregistrés dans la base de donnée. Cliquer sur l'un des titres permet d'afficher la page movie.php avec l'id correspondant.

//BASE DE DONNÉES
La bd s'appelle dev_crea et la table lié à ce projet est **my_movie_indb**. 
Je l'ai jointe dans l'email en document SQL.
