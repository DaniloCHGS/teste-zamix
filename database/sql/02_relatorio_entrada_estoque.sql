-- =====================================================
-- RELATÓRIO DE ENTRADA DE ESTOQUE
-- =====================================================
-- Este relatório mostra quais produtos e quantidades deram entrada no estoque
-- através de requisições, incluindo produtos simples e compostos
-- =====================================================

-- Query principal para relatório de entrada de estoque
SELECT 
    p.name AS PRODUTO,
    SUM(ri.quantity) AS QTDE_REQUISITADA,
    SUM(ri.quantity * p.cost_price) AS PRECO_CUSTO_TOTAL,
    SUM(ri.quantity * p.sale_price) AS PRECO_VENDA_TOTAL
FROM request_items ri
INNER JOIN products p ON ri.product_id = p.id
INNER JOIN requests r ON ri.request_id = r.id
WHERE r.requested_at BETWEEN ? AND ?  -- Parâmetros: data_inicial, data_final
    AND (? = 'todos' OR r.user_id = ?)  -- Parâmetros: filtro_usuario, user_id
GROUP BY p.id, p.name
ORDER BY p.name;

-- Query alternativa com informações detalhadas por requisição
SELECT 
    r.id AS REQUISICAO_ID,
    u.name AS USUARIO,
    r.requested_at AS DATA_REQUISICAO,
    p.name AS PRODUTO,
    p.type AS TIPO_PRODUTO,
    ri.quantity AS QUANTIDADE,
    p.cost_price AS PRECO_CUSTO_UNITARIO,
    p.sale_price AS PRECO_VENDA_UNITARIO,
    (ri.quantity * p.cost_price) AS PRECO_CUSTO_TOTAL,
    (ri.quantity * p.sale_price) AS PRECO_VENDA_TOTAL
FROM request_items ri
INNER JOIN products p ON ri.product_id = p.id
INNER JOIN requests r ON ri.request_id = r.id
INNER JOIN users u ON r.user_id = u.id
WHERE r.requested_at BETWEEN ? AND ?  -- Parâmetros: data_inicial, data_final
    AND (? = 'todos' OR r.user_id = ?)  -- Parâmetros: filtro_usuario, user_id
ORDER BY r.requested_at DESC, p.name;

-- Query para totais do relatório
SELECT 
    COUNT(DISTINCT p.id) AS TOTAL_PRODUTOS,
    SUM(ri.quantity) AS TOTAL_QUANTIDADE,
    SUM(ri.quantity * p.cost_price) AS TOTAL_CUSTO,
    SUM(ri.quantity * p.sale_price) AS TOTAL_VENDA
FROM request_items ri
INNER JOIN products p ON ri.product_id = p.id
INNER JOIN requests r ON ri.request_id = r.id
WHERE r.requested_at BETWEEN ? AND ?  -- Parâmetros: data_inicial, data_final
    AND (? = 'todos' OR r.user_id = ?);  -- Parâmetros: filtro_usuario, user_id

-- Query para produtos simples apenas
SELECT 
    p.name AS PRODUTO,
    SUM(ri.quantity) AS QTDE_REQUISITADA,
    SUM(ri.quantity * p.cost_price) AS PRECO_CUSTO_TOTAL,
    SUM(ri.quantity * p.sale_price) AS PRECO_VENDA_TOTAL
FROM request_items ri
INNER JOIN products p ON ri.product_id = p.id
INNER JOIN requests r ON ri.request_id = r.id
WHERE p.type = 'simple'
    AND r.requested_at BETWEEN ? AND ?  -- Parâmetros: data_inicial, data_final
    AND (? = 'todos' OR r.user_id = ?)  -- Parâmetros: filtro_usuario, user_id
GROUP BY p.id, p.name
ORDER BY p.name;

-- Query para produtos compostos apenas
SELECT 
    p.name AS PRODUTO,
    SUM(ri.quantity) AS QTDE_REQUISITADA,
    SUM(ri.quantity * p.sale_price) AS PRECO_VENDA_TOTAL
FROM request_items ri
INNER JOIN products p ON ri.product_id = p.id
INNER JOIN requests r ON ri.request_id = r.id
WHERE p.type = 'composite'
    AND r.requested_at BETWEEN ? AND ?  -- Parâmetros: data_inicial, data_final
    AND (? = 'todos' OR r.user_id = ?)  -- Parâmetros: filtro_usuario, user_id
GROUP BY p.id, p.name
ORDER BY p.name; 