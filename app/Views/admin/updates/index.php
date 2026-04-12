<?php
$currentPage = 'updates';
ob_start();
?>

<div class="p-6 max-w-4xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between mb-10">
        <div>
            <h1 class="text-3xl font-black text-white mb-2 font-outfit tracking-tight">Actualizaciones del Sistema</h1>
            <p class="text-gray-400 text-sm">Gestiona y aplica actualizaciones a tu plataforma mediante archivos ZIP.</p>
        </div>
        <div class="flex items-center gap-2 bg-emerald-500/10 border border-emerald-500/20 px-4 py-2 rounded-2xl">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            <span class="text-emerald-400 text-xs font-bold uppercase tracking-wider">Versión Actual: v<?= htmlspecialchars($currentVersion) ?></span>
        </div>
    </div>

    <!-- Alert Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="mb-8 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl flex items-center gap-3 text-emerald-400 animate-fade-in text-sm font-medium">
            <i class="fas fa-check-circle text-lg"></i>
            <span><?= $_SESSION['success'] ?></span>
            <?php unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="mb-8 p-4 bg-red-500/10 border border-red-500/20 rounded-2xl flex items-center gap-3 text-red-400 animate-fade-in text-sm font-medium">
            <i class="fas fa-exclamation-circle text-lg"></i>
            <span><?= $_SESSION['error'] ?></span>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 pb-12">
        <!-- Upload Form -->
        <div class="md:col-span-2">
            <div class="glass-card rounded-[2.5rem] p-8 border border-white/5 relative overflow-hidden">
                <!-- Decorative background -->
                <div class="absolute -top-24 -right-24 w-48 h-48 bg-emerald-600/10 rounded-full blur-3xl"></div>
                
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-emerald-600/20 rounded-2xl flex items-center justify-center text-emerald-400 mb-6 shadow-lg shadow-emerald-600/10 border border-emerald-500/20">
                        <i class="fas fa-cloud-upload-alt text-2xl"></i>
                    </div>

                    <h2 class="text-xl font-bold text-white mb-2 font-outfit">Instalar Nueva Actualización</h2>
                    <p class="text-gray-400 text-sm mb-8 leading-relaxed">Sube el archivo comprimido (.zip) que contiene los nuevos archivos del sistema. El proceso reemplazará los archivos existentes automáticamente.</p>

                    <form action="<?= url('admin/updates/install') ?>" method="POST" enctype="multipart/form-data" id="updateForm" onsubmit="return confirmUpdate()">
                        <div class="mb-8">
                            <label class="group relative flex flex-col items-center justify-center w-full h-48 border-2 border-dashed border-white/10 rounded-[2rem] bg-white/5 hover:bg-white/[0.08] hover:border-emerald-500/30 transition-all cursor-pointer">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center px-4" id="uploadState">
                                    <div class="w-12 h-12 bg-white/5 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                        <i class="fas fa-file-archive text-xl text-gray-400 group-hover:text-emerald-400 transition-colors"></i>
                                    </div>
                                    <p class="mb-2 text-sm text-gray-300 font-medium"><span class="text-white font-bold">Haz clic para subir</span> o arrastra un ZIP</p>
                                    <p class="text-[10px] text-gray-500 uppercase tracking-[0.2em] font-black">ZIP de actualización • Máx 128MB</p>
                                </div>
                                <div class="hidden flex-col items-center p-6 text-center" id="fileSelected">
                                    <div class="w-14 h-14 bg-emerald-500/20 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-check text-2xl text-emerald-400"></i>
                                    </div>
                                    <p class="text-sm text-white font-bold mb-1" id="fileName"></p>
                                    <p class="text-xs text-emerald-400 font-medium cursor-pointer hover:underline">Cambiar archivo seleccionado</p>
                                </div>
                                <input type="file" name="update_zip" class="hidden" accept=".zip" onchange="handleFileSelect(this)" required />
                            </label>
                        </div>

                        <button type="submit" id="installBtn" class="group w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-4 px-6 rounded-2xl flex items-center justify-center gap-3 transition-all shadow-lg shadow-emerald-600/20 active:scale-[0.98] disabled:opacity-50">
                            <i class="fas fa-rocket text-sm group-hover:-translate-y-1 transition-transform"></i>
                            <span>Iniciar Proceso de Instalación</span>
                        </button>

                        <!-- Progress State (Hidden initially) -->
                        <div id="progressState" class="hidden mt-8 text-center animate-fade-in">
                            <div class="flex items-center justify-center gap-3 mb-4">
                                <div class="w-6 h-6 border-4 border-emerald-500/20 border-t-emerald-500 rounded-full animate-spin"></div>
                                <span class="text-emerald-400 font-bold text-xs uppercase tracking-[0.2em]">Instalando... No recargues la página</span>
                            </div>
                            <div class="w-full bg-white/5 h-1.5 rounded-full overflow-hidden">
                                <div class="h-full bg-emerald-500 animate-[progress_2s_ease-in-out_infinite]" style="width: 30%"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Instructions/Safety -->
        <div class="space-y-6">
            <!-- Steps Card -->
            <div class="glass-card rounded-[2rem] p-6 border border-white/5">
                <h3 class="text-white font-bold text-[10px] uppercase tracking-[0.2em] mb-6 flex items-center gap-2 opacity-60">
                    <i class="fas fa-stream"></i> Pasos a seguir
                </h3>
                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-6 h-6 rounded-lg bg-emerald-500/20 text-emerald-400 text-[10px] font-bold flex items-center justify-center shrink-0">1</div>
                        <div>
                            <h4 class="text-xs font-bold text-white mb-1">Prepara el ZIP</h4>
                            <p class="text-[11px] text-gray-500 leading-relaxed">Crea un archivo comprimido con la estructura de carpetas de tu servidor.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-6 h-6 rounded-lg bg-emerald-500/20 text-emerald-400 text-[10px] font-bold flex items-center justify-center shrink-0">2</div>
                        <div>
                            <h4 class="text-xs font-bold text-white mb-1">Sube y Descomprime</h4>
                            <p class="text-[11px] text-gray-500 leading-relaxed">El sistema se encargará de extraer y reemplazar los archivos automáticamente.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-6 h-6 rounded-lg bg-emerald-500/20 text-emerald-400 text-[10px] font-bold flex items-center justify-center shrink-0">3</div>
                        <div>
                            <h4 class="text-xs font-bold text-white mb-1">Migración de DB</h4>
                            <p class="text-[11px] text-gray-500 leading-relaxed">Si incluyes `update_db.sql`, los cambios en la base de datos se aplicarán solos.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Caution Card -->
            <div class="glass-card rounded-[2rem] p-6 border border-red-500/10 bg-red-500/[0.02]">
                <h3 class="text-red-400 font-bold text-[10px] uppercase tracking-[0.2em] mb-4 flex items-center gap-2">
                    <i class="fas fa-exclamation-triangle"></i> Advertencia
                </h3>
                <p class="text-[11px] text-gray-500 leading-relaxed mb-4">Esta acción es irreversible y sobrescribirá archivos. Asegúrate de tener un backup reciente de tu base de datos y archivos.</p>
            </div>
        </div>
    </div>
</div>

<script>
function handleFileSelect(input) {
    const uploadState = document.getElementById('uploadState');
    const fileSelected = document.getElementById('fileSelected');
    const fileName = document.getElementById('fileName');
    
    if (input.files && input.files[0]) {
        fileName.textContent = input.files[0].name;
        uploadState.classList.add('hidden');
        fileSelected.classList.remove('hidden');
        fileSelected.classList.add('flex');
    }
}

function confirmUpdate() {
    if (confirm('⚠️ ADVERTENCIA: ¿Estás seguro de que deseas iniciar la actualización? Se reemplazarán archivos del sistema.')) {
        document.getElementById('installBtn').classList.add('hidden');
        document.getElementById('progressState').classList.remove('hidden');
        return true;
    }
    return false;
}
</script>

<style>
@keyframes progress {
    0% { transform: translateX(-100%); }
    50% { transform: translateX(0); }
    100% { transform: translateX(100%); }
}
@keyframes fade-in {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
    animation: fade-in 0.4s ease forwards;
}
</style>

<?php 
$content = ob_get_clean();
require __DIR__ . '/../../layouts/admin.php'; 
?>
