<?php


session_start();
if (isset($_POST['player1']) && isset($_POST['player2'])) {
  $_SESSION['player1'] = $_POST['player1'];
  $_SESSION['player2'] = $_POST['player2'];
  header('Location: game.php');
}

?>

<!DOCTYPE html>
<html>

<head>
  <title>Farkle Game</title>
</head>

<body>
  <h1>Connectez-vous pour jouer</h1>
  <form method="POST">
    <label>Joueur 1 : </label>
    <input type="text" name="player1"><br><br>
    <label>Joueur 2 : </label>
    <input type="text" name="player2"><br><br>
    <input type="submit" value="Jouer">
  </form>
</body>


</html>
<style>
  /* Appliquer une police de caractères personnalisée à tout le document */
  body {
    font-family: "Arial", sans-serif;
  }

  /* Styliser le titre principal */
  h1 {
    text-align: center;
    font-size: 2.5rem;
    margin-top: 2rem;
    margin-bottom: 1rem;
  }

  /* Styliser les sous-titres */
  h2 {
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
  }

  /* Ajouter un arrière-plan à la section de dés */
  h3 {
    font-size: 1.2rem;
    margin-top: 2rem;
    margin-bottom: 0.5rem;
    background-color: #f5f5f5;
    padding: 1rem;
    border-radius: 10px;
    box-shadow: 0px 3px 5px rgba(0, 0, 0, 0.2);
  }

  /* Styliser les images de dés */
  img {
    display: inline-block;
    margin-right: 1rem;
  }

  /* Styliser les boutons */
  input[type="submit"] {
    background-color: #4caf50;
    color: #fff;
    padding: 0.5rem 1rem;
    border-radius: 5px;
    border: none;
    cursor: pointer;
    margin-right: 1rem;
  }

  /* Styliser les boutons au survol */
  input[type="submit"]:hover {
    background-color: #3e8e41;
  }

  /* Styliser le formulaire */
  form {
    margin-top: 2rem;
    text-align: center;
  }
</style>