<?php

use Controller\AlgebraLinearController;
use Model\AlgebraLinearModel;
use PHPUnit\Framework\TestCase;

class AlgebraLinearTest extends TestCase
{
    private AlgebraLinearController $controller;

    protected function setUp(): void
    {
        $this->controller = new AlgebraLinearController(
            $this->createStub(AlgebraLinearModel::class)
        );
    }

    public function testSoma(): void
    {
        $resultado = $this->controller->operarMatrizes(
            [[1, 2], [3, 4]],
            [[5, 6], [7, 8]],
            'soma'
        );

        $this->assertEquals([[6, 8], [10, 12]], $resultado['resultado']);
    }

    public function testSubtracao(): void
    {
        $resultado = $this->controller->operarMatrizes(
            [[5, 6], [7, 8]],
            [[1, 2], [3, 4]],
            'sub'
        );

        $this->assertEquals([[4, 4], [4, 4]], $resultado['resultado']);
    }

    public function testMultiplicacao(): void
    {
        $resultado = $this->controller->operarMatrizes(
            [[1, 2], [3, 4]],
            [[5, 6], [7, 8]],
            'mult'
        );

        $this->assertEquals([[19, 22], [43, 50]], $resultado['resultado']);
    }

    public function testErrosDeMatriz(): void
    {
        $resultado = $this->controller->operarMatrizes(
            [[1, 2, 3], [4, 5, 6]],
            [[1, 2], [3, 4]],
            'soma'
        );

        $this->assertNull($resultado['resultado']);

        $resultado = $this->controller->operarMatrizes(
            [[1, 'abc'], [3, 4]],
            [[5, 6], [7, 8]],
            'soma'
        );

        $this->assertEquals(
            'Preencha todos os campos com números.',
            $resultado['erro']
        );
    }

    public function testOperacaoInvalida(): void
    {
        $resultado = $this->controller->operarMatrizes(
            [[1, 2], [3, 4]],
            [[5, 6], [7, 8]],
            'divisao'
        );

        $this->assertEquals('Operação inválida.', $resultado['erro']);
    }

    public function testDeterminante(): void
    {
        $resultado = $this->controller->calcularDeterminante([
            [1, 2, 3],
            [0, 1, 4],
            [5, 6, 0]
        ]);

        $this->assertEquals(1, $resultado['determinante']);
    }

    public function testDeterminanteCasosDeBorda(): void
    {
        $identidade = $this->controller->calcularDeterminante([
            [1, 0, 0],
            [0, 1, 0],
            [0, 0, 1]
        ]);

        $nula = $this->controller->calcularDeterminante([
            [0, 0, 0],
            [0, 0, 0],
            [0, 0, 0]
        ]);

        $this->assertEquals(1, $identidade['determinante']);
        $this->assertEquals(0, $nula['determinante']);
    }

    public function testDeterminanteComDecimais(): void
    {
        $resultado = $this->controller->calcularDeterminante([
            [1.5, 0, 0],
            [0, 2, 0],
            [0, 0, 3]
        ]);

        $this->assertEqualsWithDelta(
            9.0,
            $resultado['determinante'],
            0.000001
        );
    }

    public function testSistemaDeterminado(): void
    {
        $resultado = $this->controller->solveSistema(
            [[2, 1], [1, -1]],
            [5, 1]
        );

        $this->assertEquals('Possível e determinado', $resultado['tipo']);
        $this->assertEquals([2, 1], $resultado['solucao']);
    }

    public function testSistemaUmPorUm(): void
    {
        $resultado = $this->controller->solveSistema([[2]], [6]);

        $this->assertEquals('Possível e determinado', $resultado['tipo']);
        $this->assertEqualsWithDelta(3, $resultado['solucao'][0], 0.000001);
    }

    public function testSistemaImpossivel(): void
    {
        $resultado = $this->controller->solveSistema(
            [[1, 2], [2, 4]],
            [3, 7]
        );

        $this->assertEquals('Impossível', $resultado['tipo']);
        $this->assertNull($resultado['solucao']);
    }

    public function testSistemaIndeterminado(): void
    {
        $resultado = $this->controller->solveSistema(
            [[1, 2], [2, 4]],
            [3, 6]
        );

        $this->assertEquals('Possível e indeterminado', $resultado['tipo']);
        $this->assertNull($resultado['solucao']);
    }

    public function testMatrizVazia(): void
    {
        $resultado = $this->controller->solveSistema([], []);

        $this->assertEquals('A matriz não pode ser vazia.', $resultado['tipo']);
    }

    public function testDimensoesIncompativeis(): void
    {
        $resultado = $this->controller->solveSistema(
            [[1, 2], [3]],
            [5, 6]
        );

        $this->assertEquals(
            'Todas as linhas devem ter o mesmo número de colunas.',
            $resultado['tipo']
        );

        $resultado = $this->controller->solveSistema(
            [[1, 2], [3, 4]],
            [5]
        );

        $this->assertEquals(
            'A quantidade de termos independentes deve ser igual ao número de equações.',
            $resultado['tipo']
        );
    }

    public function testDadosNaoNumericos(): void
    {
        $resultado = $this->controller->solveSistema(
            [[1, 2], [3, 4]],
            [5, 'abc']
        );

        $this->assertEquals(
            'Os termos independentes devem ser numéricos.',
            $resultado['tipo']
        );
    }
}