<?php

namespace Controller;

use Model\AlgebraLinear;

class AlgebraLinearController
{
    private const EPSILON = 1e-10;

    public function __construct(private AlgebraLinear $model)
    {
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