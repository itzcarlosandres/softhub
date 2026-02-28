<?php
$currentPage = 'profile';
ob_start();

// Obtener datos del usuario actual
$userId = $_SESSION['user_id'] ?? 0;
if (!$userId) { header('Location: ' . url('admin/login')); exit; }

$db = \App\Database::getInstance()->getConnection();
$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) { header('Location: ' . url('admin/login')); exit; }
?>

<div class="max-w-5xl mx-auto animate-fade-in-up">
    
    <!-- Profile Header -->
    <div class="glass-panel p-8 rounded-2xl mb-8 relative overflow-hidden flex flex-col md:flex-row items-center gap-8">
        <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-r from-blue-600/20 to-purple-600/20"></div>
        
        <!-- Avatar -->
        <div class="relative z-10 w-32 h-32 rounded-full border-4 border-[#0f172a] bg-gray-800 flex items-center justify-center shadow-2xl">
            <span class="text-4xl font-bold text-white"><?= strtoupper(substr($user['name'], 0, 1)) ?></span>
            <div class="absolute bottom-2 right-2 w-6 h-6 bg-green-500 border-4 border-[#0f172a] rounded-full"></div>
        </div>

        <!-- Info -->
        <div class="relative z-10 text-center md:text-left flex-1 mt-4 md:mt-8">
            <h1 class="text-3xl font-bold text-white font-outfit"><?= htmlspecialchars($user['name']) ?></h1>
            <p class="text-blue-400 font-medium mb-2">Administrador del Sistema</p>
            <div class="flex flex-wrap justify-center md:justify-start gap-3">
                <span class="px-3 py-1 rounded-full bg-white/5 border border-white/10 text-xs text-gray-400">
                    <i class="fas fa-envelope mr-1"></i> <?= htmlspecialchars($user['email']) ?>
                </span>
                <span class="px-3 py-1 rounded-full bg-white/5 border border-white/10 text-xs text-gray-400">
                    <i class="fas fa-calendar mr-1"></i> Miembro desde <?= date('M Y', strtotime($user['created_at'])) ?>
                </span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        
        <!-- Edit Profile -->
        <div class="glass-panel p-8 rounded-2xl relative overflow-hidden">
            <h2 class="text-xl font-bold text-white font-outfit mb-6 flex items-center gap-2">
                <i class="fas fa-user-edit text-blue-400"></i> Editar Información
            </h2>
            
            <form action="<?= url('admin/profile/update-info') ?>" method="POST" class="space-y-6">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Nombre Completo</label>
                    <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500/50 transition-all placeholder-gray-600">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Correo Electrónico</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500/50 transition-all placeholder-gray-600">
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-3 rounded-xl shadow-lg shadow-blue-600/20 transition-all">
                    Guardar Cambios
                </button>
            </form>
        </div>

        <!-- Security -->
        <div class="glass-panel p-8 rounded-2xl relative overflow-hidden">
            <h2 class="text-xl font-bold text-white font-outfit mb-6 flex items-center gap-2">
                <i class="fas fa-shield-alt text-purple-400"></i> Seguridad
            </h2>
            
            <form action="<?= url('admin/profile/update-password') ?>" method="POST" class="space-y-6">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Contraseña Actual</label>
                    <input type="password" name="current_password" required
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-purple-500/50 transition-all placeholder-gray-600">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Nueva Contraseña</label>
                    <input type="password" name="new_password" required minlength="6"
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-purple-500/50 transition-all placeholder-gray-600">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Confirmar Contraseña</label>
                    <input type="password" name="confirm_password" required minlength="6"
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-purple-500/50 transition-all placeholder-gray-600">
                </div>

                <button type="submit" class="w-full bg-purple-600 hover:bg-purple-500 text-white font-bold py-3 rounded-xl shadow-lg shadow-purple-600/20 transition-all">
                    Actualizar Contraseña
                </button>
            </form>
        </div>

    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/admin.php';
?>
