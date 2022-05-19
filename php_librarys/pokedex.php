<?php

    //Crear pokemon

    function crear($numero,$nom,$regio,$tipus,$alsada,$pes,$evolucio,$imatge) {

        $pokemon = [
            "Numero" => $numero,
            "Nom" => $nom,
            "Regio" => $regio,
            "Tipus" => $tipus,  
            "Alsada" => $alsada,
            "Pes" => $pes,
            "Evolucio" => $evolucio,
            "Imatge" => $imatge,
        ];


        return $pokemon;
    }
    //Mostrar pokemon

    function mostrar($pokemon) {
        foreach($pokemon as $key => $valor) {            
            //echo '<label>Numero: </label>' . $pokemon['Numero'];
            if($key != "Imatge") {
                echo $key . ": " . $valor . "</br>";
            }
            else {
                //<img src="media/002.png"/>
                echo $key . ": " . $valor . "</br>";
                echo '<img src="media/' . $valor . '"/>'. "</br>";
            }

        }

    }

    //Buscar pokémon per número.
    function buscar($pokedex,$numero) {
        $indice = -1;
        $i = 0;
        //var_dump($pokedex);
        if(!empty($pokedex)) {

            foreach($pokedex as $p) {
                if($p["Numero"] == $numero) {
                    $indice = $i;
                }
                $i++;
            }

        }
        

        return $indice;

    }

    //Afegir
    function afegir($pokedex,$pokemon) {
        $indice = buscar($pokedex,$pokemon["Numero"]);
        if($indice == -1) {
            array_push($pokedex,$pokemon);
            $_SESSION["mensajeAfegir"] = "Pokemon añadido correctamente";

            
        }
        else {
            $_SESSION["mensajeAfegir"] = "Error, ya existe el pokemon el la pokedex!";
            //echo 'Error, ya existe el pokemon el la pokedex!';
        }

        return $pokedex;
    }

    //Esborrar
    function esborrar(&$pokedex,$pokemon) {
        $indice = buscar($pokedex,$pokemon["Numero"]);
        //var_dump($indice);
        if($indice != -1) {
            unset($pokedex[$indice]);
            $pokedex = array_values($pokedex);
            $_SESSION["mensajeEsborrar"] = "Pokemon borrado correctamente";
        }
        else {
            $_SESSION["mensajeEsborrar"] = "Error,no esta el pokemon el la pokedex!";
            //echo 'Error,no esta el pokemon el la pokedex!';
        }
    }

    //Modificar
    function modificar(&$pokedex,$numero,$nom,$regio,$tipus,$alsada,$pes,$evolucio,$imatgeName,$imatgeTMP) {
        $encontrado = false;
        foreach($pokedex as &$p) {
            if($p["Numero"] == $numero) {
                $encontrado = true;
                $p["Nom"] = $nom;
                $p["Regio"] = $regio;
                $p["Tipus"] = $tipus;
                $p["Alsada"] = $alsada;
                $p["Pes"] = $pes;
                $p["Evolucio"] = $evolucio;

                if($imatgeName != $p["Imatge"]) {
                    $pathImagen = obtenerRutaMediaPokedex() . $p["Imatge"];
                    var_dump($pathImagen);
                    unlink($pathImagen);

                    $extensionImagenSplit = explode(".",$imatgeName);
                    $extensionImagen = $extensionImagenSplit[count($extensionImagenSplit) - 1];
                    $imatgeName = $numero . '.' . $extensionImagen;


                    $p["Imatge"] = $imatgeName;
                    $pathImagen = obtenerRutaMediaPokedex() . $imatgeName;
                    move_uploaded_file($imatgeTMP,$pathImagen);
                }
                
            }
        }

        if(!$encontrado) {
            $_SESSION["mensajeEsborrar"] = 'Error,no esta el pokemon el la pokedex!';
        }


    }
    //Mostrar pokédex
    function mostrarPokedex($pokedex) {
        foreach($pokedex as $p) {
            mostrar($p);
        }

    }

    function obtenerRutaMediaPokedex() {

        $rutaMedia = getcwd();

        //var_dump($rutaMedia);

        $rutaMedia = str_replace('\\',"/",$rutaMedia);
        
        $rutaMedia = substr($rutaMedia,0,strlen($rutaMedia) - 15) . "media/";

        return $rutaMedia;

    }

?>  