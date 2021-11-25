<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
    include '../bootstrap/index.php';
    include '../php_partials/menu.php';
    if(!isset($_SESSION)){
        session_start();
       }
    ?>
</head>

<body>
    <?php
    //Error message
       if (isset($_SESSION["errormsg"])) {
        $error = $_SESSION["errormsg"];
        session_unset($_SESSION["errormsg"]);
     } else {
        $error = "";
      }
      // Message 
      if (isset($_SESSION["msg"])) {
        $message = $_SESSION["msg"];
        session_unset($_SESSION["msg"]);
     } else {
        $message = "";
      }  
        if (isset($_SESSION["errormsg"])) {

    ?>
        <div class="alert alert-danger" role="alert">
            <?php
            $_SESSION['error'] = $error;
            echo $error;
            session_destroy();

            ?>
        </div>

    
    <?php
    } else { ?>
        <div class="alert alert-success" role="alert">
        <?php
        $_SESSION['msg'] = $message;
        echo $message;
        
    }
     ?>

       <div class="container-fluid">
            <div class="row row-cols-1 row-cols-md-5">
                <?php 
                     if (isset($_SESSION['pokedex'])) {
                        $pokedex = $_SESSION['pokedex'];
                    } else {
                        $pokedex = [];
                    }
                    foreach($pokedex as $pokemon) {
                   ?>
                <div class="col mt-2">
                    <div class="card" style="width: 18rem;">
                        <span class="border border-secondary">
                            <img src="/pokemon/media/"<?php $pokemon['Imatge'] ."" ?> class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title"><?php $pokemon['Numero'] ."". $pokemon['Nombre']  ?></h5>
                                <?php 
                                    foreach($pokemon['Tipus'] as $tipo) {

                                    
                                ?>
                                <span class="badge bg-warning text-dark"><?php $pokemon['Tipus'][$tipus] ?></span>
                                <?php 
                                }
                                }
                                ?>
                            </div>
                            <footer class="card-footer  text-end">
                                <form action="../php_controllers/pokemonController.php" method="post">
                                <button type="submit" class="btn btn-outline-danger" name='delete'><i class="fas fa-trash-alt"></i></button>
                                <button type="submit" class="btn btn-outline-primary" name='edit'><i class="fas fa-edit"></i></button>
                                </form>
                            </footer>
                        </span>
                    </div>
                </div>
                

            <div class="position-bottom position-fixed bottom-0 end-0 m-5" style="height:25px;width:2px;">
                <a href="pokemon.php" type="button" class="btn bg-warning text-dark rounded"><i class="fas fa-plus"></i></a>
            </div>


        </div>

</body>

</html>