<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulari Pokemon</title>
</head>

<body>
    <label for="txtNumero">Número</label>
    <input type="text" name="txtNumero" id="txtNumero"><br>
    <label for="txtNombre">Nombre</label>
    <input type="text" name="txtNombre" id="txtNombre"><br>
    <label for="region">Región</label>
    <select name="region" id="region">
        <option value="kanto">Kanto</option>
        <option value="johto">Johto</option>
        <option value="hoenn">Hoenn</option>
        <option value="sinnoh">Sinnoh</option>
        <option value="teselia">Teselia</option>
    </select><br>
    <label for="tipo">Tipo</label>
    <input type="checkbox" name="planta" id="planta">Planta
    <input type="checkbox" name="veneno" id="veneno">Veneno
    <input type="checkbox" name="fuego" id="fuego">Fuego
    <input type="checkbox" name="volador" id="volador">Volador
    <input type="checkbox" name="agua" id="agua">Agua
    <input type="checkbox" name="electrico" id="electrico">Eléctrico
    <input type="checkbox" name="hada" id="hada">Hada
    <input type="checkbox" name="bicho" id="bicho">Bicho
    <input type="checkbox" name="lucha" id="lucha">Lucha
    <input type="checkbox" name="psiquico" id="psiquico">Psíquico <br>
    <label for="altura">Altura</label>
    <input type="number" name="altura" id="altura"><br>
    <label for="peso">Peso</label>
    <input type="number" min="0" step=".01" name="peso" id="peso"><br>
    <label for="evolucion">Evolución</label>
    <input type="radio" name="rEvolucion" id="rbSinEvolucionar">
    <label for="rbSinEvolucionar">Sin Evolucionar</label>
    <input type="radio" name="rEvolucion" id="rbPrimeraEvolucion">
    <label for="rbPrimeraEvolucion">Primera evolución</label>
    <input type="radio" name="rEvolucion" id="rbSegundaEvolucion">
    <label for="rbSegundaEvolucion">Segunda evolución</label><br>
    <label for="imagen">Imagen</label>
    <input type="file" id="imagen" name="imagen" accept="image/png, image/jpeg"><br>
    <button type="submit">Aceptar</button> <a href=""> Cancelar</a>

</body>

</html>