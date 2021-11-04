<?php

function crearPokemon($numero, $nom, $regio, $tipus, $alcada, $pes, $evolucio, $imatge)
{
    $pokemon = array(
        /*$numero,$nom,$regio,$tipus,$alcada,$pes,$evolucio,$imatge*/
        'Numero' => $numero,
        'Nom' => $nom,
        'Regió' => $regio,
        'Tipus' => $tipus,
        'Alçada' => $alcada,
        'Pes' => $pes,
        'Evolució' => $evolucio,
        'Imatge' => $imatge
    );
    return $pokemon;
}

function addPokemon(&$pokedex, $pokemon)
{
    $i = 0;
    $pokemonExist = false;
    while (!$pokemonExist  && $i < count($pokedex)) {
        if ($pokedex[$i]['Numero'] == $pokemon['Numero']) {
            echo 'El pokemon ya existe' .'<br>';
            $pokemonExist = true;
        }
        $i++;
    }
    if (!$pokemonExist) {
        array_push($pokedex, $pokemon);
        echo 'Add pokemon completed' .'<br>';
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
        echo 'El numero del pokemon seleccionado no se encuentra en la pokedex' .'<br>';
    } else {
        unset($pokedex[$indexOfPokemon]);
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
