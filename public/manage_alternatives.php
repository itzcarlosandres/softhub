<?php
/**
 * Gestor de Alternativas de Software
 */

require_once __DIR__ . '/../app/EnvLoader.php';
require_once __DIR__ . '/../app/Database.php';

EnvLoader::load(dirname(__DIR__));

$db = \App\Database::getInstance()->getConnection();

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['software_id'], $_POST['alternative_id'])) {
    $softwareId = $_POST['software_id'];
    $alternativeId = $_POST['alternative_id'];
    $action = $_POST['action'] ?? 'add';
    
    if ($action === 'add' && $softwareId != $alternativeId) {
        try {
            $stmt = $db->prepare("
                INSERT IGNORE INTO software_alternatives (software_id, alternative_id) 
                VALUES (?, ?)
            ");
            $stmt->execute([$softwareId, $alternativeId]);
            
            // También agregar la relación inversa
            $stmt->execute([$alternativeId, $softwareId]);
            
            $message = "✅ Alternativa agregada exitosamente";
            $messageType = "success";
        } catch (Exception $e) {
            $message = "❌ Error: " . $e->getMessage();
            $messageType = "error";
        }
    } elseif ($action === 'remove') {
        $stmt = $db->prepare("DELETE FROM software_alternatives WHERE software_id = ? AND alternative_id = ?");
        $stmt->execute([$softwareId, $alternativeId]);
        $stmt->execute([$alternativeId, $softwareId]);
        
        $message = "✅ Alternativa eliminada";
        $messageType = "success";
    }
}

// Obtener lista de software
$stmt = $db->query("SELECT id, name, icon FROM software WHERE status = 'approved' ORDER BY name");
$softwareList = $stmt->fetchAll();

// Si se seleccionó un software, obtener sus alternativas
$selectedSoftware = null;
$alternatives = [];
if (isset($_GET['software_id'])) {
    $softwareId = $_GET['software_id'];
    
    $stmt = $db->prepare("SELECT * FROM software WHERE id = ?");
    $stmt->execute([$softwareId]);
    $selectedSoftware = $stmt->fetch();
    
    if ($selectedSoftware) {
        $stmt = $db->prepare("
            SELECT s.* 
            FROM software s
            INNER JOIN software_alternatives sa ON s.id = sa.alternative_id
            WHERE sa.software_id = ?
        ");
        $stmt->execute([$softwareId]);
        $alternatives = $stmt->fetchAll();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Alternativas</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 1200px; margin: 50px auto; padding: 20px; background: #f5f5f5; }
        h1 { color: #333; }
        .container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .message { padding: 15px; margin: 20px 0; border-radius: 5px; }
        .message.success { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; }
        .message.error { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; }
        .form-group { margin: 20px 0; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; }
        button { background: #007bff; color: white; border: none; padding: 12px 24px; border-radius: 5px; cursor: pointer; font-size: 16px; }
        button:hover { background: #0056b3; }
        .alternatives-list { margin-top: 30px; }
        .alternative-item { display: flex; align-items: center; gap: 15px; padding: 15px; background: #f8f9fa; border-radius: 5px; margin: 10px 0; }
        .alternative-item img { width: 50px; height: 50px; object-fit: contain; }
        .alternative-item .info { flex: 1; }
        .alternative-item .remove { background: #dc3545; padding: 8px 16px; border-radius: 5px; color: white; text-decoration: none; }
        .alternative-item .remove:hover { background: #c82333; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔄 Gestión de Alternativas de Software</h1>
        
        <?php if (isset($message)): ?>
            <div class="message <?= $messageType ?>">
                <?= $message ?>
            </div>
        <?php endif; ?>
        
        <div class="grid">
            <!-- Seleccionar Software -->
            <div>
                <div class="form-group">
                    <label>1. Selecciona el software principal:</label>
                    <select onchange="window.location.href='?software_id=' + this.value">
                        <option value="">-- Seleccionar software --</option>
                        <?php foreach ($softwareList as $soft): ?>
                            <option value="<?= $soft['id'] ?>" <?= isset($_GET['software_id']) && $_GET['software_id'] == $soft['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($soft['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <!-- Agregar Alternativa -->
            <?php if ($selectedSoftware): ?>
            <div>
                <form method="POST">
                    <input type="hidden" name="software_id" value="<?= $selectedSoftware['id'] ?>">
                    <input type="hidden" name="action" value="add">
                    
                    <div class="form-group">
                        <label>2. Selecciona una alternativa:</label>
                        <select name="alternative_id" required>
                            <option value="">-- Seleccionar alternativa --</option>
                            <?php foreach ($softwareList as $soft): ?>
                                <?php if ($soft['id'] != $selectedSoftware['id']): ?>
                                    <option value="<?= $soft['id'] ?>">
                                        <?= htmlspecialchars($soft['name']) ?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <button type="submit">➕ Agregar Alternativa</button>
                </form>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- Lista de Alternativas -->
        <?php if ($selectedSoftware): ?>
            <div class="alternatives-list">
                <h2>Alternativas de "<?= htmlspecialchars($selectedSoftware['name']) ?>"</h2>
                
                <?php if (empty($alternatives)): ?>
                    <p style="color: #666; font-style: italic;">No hay alternativas configuradas aún.</p>
                <?php else: ?>
                    <?php foreach ($alternatives as $alt): ?>
                        <div class="alternative-item">
                            <?php if (!empty($alt['icon'])): ?>
                                <img src="<?= env('APP_URL') . '/' . $alt['icon'] ?>" alt="<?= htmlspecialchars($alt['name']) ?>">
                            <?php else: ?>
                                <div style="width: 50px; height: 50px; background: #eee; display: flex; align-items: center; justify-content: center; border-radius: 5px;">
                                    <i class="fas fa-download"></i>
                                </div>
                            <?php endif; ?>
                            
                            <div class="info">
                                <strong><?= htmlspecialchars($alt['name']) ?></strong>
                                <p style="margin: 5px 0 0 0; color: #666; font-size: 14px;">
                                    <?= htmlspecialchars($alt['short_description'] ?? '') ?>
                                </p>
                            </div>
                            
                            <form method="POST" style="margin: 0;">
                                <input type="hidden" name="software_id" value="<?= $selectedSoftware['id'] ?>">
                                <input type="hidden" name="alternative_id" value="<?= $alt['id'] ?>">
                                <input type="hidden" name="action" value="remove">
                                <button type="submit" class="alternative-item remove" onclick="return confirm('¿Eliminar esta alternativa?')">
                                    🗑️ Eliminar
                                </button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <br>
        <p>
            <a href="<?= env('APP_URL') ?: '/laravel/public' ?>">← Volver al sitio</a> | 
            <a href="<?= env('APP_URL') ?: '/laravel/public' ?>/admin/software">Admin Software</a>
        </p>
    </div>
</body>
</html>
