<?php

class Node
{

    public $info;
    public $left;
    public $right;
    public $level;

    public function __construct($info)
    {

        $this->info  = $info;
        $this->left  = null;
        $this->right = null;
        $this->level = null;
    }

    public function __toString()
    {
        return "$this->info";
    }
}



function BFS($node)
{

    $node->level = 1;

    $queue = [$node];

    $current_level = $node->level;

    $output = [];

    while (count($queue) > 0) {

        $current_node = array_shift($queue);

        if ($current_node->level > $current_level) {
            $current_level++;
            array_push($output, "\n");
        }

        array_push($output, $current_node->info . " ");

        if ($current_node->left != null) {
            $current_node->left->level = $current_level + 1;
            array_push($queue, $current_node->left);
        }

        if ($current_node->right != null) {
            $current_node->right->level = $current_level + 1;
            array_push($queue, $current_node->right);
        }
    }

    return join("", $output);
}

$root               = new Node(10);
$root->left         = new Node(9);
$root->right        = new Node(4);
$root->left->left   = new Node(1);
$root->left->right  = new Node(3);
$root->right->left  = new Node(5);
$root->right->right = new Node(7);

echo BFS($root);