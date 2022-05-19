<?php
    function openBd() {
        $serverName = "localhost";
        $username = "root";
        $password = "";

        $conexion = new PDO("mysql:host=$serverName;dbname=pokedex", $username, $password);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $conexion->exec("set names utf8");

        return $conexion;

    }

    //Seleccionar tots els pokémons.

    function selectPokemons() {

        $conexion = openBd();

        $sentenciaText = "select * from pokemons";
        
        $sentencia = $conexion->prepare($sentenciaText);
        $sentencia->execute();

        $resultados = $sentencia->fetchAll();

        $conexion = closeBd();

        return $resultados;
        
    }

    //Seleccionar tots els tipus de pokémons.
    
    function selectPokemonsTipus() {

        $conexion = openBd();

        $sentenciaText = "select * from tipos";
        
        $sentencia = $conexion->prepare($sentenciaText);
        $sentencia->execute();

        $resultados = $sentencia->fetchAll();

        $conexion = closeBd();

        return $resultados;

    }

    //Seleccionar totes les regions.

    
    function selectPokemonsRegions() {

        $conexion = openBd();
        $sentenciaText = "select * from regiones";

        $sentencia = $conexion->prepare($sentenciaText);
        $sentencia->execute();

        $resultados = $sentencia->fetchAll();

        $conexion = closeBd();

        return $resultados;

    }

    //Seleccionar un pokemon.

    function selectPokemon($numero) {

        $conexion = openBd();
        $sentenciaText = "select * from pokemons where numero = '$numero'";

        $sentencia = $conexion->prepare($sentenciaText);
        $sentencia->execute();

        $resultados = $sentencia->fetchAll();

        $pokemon = [];

        foreach($resultados as $p) {

            if($p["numero"] == $numero) {
                $pokemon = $p;
            }

        }

        $conexion = closeBd();
        
        return $pokemon;

    }

    //Seleccionar tipos del pokemon.

    function selectTiposPokemon($numeroString){

        $conexion = openBd();

        //var_dump($numeroString);


        //Obtener id
        //echo "select id from pokemons where numero = '$numeroString'";
        $sentenciaText = "select id from pokemons where numero = '$numeroString'";

        $sentencia = $conexion->prepare($sentenciaText);
        $sentencia->execute();

        $idPokemon = $sentencia->fetchAll();


        $idPokemon = (int) $idPokemon[0]["id"];

        //selectTiposPokemon


        $sentenciaText = "select * from tipos_has_pokemons where pokemons_id =" . strval($idPokemon);

        $sentencia = $conexion->prepare($sentenciaText);
        $sentencia->execute();

        $resultados = $sentencia->fetchAll();

        $conexion = closeBd();

        $tiposBd = selectPokemonsTipus();

        $tiposPokemon = [];

        foreach($resultados as $t) {
            $tipo = $t["tipos_id"];
            foreach($tiposBd as $tBd) {
                if($tipo == $tBd["id"]) {
                    array_push($tiposPokemon,$tBd["nombre"]);
                }
            }
        }

        return $tiposPokemon;
        

    }

    function obtenerRegionId($regio) {
        $regionsBd = selectPokemonsRegions();

        $regioId = 0;

        foreach($regionsBd as $r) {
            if($regio == $r["nombre"]) {
                $regioId = $r["id"];
            }
        }

        return $regioId;
    }

    //Inserir un pokemon.


    function insertPokemon($numeroString,$nom,$regio,$tipus,$alsada,$peso,$evolucio,$imatge) {
        $conexion = openBd();

        $regioId = obtenerRegionId($regio);

        //Planta, Veneno, Agua
        $tipus = str_replace(" ","",$tipus);
        $tipus = explode(",",$tipus);
        $tipusBd = selectPokemonsTipus();


        $sentenciaText = "SELECT id FROM pokemons ORDER BY id DESC LIMIT 1";
        $sentencia = $conexion->prepare($sentenciaText);

        $sentencia->execute();

        $idPokemon = $sentencia->fetchAll();

        if(empty($idPokemon)) {
            $idPokemon = 1;
        }
        else {
            $idPokemon = $idPokemon[0]["id"]+1;
        }   

        $mensaje = "";

        try {
            $conexion->beginTransaction();
            $conexion->query("insert into pokemons values ($idPokemon,'$numeroString','$nom',".strval($alsada).",".strval($peso).",'$evolucio','$imatge',".strval($regioId).")");
            $lastIdPokemon = $conexion->lastInsertId();
            //var_dump($tipus);
            
            foreach($tipus as $t) {

                foreach($tipusBd as $tBD) {

                    if($t == $tBD["nombre"]) {
                        $conexion->query("insert into tipos_has_pokemons values(".strval($tBD["id"]).",".strval($lastIdPokemon).")");
                        
                    }

                }
            }

            $conexion->commit();

            
        }
        catch(PDOException $e) {
            $conexion->rollBack();
            $mensaje = $e->getMessage();
        }


        $conexion = closeBd();

        return $mensaje;
        
    }

    //Esborrar pokemon

    function deletePokemon($numero) {
        $conexion = openBd();
        $sentenciaText = "delete from pokemons where numero = '$numero'";
        $mensaje = "";
        try {
            $sentencia = $conexion->prepare($sentenciaText);
            $sentencia->execute();
        }
        catch(PDOException $e) {
            $conexion->rollBack();
            $mensaje = $e->getMessage();
        }
        
        $conexion = closeBd();

        return $mensaje;
    }

    //Modificar pokemonModificar pokemon

    function modificarPokemon($numeroString,$nom,$alsada,$pes,$evolucio,$imatge,$regio,$tipus,$imatgeTMP) {

        $conexion = openBd();

        $regioId = obtenerRegionId($regio);

        //Obtener id

        $sentenciaText = "select id from pokemons where numero = '$numeroString'";

        $sentencia = $conexion->prepare($sentenciaText);
        $sentencia->execute();

        $idPokemon = $sentencia->fetchAll();

        $idPokemon = (int) $idPokemon[0]["id"];

        //Imagen

        $imatgeAntes = selectPokemon($numeroString);
        $imatgeAntes = $imatgeAntes["imagen"];


        if($imatgeAntes != $imatge) {
            
            $pathImagen = obtenerRutaMedia() . $imatgeAntes;
            unlink($pathImagen);

            $extensionImagenSplit = explode(".",$imatge);
            $extensionImagen = $extensionImagenSplit[count($extensionImagenSplit) - 1];
            $imatge = $numeroString . '.' . $extensionImagen;


            $pathImagen = obtenerRutaMedia() . $imatge;
            move_uploaded_file($imatgeTMP,$pathImagen);
            
        }
        else {
            $imatge = "";
        }


        //var_dump($idPokemon);
        try {
            $conexion->beginTransaction();

            $sentenciaText = "";
            if(!empty($imatge)) {
                echo '<br>';
                $conexion->query("UPDATE pokemons SET nombre = '$nom', altura = ".strval($alsada).", peso = ".strval($pes).
                ", evolucion = '$evolucio', imagen = '$imatge', regiones_id = ".strval($regioId)." ".
                "WHERE numero = '$numeroString'");
            }
            else {
                $conexion->query("UPDATE pokemons SET nombre = '$nom', altura = ".strval($alsada).", peso = ".strval($pes).
                ", evolucion = '$evolucio', regiones_id = ".strval($regioId)." ".
                "WHERE numero = '$numeroString'");
            }            

            //Eliminar

            $tipusAntes = selectTiposPokemon($numeroString);
            
            foreach($tipusAntes as $tAntes) {
                $encontrado = false;
                foreach($tipus as $t) {
                    if($tAntes == $t) {
                        $encontrado = true;
                    }

                }
                if(!$encontrado) {
                    $idTipo = obtenerIdTipus($tAntes);
                    $conexion->query("DELETE FROM tipos_has_pokemons WHERE tipos_id = ".strval($idTipo)." AND pokemons_id = " . strval($idPokemon));                    
                }
            }

            //Añadir
            //insert into tipos_has_pokemons values (8,1)

            foreach($tipus as $t) {
                $encontrado = false;
                foreach($tipusAntes as $tAntes) {
                    if($tAntes == $t) {
                        $encontrado = true;
                    }
                }
                if(!$encontrado) {
                    $idTipo = obtenerIdTipus($t);
                    $conexion->query("INSERT INTO tipos_has_pokemons VALUES (".strval($idTipo).",".strval($idPokemon).")");
                }
            }

            $conexion->commit();

        }
        catch(PDOException $e) {
            $conexion->rollBack();
            echo $e->getMessage();
        }

        
        
        

        $conexion = closeBd();

    }

    function obtenerIdTipus($tipus) {

        $tipusBd = selectPokemonsTipus();

        $idTipo = 0;

        foreach($tipusBd as $tBd) {
            if($tBd["nombre"] == $tipus) {
                $idTipo = $tBd["id"];
            }
        }

        return $idTipo;
    }

    function obtenerRegionNombre($idRegio) {
        $conexion = openBd();
        $sentenciaText = "select nombre from regiones where id = " . strval($idRegio);

        $sentencia = $conexion->prepare($sentenciaText);
        $sentencia->execute();
        $resultados = $sentencia->fetchAll();

        $conexion = closeBd();

        $nombre = $resultados[0]["nombre"];

        return $nombre;
    }



    
    function closeBd() {
        return null;
    }



?>