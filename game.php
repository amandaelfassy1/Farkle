<?php

require_once('FarkleGame.php');
session_start();

if (!isset($_SESSION['game'])) {
    // If game session does not exist, create a new game with the provided player names
    $playerNames = array($_POST['player1'], $_POST['player2']);
    $_SESSION['game'] = new FarkleGame($playerNames);
}

$game = $_SESSION['game'];

if (isset($_POST['roll'])) {
    // Roll the dices and calculate the score
    $game->rollDices();
}

if (isset($_POST['bank'])) {
    // Bank the current round score and switch to the next player
    $game->bankScore();
}

if ($game->isGameOver()) {
    // If the game is over, show the winner
    $playerScores = array();
    foreach ($game->getPlayers() as $player) {
        $playerScores[$player->getName()] = $player->getScore();
    }
    arsort($playerScores);
    $winner = key($playerScores);
    $score = current($playerScores);
    echo "<h2>Game over! $winner wins with a score of $score</h2>";
    session_destroy();
    exit();
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Farkle Game</title>
</head>

<body>

    <h1>Farkle Game</h1>
    <h2>Current Player: <?php echo $game->getCurrentPlayerName(); ?></h2>
    <h2>Current Score: <?php echo $game->getCurrentPlayerScore(); ?></h2>
    <h2>Round Score: <?php echo $game->getCurrentRoundScore(); ?></h2>
    <h3>Dices:</h3>

    <div id="dice-set">
        <?php foreach ($game->getDiceSet()->getValues() as $value) { ?>
            <img src="./dice_<?php echo $value; ?>.png" alt="Dice <?php echo $value; ?>" width="50" height="50" />
        <?php } ?>
    </div>
    <form method="post">
        <input type="submit" name="roll" value="Roll">
        <input type="submit" name="bank" value="Bank">
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