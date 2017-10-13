<?php

require '../bootstrap.php';

$dictionary = new WL\Dictionary();
$dictionary->filterWords(4);

var_dump($dictionary->containsWord('слон'));
