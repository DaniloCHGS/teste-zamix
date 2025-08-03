-- =====================================================
-- RELATÓRIO DE REQUISIÇÕES DE PRODUTOS
-- =====================================================
-- Este relatório mostra as requisições de produtos realizadas no sistema
-- incluindo detalhes dos itens e valores
-- =====================================================

-- Query principal para relatório de requisições
SELECT 
    r.id AS REQUISICAO_ID,
    u.name AS USUARIO,
    r.requested_at AS DATA_REQUISICAO,
    COUNT(ri.id) AS TOTAL_ITENS,
    SUM(ri.quantity) AS TOTAL_QUANTIDADE,
    SUM(ri.quantity * p.cost_price) AS TOTAL_CUSTO,
    SUM(ri.quantity * p.sale_price) AS TOTAL_VENDA
FROM requests r
INNER JOIN users u ON r.user_id = u.id
INNER JOIN request_items ri ON r.id = ri.request_id
INNER JOIN products p ON ri.product_id = p.id
WHERE r.requested_at BETWEEN ? AND ?  -- Parâmetros: data_inicial, data_final
    AND (? = 'todos' OR r.user_id = ?)  -- Parâmetros: filtro_usuario, user_id
GROUP BY r.id, u.name, r.requested_at
ORDER BY r.requested_at DESC;

-- Query detalhada com itens das requisições
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
FROM requests r
INNER JOIN users u ON r.user_id = u.id
INNER JOIN request_items ri ON r.id = ri.request_id
INNER JOIN products p ON ri.product_id = p.id
WHERE r.requested_at BETWEEN ? AND ?  -- Parâmetros: data_inicial, data_final
    AND (? = 'todos' OR r.user_id = ?)  -- Parâmetros: filtro_usuario, user_id
ORDER BY r.requested_at DESC, p.name;

-- Query para produtos mais requisitados
SELECT 
    p.name AS PRODUTO,
    p.type AS TIPO_PRODUTO,
    COUNT(DISTINCT r.id) AS TOTAL_REQUISICOES,
    SUM(ri.quantity) AS TOTAL_QUANTIDADE,
    SUM(ri.quantity * p.cost_price) AS TOTAL_CUSTO,
    SUM(ri.quantity * p.sale_price) AS TOTAL_VENDA
FROM request_items ri
INNER JOIN products p ON ri.product_id = p.id
INNER JOIN requests r ON ri.request_id = r.id
WHERE r.requested_at BETWEEN ? AND ?  -- Parâmetros: data_inicial, data_final
    AND (? = 'todos' OR r.user_id = ?)  -- Parâmetros: filtro_usuario, user_id
GROUP BY p.id, p.name, p.type
ORDER BY TOTAL_QUANTIDADE DESC;

-- Query para usuários que mais fizeram requisições
SELECT 
    u.name AS USUARIO,
    COUNT(DISTINCT r.id) AS TOTAL_REQUISICOES,
    SUM(ri.quantity) AS TOTAL_QUANTIDADE,
    SUM(ri.quantity * p.cost_price) AS TOTAL_CUSTO,
    SUM(ri.quantity * p.sale_price) AS TOTAL_VENDA
FROM requests r
INNER JOIN users u ON r.user_id = u.id
INNER JOIN request_items ri ON r.id = ri.request_id
INNER JOIN products p ON ri.product_id = p.id
WHERE r.requested_at BETWEEN ? AND ?  -- Parâmetros: data_inicial, data_final
    AND (? = 'todos' OR r.user_id = ?)  -- Parâmetros: filtro_usuario, user_id
GROUP BY u.id, u.name
ORDER BY TOTAL_REQUISICOES DESC;

-- Query para resumo por tipo de produto
SELECT 
    p.type AS TIPO_PRODUTO,
    COUNT(DISTINCT r.id) AS TOTAL_REQUISICOES,
    COUNT(ri.id) AS TOTAL_ITENS,
    SUM(ri.quantity) AS TOTAL_QUANTIDADE,
    SUM(ri.quantity * p.cost_price) AS TOTAL_CUSTO,
    SUM(ri.quantity * p.sale_price) AS TOTAL_VENDA
