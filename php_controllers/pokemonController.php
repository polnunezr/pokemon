<?php
include '../php_librarys/pokedex.php';

if(isset($_SESSION['pokedex'])) {
    $pokedex = $_SESSION['pokedex'];
} else {
    $pokedex = [];
}
//Ruta temporal de la imagen 


$rutaTemporal = $_FILES['imagen']['tmp_name'];
if(isset($_FILES['imagen'])){
   move_uploaded_file($rutaTemporal,$_FILES['imagen']['name']);
}
//Creamos el pokemon
$imagen = $_FILES['imagen']['name'];
$pokemon = crearPokemon($_POST['txtNumero'],$_POST['txtNombre'],$_POST['region'],$_POST['tipoPokemon'],$_POST['altura'],$_POST['peso'],$_POST['rEvolucion'],$imagen);

$pokedex = addPokemon($pokedex,$pokemon);
if($_SESSION['addPokemon' ] == 'Pokemon añadido correctamente') {
    move_uploaded_file($rutaTemporal,"../media/");
    header("Location: ../php_views/pokemon_list.php");
    exit();
} else {
    $_SESSION['pokemon'] = $pokemon;
    header("Location: ../php_views/pokemon.php");
    exit();
}