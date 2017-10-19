<?php

namespace WL;

class Node
{
    public $value;
    public $parent = null;

    public function __construct($value)
    {
        $this->value = $value;
    }
}
