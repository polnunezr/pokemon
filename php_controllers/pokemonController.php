<?php

    session_start();   
    

    include("../php_librarys/pokedex.php");

    include("../php_librarys/bd.php");

    $pokedex = recuperarPokedex();
    
    function recuperarPokedex() {        

        $pokedex = selectPokemons();

        return $pokedex;
    }

    


    if(isset($_POST["submitAfegirPokemon"])) {

        $numero = $_POST["afegirNumero"];
        //var_dump($numero);
        $nom = $_POST["afegirNom"];
        $regio = $_POST["regioAfegir"];
        $tipus = "";
        if(isset($_POST["tipusAfegir"])) {
            $tipusArray = $_POST["tipusAfegir"];
            $primero = true;
            foreach($tipusArray as $t) {
                if($primero) {
                    $tipus = $t;
                    $primero = false;
                }
                else {
                    $tipus = $tipus . ", " . $t;
                }
                
                
            }
            
        }
        //var_dump($tipus);
        
        $alsada = $_POST["alsadaAfegir"];
        $pes = $_POST["pesAfegir"];
        $evolucio = $_POST["flexRadioDefault"];
        $imatge = $_FILES["imatgeAfegir"]["name"];

        afegirController($numero,$nom,$regio,$tipus,$alsada,$pes,$evolucio,$imatge);

        unset($_POST["submitAfegirPokemon"]);

    }
    else if(isset($_POST["buttonDelete"])) {

        $pokemon = [];

        $numeroPokemon = $_POST["inputDelete"];
        $encontrado = false;
        
        foreach($pokedex as $p) {
            if($p["numero"] == $numeroPokemon) {
                $encontrado = true;
                $pokemon = $p;
            }
        }

        if($encontrado) {
            esborrarController($pokemon);
        }
        
        

        unset($_POST["buttonDelete"]);
    }
    else if(isset($_POST["buttonEdit"])) {
        editarController();
        unset($_POST["buttonEdit"]);
    }
    else if(isset($_POST["submitEditPokemon"])) {
        
        $numero = $_POST["numeroEdit"];
        $nom = $_POST["nomEdit"];
        $regio = $_POST["regioEdit"];

        $tipus = $_POST["tipusEdit"];

        $alsada = $_POST["alsadaEdit"];
        $pes = $_POST["pesEdit"];
        $evolucio = $_POST["flexRadioDefault"];

        $imatgeName = $_FILES["imatgeEdit"]["name"];
        $imatgeTMP = $_FILES["imatgeEdit"]["tmp_name"];

        echo $numero." ".$nom." ".$alsada." ".$pes." ".$evolucio." ".$imatgeName." ".$regio;
        
        modificarPokemon($numero,$nom,$alsada,$pes,$evolucio,$imatgeName,$regio,$tipus,$imatgeTMP);

        //modificar($pokedex,$numero,$nom,$regio,$tipus,$alsada,$pes,$evolucio,$imatgeName,$imatgeTMP);

        
        

        unset($_POST["submitEditPokemon"]);
        unset($_FILES["imatgeEdit"]);
        
        header("Location: ../php_views/pokemon_list.php");
        exit();
        
    }

    
    

    
    function obtenerRutaMedia() {

        $rutaMedia = getcwd();

        //var_dump($rutaMedia);

        $rutaMedia = str_replace('\\',"/",$rutaMedia);
        
        $rutaMedia = substr($rutaMedia,0,strlen($rutaMedia) - 15) . "media/";

        return $rutaMedia;

    }

    function afegirController($numero,$nom,$regio,$tipus,$alsada,$pes,$evolucio,$imatge) {
        //var_dump($imatge);
        /*
        $rutaTemporalImagen = $imatge;
        $extensionImagenSplit = explode(".",$rutaTemporalImagen);
        $extensionImagen = $extensionImagenSplit[count($extensionImagenSplit) - 1];
        $imatge = $numero . $extensionImagen;
        */

        $extensionImagenSplit = explode(".",$imatge);
        $extensionImagen = $extensionImagenSplit[count($extensionImagenSplit) - 1];
        $imatge = $numero . '.' . $extensionImagen;

        //var_dump($imatge);

        echo $numero." ".$nom." ".$regio." ".$tipus." ".$alsada." ".$pes." ".$evolucio." ".$imatge;

        $mensaje = insertPokemon($numero,$nom,$regio,$tipus,$alsada,$pes,$evolucio,$imatge);

        if(empty($mensaje)) {
            $pathImagen = obtenerRutaMedia();

            $pathImagen = $pathImagen . $imatge;               
        
            if(isset($_FILES["imatgeAfegir"])) {

                move_uploaded_file($_FILES["imatgeAfegir"]["tmp_name"],$pathImagen);

            }
            
            unset($_FILES["imatgeAfegir"]);


            $_SESSION["mensajeAfegir"] = "Pokemon añadido correctamente";


            header("Location: ../php_views/pokemon_list.php");
            exit();

        }
        else {
            $pokemon = crear($numero,$nom,$regio,$tipus,$alsada,$pes,$evolucio,$imatge);
            $_SESSION["pokemon"] = $pokemon;
            $_SESSION["mensajeAfegir"] = "Error en afegir el pokemon";
            header("Location: ../php_views/pokemon.php");
            exit();
        }
        

    }

    function esborrarController($pokemon) {

        $mensaje = deletePokemon($pokemon["numero"]);

        if(empty($mensaje)) {
            $pathImagen = obtenerRutaMedia() . $pokemon["imagen"];
            unlink($pathImagen);

            if(!file_exists($pathImagen)) {
                $_SESSION["mensajeEsborrar"] = "Pokemon borrado correctamente";
            }
            else {
                $_SESSION["mensajeEsborrar"] = "No se ha borrado el pokemon. Problemes al borrar la imagen";
            }
            
            header("Location: ../php_views/pokemon_list.php");
            exit();
            
        }
        
    }

    function editarController() {
        $pokedex = recuperarPokedex();
        if(!empty($pokedex) && isset($_POST["inputEdit"])) {

            $nPokemon = $_POST["inputEdit"];

            //var_dump($nPokemon);

            $pokemon = [];

            foreach($pokedex as $p) {

                if($p["numero"] == $nPokemon) {
                    $pokemon = $p;
                }

            }

            $_SESSION["pokemon"] = $pokemon;
            
            header('Location: ../php_views/pokemon_edit.php');

            exit();
            
            
        }


    }




?>