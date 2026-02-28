-- ============================================
-- Script para agregar columna 'name' a la tabla users
-- Ejecuta este script en phpMyAdmin
-- ============================================

-- Verificar estructura actual
DESCRIBE users;

-- Agregar columna 'name' si no existe
ALTER TABLE users 
ADD COLUMN IF NOT EXISTS name VARCHAR(100) NOT NULL DEFAULT 'Administrador' AFTER id;

-- Actualizar usuarios existentes que no tengan nombre
UPDATE users SET name = 'Administrador' WHERE name = '' OR name IS NULL;

-- Verificar cambios
DESCRIBE users;
SELECT id, name, email, role FROM users;

-- ============================================
-- RESULTADO ESPERADO:
-- ============================================
-- La tabla users debe tener estas columnas:
-- - id
-- - name (NUEVO)
-- - email
-- - password
-- - role
-- - created_at
-- - updated_at
-- ============================================
