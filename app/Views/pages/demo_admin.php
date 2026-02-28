<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo de Admin Panels Premium - SoftHub</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#3b82f6',
                        secondary: '#8b5cf6',
                    },
                    fontFamily: {
                        'outfit': ['Outfit', 'sans-serif'],
                        'inter': ['Inter', 'sans-serif'],
                        'dm-sans': ['DM Sans', 'sans-serif'],
                        'space-grotesk': ['Space Grotesk', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&family=DM+Sans:opsz,wght@9..40,400;500;700&family=Space+Grotesk:wght@400;500;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass-panel { background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.1); }
        .grid-bg { background-image: radial-gradient(#e5e7eb 1px, transparent 1px); background-size: 24px 24px; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">

    <!-- Header Simulado -->
    <header class="bg-white shadow-sm sticky top-0 z-50 border-b border-gray-200">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-600 to-purple-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-cube text-white text-sm"></i>
                </div>
                <span class="font-bold text-xl font-outfit">SoftHub Admin</span>
            </div>
            <a href="<?= url('/') ?>" class="text-sm font-medium text-blue-600 hover:text-blue-800 flex items-center gap-1">
                <i class="fas fa-arrow-left"></i> Volver al Inicio
            </a>
        </div>
    </header>

    <div class="container mx-auto px-4 py-12 text-center">
        <h1 class="text-4xl font-extrabold mb-4 bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-purple-600 font-outfit">Galería de Paneles de Administración</h1>
        <p class="text-gray-600 max-w-2xl mx-auto mb-12">Explora 5 conceptos de dashboard ultra-modernos diseñados para maximizar la productividad y la estética.</p>
    </div>

    <!-- OPCIÓN 1: Deep Glassmorphism -->
    <div class="relative py-12 bg-gray-900 border-t border-b border-gray-800 overflow-hidden">
        <div class="absolute top-0 left-0 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-br-lg z-20">OPCIÓN 1: Deep Glassmorphism (Futurista)</div>
        
        <!-- Background Glows -->
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-purple-600/20 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-blue-600/20 rounded-full blur-[120px] pointer-events-none"></div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="bg-[#0f172a]/80 backdrop-blur-xl border border-white/10 rounded-2xl overflow-hidden shadow-2xl flex h-[600px]">
                <!-- Sidebar -->
                <aside class="w-64 border-r border-white/5 bg-white/5 backdrop-blur-md flex flex-col hidden md:flex">
                    <div class="p-6 border-b border-white/5">
                        <div class="flex items-center gap-3 text-white">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-500 rounded-lg flex items-center justify-center shadow-lg shadow-blue-500/20">
                                <i class="fas fa-bolt text-xs"></i>
                            </div>
                            <span class="font-bold font-outfit tracking-wide">NEXUS</span>
                        </div>
                    </div>
                    <nav class="flex-1 p-4 space-y-2">
                        <a href="#" class="flex items-center gap-3 px-4 py-3 bg-blue-600 rounded-xl text-white shadow-lg shadow-blue-600/20">
                            <i class="fas fa-home w-5"></i> <span class="text-sm font-medium">Dashboard</span>
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-white/5 hover:text-white rounded-xl transition-colors">
                            <i class="fas fa-box w-5"></i> <span class="text-sm font-medium">Software</span>
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-white/5 hover:text-white rounded-xl transition-colors">
                            <i class="fas fa-users w-5"></i> <span class="text-sm font-medium">Usuarios</span>
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-white/5 hover:text-white rounded-xl transition-colors">
                            <i class="fas fa-chart-pie w-5"></i> <span class="text-sm font-medium">Analíticas</span>
                        </a>
                    </nav>
                    <div class="p-4 border-t border-white/5">
                        <div class="flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name=Admin&background=random" class="w-8 h-8 rounded-full border border-white/20">
                            <div class="text-xs">
                                <div class="text-white font-medium">Admin User</div>
                                <div class="text-gray-500">Pro Plan</div>
                            </div>
                        </div>
                    </div>
                </aside>
                
                <!-- Main Content -->
                <main class="flex-1 flex flex-col bg-[#0f172a]/50">
                    <!-- Topbar -->
                    <header class="h-16 border-b border-white/5 flex items-center justify-between px-6 bg-white/5 backdrop-blur-sm">
                        <div class="text-gray-400 text-sm">Dashboard / <span class="text-white">Overview</span></div>
                        <div class="flex items-center gap-4">
                            <div class="relative">
                                <i class="fas fa-bell text-gray-400 hover:text-white cursor-pointer transition-colors"></i>
                                <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                            </div>
                            <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-xs font-bold text-white border border-white/20">JP</div>
                        </div>
                    </header>

                    <!-- Content -->
                    <div class="p-6 overflow-y-auto scrollbar-hide">
                        <h2 class="text-2xl font-bold text-white mb-6 font-outfit">Bienvenido de nuevo, Admin 👋</h2>
                        
                        <!-- Stats Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                            <div class="bg-white/5 border border-white/10 p-5 rounded-2xl backdrop-blur-sm hover:bg-white/10 transition-colors group">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="w-10 h-10 bg-blue-500/20 rounded-xl flex items-center justify-center text-blue-400 group-hover:text-blue-300 transition-colors">
                                        <i class="fas fa-download"></i>
                                    </div>
                                    <span class="text-green-400 text-xs bg-green-500/10 px-2 py-1 rounded-full border border-green-500/20">+12%</span>
                                </div>
                                <div class="text-3xl font-bold text-white mb-1 font-outfit">24.5k</div>
                                <div class="text-gray-400 text-xs">Descargas Totales</div>
                            </div>
                            
                            <div class="bg-white/5 border border-white/10 p-5 rounded-2xl backdrop-blur-sm hover:bg-white/10 transition-colors group">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="w-10 h-10 bg-purple-500/20 rounded-xl flex items-center justify-center text-purple-400 group-hover:text-purple-300 transition-colors">
                                        <i class="fas fa-box-open"></i>
                                    </div>
                                    <span class="text-green-400 text-xs bg-green-500/10 px-2 py-1 rounded-full border border-green-500/20">+5%</span>
                                </div>
                                <div class="text-3xl font-bold text-white mb-1 font-outfit">1,240</div>
                                <div class="text-gray-400 text-xs">Software Activo</div>
                            </div>

                            <div class="bg-gradient-to-br from-blue-600 to-purple-600 p-5 rounded-2xl shadow-lg shadow-blue-600/20 text-white col-span-1 md:col-span-2 relative overflow-hidden">
                                <div class="absolute right-0 bottom-0 opacity-20 transform translate-x-4 translate-y-4">
                                    <i class="fas fa-rocket text-9xl"></i>
                                </div>
                                <div class="relative z-10">
                                    <h3 class="font-bold text-lg mb-2">Versión Pro Disponible</h3>
                                    <p class="text-blue-100 text-sm mb-4 max-w-xs">Actualiza ahora para desbloquear funciones avanzadas de administración.</p>
                                    <button class="bg-white text-blue-600 px-4 py-2 rounded-lg text-xs font-bold shadow-lg hover:shadow-xl hover:bg-gray-50 transition-all">Ver Planes</button>
                                </div>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden backdrop-blur-sm">
                            <div class="p-5 border-b border-white/5 flex justify-between items-center">
                                <h3 class="font-bold text-white">Últimas Actividades</h3>
                                <button class="text-xs text-blue-400 hover:text-blue-300">Ver Todo</button>
                            </div>
                            <table class="w-full text-left text-sm text-gray-400">
                                <thead class="bg-white/5 text-gray-300 uppercase text-xs">
                                    <tr>
                                        <th class="px-6 py-3 font-medium">Software</th>
                                        <th class="px-6 py-3 font-medium">Estado</th>
                                        <th class="px-6 py-3 font-medium">Fecha</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-white/5">
                                    <tr class="hover:bg-white/5 transition-colors">
                                        <td class="px-6 py-4 flex items-center gap-3">
                                            <div class="w-8 h-8 rounded bg-gray-700"></div>
                                            <span class="text-white font-medium">Adobe Photoshop 2024</span>
                                        </td>
                                        <td class="px-6 py-4"><span class="bg-green-500/20 text-green-400 px-2 py-1 rounded-md text-xs border border-green-500/20">Aprobado</span></td>
                                        <td class="px-6 py-4">Hace 2 min</td>
                                    </tr>
                                    <tr class="hover:bg-white/5 transition-colors">
                                        <td class="px-6 py-4 flex items-center gap-3">
                                            <div class="w-8 h-8 rounded bg-gray-700"></div>
                                            <span class="text-white font-medium">VS Code Insiders</span>
                                        </td>
                                        <td class="px-6 py-4"><span class="bg-yellow-500/20 text-yellow-400 px-2 py-1 rounded-md text-xs border border-yellow-500/20">Pendiente</span></td>
                                        <td class="px-6 py-4">Hace 15 min</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <!-- OPCIÓN 2: Ultra Minimal (Clean) -->
    <div class="relative py-12 bg-gray-50 border-b border-gray-200">
        <div class="absolute top-0 left-0 bg-black text-white text-xs font-bold px-3 py-1 rounded-br-lg z-20">OPCIÓN 2: Ultra Minimal (Clean) Style</div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="bg-white rounded-none border border-gray-200 shadow-sm flex h-[600px] font-inter">
                <!-- Sidebar -->
                <aside class="w-60 border-r border-gray-100 bg-white flex flex-col hidden md:flex">
                    <div class="p-6">
                        <div class="font-bold text-gray-900 tracking-tight text-lg">SoftHub.</div>
                    </div>
                    <nav class="flex-1 px-4 space-y-1">
                        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 px-2 mt-4">Main</div>
                        <a href="#" class="flex items-center gap-3 px-3 py-2 bg-gray-50 text-gray-900 rounded-md text-sm font-medium border border-gray-200/50">
                            <i class="fas fa-home w-4 text-gray-500"></i> Dashboard
                        </a>
                        <a href="#" class="flex items-center gap-3 px-3 py-2 text-gray-500 hover:bg-gray-50 hover:text-gray-900 rounded-md text-sm font-medium transition-colors">
                            <i class="fas fa-box w-4"></i> Products
                        </a>
                        <a href="#" class="flex items-center gap-3 px-3 py-2 text-gray-500 hover:bg-gray-50 hover:text-gray-900 rounded-md text-sm font-medium transition-colors">
                            <i class="fas fa-users w-4"></i> Customers
                        </a>
                    </nav>
                </aside>
                
                <!-- Main Content -->
                <main class="flex-1 flex flex-col bg-white">
                    <header class="h-14 border-b border-gray-100 flex items-center justify-between px-8 bg-white sticky top-0 z-10">
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <span class="w-2 h-2 rounded-full bg-green-500"></span> Operating Normal
                        </div>
                        <div class="flex items-center gap-4">
                            <button class="bg-black text-white text-xs font-medium px-3 py-1.5 rounded hover:bg-gray-800 transition-colors">New Release</button>
                        </div>
                    </header>

                    <div class="p-8 overflow-y-auto scrollbar-hide">
                        <h2 class="text-xl font-semibold text-gray-900 mb-1">Overview</h2>
                        <p class="text-gray-500 text-sm mb-8">Metrics for last 30 days.</p>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                            <div>
                                <div class="text-gray-500 text-sm mb-1 font-medium">Total Revenue</div>
                                <div class="text-3xl font-semibold text-gray-900 tracking-tight">$12,405</div>
                                <div class="text-green-600 text-xs mt-1 font-medium">↑ 2.5% this week</div>
                            </div>
                            <div>
                                <div class="text-gray-500 text-sm mb-1 font-medium">Active Users</div>
                                <div class="text-3xl font-semibold text-gray-900 tracking-tight">8,240</div>
                                <div class="text-green-600 text-xs mt-1 font-medium">↑ 12% this week</div>
                            </div>
                            <div>
                                <div class="text-gray-500 text-sm mb-1 font-medium">Bounce Rate</div>
                                <div class="text-3xl font-semibold text-gray-900 tracking-tight">24.5%</div>
                                <div class="text-red-600 text-xs mt-1 font-medium">↓ 0.4% this week</div>
                            </div>
                        </div>

                        <h3 class="text-sm font-medium text-gray-900 mb-4 uppercase tracking-wider">Recent Files</h3>
                        <div class="border-t border-gray-100">
                            <div class="flex items-center justify-between py-4 border-b border-gray-100 hover:bg-gray-50/50 transition-colors cursor-pointer group px-2">
                                <div class="flex items-center gap-4">
                                    <div class="w-8 h-8 bg-gray-100 rounded flex items-center justify-center text-gray-500 group-hover:bg-white group-hover:shadow-sm border border-transparent group-hover:border-gray-200 transition-all"><i class="fas fa-file"></i></div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">Project_Alpha_v2.zip</div>
                                        <div class="text-xs text-gray-500">2.4 MB • Uploaded 2h ago</div>
                                    </div>
                                </div>
                                <div class="text-gray-400 group-hover:text-black transition-colors"><i class="fas fa-ellipsis-h"></i></div>
                            </div>
                            <div class="flex items-center justify-between py-4 border-b border-gray-100 hover:bg-gray-50/50 transition-colors cursor-pointer group px-2">
                                <div class="flex items-center gap-4">
                                    <div class="w-8 h-8 bg-gray-100 rounded flex items-center justify-center text-gray-500 group-hover:bg-white group-hover:shadow-sm border border-transparent group-hover:border-gray-200 transition-all"><i class="fas fa-image"></i></div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">Design_Assets_Pack.png</div>
                                        <div class="text-xs text-gray-500">12 MB • Uploaded 5h ago</div>
                                    </div>
                                </div>
                                <div class="text-gray-400 group-hover:text-black transition-colors"><i class="fas fa-ellipsis-h"></i></div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <!-- OPCIÓN 3: Modular Bento Grid -->
    <div class="relative py-12 bg-gray-100 border-b border-gray-200">
        <div class="absolute top-0 left-0 bg-indigo-600 text-white text-xs font-bold px-3 py-1 rounded-br-lg z-20">OPCIÓN 3: Modular Bento (Organizado)</div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="bg-gray-50 rounded-3xl p-4 shadow-xl flex h-[600px] font-dm-sans gap-4">
                
                <!-- Sidebar Floating -->
                <aside class="w-20 bg-white rounded-2xl flex flex-col items-center py-6 shadow-sm border border-gray-200/50 hidden md:flex">
                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white text-lg mb-8 shadow-lg shadow-indigo-500/30">
                        <i class="fas fa-cube"></i>
                    </div>
                    <nav class="flex-1 flex flex-col gap-4 w-full px-2">
                        <a href="#" class="w-full aspect-square rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center transition-colors">
                            <i class="fas fa-home text-lg"></i>
                        </a>
                        <a href="#" class="w-full aspect-square rounded-xl text-gray-400 hover:bg-gray-100 hover:text-gray-600 flex items-center justify-center transition-colors">
                            <i class="fas fa-chart-bar text-lg"></i>
                        </a>
                        <a href="#" class="w-full aspect-square rounded-xl text-gray-400 hover:bg-gray-100 hover:text-gray-600 flex items-center justify-center transition-colors">
                            <i class="fas fa-cog text-lg"></i>
                        </a>
                    </nav>
                    <div class="mt-auto">
                        <img src="https://ui-avatars.com/api/?name=User&background=random" class="w-10 h-10 rounded-full border-2 border-white shadow-md">
                    </div>
                </aside>
                
                <!-- Main Content -->
                <main class="flex-1 flex flex-col gap-4">
                    <!-- Top Bar -->
                    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-200/50 flex justify-between items-center">
                        <h2 class="text-xl font-bold text-gray-800">Dashboard</h2>
                        <div class="flex gap-3">
                            <input type="text" placeholder="Search..." class="bg-gray-100 border-none rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-500 outline-none w-64">
                            <button class="bg-black text-white px-4 py-2 rounded-xl text-sm font-bold shadow-lg hover:-translate-y-0.5 transition-transform">Add New</button>
                        </div>
                    </div>

                    <!-- Grid Layout -->
                    <div class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-4 overflow-y-auto scrollbar-hide pb-2">
                        <!-- Stats Card Large -->
                        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-200/50 col-span-2 flex flex-col justify-between relative overflow-hidden">
                            <div class="absolute right-0 top-0 w-32 h-32 bg-indigo-50 rounded-full -mr-10 -mt-10 blur-2xl"></div>
                            <div>
                                <h3 class="text-gray-500 font-medium mb-1">Weekly Growth</h3>
                                <div class="text-4xl font-bold text-gray-900 mb-4">+1,240 <span class="text-sm font-normal text-green-500 bg-green-50 px-2 py-1 rounded-lg ml-2">+12%</span></div>
                            </div>
                            <div class="h-24 bg-gray-50 rounded-xl flex items-end justify-between px-4 pb-2 gap-2 mt-auto">
                                <div class="w-full bg-indigo-200 h-[40%] rounded-t-sm"></div>
                                <div class="w-full bg-indigo-300 h-[60%] rounded-t-sm"></div>
                                <div class="w-full bg-indigo-400 h-[30%] rounded-t-sm"></div>
                                <div class="w-full bg-indigo-500 h-[80%] rounded-t-sm"></div>
                                <div class="w-full bg-indigo-600 h-[65%] rounded-t-sm"></div>
                            </div>
                        </div>

                        <!-- Info Card -->
                        <div class="bg-indigo-600 p-6 rounded-3xl shadow-lg shadow-indigo-500/20 text-white flex flex-col justify-center text-center">
                            <i class="fas fa-crown text-4xl mb-4 text-yellow-300"></i>
                            <h3 class="font-bold text-xl mb-2">Premium Plan</h3>
                            <p class="text-indigo-200 text-sm mb-4">You are currently using the Pro plan features.</p>
                            <button class="bg-white text-indigo-600 py-2 rounded-xl font-bold text-sm hover:bg-gray-100 transition-colors">Manage</button>
                        </div>

                        <!-- List Card -->
                        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-200/50 col-span-3">
                            <h3 class="font-bold text-gray-800 mb-4">Recent Transactions</h3>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-2xl hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-green-100 text-green-600 flex items-center justify-center"><i class="fas fa-dollar-sign"></i></div>
                                        <div>
                                            <div class="font-bold text-sm text-gray-800">Subscription Updated</div>
                                            <div class="text-xs text-gray-500">Today, 12:00 PM</div>
                                        </div>
                                    </div>
                                    <div class="font-bold text-green-600">+$29.00</div>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-2xl hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center"><i class="fas fa-file-invoice"></i></div>
                                        <div>
                                            <div class="font-bold text-sm text-gray-800">Invoice Generated</div>
                                            <div class="text-xs text-gray-500">Yesterday, 4:00 PM</div>
                                        </div>
                                    </div>
                                    <div class="font-bold text-gray-600">PDF</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <!-- OPCIÓN 4: Enterprise Pro (Stripe-like) -->
    <div class="relative py-12 bg-white border-b border-gray-200">
        <div class="absolute top-0 left-0 bg-slate-700 text-white text-xs font-bold px-3 py-1 rounded-br-lg z-20">OPCIÓN 4: Enterprise Pro (SaaS)</div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="bg-slate-50 border border-slate-200 shadow-sm flex h-[600px] font-inter text-slate-600">
                <!-- Sidebar -->
                <aside class="w-64 bg-slate-100 border-r border-slate-200 flex flex-col hidden md:flex">
                    <div class="p-4 border-b border-slate-200">
                        <div class="flex items-center gap-2">
                             <div class="w-6 h-6 bg-blue-600 rounded flex items-center justify-center text-white"><i class="fas fa-cube text-xs"></i></div>
                             <span class="font-bold text-slate-800">SoftHub Corp</span>
                        </div>
                    </div>
                    <nav class="p-4 space-y-1">
                        <a href="#" class="flex items-center gap-3 px-3 py-2 text-blue-700 bg-blue-50 rounded-md text-sm font-semibold">
                            <i class="fas fa-home w-4"></i> Home
                        </a>
                         <a href="#" class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:text-slate-900 hover:bg-slate-200/50 rounded-md text-sm font-medium transition-colors">
                            <i class="fas fa-wallet w-4"></i> Payments
                        </a>
                         <a href="#" class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:text-slate-900 hover:bg-slate-200/50 rounded-md text-sm font-medium transition-colors">
                            <i class="fas fa-users w-4"></i> Customers
                        </a>
                        <div class="pt-4 mt-4 border-t border-slate-200">
                             <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 px-2">Settings</div>
                             <a href="#" class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:text-slate-900 hover:bg-slate-200/50 rounded-md text-sm font-medium transition-colors">
                                <i class="fas fa-cog w-4"></i> Preferences
                            </a>
                        </div>
                    </nav>
                </aside>
                
                <!-- Main Content -->
                <main class="flex-1 flex flex-col bg-white">
                    <header class="h-16 border-b border-slate-200 flex items-center justify-between px-8 bg-white">
                        <h2 class="text-lg font-bold text-slate-800">Overview</h2>
                        <div class="flex items-center gap-4">
                            <span class="text-xs font-medium text-slate-500">Last updated: Just now</span>
                            <button class="border border-slate-300 bg-white text-slate-700 px-3 py-1.5 rounded-md text-xs font-semibold hover:bg-slate-50 transition-colors shadow-sm">Export Data</button>
                        </div>
                    </header>
                    
                    <div class="p-8 overflow-y-auto scrollbar-hide">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                             <div class="p-4 rounded-lg bg-white border border-slate-200 shadow-sm">
                                <div class="text-xs font-bold text-slate-400 uppercase mb-1">Gross Volume</div>
                                <div class="text-2xl font-bold text-slate-800">$42,000.00</div>
                             </div>
                             <div class="p-4 rounded-lg bg-white border border-slate-200 shadow-sm">
                                <div class="text-xs font-bold text-slate-400 uppercase mb-1">Net Volume</div>
                                <div class="text-2xl font-bold text-slate-800">$38,124.00</div>
                             </div>
                             <div class="p-4 rounded-lg bg-white border border-slate-200 shadow-sm">
                                <div class="text-xs font-bold text-slate-400 uppercase mb-1">New Customers</div>
                                <div class="text-2xl font-bold text-slate-800">142</div>
                             </div>
                              <div class="p-4 rounded-lg bg-white border border-slate-200 shadow-sm">
                                <div class="text-xs font-bold text-slate-400 uppercase mb-1">Churn Rate</div>
                                <div class="text-2xl font-bold text-slate-800">0.04%</div>
                             </div>
                        </div>

                        <h3 class="text-base font-bold text-slate-800 mb-4">Latest Software Additions</h3>
                        <div class="bg-white border boundary-slate-200 rounded-lg shadow-sm overflow-hidden">
                            <table class="w-full text-left text-sm text-slate-600">
                                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold">
                                    <tr>
                                        <th class="px-6 py-3">Name</th>
                                        <th class="px-6 py-3">Added</th>
                                        <th class="px-6 py-3">Status</th>
                                        <th class="px-6 py-3 text-right">Amount</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    <tr>
                                        <td class="px-6 py-4 font-medium text-slate-900">Office Suite Pro</td>
                                        <td class="px-6 py-4">Oct 24, 2026</td>
                                        <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">Paid</span></td>
                                        <td class="px-6 py-4 text-right font-medium">$49.00</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 font-medium text-slate-900">Avast Antivirus</td>
                                        <td class="px-6 py-4">Oct 23, 2026</td>
                                        <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">Free</span></td>
                                        <td class="px-6 py-4 text-right font-medium">$0.00</td>
                                    </tr>
                                     <tr>
                                        <td class="px-6 py-4 font-medium text-slate-900">Adobe Creative Cloud</td>
                                        <td class="px-6 py-4">Oct 22, 2026</td>
                                        <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">Paid</span></td>
                                        <td class="px-6 py-4 text-right font-medium">$129.00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>


    <!-- OPCIÓN 5: Soft Modern (Friendly) -->
    <div class="relative py-12 bg-gray-50 border-b border-gray-200">
        <div class="absolute top-0 left-0 bg-pink-500 text-white text-xs font-bold px-3 py-1 rounded-br-lg z-20">OPCIÓN 5: Soft Modern (Friendly)</div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="bg-[#f8f9ff] rounded-[2rem] border-4 border-white shadow-xl flex h-[600px] font-space-grotesk overflow-hidden">
                 <!-- Sidebar -->
                <aside class="w-64 bg-white m-4 mr-0 rounded-[1.5rem] flex flex-col shadow-sm hidden md:flex">
                     <div class="p-8 text-center">
                        <div class="w-16 h-16 bg-pink-100 rounded-full mx-auto flex items-center justify-center text-3xl mb-2">🚀</div>
                        <div class="font-bold text-xl">SoftHub</div>
                     </div>
                     <nav class="flex-1 px-4 space-y-2">
                        <a href="#" class="flex items-center gap-3 px-6 py-4 bg-[#f8f9ff] text-gray-900 rounded-2xl font-bold transition-transform hover:scale-105 origin-left">
                             <i class="fas fa-grid-2 text-pink-500"></i> Dashboard
                        </a>
                        <a href="#" class="flex items-center gap-3 px-6 py-4 text-gray-500 hover:bg-[#f8f9ff] hover:text-gray-900 rounded-2xl font-bold transition-all">
                             <i class="fas fa-layer-group"></i> Librería
                        </a>
                        <a href="#" class="flex items-center gap-3 px-6 py-4 text-gray-500 hover:bg-[#f8f9ff] hover:text-gray-900 rounded-2xl font-bold transition-all">
                             <i class="fas fa-comment-alt"></i> Reviews
                        </a>
                     </nav>
                </aside>

                <!-- Content -->
                <main class="flex-1 p-8 flex flex-col">
                    <header class="flex justify-between items-center mb-8">
                         <div>
                            <h2 class="text-3xl font-bold text-gray-900">Hola, Admin!</h2>
                            <p class="text-gray-500">Aquí está lo que está pasando hoy.</p>
                         </div>
                         <div class="flex gap-4">
                            <button class="w-12 h-12 bg-white rounded-2xl shadow-sm flex items-center justify-center text-gray-400 hover:text-pink-500 transition-colors"><i class="fas fa-search"></i></button>
                            <button class="w-12 h-12 bg-white rounded-2xl shadow-sm flex items-center justify-center text-gray-400 hover:text-pink-500 transition-colors"><i class="fas fa-bell"></i></button>
                         </div>
                    </header>

                    <div class="grid grid-cols-3 gap-6 mb-8">
                         <div class="bg-white p-6 rounded-[2rem] shadow-sm hover:shadow-md transition-shadow cursor-pointer">
                            <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-500 text-xl mb-4">📥</div>
                            <div class="font-bold text-4xl mb-1">8,234</div>
                            <div class="text-gray-400 text-sm font-bold">New Downloads</div>
                         </div>
                         <div class="bg-indigo-500 text-white p-6 rounded-[2rem] shadow-lg shadow-indigo-300 transform -rotate-1 hover:rotate-0 transition-transform cursor-pointer">
                             <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center text-white text-xl mb-4">⭐</div>
                             <div class="font-bold text-4xl mb-1">4.9/5</div>
                             <div class="text-indigo-100 text-sm font-bold">User Rating</div>
                         </div>
                         <div class="bg-white p-6 rounded-[2rem] shadow-sm hover:shadow-md transition-shadow cursor-pointer">
                            <div class="w-12 h-12 bg-orange-100 rounded-2xl flex items-center justify-center text-orange-500 text-xl mb-4">🔥</div>
                            <div class="font-bold text-4xl mb-1">12</div>
                            <div class="text-gray-400 text-sm font-bold">Trending Apps</div>
                         </div>
                    </div>
                </main>
            </div>
        </div>
    </div>


</body>
</html>
