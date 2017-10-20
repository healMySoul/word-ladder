<?php

require '../bootstrap.php';

use WL\Node;
use WL\Word;

$startWord = isset($_GET['startWord']) ? $_GET['startWord'] : '';
$endWord = isset($_GET['endWord']) ? $_GET['endWord'] : '';
$queue = [];
$usedWords = [];
$paths = [];
$solutions = [];

if (mb_strlen($startWord) == mb_strlen($endWord)) {
    // keep only words with the same length as start and end words in dictionary
    $dictionary = new WL\Dictionary();
    $dictionary->filterWords(mb_strlen($startWord));

    if ($dictionary->containsWord($startWord) && $dictionary->containsWord($endWord)) {
        $startNode = new Node($startWord);

        array_push($queue, $startNode);
        array_push($usedWords, $startNode->value);

        while (count($queue) > 0) {
            $currentNode = array_shift($queue);

            if ($currentNode->value == $endWord) {
                array_push($paths, $currentNode);
                break; // use "continue", if you want multiple solutions
            }

            // find words, that can be received by 1-letter-morph from current word
            $morphlings = Word::getMorphlings($currentNode->value, $usedWords, $dictionary);

            // add morphlings to the queue
            foreach ($morphlings as $morphling) {
                $nextNode = new Node($morphling);
                $nextNode->parent = $currentNode;

                array_push($queue, $nextNode);
            }
        }

        // every solution must ascend to the first word and generate full path
        foreach ($paths as $path) {
            $solution = [];
            array_push($solution, $path->value);
            $parentNode = $path->parent;

            while ($parentNode != null) {
                array_push($solution, $parentNode->value);
                $parentNode = $parentNode->parent;
            }

            array_push($solutions, array_reverse($solution));
        }
    }
}

include 'index.phtml';
