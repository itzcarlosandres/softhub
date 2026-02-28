-- Script para limpiar referencias huérfanas de categorías eliminadas
-- Este script actualiza los software que tienen category_id de categorías que ya no existen

-- Establecer category_id a NULL para software con categorías eliminadas
UPDATE software s 
LEFT JOIN categories c ON s.category_id = c.id 
SET s.category_id = NULL 
WHERE s.category_id IS NOT NULL AND c.id IS NULL;

-- Verificar cuántos software quedaron sin categoría
SELECT COUNT(*) as software_sin_categoria 
FROM software 
WHERE category_id IS NULL;

-- Ver lista de software sin categoría (para revisión)
SELECT id, name, category_id 
FROM software 
WHERE category_id IS NULL 
ORDER BY name;
