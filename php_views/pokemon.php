    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Formulari Pokemon</title>
        <?php
        include '../bootstrap/index.php';
        if(!isset($_SESSION)){
            session_start();
           }
           if(isset([$_SESSION]['pokemon'])) {
               $pokemon = [$_SESSION]['pokemon'];
           } else {
               $pokemon = [];
           }
        ?>
    </head>
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
    <body>
        <div class="container-fluid" style="width: 45%;height:55%;margin-top:200px">

            <form class="border border-dark justify-content-center" action="../php_controllers/pokemonController.php" method="POST" enctype="multipart/form-data">
                <header class="card-header"><img src="../media/pokeball.png" height="20">Pokemon</header>
                <div class="form-group row">
                    <label for="txtNumero" class="col-sm-2 col-form-label">Número:</label>
                    <div class="col-sm-10">
                        <input class="form-control w-75" type="text" name="txtNumero" id="txtNumero" maxlength="3" placeholder="Número del pokémon" autofocus required><br>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="txtNombre" class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control w-75" name="txtNombre" id="txtNombre" placeholder="Nombre del pokémon" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="region" class="col-sm-2 col-form-label">Región</label>
                    <div class="col-sm-10">
                        <select name="region" id="region" class="form-control w-75">
                            <option value="kanto">Kanto</option>
                            <option value="johto">Johto</option>
                            <option value="hoenn">Hoenn</option>
                            <option value="sinnoh">Sinnoh</option>
                            <option value="teselia">Teselia</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-2">Tipo</div>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <label for="tipo" class="form-check-label">
                                <input type="checkbox" name="tipoPokemon[]" id="planta" value="planta">Planta
                                <input type="checkbox" name="tipoPokemon[]" id="veneno" value="veneno">Veneno
                                <input type="checkbox" name="tipoPokemon[]" id="fuego" value="fuego">Fuego
                                <input type="checkbox" name="tipoPokemon[]" id="volador" value="volador">Volador
                                <input type="checkbox" name="tipoPokemon[]" id="agua" value="agua">Agua
                                <input type="checkbox" name="tipoPokemon[]" id="electrico" value="electrico">Eléctrico
                                <input type="checkbox" name="tipoPokemon[]" id="hada" value="hada">Hada
                                <input type="checkbox" name="tipoPokemon[]" id="bicho" value="bicho">Bicho
                                <input type="checkbox" name="tipoPokemon[]" id="lucha" value="lucha">Lucha
                                <input type="checkbox" name="tipoPokemon[]" id="psiquico" value="psiqiuco">Psíquico <br>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <div class="input-group mb-3">
                            <label for="peso" class="col-sm-2 col-form-label">Altura</label>
                            <input type="number" class="form-control w-50" name="altura" id="altura" min="1" style="margin-left: 4%;">
                            <span class="input-group-text" style="margin-right:5%">cm</span>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <div class="input-group mb-3">
                            <label for="peso" class="col-sm-2 col-form-label">Peso</label>
                            <input type="number" class="form-control w-50" min="0" step=".01" name="peso" id="peso" style="margin-left: 4%;">
                            <span class="input-group-text" style="margin-right:5%">KG</span>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-2">Evolución</div>
                    <div class="col-sm-10">

                        <input type="radio" class="form-check-input" name="rEvolucion" id="rbSinEvolucionar" value="rbSinEvolucionar">
                        <label for="rbSinEvolucionar" class="form-check-label">Sin Evolucionar</label>
                        <input type="radio" class="form-check-input" name="rEvolucion" id="rbPrimeraEvolucion" value="rbPrimeraEvolucion">
                        <label for="rbPrimeraEvolucion" class="form-check-label">Primera evolución</label>
                        <input type="radio" class="form-check-input" name="rEvolucion" id="rbSegundaEvolucion" value="rbSegundaEvolucion">
                        <label for="rbSegundaEvolucion" class="form-check-label">Segunda evolución</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="imagen" class="col-sm-2 col-form-label">Imagen</label>
                    <div class="col-sm-10">
                        <input  name="imagen" type="file" id="imagen" accept="image/png, image/jpeg">

                    </div>
                </div>
                <div class="card-footer text-end">
                    <a class="btn btn-secondary text-end" href="\pokemon\index.php" role="button">Cancelar</a>
                    <button type="submit" class="btn btn-primary" name = 'add'>Aceptar</button>
                    </div>
            </form>
            
        </div>
    </body>

    </html>