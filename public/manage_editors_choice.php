<?php
/**
 * Script para probar manualmente el badge de Editor's Choice
 */

require_once __DIR__ . '/../app/EnvLoader.php';
require_once __DIR__ . '/../app/Database.php';

EnvLoader::load(dirname(__DIR__));

$db = \App\Database::getInstance()->getConnection();

// Obtener lista de software
$stmt = $db->query("SELECT id, name, badge_editors_choice FROM software ORDER BY name LIMIT 20");
$softwareList = $stmt->fetchAll();

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['software_id'])) {
    $softwareId = $_POST['software_id'];
    $badgeValue = isset($_POST['badge_editors_choice']) ? 1 : 0;
    
    $stmt = $db->prepare("UPDATE software SET badge_editors_choice = ? WHERE id = ?");
    $stmt->execute([$badgeValue, $softwareId]);
    
    echo "<div style='background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; margin: 20px 0; border-radius: 5px;'>";
    echo "✅ <strong>Badge actualizado exitosamente!</strong><br>";
    echo "Software ID: $softwareId<br>";
    echo "Badge Editor's Choice: " . ($badgeValue ? 'Activado ✓' : 'Desactivado ✗');
    echo "</div>";
    
    // Recargar lista
    $stmt = $db->query("SELECT id, name, badge_editors_choice FROM software ORDER BY name LIMIT 20");
    $softwareList = $stmt->fetchAll();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Editor's Choice</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
        h1 { color: #333; }
        .software-item { background: #f8f9fa; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #007bff; }
        .software-item.active { border-left-color: #28a745; background: #d4edda; }
        label { display: flex; align-items: center; cursor: pointer; }
        input[type="checkbox"] { width: 20px; height: 20px; margin-right: 10px; cursor: pointer; }
        button { background: #007bff; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-size: 16px; }
        button:hover { background: #0056b3; }
        .status { font-weight: bold; margin-left: auto; }
        .status.active { color: #28a745; }
        .status.inactive { color: #dc3545; }
    </style>
</head>
<body>
    <h1>🏆 Gestión de Editor's Choice</h1>
    <p>Marca o desmarca el checkbox para activar/desactivar el badge de Editor's Choice:</p>
    
    <?php foreach ($softwareList as $soft): ?>
        <form method="POST" class="software-item <?= $soft['badge_editors_choice'] ? 'active' : '' ?>">
            <input type="hidden" name="software_id" value="<?= $soft['id'] ?>">
            <label>
                <input type="checkbox" 
                       name="badge_editors_choice" 
                       value="1" 
                       <?= $soft['badge_editors_choice'] ? 'checked' : '' ?>
                       onchange="this.form.submit()">
                <strong><?= htmlspecialchars($soft['name']) ?></strong>
                <span class="status <?= $soft['badge_editors_choice'] ? 'active' : 'inactive' ?>">
                    <?= $soft['badge_editors_choice'] ? '✓ Activado' : '✗ Desactivado' ?>
                </span>
            </label>
        </form>
    <?php endforeach; ?>
    
    <br>
    <p>
        <a href="check_badges.php">Ver estado de todos los badges</a> | 
        <a href="<?= env('APP_URL') ?: '/laravel/public' ?>">Volver al sitio</a>
    </p>
</body>
</html>
