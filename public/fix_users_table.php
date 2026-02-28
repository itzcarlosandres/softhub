<?php
/**
 * Script para verificar y actualizar la estructura de la tabla users
 */

require_once __DIR__ . '/../app/EnvLoader.php';
require_once __DIR__ . '/../app/Database.php';

EnvLoader::load(dirname(__DIR__));

echo "🔧 VERIFICANDO ESTRUCTURA DE LA TABLA USERS\n";
echo "==========================================\n\n";

try {
    $db = \App\Database::getInstance()->getConnection();
    
    // Verificar si existe la columna 'name'
    $stmt = $db->query("SHOW COLUMNS FROM users LIKE 'name'");
    $nameColumn = $stmt->fetch();
    
    if (!$nameColumn) {
        echo "❌ La columna 'name' NO existe\n";
        echo "📝 Agregando columna 'name'...\n";
        
        $db->exec("ALTER TABLE users ADD COLUMN name VARCHAR(100) NOT NULL DEFAULT 'Administrador' AFTER id");
        
        echo "✅ Columna 'name' agregada exitosamente\n\n";
    } else {
        echo "✅ La columna 'name' ya existe\n\n";
    }
    
    // Mostrar estructura actual de la tabla
    echo "📋 ESTRUCTURA ACTUAL DE LA TABLA USERS:\n";
    echo "---------------------------------------\n";
    
    $stmt = $db->query("DESCRIBE users");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($columns as $column) {
        echo sprintf(
            "%-20s %-20s %s\n",
            $column['Field'],
            $column['Type'],
            $column['Null'] === 'NO' ? 'NOT NULL' : 'NULL'
        );
    }
    
    echo "\n✅ Verificación completada\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
?>
