<?php
    session_start();
    /*
    $_SESSION["pokemon"] = [
        "Numero" => "001",
        "Nom" => "Bulbasaur",
        "Regio" => "Hoenn",
        "Tipus" => "Planta, Veneno",
        "Alsada" => 70,
        "Pes" => 6.9,
        "Evolucio" => "Sense evolucionar",
        "Imatge" => "001.png",

    ];
    */
    $pokemon = [];

    if(isset($_SESSION["pokemon"])) {
        $pokemon = $_SESSION["pokemon"];
    }

    var_dump($pokemon);


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

    include("../php_librarys/bd.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        include('../data/bootstrap.php')
    ?>
    <title>Document</title>
</head>
<body>

    <div class="card">
    <div class="d-flex card-header p-2 mb-2 bg-secondary text-white">

        <img class="m-1" width="50" height="50" src="../media/pikachu.png" alt="">
        <h3 class="mt-2 ms-2">Pokemon</h3>

    </div>
    <div class="card-body">
        <div class="container-fluid">

            <form method="POST" action="../php_controllers/pokemonController.php" enctype="multipart/form-data">

                <div class="row">
                    <div class="col col-1 d-flex align-items-center">
                        <p>Número</p>
                    
                    </div>
                    <div class="col col-11">
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" aria-describedby="basic-addon1" name="numeroEdit" value="<?php
                            if(isset($_SESSION["pokemon"])) {
                                echo $pokemon["numero"];
                            }
                            ?>" readonly>
                        </div>
                    </div>

                </div>

                <div class="row mt-4">
                    <div class="col col-1 d-flex align-items-center">
                        <p>Nombre</p>
                    </div>
                    <div class="col col-11">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" aria-describedby="basic-addon1" name="nomEdit" value="<?php
                            if(isset($_SESSION["pokemon"])) {
                                echo $pokemon["nombre"];
                            }
                            ?>"required>
                        </div>
                    </div>

                </div>

                <div class="row mt-4">
                    <div class="col col-1 d-flex align-items-center">
                        <p>Regió</p>
                    </div>
                    <div class="col col-11">
                        <select class="form-select" aria-label="Default select example" name="regioEdit">
                            <?php
                                if(isset($_SESSION["pokemon"])) {

                                    $region = obtenerRegionNombre($pokemon["regiones_id"]);

                                    $regiones = ["Kanto","Jotho","Hoenn","Teselia"];

                                    $posicion = 0;
        
                                    switch($region) {
                                        case 'Kanto':
                                            echo '<option selected>'.$regiones[0].'</option>';
                                            break;
                                        case 'Jotho':
                                            echo '<option selected>'.$regiones[1].'</option>';
                                            $posicion = 1;
                                            break;
                                        case 'Hoenn':
                                            echo '<option selected>'.$regiones[2].'</option>';
                                            $posicion = 2;
                                            break;
                                        case 'Teselia':
                                            echo '<option selected>'.$regiones[3].'</option>';
                                            $posicion = 3;
                                            break;
        
                                    }

                                    unset($regiones[$posicion]);

                                    array_values($regiones);

                                    foreach($regiones as $r) {
                                        echo '<option>'.$r.'</option>';
                                    }

                                }
                                else {
                                    echo '<option selected>Kanto</option>';
                                    echo '<option>Jotho</option>';
                                    echo '<option>Hoenn</option>';
                                    echo '<option>Teselia</option>';
                                }
                                
                                
                            ?>
                        </select>
                    </div>

                </div>

                
                <div class="row mt-4">
                    <div class="col col-1 d-flex align-items-center">
                        <p>Tipo</p>
                    </div>
                    <div class="col col-11">
                        <div class="d-flex">


                            <div class="form-check">

                                <?php

                                    $tipos = selectTiposPokemon($pokemon["numero"]);

                                    function checkChecked($tipoInput,$tipos) {

                                        $checked = false;
                                        
                                        foreach($tipos as $t) {
                                            
                                            if($t == $tipoInput) {
                                                $checked = true;
                                            }
                                        }

                                        if($checked) {
                                            echo 'checked';
                                        }
                                    }
                                ?>

                                <input class="form-check-input" type="checkbox" value="Planta" name="tipusEdit[]" <?php 
                                if(isset($_SESSION["pokemon"])) {
                                    if(!empty($tipos)) {

                                        $tipoInput = "Planta";

                                        checkChecked($tipoInput,$tipos);
                                    }
                                    

                                    
                                }
                                ?>>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Planta
                                </label>
                            </div>

                            <div class="form-check ms-3">
                                <input class="form-check-input" type="checkbox" value="Veneno" name="tipusEdit[]" <?php 
                                if(isset($_SESSION["pokemon"])) {
                                    if(!empty($tipos)) {

                                        $tipoInput = "Veneno";

                                        checkChecked($tipoInput,$tipos);
                                    }
                                    
                                }
                                ?>>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Veneno
                                </label>
                            </div>

                            <div class="form-check ms-3">
                                <input class="form-check-input" type="checkbox" value="Fuego" name="tipusEdit[]" <?php 
                                if(isset($_SESSION["pokemon"])) {
                                    if(!empty($tipos)) {
                                        $tipoInput = "Fuego";

                                        checkChecked($tipoInput,$tipos);
                                    }

                                    
                                }
                                ?>>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Fuego
                                </label>
                            </div>

                            <div class="form-check ms-3">
                                <input class="form-check-input" type="checkbox" value="Volador" name="tipusEdit[]" <?php 
                                if(isset($_SESSION["pokemon"])) {
                                    if(!empty($tipos)) {
                                    $tipoInput = "Volador";

                                    checkChecked($tipoInput,$tipos);

                                    }
                                }
                                ?>>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Volador
                                </label>
                            </div>

                            <div class="form-check ms-3">
                                <input class="form-check-input" type="checkbox" value="Agua" name="tipusEdit[]" <?php 
                                if(isset($_SESSION["pokemon"])) {
                                    if(!empty($tipos)) {
                                        $tipoInput = "Agua";

                                        checkChecked($tipoInput,$tipos);

                                    }
                                }
                                ?>>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Agua
                                </label>
                            </div>

                            <div class="form-check ms-3">
                                <input class="form-check-input" type="checkbox" value="Electrico" name="tipusEdit[]" <?php 
                                if(isset($_SESSION["pokemon"])) {
                                    if(!empty($tipos)) {
                                        $tipoInput = "Electrico";

                                        checkChecked($tipoInput,$tipos);

                                    }
                                }
                                ?>>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Eléctrico
                                </label>
                            </div>

                            <div class="form-check ms-3">
                                <input class="form-check-input" type="checkbox" value="Hada" name="tipusEdit[]" <?php 
                                if(isset($_SESSION["pokemon"])) {
                                    if(!empty($tipos)) {
                                        $tipoInput = "Hada";

                                        checkChecked($tipoInput,$tipos);

                                    }
                                }
                                ?>>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Hada
                                </label>
                            </div>

                            <div class="form-check ms-3">
                                <input class="form-check-input" type="checkbox" value="Bicho" name="tipusEdit[]" <?php 
                                if(isset($_SESSION["pokemon"])) {
                                    if(!empty($tipos)) {
                                        $tipoInput = "Bicho";

                                        checkChecked($tipoInput,$tipos);
                                    }
                                    
                                }
                                ?>>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Bicho
                                </label>
                            </div>


                        </div>

                        <div class="d-flex mt-2">

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Lucha" name="tipusEdit[]" <?php 
                                if(isset($_SESSION["pokemon"])) {
                                    if(!empty($tipos)) {
                                        $tipoInput = "Lucha";

                                        checkChecked($tipoInput,$tipos);
                                    }
                                    
                                }
                                ?>>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Lucha
                                </label>
                            </div>

                            <div class="form-check ms-3">
                                <input class="form-check-input" type="checkbox" value="Psiquico" name="tipusEdit[]" <?php 
                                if(isset($_SESSION["pokemon"])) {
                                    if(!empty($tipos)) {
                                        $tipoInput = "Psiquico";

                                        checkChecked($tipoInput,$tipos);
                                    }
                                    
                                }
                                ?>>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Psíquico
                                </label>
                            </div>


                        </div>
                        

                </div>

                <div class="row mt-4">
                    <div class="col col-1 d-flex align-items-center">
                        <p>Altura</p>
                    </div>
                    <div class="col col-11">
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" aria-describedby="basic-addon2" name="alsadaEdit" value="<?php
                            if(isset($_SESSION["pokemon"])) {
                                echo $pokemon["altura"];
                            }
                            
                            ?>" required>
                            <span class="input-group-text" id="basic-addon2">cm</span>
                        </div>
                    </div>

                </div>


                <div class="row mt-4">
                    <div class="col col-1 d-flex align-items-center">
                        <p>Peso</p>
                    </div>
                    <div class="col col-11">
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" aria-describedby="basic-addon2" name="pesEdit" value="<?php
                            if(isset($_SESSION["pokemon"])) {
                                echo $pokemon["peso"];
                            }
                            
                            ?>" required>
                            <span class="input-group-text" id="basic-addon2">kg</span>
                        </div>
                    </div>

                </div>


                <div class="row mt-4">
                    <div class="col col-1 d-flex align-items-center">
                        <p>Evolución</p>
                    </div>
                    <div class="col col-11">
                        <div class="d-flex">


                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" value="Sense evolucionar" <?php
                                if(isset($_SESSION["pokemon"])) {
                                    $evolucionInput = "Sense evolucionar";
                                    if($evolucionInput == $pokemon["evolucion"]) {
                                        echo 'checked';
                                    }
                                }
                                else {
                                    echo 'checked';
                                }
                                
                                ?>>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Sense evolucionar
                                </label>
                            </div>

                            <div class="form-check ms-3">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" value="Primera evolucio" <?php
                                if(isset($_SESSION["pokemon"])) {
                                    $evolucionInput = "Primera evolucio";
                                    if($evolucionInput == $pokemon["evolucion"]) {
                                        echo 'checked';
                                    }
                                }
                                
                                ?>>
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Primera evolucio
                                </label>
                            </div>

                            <div class="form-check ms-3">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" value="Altres evolucions" <?php
                                if(isset($_SESSION["pokemon"])) {
                                    $evolucionInput = "Altres evolucions";
                                    if($evolucionInput == $pokemon["evolucion"]) {
                                        echo 'checked';
                                    }
                                }
                                
                                ?>>
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Altres evolucions
                                </label>
                            </div>


                        </div>
                        

                    </div>

                </div>

                <div class="row mt-4">
                    <div class="col col-1 d-flex align align-items-center">
                        <p>Imagen</p>
                    </div>

                    <div class="col col-11">
                        <input type="file" name="imatgeEdit" value="Seleccionar archivo" accept="image/*" required>

                    </div>



                </div>

                <div class="row mt-4">
                    <div class="col col-12">
                        <div class="d-flex justify-content-end">
                            <a href="pokemon_list.php">

                                <button type="button" class="btn btn-secondary mx-3">Cancelar</button>


                            </a>

                            
                            <button type="submit" class="btn btn-primary" name="submitEditPokemon">Aceptar</button> 
                            
                            
                        </div>
                    
                </div>


            </div>

            </form>
            
        </div>
    </div>
    </div>

    <!--
    <form action="" method="">
        
        <div>
            <label>Numero</label>
            <input type="text" maxlength="3" placeholder="Número de pokemon" autofocus/>
        </div>
        <div>
            <label>Nombre</label>
            <input type="text" placeholder="Nombre de pokémon"/>
        </div>
        <div>
            <label>Regio</label>
            <select>
                <option>Kanto</option>
                <option>Jotho</option>
                <option>Hoenn</option>
                <option>Sinnoh</option>
                <option>Teselia</option>
            </select>
        </div>

        <div>
            <label>Tipo</label>
            <input type="checkbox" name="tipo" value="planta"/>
            <label>Planta</label>

            <input type="checkbox" name="tipo" value="veneno"/>
            <label>Veneno</label>

            <input type="checkbox" name="tipo" value="fuego"/>
            <label>Fuego</label>

            <input type="checkbox" name="tipo" value="volador"/>
            <label>Volador</label>

            <input type="checkbox" name="tipo" value="agua"/>
            <label>Agua</label>

            <input type="checkbox" name="tipo" value="electrico"/>
            <label>Eléctrico</label>

            <input type="checkbox" name="tipo" value="hada"/>
            <label>Hada</label>

            <input type="checkbox" name="tipo" value="bicho"/>
            <label>Bicho</label>

            <input type="checkbox" name="tipo" value="lucha"/>
            <label>Lucha</label>

            <input type="checkbox" name="tipo" value="psiquico"/>
            <label>Psíquico</label>

        </div>

        <div>
            <label>Altura</label>
            <input type="number" min="1"/>

        </div>

        <div>
            <label>Pes</label>
            <input type="number" min="0" step="0.01" />

        </div>

        <div>
            <label>Evolucio</label>
            <input type="radio" name="evolucio" value="sinEvolucionar" checked/>
            <label>Sin evolucionar</label>

            <input type="radio" name="evolucio" value="primeraEvolucion"/>
            <label>Primera evolucion</label>

            <input type="radio" name="evolucio" value="otrasEvoluciones"/>
            <label>Otras evoluciones</label>

        </div>

        <div>
            <label>Imagen</label>
            <input type="file" value="Seleccionar archivo"/>

        </div>

        <div>
            <button type="submit">Aceptar</button>
            <a href="./index.php">Cancelar</a>
        </div>
    
    </form>
    -->
    
</body>
</html>