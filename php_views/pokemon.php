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
    <input type="text" name="txtNumero" id="txtNumero" maxlength="3" placeholder="Número del pokémon" autofocus><br>
    <label for="txtNombre">Nombre</label>
    <input type="text" name="txtNombre" id="txtNombre" placeholder="Nombre del pokémon"><br>
    <label for="region">Región</label>
    <select name="region" id="region">
        <option value="kanto">Kanto</option>
        <option value="johto">Johto</option>
        <option value="hoenn">Hoenn</option>
        <option value="sinnoh">Sinnoh</option>
        <option value="teselia">Teselia</option>
    </select><br>
    <label for="tipo">Tipo</label>
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
    <label for="altura">Altura</label>
    <input type="number" name="altura" id="altura" min="1"><br>
    <label for="peso">Peso</label>
    <input type="number" min="0" step=".01" name="peso" id="peso"><br>
    <label for="evolucion">Evolución</label>
    <input type="radio" name="rEvolucion" id="rbSinEvolucionar" value="rbSinEvolucionar">
    <label for="rbSinEvolucionar">Sin Evolucionar</label>
    <input type="radio" name="rEvolucion" id="rbPrimeraEvolucion" value="rbPrimeraEvolucion">
    <label for="rbPrimeraEvolucion">Primera evolución</label>
    <input type="radio" name="rEvolucion" id="rbSegundaEvolucion" value="rbSegundaEvolucion">
    <label for="rbSegundaEvolucion">Segunda evolución</label><br>
    <label for="imagen">Imagen</label>
    <input type="file" id="imagen" name="imagen" accept="image/png, image/jpeg"><br>
    <button type="submit">Aceptar</button> <a href=""> Cancelar</a>

</body>

</html>