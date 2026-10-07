# Álgebra Linear

Aplicação web desenvolvida em **PHP** para realizar cálculos de Álgebra Linear por meio de uma interface simples e interativa.

O projeto foi desenvolvido como uma atividade de integração entre **Matemática e Desenvolvimento de Sistemas**, utilizando conceitos matemáticos na implementação de algoritmos em PHP.

## Sobre o projeto

A aplicação permite realizar cálculos envolvendo:

- Operações com matrizes 2×2;
- Soma de matrizes;
- Subtração de matrizes;
- Multiplicação de matrizes;
- Cálculo do determinante de uma matriz 3×3;
- Resolução e classificação de sistemas lineares;
- Validação dos valores informados pelo usuário;
- Armazenamento de sistemas lineares no banco de dados.

A resolução dos sistemas lineares é realizada por meio de operações com matrizes e cálculo de posto, permitindo classificar o sistema como:

- **Possível e determinado**;
- **Possível e indeterminado**;
- **Impossível**.

## Tecnologias utilizadas

- **PHP**
- **HTML5**
- **CSS3**
- **Bootstrap 5**
- **MySQL**
- **PDO**
- **Composer**
- **vlucas/phpdotenv**

## Estrutura do projeto

```text
Interarea_Matematica/
│
├── Config/
│   └── configuration.php
│
├── Controller/
│   └── AlgebraLinearController.php
│
├── Model/
│   ├── AlgebraLinearModel.php
│   └── Connection.php
│
├── View/
│   ├── AlgebraLinear.php
│   └── AlgebraLinearTest.php
│
├── templates/
│   └── css/
│       └── global.css
│
├── index.php
├── composer.json
├── composer.lock
├── .gitignore
└── README.md
```

### Organização das pastas

- **Config/** → contém as configurações de conexão com o banco de dados.
- **Controller/** → contém as regras responsáveis pelo processamento dos cálculos e pela validação dos dados.
- **Model/** → responsável pela comunicação com o banco de dados e pelo armazenamento dos resultados.
- **View/** → contém classes da apresentação e execução das funcionalidades.
- **templates/css/** → contém os estilos da interface do projeto.
- **index.php** → página principal do projeto.
- **composer.json** → configura as dependências e o autoload do projeto.

## Operações com matrizes

A aplicação trabalha com matrizes **2×2** e disponibiliza três operações:

### Soma

Realiza a soma dos elementos correspondentes das matrizes A e B.

```text
A + B
```

### Subtração

Realiza a subtração dos elementos correspondentes.

```text
A - B
```

### Multiplicação

Realiza a multiplicação matricial entre A e B.

```text
A × B
```

Os valores são validados antes da realização dos cálculos.

## Determinante

A aplicação calcula o determinante de uma matriz **3×3**.

O cálculo é realizado diretamente no `AlgebraLinearController.php`, utilizando a regra de Sarrus.

Exemplo:

```text
| a b c |
| d e f |
| g h i |
```

O sistema calcula o determinante e apresenta o resultado na interface.

## Sistemas lineares

A aplicação informa os coeficientes de um sistema linear e seus termos independentes.

Exemplo:

```text
a1x + b1y = c1
a2x + b2y = c2
```

O sistema utiliza operações de eliminação por linhas para encontrar a solução.

Após o cálculo, o sistema identifica uma das três classificações:

### Sistema possível e determinado

Possui uma única solução.

### Sistema possível e indeterminado

Possui infinitas soluções.

### Sistema impossível

Não possui solução.

## Banco de dados

O projeto utiliza **MySQL** através do **PDO**.

As configurações de conexão estão no arquivo:

```text
Config/configuration.php
```

O sistema utiliza o banco:

```text
fitcalc
```

Para o armazenamento dos sistemas lineares, o código utiliza a tabela:

```text
SistemaLinear
```

com os dados da matriz, dos termos independentes e do resultado armazenados em formato JSON.

### Exemplo de configuração

```php
define("DB_NAME", "fitcalc");
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASSWORD", "sua_senha");
define("DB_PORT", "3306");
```

## Instalação

### 1. Pré-requisitos

Antes de executar o projeto, é necessário ter instalado:

- PHP;
- Composer;
- MySQL;
- Um servidor local, como XAMPP, WAMP, Laragon ou PHP embutido.

### 2. Clonar o projeto

```bash
git clone URL_DO_REPOSITORIO
```

Depois, entre na pasta:

```bash
cd Interarea_Matematica
```

### 3. Instalar as dependências

Execute:

```bash
composer install
```

Nesse passo o Composer instalará as dependências definidas no `composer.json`.

### 4. Configurar o banco de dados

Crie um banco de dados MySQL chamado:

```sql
CREATE DATABASE fitcalc;
```

Depois, configure os dados de acesso no arquivo:

```text
Config/configuration.php
```

A tabela `SistemaLinear` deve possuir os campos utilizados pelo model:

```sql
CREATE TABLE SistemaLinear (
    id INT AUTO_INCREMENT PRIMARY KEY,
    matriz JSON NOT NULL,
    termos JSON NOT NULL,
    resultado JSON NOT NULL
);
```

## ▶ Execução

Na pasta do projeto, execute:

```bash
php -S localhost:3000
```

Depois, abra no navegador:

```text
http://localhost:3000
```

A página inicial mostrará as funcionalidades da Álgebra Linear.

## Validação dos dados

O sistema possui validações para evitar cálculos com dados inválidos.

Entre as verificações realizadas estão:

- Matriz vazia;
- Quantidade incorreta de linhas ou colunas;
- Campos sem preenchimento;
- Valores que não são numéricos;
- Quantidade incorreta de termos independentes;
- Operação de matriz inválida.

## Arquitetura

O projeto segue uma organização baseada no padrão **MVC (Model-View-Controller)**.

### Model

Responsável pelo acesso ao banco de dados.

```text
Model/
├── AlgebraLinearModel.php
└── Connection.php
```

### View

Responsável pelas classes relacionadas à apresentação e interação com as funcionalidades.

```text
View/
├── AlgebraLinear.php
└── AlgebraLinearTest.php
```

### Controller

Responsável pelo processamento das operações matemáticas, validações e comunicação com o Model.

```text
Controller/
└── AlgebraLinearController.php
```

## Testes

O projeto possui arquivos relacionados à execução das funcionalidades, como:

```text
View/AlgebraLinearTest.php
```

## Funcionalidades implementadas

|Funcionalidades

Soma de matrizes 2×2 
Subtração de matrizes 2×2 
Multiplicação de matrizes 2×2 
Determinante de matriz 3×3 
Resolução de sistema linear 
Classificação de sistema linear 
Validação dos dados 
Salvamento de sistema no MySQL 

## Autores

Projeto desenvolvido por:

- Ana Clara Marques
- Anna Clara Vieira

## Licença

Este projeto foi desenvolvido para fins **educacionais e acadêmicos**.
