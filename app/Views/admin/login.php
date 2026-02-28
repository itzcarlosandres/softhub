<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Acceso Admin - SoftHub' ?></title>
    
    <!-- Favicon -->
    <?php
    $settingsModel = new \App\Models\SiteSetting();
    $favicon = $settingsModel->get('site_favicon');
    ?>
    <?php if ($favicon): ?>
        <link rel="icon" type="image/x-icon" href="<?= url($favicon) ?>">
        <link rel="apple-touch-icon" href="<?= url($favicon) ?>">
    <?php else: ?>
        <link rel="icon" type="image/x-icon" href="<?= url('favicon.ico') ?>">
    <?php endif; ?>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        dark: {
                            900: '#0f172a',
                            800: '#1e293b',
                        }
                    },
                    fontFamily: {
                        'outfit': ['Outfit', 'sans-serif'],
                        'inter': ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, .font-outfit { font-family: 'Outfit', sans-serif; }

        .glass-container {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        @keyframes pulse-slow {
            0%, 100% { opacity: 0.4; }
            50% { opacity: 0.7; }
        }
        .animate-pulse-slow {
            animation: pulse-slow 4s infinite;
        }

        /* Avatar Animation States */
        .avatar-hands {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            z-index: 20;
        }

        .eye-dot {
            width: 8px;
            height: 8px;
            background: white;
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
        }
    </style>
</head>
<body class="bg-dark-900 text-gray-300 min-h-screen flex items-center justify-center p-6 relative overflow-hidden">

    <!-- Premium Animated Background -->
    <div class="fixed top-0 left-0 w-full h-full pointer-events-none z-0">
        <div class="absolute top-[-10%] right-[-5%] w-[500px] h-[500px] bg-blue-600/20 rounded-full blur-[120px] animate-pulse-slow"></div>
        <div class="absolute bottom-[-10%] left-[-5%] w-[500px] h-[500px] bg-purple-600/20 rounded-full blur-[120px] animate-pulse-slow" style="animation-delay: 2s;"></div>
    </div>

    <!-- Login Card -->
    <div class="w-full max-w-md relative z-10" x-data="{ showPassword: false, isTypingPassword: false }">
        
        <div class="glass-container rounded-[2.5rem] p-8 md:p-10 shadow-2xl shadow-black/40">
            
            <!-- Dynamic Avatar (Improved Eyes visibility) -->
            <div class="flex justify-center mb-8 relative">
                <div class="w-28 h-28 bg-gradient-to-br from-gray-800 to-black rounded-[2rem] flex items-center justify-center shadow-2xl border border-white/5 relative overflow-hidden">
                    
                    <!-- The Eyes -->
                    <div class="flex gap-4 mb-4 transition-all duration-300" :class="isTypingPassword ? 'opacity-0 scale-50' : 'opacity-100 scale-100'">
                        <div class="eye-dot"></div>
                        <div class="eye-dot"></div>
                    </div>

                    <!-- Mouth / Face Details -->
                    <div class="absolute bottom-6 w-8 h-1 bg-white/20 rounded-full"></div>

                    <!-- The Hands (Covering Eyes Animation) -->
                    <div class="absolute inset-0 flex items-center justify-center avatar-hands" 
                         :style="isTypingPassword ? 'transform: translateY(0)' : 'transform: translateY(120%)'">
                        <div class="flex gap-2">
                            <!-- Left Hand -->
                            <div class="w-10 h-14 bg-blue-600 rounded-t-2xl shadow-lg border-t border-white/20"></div>
                            <!-- Right Hand -->
                            <div class="w-10 h-14 bg-blue-600 rounded-t-2xl shadow-lg border-t border-white/20"></div>
                        </div>
                    </div>
                </div>

                <!-- Status Badge -->
                <div class="absolute -bottom-2 px-4 py-1 bg-blue-500 text-white text-[10px] font-bold uppercase tracking-widest rounded-full shadow-lg border border-blue-400">
                    Admin Access
                </div>
            </div>

            <div class="text-center mb-10">
                <h1 class="text-3xl font-black text-white mb-2 tracking-tight uppercase">Panel de Control</h1>
                <p class="text-gray-500 text-sm font-medium">Bienvenido de nuevo, Comandante.</p>
            </div>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="mb-6 bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-2xl flex items-center gap-3 animate-bounce">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span class="text-sm font-medium"><?= $_SESSION['error'] ?></span>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <form action="<?= url('admin/login') ?>" method="POST" class="space-y-6">
                <!-- Username/Email -->
                <div class="group">
                    <label for="email" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 ml-1 transition-colors group-focus-within:text-blue-400">
                        Identificación
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500 group-focus-within:text-blue-400 transition-colors">
                            <i class="fas fa-envelope text-sm"></i>
                        </span>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            required
                            @focus="isTypingPassword = false"
                            class="w-full bg-white/5 border border-white/10 text-white pl-11 pr-4 py-4 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all placeholder-gray-600"
                            placeholder="admin@softhub.com"
                        >
                    </div>
                </div>

                <!-- Password with Reactive Eye Interaction -->
                <div class="group">
                    <div class="flex justify-between items-center mb-2 ml-1">
                        <label for="password" class="block text-xs font-bold text-gray-500 uppercase tracking-widest transition-colors group-focus-within:text-purple-400">
                            Código de Acceso
                        </label>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500 group-focus-within:text-purple-400 transition-colors">
                            <i class="fas fa-lock text-sm"></i>
                        </span>
                        <input 
                            :type="showPassword ? 'text' : 'password'" 
                            id="password" 
                            name="password" 
                            required
                            @focus="isTypingPassword = true"
                            @blur="isTypingPassword = false"
                            class="w-full bg-white/5 border border-white/10 text-white pl-11 pr-12 py-4 rounded-2xl focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500 transition-all placeholder-gray-600"
                            placeholder="••••••••"
                        >
                        <!-- Show/Hide Toggle -->
                        <button 
                            type="button"
                            @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-500 hover:text-white transition-colors"
                        >
                            <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <!-- Login Button -->
                <button 
                    type="submit" 
                    class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-bold py-4 rounded-2xl shadow-xl shadow-blue-900/20 transform transition-all active:scale-95 flex items-center justify-center gap-3 group"
                >
                    <span>ACCEDER AL SISTEMA</span>
                    <i class="fas fa-chevron-right text-xs group-hover:translate-x-1 transition-transform"></i>
                </button>
            </form>

            <div class="mt-8 text-center pt-6 border-t border-white/5">
                <a href="<?= url() ?>" class="text-gray-500 hover:text-white text-xs font-semibold tracking-wide transition-colors flex items-center justify-center gap-2">
                    <i class="fas fa-arrow-left text-[10px]"></i>
                    VOLVER AL PORTAL PÚBLICO
                </a>
            </div>
        </div>

        <!-- Footer Text -->
        <p class="mt-8 text-center text-gray-600 text-[10px] tracking-[0.2em] uppercase font-bold">
            SoftHub Secure Environment &copy; <?= date('Y') ?>
        </p>
    </div>

</body>
</html>
