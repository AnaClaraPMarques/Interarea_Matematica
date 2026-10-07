# Relatório Técnico — Álgebra Linear

## 1. Introdução

O projeto **Álgebra Linear** foi desenvolvido em PHP como uma atividade de integração entre Matemática e Desenvolvimento de Sistemas. A aplicação permite realizar operações com matrizes, calcular determinantes e resolver sistemas lineares por meio de uma interface web.

Além dos cálculos matemáticos, o projeto possui validações dos dados informados pelo usuário, armazenamento de sistemas no banco de dados e testes automatizados utilizando PHPUnit.

## 2. Objetivo

O objetivo principal é desenvolver um projeto capaz de implementar algoritmos de Álgebra Linear,permitindo ao usuário realizar cálculos matemáticos e visualizar seus resultados.

Também foi utilizado o desenvolvimento orientado a testes para verificar o funcionamento dos códigos e garantir maior confiabilidade no projeto.

## 3. Algoritmos implementados

### 3.1 Operações com matrizes

A aplicação realiza três operações com matrizes 2×2:

* Soma;
* Subtração;
* Multiplicação.

Na soma e na subtração, os elementos correspondentes das duas matrizes são operados individualmente.

Na multiplicação, cada elemento da matriz resultante é obtido pela multiplicação dos elementos das linhas da primeira matriz pelos elementos das colunas da segunda matriz e pela soma dos resultados.

### 3.2 Determinante

O sistema calcula o determinante de matrizes 3×3 utilizando a **Regra de Sarrus**.

O algoritmo realiza as multiplicações das diagonais principais e secundárias e calcula a diferença entre esses resultados, obtendo o determinante da matriz.

### 3.3 Sistemas lineares

A resolução de sistemas lineares é realizada utilizando operações de eliminação por linhas.

Os dados são organizados em uma matriz aumentada, contendo os coeficientes das incógnitas e os termos independentes. O código utiliza pivôs para transformar a matriz e identificar o posto do sistema.

Após o processamento, o sistema é classificado como:

* **Possível e determinado**, quando possui uma única solução;
* **Possível e indeterminado**, quando possui infinitas soluções;
* **Impossível**, quando não possui solução.

O algoritmo também utiliza uma pequena margem de tolerância (`EPSILON`) para evitar problemas causados pela precisão dos números.

## 4. Organização do projeto

O projeto possui uma organização baseada no padrão **MVC (Model-View-Controller)**.

### Controller

O arquivo `AlgebraLinearController.php` armazena as principais operações matemáticas e as validações dos dados.

Entre seus objetivos estão:

* operações com matrizes;
* cálculo do determinante;
* resolução de sistemas lineares;
* classificação dos sistemas;
* validação dos dados.

### Model

O `AlgebraLinearModel.php` é responsável pela comunicação com o banco de dados.

Os sistemas lineares podem ser armazenados com suas matrizes, termos independentes e resultados.

### View

A pasta `View` contém a parte responsável pela apresentação e interação com o usuário.

### Tests

A pasta `tests` contém os testes automatizados realizados com PHPUnit.

## 5. Estruturas de dados

As matrizes são representadas no PHP por **arrays bidimensionais**.

Exemplo:

```php
[
    [1, 2],
    [3, 4]
]
```

Os termos independentes dos sistemas são armazenados em arrays simples:

```php
[5, 1]
```

Durante a resolução dos sistemas, os dados são transformados em uma matriz aumentada, adicionando os termos independentes ao final de cada linha.

Para o armazenamento no banco de dados, os arrays são convertidos para **JSON**.

## 6. Validação e tratamento de erros

A aplicação realiza validações antes de executar os cálculos.

São verificadas situações como:

* matriz vazia;
* quantidade incorreta de linhas ou colunas;
* linhas com tamanhos diferentes;
* campos sem preenchimento;
* valores não numéricos;
* quantidade incorreta de termos independentes;
* dimensões incompatíveis;
* operação inválida.

Nos sistemas lineares também são identificados sistemas impossíveis e indeterminados.

Essas validações evitam que entradas inválidas sejam utilizadas nos cálculos.

## 7. Testes automatizados

Os testes foram desenvolvidos utilizando **PHPUnit**.

A suíte de testes verifica diferentes situações, incluindo casos normais, casos de borda e entradas inválidas.

Entre os testes realizados estão:

* soma de matrizes;
* subtração de matrizes;
* multiplicação de matrizes;
* operação inválida;
* determinante;
* matriz identidade;
* matriz nula;
* valores decimais;
* sistema determinado;
* sistema 1×1;
* sistema impossível;
* sistema indeterminado;
* matriz vazia;
* dimensões incompatíveis;
* dados não numéricos.

Atualmente, a suíte possui:

**15 testes e 22 asserções**, com todos os testes passando.

## 8. Cobertura de código

A cobertura dos algoritmos foi verificada utilizando **PHPUnit e Xdebug**.

O resultado foi:

**95,32% de cobertura de linhas (102 de 107 linhas).**

O relatório pode ser gerado utilizando:

```bash
vendor\bin\phpunit --coverage-text
```

Também é possível gerar uma versão em HTML:

```bash
vendor\bin\phpunit --coverage-html coverage
```

## 9. Banco de dados

A aplicação utiliza **MySQL** para armazenar os sistemas lineares.

Para a comunicação com o banco é utilizado o **PDO**, permitindo executar comandos SQL de forma segura.

## 10. Dificuldades e soluções

Durante o desenvolvimento, uma das principais dificuldades foi implementar corretamente a resolução e classificação dos sistemas lineares.

Para solucionar esse problema, foi utilizado um processo de eliminação por linhas com escolha de pivôs e uma margem de tolerância para números próximos de zero.

Outra dificuldade foi configurar os testes de cobertura. Para isso, foi utilizado o **Xdebug** junto ao PHPUnit, assim gerando o relatório de cobertura dos algoritmos.

Também foram criados testes para diferentes situações, incluindo casos de borda e entradas inválidas, aumentando a confiabilidade do projeto.

## 11. Conclusão

O projeto aplicou conceitos de Álgebra Linear na prática por meio do desenvolvimento de uma aplicação web em PHP.

Foram implementadas operações com matrizes, cálculo de determinante e resolução de sistemas lineares, além de validações, armazenamento em banco de dados e testes automatizados.

A cobertura de **95,32% das linhas de código** demonstra que os principais códigos e funcionalidades foram amplamente testados, contribuindo para a confiabilidade do sistema.
