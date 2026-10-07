# Álgebra Linear

Aplicação web desenvolvida em **PHP** para realizar operações de Álgebra Linear, como operações com matrizes, cálculo de determinante e resolução de sistemas lineares.

O projeto foi desenvolvido como atividade de integração entre **Matemática e Desenvolvimento de Sistemas**.

## Tecnologias

* PHP 8.4
* HTML5 e CSS3
* Bootstrap 5
* MySQL
* PDO
* Composer
* PHPUnit
* Xdebug
* Laravel Herd

## Funcionalidades

* Soma de matrizes 2×2;
* Subtração de matrizes 2×2;
* Multiplicação de matrizes 2×2;
* Determinante de matriz 3×3;
* Resolução e classificação de sistemas lineares;
* Validação dos dados;
* Armazenamento dos sistemas no banco de dados.

Os sistemas podem ser classificados como:

* **Possível e determinado**;
* **Possível e indeterminado**;
* **Impossível**.

## Estrutura

```text
Interarea_Matematica/
├── Config/
├── Controller/
├── Model/
├── View/
├── templates/
├── tests/
├── index.php
├── composer.json
├── composer.lock
├── phpunit.xml
├── .gitignore
└── README.md
```

* `Controller/` → cálculos e validações.
* `Model/` → comunicação com o banco de dados.
* `View/` → interface da aplicação do projeto.
* `tests/` → testes automatizados.
* `Config/` → configurações do projeto.

## Algoritmos

### Matrizes

São realizadas operações de **soma, subtração e multiplicação** entre matrizes 2×2.

### Determinante

O determinante de matrizes 3×3 é calculado utilizando a **Regra de Sarrus**.

### Sistemas lineares

A resolução utiliza **eliminação por linhas**, permitindo encontrar a solução e classificar o sistema.

## Banco de dados

O projeto utiliza **MySQL** com PDO.

O banco utilizado é:

```text
fitcalc
```

A tabela `SistemaLinear` guarda a matriz, os termos independentes e o resultado em formato JSON.

## Instalação

Clone o projeto e instale as dependências:

```bash
git clone URL_DO_REPOSITORIO
cd Interarea_Matematica
composer install
```

Configure o banco de dados em:

```text
Config/configuration.php
```

## Execução

O projeto utiliza **Laravel Herd**.

Após vincular a pasta ao Herd, acesse:

```text
http://Interarea_Matematica.test
```

## Testes

Os testes automatizados estão em:

```text
tests/AlgebraLinearTest.php
```

Para executar:

```bash
vendor\bin\phpunit
```

Resultado atual:

* **15 testes**
* **22 asserções**
* **100% passando**

## Cobertura

A cobertura é realizada com **PHPUnit + Xdebug**.

Para visualizar no terminal:

```bash
vendor\bin\phpunit --coverage-text
```

Cobertura atual:

**95,32% das linhas de código.**

Para gerar o relatório HTML:

```bash
vendor\bin\phpunit --coverage-html coverage
```

O relatório será gerado em:

```text
coverage/index.html
```

## Autores

* Ana Clara Marques
* Anna Clara Vieira

## Licença

Projeto desenvolvido para fins **educacionais e acadêmicos**.
