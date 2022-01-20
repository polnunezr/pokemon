<?php 
function openBD() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $conn = new PDO("mysql:host=$servername;dbname=pokedex", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn -> exec('set names utf8');
    return $conn;
  
}
function selectAllPokemons() {
   $conn = openBD();
   $setenciaText = "select * from pokemons";
   $sentencia = $conn->prepare($setenciaText);
   $sentencia->execute();
   $resultado = $sentencia->fetchAll();
   $conn = closeBD();

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
    $setenciaText = "select * from pokemons where numero ='$id'";
    $sentencia = $connexion->prepare($setenciaText);
    $sentencia->execute();
    $resultado = $sentencia->fetchAll();
    $connexion = closeBD();
 
    return $resultado;
 }
 function selectTypesPokemon($id) {
    $connexion = openBD();
    $setenciaText = "select id from pokemons where numero = " .$id ;
    $sentencia = $connexion->prepare($setenciaText);
    $sentencia->execute();
    $resultado = $sentencia->fetchAll();
    $id2 = $resultado[0]["id"];
    $sentenciaText2 = "select tipos_id from tipos_has_pokemons where pokemons_id = " .$id2;
    $sentencia2 = $connexion->prepare($sentenciaText2);
    $sentencia2-> execute();
    $resultado2 = $sentencia2->fetchAll();
    $connexion = closeBD();
 
    return $resultado2;
 }
 function insertPokemon($numero,$nombre,$tipos,$altura,$peso,$evolucion,$imatge,$region) {
    try {
   $typesPokemons = selectAllTypes();
   $conexion = openBD();
   $conexion->beginTransaction();
   $setenciaText = "select max(id) from pokemons";
   $sentencia = $conexion->prepare($setenciaText);
   $sentencia->execute();
   $resultado = $sentencia->fetchAll();
   $id3 = $resultado[0]["max(id)"];
   $id3++;
   $setenciaText2 = "select id from regiones where nombre ="."'$region'";
   $sentencia2 = $conexion->prepare($setenciaText2);
   $sentencia2->execute();
   $resultado2 = $sentencia2->fetchAll();
   $idRegion = $resultado2[0]["id"];
   $conexion->query("INSERT INTO pokemons values($id3,'$numero','$nombre',$altura,$peso,'$evolucion','$imatge',$idRegion)") ;
   $i = 0;
   $k=0;
   while($i < count($typesPokemons)) {
      while($k < count($tipos)) {
      if($typesPokemons[$i]['nombre'] == $tipos[$k] ) {
      $idTipo = $typesPokemons[$i]['id'];
      $conexion->query("INSERT INTO tipos_has_pokemons values($idTipo,$id3)");
      $k++;
      }
      $i++;
   }
   $conexion->commit();
   $conexion = closeBd();

}
    } catch(PDOException $ex){
       echo $ex;
    }

}

function deletePokemons($id) {
   $deletePokemon = false;
   try {
      $conexion = openBD();
      $conexion->beginTransaction();
      $setenciaText = "select id from pokemons where numero =" .$id;
      $sentencia = $conexion->prepare($setenciaText);
      $sentencia->execute();
      $resultado = $sentencia->fetchAll();
      $id2 = $resultado[0]["id"];
      $conexion->query("DELETE FROM pokemons WHERE numero = '$id'");
      $conexion->query("DELETE FROM tipos_has_pokemons WHERE pokemons_id = '$id2'");
      $conexion->commit();
      $conexion = closeBd();
      $deletePokemon = true;
   
   }
   catch(PDOException $ex){
          echo $ex;
   }
   return $deletePokemon;
}

function editPokemon($numero,$nombre,$tipos,$altura,$peso,$evolucion,$imatge,$region) {
   try {
      $typesPokemons = selectAllTypes();
      $conexion = openBD();
      $conexion->beginTransaction();
      $setenciaText = "select id from pokemons where numero =" .$numero;
      $sentencia = $conexion->prepare($setenciaText);
      $sentencia->execute();
      $resultado = $sentencia->fetchAll();
      $id3 = $resultado[0]["id"];
      $setenciaText2 = "select id from regiones where nombre ="."'$region'";
      $sentencia2 = $conexion->prepare($setenciaText2);
      $sentencia2->execute();
      $resultado2 = $sentencia2->fetchAll();
      $idRegion = $resultado2[0]["id"];
      $conexion->query("UPDATE INTO pokemons SET 
      'numero' = '$numero',
      'nombre' = '$nombre',
      'altura' = $altura,
      'peso' = $peso,
      'evolucion' = '$evolucion',
      'imagen'= '$imatge',
      'regiones_id' = $idRegion)") ;
      $i = 0;
      $k=0;
      while($i < count($typesPokemons)) {
         while($k < count($tipos)) {
         if($typesPokemons[$i]['nombre'] == $tipos[$k] ) {
         $idTipo = $typesPokemons[$i]['id'];
         $conexion->query("UPDATE tipos_has_pokemons 
                           SET 
                           'tipos_id' = $idTipo,
                            'pokemons_id' = $id3)");
         $k++;
         }
         $i++;
      }
      $conexion->commit();
      $conexion = closeBd();
      
   }
       } catch(PDOException $ex){
          echo $ex;
       }
}


function closeBD() {
    return null;
}
