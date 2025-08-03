-- =====================================================
-- RELATÓRIO DE SAÍDA DE ESTOQUE
-- =====================================================
-- Este relatório mostra quais produtos e quantidades foram retirados do estoque
-- através de requisições. Para produtos compostos, mostra os componentes simples
-- =====================================================

-- Query principal para relatório de saída de estoque (produtos simples)
SELECT 
    p.name AS PRODUTO,
    SUM(ri.quantity) AS QTDE_RETIRADA_ESTOQUE,
    SUM(ri.quantity * p.cost_price) AS PRECO_CUSTO_TOTAL
FROM request_items ri
INNER JOIN products p ON ri.product_id = p.id
INNER JOIN requests r ON ri.request_id = r.id
WHERE p.type = 'simple'
    AND r.requested_at BETWEEN ? AND ?  -- Parâmetros: data_inicial, data_final
    AND (? = 'todos' OR r.user_id = ?)  -- Parâmetros: filtro_usuario, user_id
GROUP BY p.id, p.name
ORDER BY p.name;

-- Query para decomposição de produtos compostos (componentes simples)
SELECT 
    p_component.name AS PRODUTO,
    SUM(ri.quantity * pc.quantity) AS QTDE_RETIRADA_ESTOQUE,
    SUM(ri.quantity * pc.quantity * p_component.cost_price) AS PRECO_CUSTO_TOTAL
FROM request_items ri
INNER JOIN products p ON ri.product_id = p.id
INNER JOIN product_components pc ON p.id = pc.product_id
INNER JOIN products p_component ON pc.component_id = p_component.id
INNER JOIN requests r ON ri.request_id = r.id
WHERE p.type = 'composite'
    AND p_component.type = 'simple'
    AND r.requested_at BETWEEN ? AND ?  -- Parâmetros: data_inicial, data_final
    AND (? = 'todos' OR r.user_id = ?)  -- Parâmetros: filtro_usuario, user_id
GROUP BY p_component.id, p_component.name
ORDER BY p_component.name;

-- Query combinada: produtos simples + componentes de produtos compostos
SELECT 
    p.name AS PRODUTO,
    SUM(ri.quantity) AS QTDE_RETIRADA_ESTOQUE,
    SUM(ri.quantity * p.cost_price) AS PRECO_CUSTO_TOTAL
FROM request_items ri
INNER JOIN products p ON ri.product_id = p.id
INNER JOIN requests r ON ri.request_id = r.id
WHERE p.type = 'simple'
    AND r.requested_at BETWEEN ? AND ?  -- Parâmetros: data_inicial, data_final
    AND (? = 'todos' OR r.user_id = ?)  -- Parâmetros: filtro_usuario, user_id
GROUP BY p.id, p.name

UNION ALL

SELECT 
    p_component.name AS PRODUTO,
    SUM(ri.quantity * pc.quantity) AS QTDE_RETIRADA_ESTOQUE,
    SUM(ri.quantity * pc.quantity * p_component.cost_price) AS PRECO_CUSTO_TOTAL
FROM request_items ri
INNER JOIN products p ON ri.product_id = p.id
INNER JOIN product_components pc ON p.id = pc.product_id
INNER JOIN products p_component ON pc.component_id = p_component.id
INNER JOIN requests r ON ri.request_id = r.id
WHERE p.type = 'composite'
    AND p_component.type = 'simple'
    AND r.requested_at BETWEEN ? AND ?  -- Parâmetros: data_inicial, data_final
    AND (? = 'todos' OR r.user_id = ?)  -- Parâmetros: filtro_usuario, user_id
GROUP BY p_component.id, p_component.name
ORDER BY PRODUTO;

-- Query para totais do relatório de saída
SELECT 
    COUNT(DISTINCT p.id) AS TOTAL_PRODUTOS_SIMPLES,
    SUM(ri.quantity) AS TOTAL_QUANTIDADE_SIMPLES,
    SUM(ri.quantity * p.cost_price) AS TOTAL_CUSTO_SIMPLES
FROM request_items ri
INNER JOIN products p ON ri.product_id = p.id
INNER JOIN requests r ON ri.request_id = r.id
WHERE p.type = 'simple'
    AND r.requested_at BETWEEN ? AND ?  -- Parâmetros: data_inicial, data_final
    AND (? = 'todos' OR r.user_id = ?)  -- Parâmetros: filtro_usuario, user_id

UNION ALL

SELECT 
    COUNT(DISTINCT p_component.id) AS TOTAL_COMPONENTES,
    SUM(ri.quantity * pc.quantity) AS TOTAL_QUANTIDADE_COMPONENTES,
    SUM(ri.quantity * pc.quantity * p_component.cost_price) AS TOTAL_CUSTO_COMPONENTES
FROM request_items ri
INNER JOIN products p ON ri.product_id = p.id
INNER JOIN product_components pc ON p.id = pc.product_id
INNER JOIN products p_component ON pc.component_id = p_component.id
INNER JOIN requests r ON ri.request_id = r.id
WHERE p.type = 'composite'
    AND p_component.type = 'simple'
    AND r.requested_at BETWEEN ? AND ?  -- Parâmetros: data_inicial, data_final
    AND (? = 'todos' OR r.user_id = ?);  -- Parâmetros: filtro_usuario, user_id

-- Query detalhada por requisição (para auditoria)
SELECT 
    r.id AS REQUISICAO_ID,
    u.name AS USUARIO,
    r.requested_at AS DATA_REQUISICAO,
    p.name AS PRODUTO_REQUISITADO,
    p.type AS TIPO_PRODUTO,
    ri.quantity AS QUANTIDADE_REQUISITADA,
    CASE 
        WHEN p.type = 'simple' THEN p.name
        ELSE CONCAT(p.name, ' (Componente)')
    END AS PRODUTO_SAIDA,
    CASE 
        WHEN p.type = 'simple' THEN ri.quantity
        ELSE (ri.quantity * pc.quantity)
    END AS QUANTIDADE_SAIDA,
    CASE 
        WHEN p.type = 'simple' THEN (ri.quantity * p.cost_price)
        ELSE (ri.quantity * pc.quantity * p_component.cost_price)
    END AS CUSTO_TOTAL
FROM request_items ri
INNER JOIN products p ON ri.product_id = p.id
INNER JOIN requests r ON ri.request_id = r.id
INNER JOIN users u ON r.user_id = u.id
LEFT JOIN product_components pc ON p.id = pc.product_id AND p.type = 'composite'
LEFT JOIN products p_component ON pc.component_id = p_component.id AND p.type = 'composite'
WHERE r.requested_at BETWEEN ? AND ?  -- Parâmetros: data_inicial, data_final
    AND (? = 'todos' OR r.user_id = ?)  -- Parâmetros: filtro_usuario, user_id
ORDER BY r.requested_at DESC, p.name; 