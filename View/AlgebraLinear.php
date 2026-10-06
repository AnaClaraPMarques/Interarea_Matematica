<?php

declare(strict_types=1);

namespace App;

public function __construct(private AlgebraLinearController $controller)
{
}


class SistemaLinear
{
    
  public function solveSistema(array $matriz, array $termos): array
{
    return $this->controller->solveSistema($matriz, $termos);
}

public function classifySistema(array $m, int $posto, int $linhas, int $colunas): string
{
    return $this->controller->classifySistema($m, $posto, $linhas, $colunas);
}

public function validateData(array $matriz, array $termos): string
{
    return $this->controller->validateData($matriz, $termos);
}

public function saveSistema(array $matriz, array $termos, array $resultado): string
{
    return $this->controller->saveSistema($matriz, $termos, $resultado);
}
    
}
