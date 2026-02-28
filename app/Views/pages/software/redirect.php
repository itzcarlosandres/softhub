<?php
ob_start();
?>

<!-- Redirect / Countdown Page -->
<section class="min-h-[calc(100vh-80px)] bg-white dark:bg-gray-900 flex items-center justify-center py-12 px-6 transition-colors duration-300">
    <div class="w-full max-w-xl text-center">
        
        <!-- Header -->
        <div class="mb-12">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-50 dark:bg-blue-900/30 rounded-2xl mb-6">
                <?php if (!empty($link['software_icon'])): ?>
                    <img src="<?= url(htmlspecialchars($link['software_icon'])) ?>" alt="<?= htmlspecialchars($link['software_name']) ?>" class="w-12 h-12 object-contain">
                <?php else: ?>
                    <i class="fas fa-rocket text-3xl text-blue-600 dark:text-blue-400"></i>
                <?php endif; ?>
            </div>
            <h1 class="text-3xl font-black text-gray-900 dark:text-white mb-2 tracking-tight transition-colors">
                Preparando tu descarga
            </h1>
            <p class="text-gray-500 dark:text-gray-400 font-medium transition-colors">
                Estás a punto de descargar <span class="text-blue-600 dark:text-blue-400 font-bold"><?= htmlspecialchars($link['software_name']) ?></span>
            </p>
        </div>

        <!-- Countdown Card -->
        <div class="bg-gray-50 dark:bg-gray-800/50 rounded-[2.5rem] p-10 md:p-16 border border-gray-100 dark:border-gray-800 transition-colors mb-12">
            <div id="countdown-wrapper" class="relative inline-block mb-8">
                <!-- Circular Progress -->
                <svg class="transform -rotate-90 w-48 h-48">
                    <circle cx="96" cy="96" r="88" stroke="currentColor" stroke-width="4" fill="none" class="text-gray-200 dark:text-gray-700"></circle>
                    <circle id="progress-circle" cx="96" cy="96" r="88" stroke="currentColor" stroke-width="6" fill="none" 
                            stroke-dasharray="552.92" stroke-dashoffset="0" class="text-blue-600 dark:text-blue-400 transition-all duration-1000 ease-linear"></circle>
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span id="countdown-number" class="text-7xl font-black text-gray-900 dark:text-white"><?= (int)$countdown ?></span>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">Segundos</span>
                </div>
            </div>

            <div id="action-wrapper" class="hidden">
                <a href="<?= htmlspecialchars($link['download_url']) ?>" id="final-download-btn" target="_blank"
                   class="inline-flex items-center justify-center gap-3 bg-blue-600 text-white px-12 py-5 rounded-2xl font-bold text-xl hover:bg-blue-700 transition shadow-xl shadow-blue-500/20 w-full group">
                    <i class="fas fa-cloud-download-alt group-hover:bounce"></i> 
                    Comenzar Descarga
                </a>
                <p class="text-xs text-gray-400 mt-4 font-medium uppercase tracking-widest">Si no inicia, pulsa el botón</p>
            </div>

            <div id="wait-message">
                <p class="text-sm font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-2">Por favor espera un momento</p>
                <div class="flex justify-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-bounce" style="animation-delay: 0.1s"></span>
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-bounce" style="animation-delay: 0.2s"></span>
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-bounce" style="animation-delay: 0.3s"></span>
                </div>
            </div>
        </div>

        <!-- Meta Info -->
        <div class="flex flex-wrap justify-center gap-6 text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mb-12">
            <div class="flex items-center gap-2 border-r border-gray-200 dark:border-gray-800 pr-6 last:border-0 last:pr-0">
                <span class="text-gray-300 dark:text-gray-600">Servidor</span> 
                <span class="text-gray-900 dark:text-white"><?= htmlspecialchars($link['platform'] ?: 'Cloud') ?></span>
            </div>
            <div class="flex items-center gap-2">
                <i class="fas fa-check-circle text-green-500"></i> Seguro
            </div>
        </div>

        <!-- Back Link -->
        <a href="<?= url('software/' . $link['software_slug']) ?>" class="text-sm font-bold text-gray-400 hover:text-blue-600 transition-colors inline-flex items-center gap-2">
            <i class="fas fa-times text-[10px]"></i>
            Cancelar y volver
        </a>
    </div>
</section>

<style>
@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-5px); }
}
.group-hover\:bounce:hover {
    animation: bounce 0.5s infinite;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let timeLeft = <?= (int)$countdown ?>;
    const numberElement = document.getElementById('countdown-number');
    const circle = document.getElementById('progress-circle');
    const actionWrapper = document.getElementById('action-wrapper');
    const waitMessage = document.getElementById('wait-message');
    const countdownWrapper = document.getElementById('countdown-wrapper');
    const finalBtn = document.getElementById('final-download-btn');
    
    const circumference = 552.92;
    const totalTime = <?= (int)$countdown ?>;

    function timer() {
        if (timeLeft <= 0) {
            numberElement.textContent = "0";
            circle.style.strokeDashoffset = circumference;
            
            // Show button
            waitMessage.classList.add('hidden');
            countdownWrapper.classList.add('opacity-50', 'scale-90', 'transition-all', 'duration-500');
            actionWrapper.classList.remove('hidden');
            actionWrapper.classList.add('animate-fadeIn');
            
            // Auto redirect/download
            window.location.href = finalBtn.href;
            return;
        }

        numberElement.textContent = timeLeft;
        const offset = circumference - (circumference * (totalTime - timeLeft) / totalTime);
        circle.style.strokeDashoffset = offset;
        
        timeLeft--;
        setTimeout(timer, 1000);
    }

    setTimeout(timer, 500);
});
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/main.php';
?>
