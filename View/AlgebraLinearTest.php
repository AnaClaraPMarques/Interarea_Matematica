<?php

declare(strict_types=1);

namespace View;

use Controller\AlgebraLinearController;

class AlgebraLinearTest
{
    public function __construct(private AlgebraLinearController $controller)
    {
    }

    public function executar(array $matriz, array $termos): array
    {
        return $this->controller->solveSistema($matriz, $termos);
    }
}