<?php 
function openBD() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $conn = new PDO("mysql:host=$servername;dbname=pokedex", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn -> exec('set names utf8');
  
}
function selectAllPokemons() {
   $connexion = openBD();
   $setenciaText = "select * from pokemons";
   $sentencia = $connexion->prepare($setenciaText);
   $sentencia->execute();
   $resultado = $sentencia->fetchAll();
   $connexion = closeBD();

   return $resultado;
}

function selectAllTypes() {
   $connexion = openBD();
   $setenciaText = "select * from tipos";
   $sentencia = $connexion->prepare($setenciaText);
   $sentencia->execute();
   $resultado = $sentencia->fetchAll();
   $connexion = closeBD();

   return $resultado;
}
function selectAllRegions() {
    $connexion = openBD();
    $setenciaText = "select * from regiones";
    $sentencia = $connexion->prepare($setenciaText);
    $sentencia->execute();
    $resultado = $sentencia->fetchAll();
    $connexion = closeBD();
 
    return $resultado;
 }

 function selectPokemon($id) {
    $connexion = openBD();
    $setenciaText = "select * from pokemons where numero = " . $id;
    $sentencia = $connexion->prepare($setenciaText);
    $sentencia->execute();
    $resultado = $sentencia->fetchAll();
    $connexion = closeBD();
 
    return $resultado;
 }
 
function closeBD() {
    return null;
}
