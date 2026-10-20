# CRUD de Agenda de Contatos

Este projeto é uma aplicação web para o gerenciamento de contatos. A implementação atende rigorosamente a todos os critérios de aceitação e especificações técnicas descritas nos documentos de referência: `user_story.docx`, `requisitos_de_sistema.pdf` e `rodando_a_aplicacao.txt`.
O CRUD poderia ser feito com apenas 1 arquivo `.php`, qualquer impressão de "overengineering" pode ser vista como apresentação da separação de responsabilidades na arquitetura sugerida nas documentações. Considere ler o item **Melhoria Contínua**, no final do documento.

## Arquitetura e Decisões Técnicas

O projeto foi construído utilizando:

*   **PHP 8.4:**
*   **Slim Framework 4:** Micro-framework para aproveitamento de recursos como roteamento e uso das PSR-7/PSR-15
*   **Doctrine ORM 3:** Mapeamento de dados utilizando **PHP Attributes**
*   **Padrões de Projeto (Design Patterns):**
    *   **Service & Repository Pattern:** O serviço usa o repositório injetado
    *   **Value Objects (VO):** Para isolar validação de limite de idade em `DataNascimentoVO` e higienização em `EnderecoVO`
    *   **Data Transfer Objects (DTO):** Para transferência de objetos entre as camadas
*   **Frontend:** Bootstrap 5 com jQuery 4, pela simplicidade na implementação

## Como Executar - Docker

1. Clone este repositório
2. Na raiz do projeto, renomeie ou copie o arquivo `.env.example` para `.env`
3. Suba os containers com o Docker Compose:
   ```bash
   docker-compose up -d --build
   ```
4. Acesse a aplicação no navegador: **http://localhost:8000/agenda/index**

## Como Executar - Local
1. Certifique-se de ter o **PHP 8.4+** e o **Composer** instalados na sua máquina, além de um servidor **MySQL** rodando.
2. Clone o repositório.
3. Instale as dependências do projeto:
   ```bash
   composer install
   ```
4. Crie o banco de dados no seu MySQL:
   ```sql
   CREATE DATABASE php_crud_agenda;
   ```
5. Copie o arquivo `.env.example` para `.env` e ajuste as credenciais do banco. **Importante:** ajuste o .env com as suas configurações de banco de dados.
6. Gere as tabelas no banco de dados:
   ```bash
   php app/Commands/db_migrate.php
   ```
7. (OPCIONAL) Popular o banco com dados aleatórios
   ```bash
   php app/Commands/db_seed.php
   ```
8. Inicie o servidor embutido do PHP apontando para a pasta `public`:
   ```bash
   php -S localhost:8000 -t public
   ```
9. Acesse no navegador: **http://localhost:8000/agenda/index**


## Testes Automatizados (PHPUnit)

Para executar os testes via Docker:
```bash
docker exec -it agenda_app vendor/bin/phpunit
```

Para executar localmente (sem Docker):
```bash
vendor/bin/phpunit
```

## Estrutura de Diretórios
* `app/Controllers/`: Manipulação das requisições Web e API.
* `app/Models/`: Entidades mapeadas para o banco de dados.
* `app/Services/`: Lógica de negócio e orquestração.
* `app/Repositories/`: Isolamento das queries SQL/DQL.
* `app/ValueObjects/` & `app/DTOs/`: Validação de domínio e transporte de dados.
* `app/Views/`: Templates PHP com HTML puro integrados ao Slim.
* `public/`: Front Controller (`index.php`) e assets estáticos (CSS/JS locais).

## Melhoria contínua

Embora este projeto tenha sido desenvolvido de forma enxuta para atender aos requisitos do teste, a arquitetura foi desenhada pensando em escalabilidade. Abaixo estão algumas reflexões que tive sobre possíveis problemas que até um CRUD pode enfrentar:

**Como lidar com milhares de requisições de criação simultâneas?**

Do jeito que tá, o banco VAI cair. O servidor VAI travar. Implementando uma **Fila de Mensageria** (RabbitMQ), o Controller da API pode só validar os dados e os colocar em uma fila, retornando sucesso imediato ao usuário. Um *worker* processa a fila e faz os inserts no MySQL de forma controlada.

**Muitos usuários acessando a página principal de listagem ao mesmo tempo vai causar lentidão**

Eu atacaria em duas frentes:

1. **Cache:** Implementaria uma camada de cache (Redis) usando a biblioteca `symfony/cache` (já disponível no projeto). A query principal da listagem seria servida direto da memória, aliviando o banco de dados.
2. **Otimização do Banco (Índices):** Evoluiria a estrutura do banco separando os campos do endereço (rua, bairro, cidade, UF) em colunas específicas ou em uma tabela relacional. Em seguida, aplicaria **Índices (Indexes)** em colunas que frequentemente sofrem buscas ou ordenações, como `cidade`, `uf` e extrairia o `ano_nascimento`.

**Observabilidade em produção**  

O *Error Middleware* do Slim pode capturar qualquer exceção não tratada, salvar um log com todo o contexto e integrar uma ferramenta de Observabilidade como o **New Relic** pode ajudar visualmente.

**API aberta vs Segurança**  

Se a aplicação precisasse receber milhares de tentativas de salvar contatos por segundo, convém adicionar um *middleware* de **Rate Limiting** no Slim 4, para limitar a quantidade de requests que um mesmo IP pode fazer por minuto. Na camada de infra, colocaria a aplicação atrás de um WAF (Web Application Firewall), como o Cloudflare, para mitigar ataques maliciosos antes mesmo de chegarem ao servidor PHP.