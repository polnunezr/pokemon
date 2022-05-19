<?php
    session_start();

    include("../php_librarys/bd.php");

    if(isset($_SESSION["mensajeAfegir"])) {
        if($_SESSION["mensajeAfegir"] != "Pokemon añadido correctamente") {

            echo '<div class="alert alert-danger" role="alert">';
            echo $_SESSION["mensajeAfegir"];
            echo '</div>';
        }
        else {
            echo '<div class="alert alert-success" role="alert">';
            echo $_SESSION["mensajeAfegir"];
            echo '</div>';
        }
        unset($_SESSION["mensajeAfegir"]);
    }
    else if(isset($_SESSION["mensajeEsborrar"])) {
        if($_SESSION["mensajeEsborrar"] != "Pokemon borrado correctamente") {

            echo '<div class="alert alert-danger" role="alert">';
            echo $_SESSION["mensajeEsborrar"];
            echo '</div>';
        }
        else {
            echo '<div class="alert alert-success" role="alert">';
            echo $_SESSION["mensajeEsborrar"];
            echo '</div>';
        }
        unset($_SESSION["mensajeEsborrar"]);

    }
    /*
    $pokedex;

    if(!isset($_SESSION["pokedex"])) {

        $pokedex = [];
    }

    else {
        $pokedex = $_SESSION["pokedex"];
    }

    if(isset($_SESSION["pokemon"])) {
        unset($_SESSION["pokemon"]);
    }
    */
    if(isset($_SESSION["pokemon"])) {
        unset($_SESSION["pokemon"]);
    }

    $pokedex = selectPokemons();
    $tipos = selectPokemonsTipus();
    $regions = selectPokemonsRegions();
    $pokemon = selectPokemon(2);
    //$tiposPokemon = selectTiposPokemon(2);
    //modificarPokemon("003","Snorlaxx",50,150,"Sense evolucio","",4,"Planta, Agua, Lucha");
    // insertPokemon("003","Pikachu","Teselia","Planta, Veneno, Agua, Bicho",99.5,50,"Sense evolucionar","003.png");
    //deletePokemon(1);
    //var_dump($pokedex);

   

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<link rel="stylesheet" href="../style/styleList.css">-->
    <link rel="stylesheet" href="../style/estiloPokemon_list.css">
    <?php
        include('../data/bootstrap.php')
    ?>
    <title>Document</title>
</head>
<body>
    <?php
        include('../php_partials/menu.php')
    ?>
    <a href="pokemon.php">
        <div id="buttonPlus"></div>
    </a>

    <div class="container-fluid">
        
        

        

            <?php

                $countCard = 1;

               

                foreach($pokedex as $p) {

                    if($countCard == 1) { 
                        echo '<div class="row row-cols-1 row-cols-md-5 g-5">';
                    }

                    echo '<form method="POST" action="../php_controllers/pokemonController.php">';

                    echo '<div class="col d-flex justify-content-center align-items-center">';
                    echo '<div class="card border-secondary w-51 m-4">';
                    echo '<div class="card-body">';
                    echo '<img src="../media/'.$p["imagen"].'" class="card-img-top p-2 imgPokemon " alt="...">';
                    echo '<div class="tipus">';
                    echo '<h5 class="card-title"><strong>'. $p["numero"].'-'.$p["nombre"] .'</strong></h5>';

                    echo '<p class="card-text ">';
                    
                    $numeroPokemon = $p["numero"];
                    //var_dump($numeroPokemon);

                    $tipos = selectTiposPokemon($numeroPokemon);
                    
                    

                    if(count($tipos) == 1) {
                        echo '<span class="badge bg-warning text-dark">'.$tipos[0].'</span>';

                    }
                    elseif(!empty($tipos)){
                        $finalizado = false;
                        $countTipos = count($tipos);
                        //var_dump($countTipos);
                        //var_dump($countTipos);
                        do {
                            $countTipos = $countTipos - 2;
                            //var_dump($countTipos);
                            if($countTipos >= 0) {
                                echo '<span class="badge bg-warning text-dark">'.$tipos[$countTipos].'</span> <span class="badge bg-warning text-dark">'.$tipos[$countTipos+1].'</span><br>';
                            }
                            else {
                                if($countTipos == -1) {
                                    echo '<span class="badge bg-warning text-dark">'.$tipos[0].'</span>';
                                }

                                $finalizado = true;
                            }


                        } while(!$finalizado);
                        
                    }                
                    

                    echo "</p>";

                    echo '</div>';
                    echo '</div>';
                    echo '<div class="card-footer d-flex justify-content-end">';

                    echo '<button type="submit" name="buttonDelete" class="btn btn-outline-danger me-3"><i class="far fa-trash-alt"></i></button>';
                    echo '<input type="hidden" name="inputDelete" value="'.$p["numero"].'">';   
                    //var_dump($p["Numero"]);

                    echo '<button type="submit" name="buttonEdit" class="btn btn-outline-primary"><i class="far fa-edit"></i></button>';
                    echo '<input type="hidden" name="inputEdit" value="'.$p["numero"].'">';

                    echo '</div>';

                    echo '</div>';
                    echo '</div>';

                    echo '</form>';

                    if($countCard == 5) {
                        echo '</div>';
                        $countCard = 0;
                    }


                    $countCard++;

                }

                if($countCard != 1) {
                    echo '</div>';
                }

                

            ?>

        


    </div>

    <script src="https://kit.fontawesome.com/7fae944b38.js" crossorigin="anonymous"></script>
    
</body>
</html>