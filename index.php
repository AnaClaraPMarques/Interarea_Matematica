<?php

require_once __DIR__ . '/vendor/autoload.php';

use Controller\AlgebraLinearController;
use Model\AlgebraLinearModel;

$model = new AlgebraLinearModel();
$controller = new AlgebraLinearController($model);

$resMatriz = null;
$resDet = null;
$resSistema = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';

    if ($acao === 'matrizes') {
        $resMatriz = $controller->operarMatrizes(
            $_POST['a'] ?? [],
            $_POST['b'] ?? [],
            $_POST['op'] ?? ''
        );
    }

    if ($acao === 'determinante') {
        $resDet = $controller->calcularDeterminante(
            $_POST['m'] ?? []
        );
    }

    if ($acao === 'sistema') {
        $resSistema = $controller->solveSistema(
            $_POST['s'] ?? [],
            $_POST['t'] ?? []
        );
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

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous"
    >
</head>

<body>

<header>
    <h1>Álgebra Linear</h1>
</header>

<main>


    <section id="matrizes">

        <h2>Operações com Matrizes</h2>

        <form method="POST">

            <input
                type="hidden"
                name="acao"
                value="matrizes"
            >

            <div class="matrizes">

              
                <div>

                    <h3>Matriz A</h3>

                    <input
                        type="number"
                        step="any"
                        name="a[0][0]"
                    >

                    <input
                        type="number"
                        step="any"
                        name="a[0][1]"
                    >

                    <br>

                    <input
                        type="number"
                        step="any"
                        name="a[1][0]"
                    >

                    <input
                        type="number"
                        step="any"
                        name="a[1][1]"
                    >

                </div>


                
                <select name="op">

                    <option value="soma">+</option>
                    <option value="sub">-</option>
                    <option value="mult">×</option>

                </select>


              
                <div>

                    <h3>Matriz B</h3>

                    <input
                        type="number"
                        step="any"
                        name="b[0][0]"
                    >

                    <input
                        type="number"
                        step="any"
                        name="b[0][1]"
                    >

                    <br>

                    <input
                        type="number"
                        step="any"
                        name="b[1][0]"
                    >

                    <input
                        type="number"
                        step="any"
                        name="b[1][1]"
                    >

                </div>

            </div>


            <div class="d-grid gap-1">

                <button
                    class="btn btn-primary"
                    type="submit"
                >
                    Calcular
                </button>

            </div>

        </form>


        <div class="resultado">

            <?php if ($resMatriz === null): ?>

                Resultado: [ 0 0 ] [ 0 0 ]

            <?php elseif ($resMatriz['erro'] !== null): ?>

                <?= htmlspecialchars($resMatriz['erro']) ?>

            <?php else: ?>

                Resultado:

                <?php foreach ($resMatriz['resultado'] as $linha): ?>

                    [ <?= implode(
                        ' ',
                        array_map(
                            fn($valor) => round($valor, 4),
                            $linha
                        )
                    ) ?> ]

                <?php endforeach; ?>

            <?php endif; ?>

        </div>

    </section>

    <section id="determinante">

        <h2>Determinante</h2>


        <form method="POST">

            <input
                type="hidden"
                name="acao"
                value="determinante"
            >


            <div class="matriz-determinante">

                <input
                    type="number"
                    step="any"
                    name="m[0][0]"
                    autocomplete="off"
                    required
                >

                <input
                    type="number"
                    step="any"
                    name="m[0][1]"
                    autocomplete="off"
                    required
                >

                <input
                    type="number"
                    step="any"
                    name="m[0][2]"
                    autocomplete="off"
                    required
                >


                <input
                    type="number"
                    step="any"
                    name="m[1][0]"
                    autocomplete="off"
                    required
                >

                <input
                    type="number"
                    step="any"
                    name="m[1][1]"
                    autocomplete="off"
                    required
                >

                <input
                    type="number"
                    step="any"
                    name="m[1][2]"
                    autocomplete="off"
                    required
                >


                <input
                    type="number"
                    step="any"
                    name="m[2][0]"
                    autocomplete="off"
                    required
                >

                <input
                    type="number"
                    step="any"
                    name="m[2][1]"
                    autocomplete="off"
                    required
                >

                <input
                    type="number"
                    step="any"
                    name="m[2][2]"
                    autocomplete="off"
                    required
                >

            </div>


            <div class="d-grid gap-1">

                <button
                    class="btn btn-primary"
                    type="submit"
                >
                    Calcular determinante
                </button>

            </div>

        </form>


        <p class="resultado-determinante">

            Determinante:

            <strong>

                <?php if ($resDet === null): ?>

                    —

                <?php elseif ($resDet['erro'] !== null): ?>

                    <?= htmlspecialchars($resDet['erro']) ?>

                <?php else: ?>

                    <?= round($resDet['determinante'], 4) ?>

                <?php endif; ?>

            </strong>

        </p>

    </section>


    <section id="sistema">

        <h2>Fórmula Geral</h2>


        <form method="POST">

            <input
                type="hidden"
                name="acao"
                value="sistema"
            >


            <div class="sistema">

                <p>

                    <input
                        type="number"
                        step="any"
                        name="s[0][0]"
                    >

                    x +

                    <input
                        type="number"
                        step="any"
                        name="s[0][1]"
                    >

                    y =

                    <input
                        type="number"
                        step="any"
                        name="t[0]"
                    >

                </p>


                <p>

                    <input
                        type="number"
                        step="any"
                        name="s[1][0]"
                    >

                    x +

                    <input
                        type="number"
                        step="any"
                        name="s[1][1]"
                    >

                    y =

                    <input
                        type="number"
                        step="any"
                        name="t[1]"
                    >

                </p>

            </div>


            <div class="d-grid gap-1">

                <button
                    class="btn btn-primary"
                    type="submit"
                >
                    Resolver sistema
                </button>

            </div>

        </form>


        <div class="resultado">

            <?php if ($resSistema === null): ?>

                Resultado: x = 0, y = 0

            <?php else: ?>

                <?php if ($resSistema['solucao'] !== null): ?>

                    Resultado:

                    x =
                    <?= round($resSistema['solucao'][0], 4) ?>

                    ,

                    y =
                    <?= round($resSistema['solucao'][1], 4) ?>

                    <br>

                <?php endif; ?>

                <?= htmlspecialchars($resSistema['tipo']) ?>

            <?php endif; ?>

        </div>

    </section>

</main>

</body>

</html>