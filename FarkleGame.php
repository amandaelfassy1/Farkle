<?php

class Dice
{
    private $value;

    public function roll()
    {
        $this->value = rand(1, 6);
    }

    public function getValue()
    {
        return $this->value;
    }
}

class DiceSet
{
    private $dices;

    public function __construct()
    {
        for ($i = 0; $i < 6; $i++) {
            $this->dices[$i] = new Dice();
        }
    }

    public function roll()
    {
        foreach ($this->dices as $dice) {
            $dice->roll();
        }
    }

    public function getValues()
    {
        $values = array();
        foreach ($this->dices as $dice) {
            $values[] = $dice->getValue();
        }
        return $values;
    }
}

class Player
{
    private $name;
    private $score;

    public function __construct($name)
    {
        $this->name = $name;
        $this->score = 0;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getScore()
    {
        return $this->score;
    }

    public function addScore($points)
    {
        $this->score += $points;
    }
}

class FarkleGame
{
    private $players;
    private $diceSet;
    private $rules;
    private $currentPlayerIndex;
    private $roundScore;

    public function __construct($playerNames)
    {
        $this->players = array();
        foreach ($playerNames as $name) {
            $this->players[] = new Player($name);
        }
        $this->diceSet = new DiceSet();
        $this->rules = array(
            '1' => 100,
            '5' => 50,
            '3-1' => 1000,
            '3-2' => 200,
            '3-3' => 300,
            '3-4' => 400,
            '3-5' => 500,
            '3-6' => 600,
            '4-1' => 2000,
            '4-2' => 400,
            '4-3' => 600,
            '4-4' => 800,
            '4-5' => 1000,
            '4-6' => 1200,
            '5-1' => 3000,
            '5-2' => 500,
            '5-3' => 750,
            '5-4' => 1000,
            '5-5' => 1250,
            '5-6' => 1500,
            '6-1' => 4000,
            '6-2' => 600,
            '6-3' => 900,
            '6-4' => 1200,
            '6-5' => 1500,
            '6-6' => 1800
        );
        $this->currentPlayerIndex = 0;
        $this->roundScore = 0;
    }
    public function getDiceSet()
    {
        return $this->diceSet;
    }
    public function getCurrentPlayerName()
    {
        return $this->players[$this->currentPlayerIndex]->getName();
    }

    public function getCurrentPlayerScore()
    {
        return $this->players[$this->currentPlayerIndex]->getScore();
    }

    public function getCurrentRoundScore()
    {
        return $this->roundScore;
    }

    public function rollDices()
    {
        $this->diceSet->roll();
        $values = $this->diceSet->getValues();
        $score = $this->calculateScore($values);

        if ($score == 0) {
            $this->roundScore = 0;
            $this->nextPlayer();
        } else {
            $this->roundScore += $score;
        }
    }

    public function bankScore()
    {
        $this->players[$this->currentPlayerIndex]->addScore($this->roundScore);
        $this->roundScore = 0;
        $this->nextPlayer();
    }

    public function calculateScore($values)
    {
        $score = 0;
        $counts = array_count_values($values);

        foreach ($counts as $value => $count) {
            if ($count >= 3) {
                $score += $this->rules[$count . '-' . $value];
                $count -= 3;
            }

            if ($value == 1) {
                $score += $count * $this->rules['1'];
            } elseif ($value == 5) {
                $score += $count * $this->rules['5'];
            }
        }

        if (count($counts) == 6) {
            $score += 1500;
        }

        return $score;
    }

    private function nextPlayer()
    {
        $this->currentPlayerIndex = ($this->currentPlayerIndex + 1) % count($this->players);
    }

    public function isGameOver()
    {
        foreach ($this->players as $player) {
            if ($player->getScore() >= 10000) {
                return true;
            }
        }
        return false;
    }
}
