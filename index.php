<?php

require_once __DIR__ . '/vendor/autoload.php'; 
use Controller\AlgebraLinearController;
use Model\SistemaLinear;

$controller = new AlgebraLinearController(new SistemaLinear());

$resMatriz = null;
$resDet = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (($_POST['acao'] ?? '') === 'matrizes') {
        $resMatriz = $controller->operarMatrizes($_POST['a'], $_POST['b'], $_POST['op']);
    }
    if (($_POST['acao'] ?? '') === 'determinante') {
        $resDet = $controller->calcularDeterminante($_POST['m']);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Álgebra Linear</title>
    <link rel="stylesheet" href="templates/css/global.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>

<header>
    <h1>Álgebra Linear</h1>
</header>

<main>

    <?php
$resMatriz = null;
$resDet = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (($_POST['acao'] ?? '') === 'matrizes') {
        $resMatriz = $controller->operarMatrizes($_POST['a'], $_POST['b'], $_POST['op']);
    }
    if (($_POST['acao'] ?? '') === 'determinante') {
        $resDet = $controller->calcularDeterminante($_POST['m']);
    }
}
?>

<section id="matrizes">
    <h2>Operações com Matrizes</h2>

    <form method="POST">
        <input type="hidden" name="acao" value="matrizes">

        <div class="matrizes">
            <div>
                <h3>Matriz A</h3>
                <input type="number" step="any" name="a[0][0]">
                <input type="number" step="any" name="a[0][1]"><br>
                <input type="number" step="any" name="a[1][0]">
                <input type="number" step="any" name="a[1][1]">
            </div>

            <select name="op">
                <option value="soma">+</option>
                <option value="sub">-</option>
                <option value="mult">×</option>
            </select>

            <div>
                <h3>Matriz B</h3>
                <input type="number" step="any" name="b[0][0]">
                <input type="number" step="any" name="b[0][1]"><br>
                <input type="number" step="any" name="b[1][0]">
                <input type="number" step="any" name="b[1][1]">
            </div>
        </div>

        <div class="d-grid gap-1">
            <button class="btn btn-primary" type="submit">Calcular</button>
        </div>
    </form>

    <div class="resultado">
        <?php if ($resMatriz === null): ?>
            Resultado: [ 0  0 ] [ 0  0 ]
        <?php elseif ($resMatriz['erro'] !== null): ?>
            <?= htmlspecialchars($resMatriz['erro']) ?>
        <?php else: ?>
            Resultado:
            <?php foreach ($resMatriz['resultado'] as $linha): ?>
                [ <?= implode('  ', $linha) ?> ]
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<div class="d-grid gap-1">
  <button class="btn btn-primary" type="button">Calcular</button>

</div>
        

        <div class="resultado">
            Resultado: [ 0  0 ] [ 0  0 ]
        </div>
    </section>


    <section id="determinante">
    <h2>Determinante</h2>

    <form method="POST">
        <input type="hidden" name="acao" value="determinante">

        <div class="matriz">
            <input type="number" step="any" name="m[0][0]">
            <input type="number" step="any" name="m[0][1]">
            <input type="number" step="any" name="m[0][2]">
            <input type="number" step="any" name="m[1][0]">
            <input type="number" step="any" name="m[1][1]">
            <input type="number" step="any" name="m[1][2]">
            <input type="number" step="any" name="m[2][0]">
            <input type="number" step="any" name="m[2][1]">
            <input type="number" step="any" name="m[2][2]">
        </div>

        <div class="d-grid gap-1">
            <button class="btn btn-primary" type="submit">Calcular determinante</button>
        </div>
    </form>

    <p>
        Determinante:
        <strong>
            <?php if ($resDet === null): ?>
                0
            <?php elseif ($resDet['erro'] !== null): ?>
                <?= htmlspecialchars($resDet['erro']) ?>
            <?php else: ?>
                <?= $resDet['determinante'] ?>
            <?php endif; ?>
        </strong>
    </p>
</section>


    <section id="sistema">
        <h2>Fórmula Geral</h2>

        <div class="sistema">
            <p>
                <input> x +
                <input> y =