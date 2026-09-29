<?php

declare(strict_types=1);

namespace App;

/**
 * Classe responsável por classificar e (opcionalmente) calcular
 * parâmetros de qualidade da água, com base nos padrões de
 * potabilidade usados no Laboratório da Água / Biofiltro Experimental.
 */
class QualidadeAgua
{
    // Faixas de referência de potabilidade
    private const PH_MIN = 6.0;
    private const PH_MAX = 9.5;
    private const TURBIDEZ_MAX = 5.0;      // uT
    private const CLORO_MIN = 0.2;         // mg/L
    private const CLORO_MAX = 2.0;         // mg/L
    private const DUREZA_MAX = 500.0;      // mg/L

    /**
     * ABORDAGEM 1 — pH como valor de entrada direta (dataset real).
     * Apenas classifica o valor recebido dentro da faixa de potabilidade.
     */
    public function classificarPH(float $ph): string
    {
        return ($ph >= self::PH_MIN && $ph <= self::PH_MAX)
            ? 'Dentro do padrão'
            : 'Fora do padrão';
    }

    /**
     * ABORDAGEM 2 — pH calculado a partir da concentração de íons H+.
     * pH = -log10([H+])
     *
     * @throws \InvalidArgumentException se a concentração for <= 0
     */
    public function calcularPHPorConcentracao(float $concentracaoH): float
    {
        if ($concentracaoH <= 0) {
            throw new \InvalidArgumentException(
                'Concentração de H+ deve ser maior que zero'
            );
        }

        return round(-log10($concentracaoH), 2);
    }

    public function classificarTurbidez(float $turbidez): string
    {
        return $turbidez <= self::TURBIDEZ_MAX
            ? 'Dentro do padrão'
            : 'Fora do padrão';
    }

    public function classificarCloroResidual(float $cloro): string
    {
        return ($cloro >= self::CLORO_MIN && $cloro <= self::CLORO_MAX)
            ? 'Dentro do padrão'
            : 'Fora do padrão';
    }

    public function classificarDureza(float $dureza): string
    {
        return $dureza <= self::DUREZA_MAX
            ? 'Dentro do padrão'
            : 'Fora do padrão';
    }

    /**
     * Classifica todos os parâmetros de uma vez e indica se a água
     * está potável (todos os parâmetros dentro do padrão).
     *
     * @return array{
     *     ph: string,
     *     turbidez: string,
     *     cloroResidual: string,
     *     dureza: string,
     *     potavel: bool
     * }
     */
    public function classificarAgua(
        float $ph,
        float $turbidez,
        float $cloroResidual,
        float $dureza,
        float $temperatura
    ): array {
        $resultado = [
            'ph' => $this->classificarPH($ph),
            'turbidez' => $this->classificarTurbidez($turbidez),
            'cloroResidual' => $this->classificarCloroResidual($cloroResidual),
            'dureza' => $this->classificarDureza($dureza),
            'temperatura' => $temperatura, // informativo, sem padrão rígido
        ];

        $resultado['potavel'] = !in_array('Fora do padrão', $resultado, true);

        return $resultado;
    }
}
