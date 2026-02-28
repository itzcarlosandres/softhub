-- Agregar columna trending a la tabla software
ALTER TABLE `software` ADD COLUMN `trending` TINYINT(1) NOT NULL DEFAULT 0 AFTER `featured`;

-- Índice para mejorar el rendimiento
CREATE INDEX idx_trending ON software(trending);
