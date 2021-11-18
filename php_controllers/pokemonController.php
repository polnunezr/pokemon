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
$imagen = null;
$pokemon = crearPokemon($_POST['txtNumero'],$_POST['txtNombre'],$_POST['region'],$_POST['tipoPokemon'],$_POST['altura'],$_POST['peso'],$_POST['rEvolucion'],$imagen);
if($imagen == null) {
    echo '<p><img src="../media/'.$_FILES['imagen']['name'].'"></p>';
}