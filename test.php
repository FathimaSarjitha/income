<?php

// require 'libs/load.php';

// echo 'hello';

// print($_SERVER['DOCUMENT_ROOT']);

// $sess = new Session("bbc994116293c0c838bbf5d37771c6a2");
// print($sess->token);
// print($sess->ip);

exec('ifconfig', $output);

print_r($output);