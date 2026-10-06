<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Álgebra Linear</title>
    <link rel="stylesheet" href="templates/css/global.css">
</head>

<body>

<header>
    <h1>Álgebra Linear</h1>
</header>

<main>

    <section id="matrizes">
        <h2>Operações com Matrizes</h2>

        <div class="matrizes">
            <div>
                <h3>Matriz A</h3>
                <input><input><br>
                <input><input>
            </div>

            <select>
                <option>+</option>
                <option>-</option>
                <option>×</option>
            </select>

            <div>
                <h3>Matriz B</h3>
                <input><input><br>
                <input><input>
            </div>
        </div>

        <button>Calcular</button>

        <div class="resultado">
            Resultado: [ 0  0 ] [ 0  0 ]
        </div>
    </section>


    <section>
        <h2>Determinante</h2>

        <div class="matriz">
            <input><input><input>
            <input><input><input>
            <input><input><input>
        </div>

        <button>Calcular determinante</button>

        <p>Determinante: <strong>0</strong></p>
    </section>


    <section id="sistema">
        <h2>Sistema Linear</h2>

        <div class="sistema">
            <p>
                <input> x +
                <input> y =