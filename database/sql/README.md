# Arquivos SQL - Sistema de Gestão de Estoque

Este diretório contém os arquivos SQL necessários para o funcionamento completo do sistema de gestão de estoque.

## 📁 Estrutura dos Arquivos

### 1. `01_estrutura_relacional.sql`

**Descrição:** Script completo para criação da estrutura relacional do banco de dados.

**Conteúdo:**

-   Tabela `users` - Usuários do sistema
-   Tabela `products` - Produtos (simples e compostos)
-   Tabela `product_components` - Componentes de produtos compostos
-   Tabela `requests` - Requisições de produtos
-   Tabela `request_items` - Itens das requisições
-   Tabela `stocks` - Controle de estoque
-   Tabela `stock_movements` - Movimentações de estoque
-   Tabelas de suporte: `sessions`, `cache`, `jobs`, `failed_jobs`
-   Índices para otimização de performance

### 2. `02_relatorio_entrada_estoque.sql`

**Descrição:** Queries para geração do relatório de entrada de estoque.

**Queries Incluídas:**

-   Query principal com agrupamento por produto
-   Query detalhada por requisição
-   Query para cálculo de totais
-   Query para produtos simples apenas
-   Query para produtos compostos apenas

**Parâmetros:**

-   `data_inicial` - Data de início do período
-   `data_final` - Data de fim do período
-   `filtro_usuario` - 'todos' ou ID específico do usuário
-   `user_id` - ID do usuário (quando filtro específico)

### 3. `03_relatorio_saida_estoque.sql`

**Descrição:** Queries para geração do relatório de saída de estoque.

**Queries Incluídas:**

-   Query principal para produtos simples
-   Query para decomposição de produtos compostos
-   Query combinada (simples + componentes)
-   Query para cálculo de totais
-   Query detalhada para auditoria

**Características Especiais:**

-   Decomposição automática de produtos compostos
-   Cálculo de componentes simples retirados
-   Suporte a filtros por período e usuário

### 4. `04_relatorio_requisicoes.sql`

**Descrição:** Queries para geração do relatório de requisições de produtos.

**Queries Incluídas:**

-   Query principal com resumo por requisição
-   Query detalhada com itens
-   Query para produtos mais requisitados
-   Query para usuários que mais fizeram requisições
-   Query para resumo por tipo de produto
-   Query para totais gerais
-   Query para análise por período (diário)
-   Query para produtos compostos com componentes

## 🔧 Como Usar

### Execução da Estrutura

```sql
-- Para criar o banco de dados
mysql -u usuario -p nome_do_banco < 01_estrutura_relacional.sql
```

### Execução dos Relatórios

```sql
-- Exemplo de uso das queries de relatório
-- Substitua os parâmetros (?) pelos valores desejados

-- Relatório de entrada (período: 01/01/2024 a 31/01/2024, todos os usuários)
SELECT * FROM (
    -- Cole aqui a query principal do arquivo 02_relatorio_entrada_estoque.sql
) AS relatorio_entrada
WHERE data_inicial = '2024-01-01'
  AND data_final = '2024-01-31'
  AND filtro_usuario = 'todos';
```

## 📊 Estrutura de Dados

### Relacionamentos Principais

-   **Users** → **Requests** (1:N)
-   **Requests** → **RequestItems** (1:N)
-   **Products** → **RequestItems** (1:N)
-   **Products** → **ProductComponents** (1:N) - Auto-relacionamento
-   **Products** → **Stocks** (1:1)
-   **Products** → **StockMovements** (1:N)
-   **Users** → **StockMovements** (1:N)

### Tipos de Produtos

-   **Simple**: Produtos básicos com preço de custo e venda
-   **Composite**: Produtos compostos por outros produtos simples

## 🎯 Funcionalidades dos Relatórios

### Relatório de Entrada

-   Mostra produtos que deram entrada no estoque
-   Inclui produtos simples e compostos
-   Calcula custos e valores de venda
-   Suporte a filtros por período e usuário

### Relatório de Saída

-   Mostra produtos retirados do estoque
-   Decompõe produtos compostos em componentes
-   Foca em produtos simples para controle de estoque
-   Calcula custos totais

### Relatório de Requisições

-   Análise detalhada das requisições
-   Estatísticas por usuário e produto
-   Análise temporal (diária)
-   Decomposição de produtos compostos

## ⚠️ Observações Importantes

1. **Parâmetros:** Todas as queries usam parâmetros (?) que devem ser substituídos pelos valores reais
2. **Performance:** Índices foram criados para otimizar as consultas
3. **Integridade:** Foreign keys garantem a integridade referencial
4. **Flexibilidade:** Queries suportam filtros opcionais por usuário

## 🔄 Compatibilidade

-   **Banco de Dados:** MySQL/MariaDB
-   **Versão:** 5.7+ ou 8.0+
-   **Charset:** UTF-8
-   **Engine:** InnoDB (recomendado)

## 📝 Notas de Implementação

Estes arquivos SQL complementam a implementação Laravel do sistema, fornecendo:

-   Scripts de criação de banco
-   Queries otimizadas para relatórios
-   Flexibilidade para uso direto em SQL
-   Documentação completa das estruturas