FROM request_items ri
INNER JOIN products p ON ri.product_id = p.id
INNER JOIN requests r ON ri.request_id = r.id
WHERE r.requested_at BETWEEN ? AND ?  -- Parâmetros: data_inicial, data_final
    AND (? = 'todos' OR r.user_id = ?)  -- Parâmetros: filtro_usuario, user_id
GROUP BY p.type
ORDER BY p.type;

-- Query para totais gerais do relatório
SELECT 
    COUNT(DISTINCT r.id) AS TOTAL_REQUISICOES,
    COUNT(DISTINCT u.id) AS TOTAL_USUARIOS,
    COUNT(DISTINCT p.id) AS TOTAL_PRODUTOS,
    SUM(ri.quantity) AS TOTAL_QUANTIDADE,
    SUM(ri.quantity * p.cost_price) AS TOTAL_CUSTO,
    SUM(ri.quantity * p.sale_price) AS TOTAL_VENDA,
    AVG(ri.quantity) AS MEDIA_QUANTIDADE_POR_ITEM
FROM requests r
INNER JOIN users u ON r.user_id = u.id
INNER JOIN request_items ri ON r.id = ri.request_id
INNER JOIN products p ON ri.product_id = p.id
WHERE r.requested_at BETWEEN ? AND ?  -- Parâmetros: data_inicial, data_final
    AND (? = 'todos' OR r.user_id = ?);  -- Parâmetros: filtro_usuario, user_id

-- Query para requisições por período (diário)
SELECT 
    DATE(r.requested_at) AS DATA,
    COUNT(DISTINCT r.id) AS TOTAL_REQUISICOES,
    SUM(ri.quantity) AS TOTAL_QUANTIDADE,
    SUM(ri.quantity * p.cost_price) AS TOTAL_CUSTO,
    SUM(ri.quantity * p.sale_price) AS TOTAL_VENDA
FROM requests r
INNER JOIN request_items ri ON r.id = ri.request_id
INNER JOIN products p ON ri.product_id = p.id
WHERE r.requested_at BETWEEN ? AND ?  -- Parâmetros: data_inicial, data_final
    AND (? = 'todos' OR r.user_id = ?)  -- Parâmetros: filtro_usuario, user_id
GROUP BY DATE(r.requested_at)
ORDER BY DATA DESC;

-- Query para produtos compostos com seus componentes
SELECT 
    r.id AS REQUISICAO_ID,
    u.name AS USUARIO,
    r.requested_at AS DATA_REQUISICAO,
    p.name AS PRODUTO_COMPOSTO,
    ri.quantity AS QUANTIDADE_REQUISITADA,
    p_component.name AS COMPONENTE,
    pc.quantity AS QUANTIDADE_COMPONENTE,
    (ri.quantity * pc.quantity) AS QUANTIDADE_TOTAL_COMPONENTE,
    p_component.cost_price AS PRECO_CUSTO_COMPONENTE,
    (ri.quantity * pc.quantity * p_component.cost_price) AS CUSTO_TOTAL_COMPONENTE
FROM requests r
INNER JOIN users u ON r.user_id = u.id
INNER JOIN request_items ri ON r.id = ri.request_id
INNER JOIN products p ON ri.product_id = p.id
INNER JOIN product_components pc ON p.id = pc.product_id
INNER JOIN products p_component ON pc.component_id = p_component.id
WHERE p.type = 'composite'
    AND r.requested_at BETWEEN ? AND ?  -- Parâmetros: data_inicial, data_final
    AND (? = 'todos' OR r.user_id = ?)  -- Parâmetros: filtro_usuario, user_id
ORDER BY r.requested_at DESC, p.name, p_component.name; 