<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diagnóstico de Tabla Users</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 { color: #333; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #4CAF50;
            color: white;
        }
        .success { color: #4CAF50; }
        .error { color: #f44336; }
        .info { 
            background: #e3f2fd;
            padding: 15px;
            border-left: 4px solid #2196F3;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Diagnóstico de Tabla Users</h1>
        
        <?php
        require_once __DIR__ . '/../app/EnvLoader.php';
        require_once __DIR__ . '/../app/Database.php';
        
        EnvLoader::load(dirname(__DIR__));
        
        try {
            $db = \App\Database::getInstance()->getConnection();
            
            echo "<h2>✅ Conexión a Base de Datos: OK</h2>";
            
            // Mostrar estructura de la tabla
            echo "<h2>📋 Estructura de la tabla 'users':</h2>";
            $stmt = $db->query("DESCRIBE users");
            $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo "<table>";
            echo "<tr><th>Campo</th><th>Tipo</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
            
            $hasNameColumn = false;
            foreach ($columns as $column) {
                if ($column['Field'] === 'name') {
                    $hasNameColumn = true;
                }
                echo "<tr>";
                echo "<td><strong>" . htmlspecialchars($column['Field']) . "</strong></td>";
                echo "<td>" . htmlspecialchars($column['Type']) . "</td>";
                echo "<td>" . htmlspecialchars($column['Null']) . "</td>";
                echo "<td>" . htmlspecialchars($column['Key']) . "</td>";
                echo "<td>" . htmlspecialchars($column['Default'] ?? 'NULL') . "</td>";
                echo "<td>" . htmlspecialchars($column['Extra']) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            
            // Verificar columna 'name'
            if ($hasNameColumn) {
                echo "<div class='info success'>";
                echo "<strong>✅ La columna 'name' EXISTE</strong>";
                echo "</div>";
            } else {
                echo "<div class='info error'>";
                echo "<strong>❌ La columna 'name' NO EXISTE</strong>";
                echo "<p>Ejecuta este comando en phpMyAdmin:</p>";
                echo "<code>ALTER TABLE users ADD COLUMN name VARCHAR(100) NOT NULL DEFAULT 'Administrador' AFTER id;</code>";
                echo "</div>";
            }
            
            // Mostrar usuarios
            echo "<h2>👥 Usuarios en la base de datos:</h2>";
            $stmt = $db->query("SELECT * FROM users");
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (empty($users)) {
                echo "<p class='error'>No hay usuarios en la base de datos</p>";
            } else {
                echo "<table>";
                echo "<tr>";
                foreach (array_keys($users[0]) as $key) {
                    echo "<th>" . htmlspecialchars($key) . "</th>";
                }
                echo "</tr>";
                
                foreach ($users as $user) {
                    echo "<tr>";
                    foreach ($user as $key => $value) {
                        if ($key === 'password') {
                            echo "<td>***hidden***</td>";
                        } else {
                            echo "<td>" . htmlspecialchars($value ?? 'NULL') . "</td>";
                        }
                    }
                    echo "</tr>";
                }
                echo "</table>";
            }
            
            // Probar UPDATE
            echo "<h2>🧪 Prueba de UPDATE:</h2>";
            if ($hasNameColumn && !empty($users)) {
                $testUserId = $users[0]['id'];
                try {
                    $stmt = $db->prepare("UPDATE users SET name = ? WHERE id = ?");
                    $stmt->execute(['Test Name', $testUserId]);
                    echo "<p class='success'>✅ El UPDATE funciona correctamente</p>";
                    
                    // Revertir cambio
                    $stmt = $db->prepare("UPDATE users SET name = ? WHERE id = ?");
                    $stmt->execute(['Administrador', $testUserId]);
                } catch (Exception $e) {
                    echo "<p class='error'>❌ Error en UPDATE: " . htmlspecialchars($e->getMessage()) . "</p>";
                }
            }
            
        } catch (Exception $e) {
            echo "<div class='info error'>";
            echo "<strong>❌ Error:</strong> " . htmlspecialchars($e->getMessage());
            echo "</div>";
        }
        ?>
        
        <div style="margin-top: 30px; padding: 20px; background: #f9f9f9; border-radius: 5px;">
            <h3>📝 Soluciones:</h3>
            <ol>
                <li>Si la columna 'name' NO existe, ejecuta el ALTER TABLE en phpMyAdmin</li>
                <li>Si la columna existe pero hay error, verifica los permisos de la base de datos</li>
                <li>Si todo está OK aquí pero falla en el perfil, limpia la caché del navegador</li>
            </ol>
        </div>
    </div>
</body>
</html>
