<?php
include '../php_librarys/pokedex.php';
if(!isset($_SESSION)){
    session_start();
   }

//Ruta temporal de la imagen 

if (isset($_POST['add'])) {
    $rutaTemporal = $_FILES['imagen']['tmp_name'];
    if (isset($_FILES['imagen'])) {
        move_uploaded_file($rutaTemporal, $_FILES['imagen']['name']);
    }
    //Creamos el pokemon
    $imagen = $_FILES['imagen']['name'];
    $pokemon = crearPokemon($_POST['txtNumero'], $_POST['txtNombre'], $_POST['region'], $_POST['tipoPokemon'], $_POST['altura'], $_POST['peso'], $_POST['rEvolucion'], $imagen);
    $pokedex = addPokemon($pokedex, $pokemon);
    if ($_SESSION['addPokemon'] == 'Pokemon añadido correctamente') {
        move_uploaded_file($rutaTemporal, "../media/");
        addPokemon($pokedex, $pokemon);
        $_SESSION['pokedex'] = $pokedex;
        $_SESSION['msg'] = "Pokemon añadido correctamente";
        header('Location:' . '../php_views/pokemon_list.php', true, 302);
    } else {
        $_SESSION['pokemon'] = $pokedex;
        $_SESSION['errormsg'] = "Error al añdir el pokemon";
        header('Location: ' . '../php_views/pokemon.php', true, 302);       
    }
} elseif (isset($_POST['editPokemon'])) {
    $_SESSION['pokemonModified'] = findPokemon($pokedex,$_POST['editPokemon']);
    header('Location:' . '../php_views/pokemon_edit.php', true, 302);
 
} elseif (isset($_POST['edit'])) { 
    $rutaTemporal = $_FILES['imagen']['tmp_name'];
    if (isset($_FILES['imagen'])) {
        move_uploaded_file($rutaTemporal, $_FILES['imagen']['name']);
    }
    //Creamos el pokemon
    $imagen = $_FILES['imagen']['name'];
    $pokemon = modifyPokemon($pokedex,$_POST['edit'], $_POST['edit'], $_POST['txtNombre'], $_POST['region'], $_POST['tipoPokemon'], $_POST['altura'], $_POST['peso'], $_POST['rEvolucion'], $imagen);
    $_SESSION['pokedex'] = $pokedex;
    header('Location:' . '../php_views/pokemon_list.php', true, 302);

} elseif (isset($_POST['delete'])) {
$pokedex = deletePokemon($pokedex, $_POST['delete']);
    if ($_SESSION['deletePokemon'] == 'El pokemon seleccionado se ha borrado de la pokedex') {
        $indexOfPokemon = array_search($_POST['txtNumero'], array_column($pokedex, 'Numero'));
        unlink("../media/" . $pokemon[$indexOfPokemon]['Imatge']);
        $_SESSION['pokedex'] = $pokedex;
        header('Location:' . '../php_views/pokemon_list.php', true, 302);
    } else {
        $_SESSION['deletePokemon'] == "No se ha borrado el pokemon.Problemas al borrar la imagen";
        header('Location:' . '../php_views/pokemon_list.php', true, 302);

    }
}
