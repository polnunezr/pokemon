<?php
session_start();
include '/pokemon/php_librarys/pokedex.php';
if(isset($_SESSION['pokedex'])) {
    $pokedex = $_SESSION['pokedex'];
} else {
    $pokedex = [];
}
