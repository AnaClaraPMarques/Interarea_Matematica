<?php

namespace Controller;

use Model\AlgebraLinearModel;

class AlgebraLinearController
{
    private const EPSILON = 1e-10;

    private AlgebraLinearModel $model;

    public function __construct(AlgebraLinearModel $model)
    {
        $this->model = $model;
    }

    public function operarMatrizes(array $a, array $b, string $operacao): array
    {
        $validacaoA = $this->validarMatriz($a, 2, 2);
        if ($validacaoA !== null) {
            return ['resultado' => null, 'erro' => $validacaoA];
        }

        $validacaoB = $this->validarMatriz($b, 2, 2);
        if ($validacaoB !== null) {
            return ['resultado' => null, 'erro' => $validacaoB];
        }

        $resultado = [[0, 0], [0, 0]];

        switch ($operacao) {
            case 'soma':
                for ($i = 0; $i < 2; $i++) {
                    for ($j = 0; $j < 2; $j++) {
                        $resultado[$i][$j] = (float) $a[$i][$j] + (float) $b[$i][$j];
                    }
                }
                break;

            case 'sub':
                for ($i = 0; $i < 2; $i++) {
                    for ($j = 0; $j < 2; $j++) {
                        $resultado[$i][$j] = (float) $a[$i][$j] - (float) $b[$i][$j];
                    }
                }
                break;

            case 'mult':
                for ($i = 0; $i < 2; $i++) {
                    for ($j = 0; $j < 2; $j++) {
                        $resultado[$i][$j] =
                            (float) $a[$i][0] * (float) $b[0][$j] +
                            (float) $a[$i][1] * (float) $b[1][$j];
                    }
                }
                break;

            default:
                return ['resultado' => null, 'erro' => 'Operação inválida.'];
        }

        return ['resultado' => $resultado, 'erro' => null];
    }

    private function validarMatriz(array $matriz, int $linhas, int $colunas): ?string
    {
        if (count($matriz) !== $linhas) {
            return "A matriz deve ter {$linhas} linhas.";
        }

        for ($i = 0; $i < $linhas; $i++) {
            if (!isset($matriz[$i]) || !is_array($matriz[$i]) || count($matriz[$i]) !== $colunas) {
                return "A matriz deve ser {$linhas}x{$colunas}.";
            }

            for ($j = 0; $j < $colunas; $j++) {
                if ($matriz[$i][$j] === '' || !is_numeric($matriz[$i][$j])) {
                    return 'Preencha todos os campos com números.';
                }
            }
        }

        return null;
    }

    public function calcularDeterminante(array $m): array
    {
        $erro = $this->validarMatriz($m, 3, 3);

        if ($erro !== null) {
            return ['determinante' => null, 'erro' => $erro];
        }

        $det =
            ((float) $m[0][0] * (float) $m[1][1] * (float) $m[2][2]) +
            ((float) $m[0][1] * (float) $m[1][2] * (float) $m[2][0]) +
            ((float) $m[0][2] * (float) $m[1][0] * (float) $m[2][1]) -
            ((float) $m[0][2] * (float) $m[1][1] * (float) $m[2][0]) -
            ((float) $m[0][0] * (float) $m[1][2] * (float) $m[2][1]) -
            ((float) $m[0][1] * (float) $m[1][0] * (float) $m[2][2]);

        return ['determinante' => $det, 'erro' => null];
    }

    public function solveSistema(array $matriz, array $termos): array
    {
        $error = $this->validateData($matriz, $termos);

        if ($error !== null) {
            return $error;
        }

        $linhas = count($matriz);
        $colunas = count($matriz[0]);

        $m = [];
        foreach ($matriz as $i => $linha) {
            $m[$i] = array_map('floatval', array_values($linha));
            $m[$i][] = (float) $termos[$i];
        }

        $posto = 0;

        for ($col = 0; $col < $colunas && $posto < $linhas; $col++) {
            $pivo = $posto;

            for ($i = $posto + 1; $i < $linhas; $i++) {
                if (abs($m[$i][$col]) > abs($m[$pivo][$col])) {
                    $pivo = $i;
                }
            }

            if (abs($m[$pivo][$col]) < self::EPSILON) {
                continue;
            }

            [$m[$posto], $m[$pivo]] = [$m[$pivo], $m[$posto]];

            $divisor = $m[$posto][$col];

            for ($j = $col; $j <= $colunas; $j++) {
                $m[$posto][$j] /= $divisor;
            }

            for ($i = 0; $i < $linhas; $i++) {
                if ($i !== $posto) {
                    $fator = $m[$i][$col];

                    for ($j = $col; $j <= $colunas; $j++) {
                        $m[$i][$j] -= $fator * $m[$posto][$j];
                    }
                }
            }

            $posto++;
        }

        $tipo = $this->classifySistema($m, $posto, $linhas, $colunas);
        $solucao = null;

        if ($tipo === 'Possível e determinado') {
            $solucao = [];

            for ($i = 0; $i < $colunas; $i++) {
                $solucao[] = $m[$i][$colunas];
            }
        }

        return [
            'solucao' => $solucao,
            'posto' => $posto,
            'tipo' => $tipo
        ];
    }

    public function classifySistema(array $m, int $posto, int $linhas, int $colunas): string
    {
        for ($i = $posto; $i < $linhas; $i++) {
            if (abs($m[$i][$colunas]) > self::EPSILON) {
                return 'Impossível';
            }
        }

        return $posto === $colunas
            ? 'Possível e determinado'
            : 'Possível e indeterminado';
    }

    public function validateData(array $matriz, array $termos): ?array
    {
        if (count($matriz) === 0 || !isset($matriz[0]) || !is_array($matriz[0]) || count($matriz[0]) === 0) {
            return ['solucao' => null, 'tipo' => 'A matriz não pode ser vazia.'];
        }

        $colunas = count($matriz[0]);

        foreach ($matriz as $linha) {
            if (!is_array($linha) || count($linha) !== $colunas) {
                return ['solucao' => null, 'tipo' => 'Todas as linhas devem ter o mesmo número de colunas.'];
            }

            foreach ($linha as $valor) {
                if ($valor === '' || !is_numeric($valor)) {
                    return ['solucao' => null, 'tipo' => 'A matriz deve conter apenas números.'];
                }
            }
        }

        if (count($termos) !== count($matriz)) {
            return ['solucao' => null, 'tipo' => 'A quantidade de termos independentes deve ser igual ao número de equações.'];
        }

        foreach ($termos as $valor) {
            if ($valor === '' || !is_numeric($valor)) {
                return ['solucao' => null, 'tipo' => 'Os termos independentes devem ser numéricos.'];
            }
        }

        return null;
    }

    public function saveSistema(array $matriz, array $termos, array $resultado): bool
    {
        return $this->model->createSistema($matriz, $termos, $resultado);
    }
}
