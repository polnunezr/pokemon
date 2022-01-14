<?php
<<<<<<< HEAD
session_start();
if (isset($_SESSION['pokedex'])) {
    $pokedex = $_SESSION['pokedex'];
} else {
    $pokedex = [];
}
=======

  
>>>>>>> 898f7834d4b3b9cef4838fcad9f1dfa2068ca990
function crearPokemon($numero, $nom, $regio, $tipus, $alcada, $pes, $evolucio, $imatge)
{
    
    $pokemon = [
        'Numero' => $numero,
        'Nom' => $nom,
        'Regió' => $regio,
        'Tipus' => $tipus,
        'Alçada' => $alcada,
        'Pes' => $pes,
        'Evolució' => $evolucio,
        'Imatge' => $imatge
    ];
    return $pokemon;
   
}

function addPokemon(&$pokedex, $pokemon)
{
    
    $i = 0;
    $pokemonExist = false;
    while ($pokemonExist == false && $i < count($pokedex)) {
        if ($pokedex[$i]['Numero'] == $pokemon['Numero']) {
            $pokemonExist = true;
            $_SESSION['addPokemon'] = 'Error, el pokemon ya existe';

        }
        $i++;
    }
    if ($pokemonExist == false) {
        array_push($pokedex,$pokemon);
        $_SESSION['addPokemon'] = 'Pokemon añadido correctamente' ;
       
    }

    return $pokedex;
}

function findPokemon(&$pokedex, $numero)
{
    $i = 0;
    $foundPokemon = false;
    while ($foundPokemon == false && $i < count($pokedex)) {
        if ($pokedex[$i]['Numero'] === $numero) {
            echo 'El pokemon con el codigo ' . $numero . ' se encuentra en la posicion ' . $i . '<br>';
            $foundPokemon = true;
        }
        $i++;
    }
    if (!$foundPokemon) {
        echo -1 .'<br>';
    }
}

function mostrarPokemon($pokemon)
{

    foreach ($pokemon as $key => $valor) {
        if ($key == 'Tipus') {
            foreach ($pokemon[$key] as  $valor1 => $valor2) {
                echo $key . '=>' . $valor2 . '<br>';
            }
        } else {
            echo $key . '=> ' . $valor . '<br>';
        }
    }
}

function modifyPokemon(&$pokedex, $numSearch, $numero, $nom, $regio, $tipus, $alcada, $pes, $evolucio, $imatge)
{
    $pokemonModifyed = false;
    $i = 0;
    do {
        if ($pokedex[$i]['Numero'] === $numSearch) {
            $pokedex[$i]['Numero'] = $numero;
            $pokedex[$i]['Nom'] = $nom;
            $pokedex[$i]['Regió'] = $regio;
            $pokedex[$i]['Tipus'] = $tipus;
            $pokedex[$i]['Alçada'] = $alcada;
            $pokedex[$i]['Pes'] = $pes;
            $pokedex[$i]['Evolució'] = $evolucio;
            $pokedex[$i]['Imatge'] = $imatge;
            $pokemonModifyed = true;
        }
        $i++;
    } while ($i < count($pokedex) && $pokemonModifyed == false);
    return $pokedex;
}

function deletePokemon(&$pokedex, $numero)
{
    $indexOfPokemon = array_search($numero, array_column($pokedex, 'Numero'));
    if ($indexOfPokemon === false) {
        $_SESSION['deletePokemon'] = 'El pokemon seleccionado no se encuentra en la pokedex';
    } else {
        unset($pokedex[$indexOfPokemon]);
        $_SESSION['deletePokemon'] = 'El pokemon seleccionado se ha borrado de la pokedex';
        $pokedex = array_values($pokedex);
    }
    return $pokedex;
}

function showPokedex(&$pokedex)
{
    foreach ($pokedex as $pokemon) {
        foreach ($pokemon as $key => $valor) {
            if ($key == 'Tipus') {
                foreach ($pokemon[$key] as  $valor1 => $valor2) {
                    echo $key . '=>' . $valor2 . '<br>';
                }
            } elseif($key =='Imatge') {
                echo $key .'=>' . '<img src="./media/'.$valor. '" width="200" height="200">' .'<br>';
            } else {
                echo $key . '=> ' . $valor . '<br>';
            }
        }
        echo '<br>';
    }
}
