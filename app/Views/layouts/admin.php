<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Panel' ?> - SoftHub</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        dark: {
                            900: '#0f172a', /* Slate 900 */
                            800: '#1e293b', /* Slate 800 */
                            700: '#334155', /* Slate 700 */
                        },
                        glass: {
                            100: 'rgba(255, 255, 255, 0.1)',
                            200: 'rgba(255, 255, 255, 0.2)',
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
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6, .font-outfit { font-family: 'Outfit', sans-serif; }
        
        /* Custom Scrollbar for Dark Mode */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #0f172a; 
        }
        ::-webkit-scrollbar-thumb {
            background: #334155; 
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #475569; 
        }

        .glass-panel {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
        }
        
        .glass-card:hover {
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="bg-[#0f172a] text-gray-300 overflow-hidden">

    <!-- Background Glows -->
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden pointer-events-none z-0">
        <div class="absolute top-[-10%] right-[-5%] w-[600px] h-[600px] bg-purple-600/20 rounded-full blur-[120px] animate-pulse"></div>
        <div class="absolute bottom-[-10%] left-[-5%] w-[600px] h-[600px] bg-blue-600/20 rounded-full blur-[120px] animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <div class="flex h-screen relative z-10" x-data="{ sidebarOpen: false }">
        
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 glass-panel border-r border-white/5 transition-transform duration-300 md:relative md:translate-x-0 flex flex-col">
            <!-- Logo -->
            <div class="h-20 flex items-center px-6 border-b border-white/5">
                <a href="<?= url('admin') ?>" class="flex items-center gap-3 text-white">
                    <div class="w-9 h-9 bg-gradient-to-br from-blue-600 to-purple-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-600/20">
                        <i class="fas fa-bolt text-sm"></i>
                    </div>
                    <div>
                        <span class="font-bold text-lg font-outfit tracking-wide block leading-none">SoftHub</span>
                        <span class="text-[10px] text-blue-400 font-medium tracking-wider uppercase">Admin Pro</span>
                    </div>
                </a>
            </div>

            <!-- Nav -->
            <nav class="flex-1 overflow-y-auto py-6 px-3 space-y-1">
                <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 mt-2 font-outfit">Main</p>
                
                <?php $cp = $currentPage ?? ''; ?>

                <a href="<?= url('admin') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all group <?= $cp == 'dashboard' ? 'bg-blue-600/20 text-blue-400 font-medium border border-blue-500/20' : 'text-gray-400 hover:bg-white/5 hover:text-white' ?>">
                    <i class="fas fa-home w-5 text-center <?= $cp == 'dashboard' ? 'text-blue-400' : 'text-gray-500 group-hover:text-white' ?>"></i>
                    <span>Dashboard</span>
                    <?php if($cp == 'dashboard'): ?>
                        <span class="ml-auto w-1.5 h-1.5 rounded-full bg-blue-400 shadow-[0_0_8px_rgba(96,165,250,0.6)]"></span>
                    <?php endif; ?>
                </a>

                <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 mt-6 font-outfit">Management</p>

                <a href="<?= url('admin/software') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all group <?= $cp == 'software' ? 'bg-purple-600/20 text-purple-400 font-medium border border-purple-500/20' : 'text-gray-400 hover:bg-white/5 hover:text-white' ?>">
                    <i class="fas fa-box w-5 text-center <?= $cp == 'software' ? 'text-purple-400' : 'text-gray-500 group-hover:text-white' ?>"></i>
                    <span>Software</span>
                </a>

                <a href="<?= url('admin/categories') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all group <?= $cp == 'categories' ? 'bg-pink-600/20 text-pink-400 font-medium border border-pink-500/20' : 'text-gray-400 hover:bg-white/5 hover:text-white' ?>">
                    <i class="fas fa-tags w-5 text-center <?= $cp == 'categories' ? 'text-pink-400' : 'text-gray-500 group-hover:text-white' ?>"></i>
                    <span>Categorías</span>
                </a>

                <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 mt-6 font-outfit">System</p>

                <a href="<?= url('admin/settings') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all group <?= $cp == 'settings' ? 'bg-emerald-600/20 text-emerald-400 font-medium border border-emerald-500/20' : 'text-gray-400 hover:bg-white/5 hover:text-white' ?>">
                    <i class="fas fa-cog w-5 text-center <?= $cp == 'settings' ? 'text-emerald-400' : 'text-gray-500 group-hover:text-white' ?>"></i>
                    <span>Configuración</span>
                </a>
                
                <a href="<?= url('admin/profile') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all group <?= $cp == 'profile' ? 'bg-orange-600/20 text-orange-400 font-medium border border-orange-500/20' : 'text-gray-400 hover:bg-white/5 hover:text-white' ?>">
                    <i class="fas fa-user-circle w-5 text-center <?= $cp == 'profile' ? 'text-orange-400' : 'text-gray-500 group-hover:text-white' ?>"></i>
                    <span>Perfil</span>
                </a>
            </nav>

            <!-- User Panel -->
            <div class="p-4 border-t border-white/5">
                <div class="flex items-center gap-3 p-3 rounded-xl bg-white/5 border border-white/5 backdrop-blur-sm">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-r from-gray-700 to-gray-600 flex items-center justify-center text-white text-xs font-bold border border-white/10">
                        <?= strtoupper(substr($_SESSION['admin_username'] ?? 'A', 0, 1)) ?>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-medium text-white truncate"><?= $_SESSION['admin_username'] ?? 'Admin' ?></div>
                        <div class="text-[10px] text-gray-500 truncate">Administrator</div>
                    </div>
                    <a href="<?= url('admin/logout') ?>" class="text-gray-500 hover:text-red-400 transition-colors" title="Cerrar Sesión">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </div>
            </div>
        </aside>

        <!-- Mobile Overlay -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40 md:hidden" x-transition.opacity></div>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden bg-transparent">
            
            <!-- Topbar (Glass) -->
            <header class="h-20 glass-panel border-b border-white/5 flex items-center justify-between px-8 z-30 sticky top-0">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-gray-400 hover:text-white bg-white/5 p-2 rounded-lg transition-colors">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div>
                        <h2 class="text-xl font-bold text-white font-outfit tracking-tight"><?= $title ?? 'Dashboard' ?></h2>
                        <p class="text-xs text-gray-500 hidden sm:block">Bienvenido al centro de control futurista.</p>
                    </div>
                </div>

                <div class="flex items-center gap-5">
                    <!-- Search Bar (Visual) -->
                    <div class="hidden md:flex items-center bg-white/5 border border-white/10 rounded-full px-4 py-2 w-64 focus-within:bg-white/10 focus-within:border-white/20 transition-all">
                        <i class="fas fa-search text-gray-500 text-sm"></i>
                        <input type="text" placeholder="Buscar..." class="bg-transparent border-none text-sm text-white placeholder-gray-500 focus:outline-none w-full ml-3">
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-3">
                        <button class="w-10 h-10 rounded-full bg-white/5 hover:bg-white/10 flex items-center justify-center text-gray-400 hover:text-white transition-colors border border-white/5 relative">
                            <i class="fas fa-bell"></i>
                            <span class="absolute top-2 right-2.5 w-2 h-2 bg-red-500 rounded-full shadow-[0_0_8px_rgba(239,68,68,0.6)] animate-pulse"></span>
                        </button>
                        <a href="<?= url('/') ?>" target="_blank" class="w-10 h-10 rounded-full bg-white/5 hover:bg-white/10 flex items-center justify-center text-gray-400 hover:text-blue-400 transition-colors border border-white/5" title="Ver Sitio Web">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 overflow-y-auto p-6 md:p-8 scroll-smooth pb-20">
                
                <!-- Flash Messages -->
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="mb-6 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-xl flex items-center gap-3 animate-fade-in-down backdrop-blur-sm shadow-lg shadow-emerald-500/5">
                        <i class="fas fa-check-circle text-lg"></i>
                        <span><?= $_SESSION['success'] ?></span>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="mb-6 bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl flex items-center gap-3 animate-fade-in-down backdrop-blur-sm shadow-lg shadow-red-500/5">
                        <i class="fas fa-exclamation-circle text-lg"></i>
                        <span><?= $_SESSION['error'] ?></span>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <?= $content ?? '' ?>
                
            </main>
        </div>
    </div>

</body>
</html>
