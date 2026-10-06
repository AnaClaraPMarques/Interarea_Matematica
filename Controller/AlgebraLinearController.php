<?php

namespace Controller;

use Model\AlgebraLinear;

class AlgebraLinearController
{
    private const EPSILON = 1e-10;

    public function __construct(private AlgebraLinear $model)
    {
    }


    public function calcularDeterminante(array $m): array
{
    if (count($m) !== 3) {
        return ["determinante" => null, "erro" => "A matriz deve ser 3x3."];
    }

    foreach ($m as $linha) {
        if (!is_array($linha) || count($linha) !== 3) {
            return ["determinante" => null, "erro" => "A matriz deve ser 3x3."];
        }
        foreach ($linha as $valor) {
            if (!is_numeric($valor)) {
                return ["determinante" => null, "erro" => "Preencha todos os campos com números."];
            }
        }
    }

    // diagonais principais (+) e secundárias (-)
    $det =
        ($m[0][0] * $m[1][1] * $m[2][2]) +
        ($m[0][1] * $m[1][2] * $m[2][0]) +
        ($m[0][2] * $m[1][0] * $m[2][1]) -
        ($m[0][2] * $m[1][1] * $m[2][0]) -
        ($m[0][0] * $m[1][2] * $m[2][1]) -
        ($m[0][1] * $m[1][0] * $m[2][2]);

    return ["determinante" => $det, "erro" => null];
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
        if ($tipo === "Possível e determinado") {
            $solucao = [];
            for ($i = 0; $i < $colunas; $i++) {
                $solucao[] = $m[$i][$colunas];
            }
        }

        return [
            "solucao" => $solucao,
            "posto" => $posto,
            "tipo" => $tipo
        ];
    }

    public function classifySistema(array $m, int $posto, int $linhas, int $colunas): string
    {
        
        for ($i = $posto; $i < $linhas; $i++) {
            if (abs($m[$i][$colunas]) > self::EPSILON) {
                return "Impossível";
            }
        }

        return $posto === $colunas
            ? "Possível e determinado"
            : "Possível e indeterminado";
    }

    public function validateData(array $matriz, array $termos): ?array
    {
        if (count($matriz) === 0 || !is_array($matriz[0]) || count($matriz[0]) === 0) {
            return ["solucao" => null, "tipo" => "A matriz não pode ser vazia."];
        }

        $colunas = count($matriz[0]);

        foreach ($matriz as $linha) {
            if (!is_array($linha) || count($linha) !== $colunas) {
                return ["solucao" => null, "tipo" => "Todas as linhas devem ter o mesmo número de colunas."];
            }
            foreach ($linha as $valor) {
                if (!is_numeric($valor)) {
                    return ["solucao" => null, "tipo" => "A matriz deve conter apenas números."];
                }
            }
        }

        if (count($termos) !== count($matriz)) {
            return ["solucao" => null, "tipo" => "Dimensões incompatíveis: a quantidade de termos independentes deve ser igual ao número de equações."];
        }

        foreach ($termos as $valor) {
            if (!is_numeric($valor)) {
                return ["solucao" => null, "tipo" => "Os termos independentes devem ser numéricos."];
            }
        }

        return null;
    }

    public function saveSistema(array $matriz, array $termos, array $resultado): bool
    {
        return $this->model->createSistema($matriz, $termos, $resultado);
    }
}