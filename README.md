# 🏢 Sistema de Gestão de Estoque - Zamix

[![Laravel](https://img.shields.io/badge/Laravel-10.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.1+-blue.svg)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-orange.svg)](https://mysql.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-3.x-38B2AC.svg)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

> **Sistema completo de gestão de estoque desenvolvido para a Zamix, com controle de produtos simples e compostos, requisições, movimentações de estoque e relatórios gerenciais.**

## 📋 Índice

-   [🎯 Sobre o Projeto](#-sobre-o-projeto)
-   [🚀 Funcionalidades](#-funcionalidades)
-   [🛠️ Tecnologias Utilizadas](#️-tecnologias-utilizadas)
-   [📁 Estrutura do Projeto](#-estrutura-do-projeto)
-   [⚙️ Configuração do Ambiente](#️-configuração-do-ambiente)
-   [🔧 Instalação e Setup](#-instalação-e-setup)
-   [📊 Banco de Dados](#-banco-de-dados)
-   [🎨 Interface e UX](#-interface-e-ux)
-   [📈 Relatórios](#-relatórios)
-   [🧪 Testes](#-testes)
-   [📚 Documentação](#-documentação)
-   [🤝 Contribuição](#-contribuição)
-   [📄 Licença](#-licença)

---

## 🎯 Sobre o Projeto

O **Sistema de Gestão de Estoque** é uma aplicação web desenvolvida em Laravel para a empresa **Zamix**, oferecendo uma solução completa para controle de estoque, gestão de produtos e geração de relatórios gerenciais.

### 🎯 Objetivos

-   **Controle de Estoque**: Gestão completa de entrada e saída de produtos
-   **Produtos Compostos**: Suporte a produtos que são compostos por outros produtos
-   **Requisições**: Sistema de requisições de produtos com aprovação
-   **Relatórios**: Geração de relatórios gerenciais para tomada de decisão
-   **Interface Moderna**: UX/UI responsiva e intuitiva

---

## 🚀 Funcionalidades

### 👥 Gestão de Usuários

-   ✅ Cadastro, edição e exclusão de usuários
-   ✅ Sistema de autenticação
-   ✅ Controle de permissões

### 📦 Gestão de Produtos

-   ✅ **Produtos Simples**: Cadastro com preço de custo e venda
-   ✅ **Produtos Compostos**: Composição por produtos simples
-   ✅ Controle de componentes e quantidades
-   ✅ Cálculo automático de custos

### 📊 Controle de Estoque

-   ✅ **Entrada de Estoque**: Registro de produtos que entram
-   ✅ **Saída de Estoque**: Controle de produtos que saem
-   ✅ **Histórico**: Rastreamento completo de movimentações
-   ✅ **Saldo Atual**: Visualização em tempo real

### 📋 Sistema de Requisições

-   ✅ **Nova Requisição**: Criação de requisições com múltiplos itens
-   ✅ **Aprovação**: Fluxo de aprovação de requisições
-   ✅ **Rastreamento**: Histórico completo de requisições
-   ✅ **Associação**: Vinculação com usuários

### 📈 Relatórios Gerenciais

-   ✅ **Relatório de Entrada**: Produtos que entraram no estoque
-   ✅ **Relatório de Saída**: Produtos retirados do estoque
-   ✅ **Filtros Avançados**: Por período, usuário e tipo
-   ✅ **Exportação PDF**: Relatórios em formato PDF
-   ✅ **Totais Automáticos**: Cálculos de custos e valores

---

## 🛠️ Tecnologias Utilizadas

### Backend

-   **[Laravel 10.x](https://laravel.com)** - Framework PHP
-   **[PHP 8.1+](https://php.net)** - Linguagem de programação
-   **[MySQL 8.0+](https://mysql.com)** - Banco de dados
-   **[Eloquent ORM](https://laravel.com/docs/eloquent)** - Mapeamento objeto-relacional

### Frontend

-   **[Tailwind CSS 3.x](https://tailwindcss.com)** - Framework CSS
-   **[Alpine.js](https://alpinejs.dev)** - Framework JavaScript minimalista
-   **[Lucide Icons](https://lucide.dev)** - Biblioteca de ícones
-   **[Blade Templates](https://laravel.com/docs/blade)** - Engine de templates

### Bibliotecas e Ferramentas

-   **[Barryvdh/DomPDF](https://github.com/barryvdh/laravel-dompdf)** - Geração de PDFs
-   **[Laravel Breeze](https://laravel.com/docs/starter-kits)** - Autenticação
-   **[Laravel Migrations](https://laravel.com/docs/migrations)** - Controle de banco
-   **[Laravel Seeders](https://laravel.com/docs/seeders)** - Dados de teste

### Ferramentas de Desenvolvimento

-   **[Composer](https://getcomposer.org)** - Gerenciador de dependências PHP
-   **[NPM](https://npmjs.com)** - Gerenciador de pacotes Node.js
-   **[Git](https://git-scm.com)** - Controle de versão
-   **[Docker](https://docker.com)** - Containerização (opcional)

---

## 📁 Estrutura do Projeto

```
teste-zamix/
├── 📁 app/
│   ├── 📁 Http/
│   │   ├── 📁 Controllers/          # Controladores da aplicação
│   │   │   ├── ProductController.php
│   │   │   ├── ProductCompositeController.php
│   │   │   ├── RequestController.php
│   │   │   ├── ReportController.php
│   │   │   ├── StockController.php
│   │   │   ├── StockMovementController.php
│   │   │   └── UserController.php
│   │   └── 📁 Requests/             # Validações de formulários
│   ├── 📁 Models/                   # Modelos Eloquent
│   │   ├── Product.php
│   │   ├── ProductComponent.php
│   │   ├── Request.php
│   │   ├── RequestItem.php
│   │   ├── Stock.php
│   │   ├── StockMovement.php
│   │   └── User.php
│   ├── 📁 Services/                 # Camada de serviços
│   │   └── RequestService.php
│   └── 📁 Repositories/             # Camada de repositórios
│       └── RequestRepository.php
├── 📁 database/
│   ├── 📁 migrations/               # Migrações do banco
│   ├── 📁 seeders/                  # Seeders para dados de teste
│   ├── 📁 factories/                # Factories para testes
│   └── 📁 sql/                      # Arquivos SQL para relatórios
│       ├── 01_estrutura_relacional.sql
│       ├── 02_relatorio_entrada_estoque.sql
│       ├── 03_relatorio_saida_estoque.sql
│       ├── 04_relatorio_requisicoes.sql
│       └── README.md
├── 📁 resources/
│   ├── 📁 views/                    # Templates Blade
│   │   ├── 📁 admin/                # Views administrativas
│   │   │   ├── 📁 products/         # Gestão de produtos
│   │   │   ├── 📁 requests/         # Gestão de requisições
│   │   │   ├── 📁 reports/          # Relatórios
│   │   │   ├── 📁 stocks/           # Controle de estoque
│   │   │   └── 📁 users/            # Gestão de usuários
│   │   ├── 📁 components/           # Componentes Blade reutilizáveis
│   │   └── 📁 layouts/              # Layouts base
│   ├── 📁 css/                      # Estilos CSS
│   └── 📁 js/                       # Scripts JavaScript
├── 📁 routes/                       # Definição de rotas
│   ├── web.php                      # Rotas principais
│   ├── products.php                 # Rotas de produtos
│   ├── requests.php                 # Rotas de requisições
│   ├── reports.php                  # Rotas de relatórios
│   ├── stocks.php                   # Rotas de estoque
│   └── users.php                    # Rotas de usuários
├── 📁 storage/                      # Arquivos de storage
├── 📁 tests/                        # Testes automatizados
├── 📄 .env.example                  # Configurações de ambiente
├── 📄 composer.json                 # Dependências PHP
├── 📄 package.json                  # Dependências Node.js
├── 📄 artisan                       # Console Laravel
└── 📄 README.md                     # Este arquivo
```

---

## ⚙️ Configuração do Ambiente

### Requisitos do Sistema

-   **PHP**: 8.1 ou superior
-   **Composer**: 2.0 ou superior
-   **MySQL**: 8.0 ou superior
-   **Node.js**: 16.0 ou superior
-   **NPM**: 8.0 ou superior

### Extensões PHP Necessárias

```bash
# Extensões obrigatórias
- BCMath PHP Extension
- Ctype PHP Extension
- cURL PHP Extension
- DOM PHP Extension
- Fileinfo PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PCRE PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
```

---

## 🔧 Instalação e Setup

### 1. Clone o Repositório

```bash
git clone https://github.com/DaniloCHGS/teste-zamix.git
cd teste-zamix
```

### 2. Instale as Dependências PHP

```bash
composer install
```

### 3. Configure o Ambiente

```bash
# Copie o arquivo de configuração
cp .env.example .env

# Gere a chave da aplicação
php artisan key:generate
```

### 4. Configure o Banco de Dados

Edite o arquivo `.env` com suas configurações:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=zamix_estoque
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

### 5. Execute as Migrações

```bash
# Execute as migrações
php artisan migrate

# Execute os seeders (opcional)
php artisan db:seed
```

### 6. Instale as Dependências Frontend

```bash
npm install
npm run dev
```

### 7. Configure o Storage

```bash
# Crie o link simbólico para storage
php artisan storage:link
```

### 8. Inicie o Servidor

```bash
# Desenvolvimento
php artisan serve

# Ou com host específico
php artisan serve --host=0.0.0.0 --port=8000
```

### 9. Acesse a Aplicação

Abra seu navegador e acesse: `http://localhost:8000`

---

## 📊 Banco de Dados

### Estrutura Principal

O sistema utiliza as seguintes tabelas principais:

-   **`users`** - Usuários do sistema
-   **`products`** - Produtos (simples e compostos)
-   **`product_components`** - Componentes de produtos compostos
-   **`requests`** - Requisições de produtos
-   **`request_items`** - Itens das requisições
-   **`stocks`** - Controle de estoque
-   **`stock_movements`** - Histórico de movimentações

### Arquivos SQL

O projeto inclui arquivos SQL completos em `database/sql/`:

-   **`01_estrutura_relacional.sql`** - Criação da estrutura completa
-   **`02_relatorio_entrada_estoque.sql`** - Queries para relatório de entrada
-   **`03_relatorio_saida_estoque.sql`** - Queries para relatório de saída
-   **`04_relatorio_requisicoes.sql`** - Queries para análise de requisições

### Migrações

```bash
# Criar nova migração
php artisan make:migration nome_da_migracao

# Executar migrações
php artisan migrate

# Reverter migrações
php artisan migrate:rollback

# Reset completo
php artisan migrate:fresh --seed
```

---

## 🎨 Interface e UX

### Design System

-   **Framework CSS**: Tailwind CSS 3.x
-   **Ícones**: Lucide Icons (SVG)
-   **JavaScript**: Alpine.js para interatividade
-   **Responsividade**: Mobile-first design

### Componentes Reutilizáveis

-   **`x-alert`** - Mensagens de feedback
-   **`x-button`** - Botões padronizados
-   **`x-table`** - Tabelas responsivas

### Características da Interface

-   ✅ **Responsiva**: Funciona em desktop, tablet e mobile
-   ✅ **Acessível**: Seguindo padrões de acessibilidade
-   ✅ **Intuitiva**: Navegação clara e objetiva
-   ✅ **Moderno**: Design atual e profissional
-   ✅ **Performance**: Carregamento rápido e otimizado

---

## 📈 Relatórios

### Tipos de Relatórios Disponíveis

1. **Relatório de Entrada de Estoque**

    - Produtos que entraram no estoque
    - Inclui produtos simples e compostos
    - Cálculo de custos e valores de venda
    - Filtros por período e usuário

2. **Relatório de Saída de Estoque**

    - Produtos retirados do estoque
    - Decomposição de produtos compostos
    - Foco em produtos simples
    - Cálculo de custos totais

3. **Relatório de Requisições**
    - Análise detalhada das requisições
    - Estatísticas por usuário e produto
    - Análise temporal
    - Decomposição de produtos compostos

### Funcionalidades dos Relatórios

-   ✅ **Filtros Avançados**: Data inicial, data final, usuário
-   ✅ **Exportação PDF**: Relatórios em formato PDF
-   ✅ **Totais Automáticos**: Cálculos de custos e valores
-   ✅ **Decomposição**: Produtos compostos em componentes
-   ✅ **Performance**: Queries otimizadas

---

## 🧪 Testes

### Executando Testes

```bash
# Executar todos os testes
php artisan test

# Executar testes específicos
php artisan test --filter NomeDoTeste

# Executar com coverage (se configurado)
php artisan test --coverage
```

### Estrutura de Testes

```
tests/
├── 📁 Feature/          # Testes de funcionalidades
│   ├── ProductTest.php
│   ├── RequestTest.php
│   └── ReportTest.php
└── 📁 Unit/             # Testes unitários
    ├── ProductTest.php
    └── RequestTest.php
```

---

## 📚 Documentação

### Documentação Técnica

-   **`IMPLEMENTACAO_COMPLETA.md`** - Documentação completa da implementação
-   **`database/sql/README.md`** - Documentação dos arquivos SQL
-   **Comentários no código** - Documentação inline

### APIs e Endpoints

O sistema utiliza rotas RESTful organizadas por módulo:

-   **`/produtos/*`** - Gestão de produtos
-   **`/requisicoes/*`** - Gestão de requisições
-   **`/estoque/*`** - Controle de estoque
-   **`/relatorios/*`** - Geração de relatórios
-   **`/usuarios/*`** - Gestão de usuários

---

## 🤝 Contribuição

### Padrões de Código

-   **PSR-12** - Padrões de codificação PHP
-   **Laravel Conventions** - Convenções do Laravel
-   **Clean Code** - Código limpo e legível
-   **SOLID Principles** - Princípios SOLID

### Processo de Contribuição

1. Fork o projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

### Checklist de Qualidade

-   ✅ Código segue padrões PSR-12
-   ✅ Testes passando
-   ✅ Documentação atualizada
-   ✅ Interface responsiva
-   ✅ Performance otimizada

---

## 📄 Licença

Este projeto está licenciado sob a Licença MIT - veja o arquivo [LICENSE](LICENSE) para detalhes.

---

## 👨‍💻 Desenvolvedor

**Desenvolvido para a Zamix**

-   **Tecnologias**: Laravel, PHP, MySQL, Tailwind CSS
-   **Arquitetura**: MVC, Repository Pattern, Service Layer
-   **Qualidade**: Código limpo, testável e documentado
-   **Performance**: Otimizado para produção

---

## 🎯 Conclusão

Este sistema representa uma solução completa e profissional para gestão de estoque, desenvolvida com as melhores práticas de desenvolvimento web moderno. A arquitetura escalável, interface intuitiva e funcionalidades robustas tornam esta aplicação ideal para uso em ambiente corporativo.

**🚀 Sistema pronto para produção!**

---

_Desenvolvido com ❤️ para a Zamix_
