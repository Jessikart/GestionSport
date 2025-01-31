<?php
error_reporting(E_ALL & ~E_DEPRECATED);
// gestion des templates avec Twig
	require_once('./twig/vendor/autoload.php');
    $loader = new \Twig\Loader\FilesystemLoader('Views');
    $twig = new \Twig\Environment($loader, ['cache' => false]);
?>

