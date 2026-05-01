<?php
$currentPage = 'import';
$categories = $db->query("SELECT * FROM categories ORDER BY name")->fetchAll();
ob_start();
?>
<div class="max-w-6xl animate-fade-in-up pb-24 mx-auto">
    
    <!-- Encabezado con efecto Glass -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-6">
        <div>
            <h1 class="text-4xl font-black text-white font-outfit tracking-tight flex items-center gap-4">
                <i class="fas fa-file-import text-blue-400 drop-shadow-[0_0_15px_rgba(96,165,250,0.5)]"></i> 
                Importador Pro
            </h1>
            <p class="text-gray-400 mt-2 font-medium">Extrae datos, genera contenido con IA y publica en segundos.</p>
        </div>
        
        <div class="flex items-center gap-3 bg-white/5 p-2 rounded-2xl border border-white/10 backdrop-blur-xl">
            <div class="flex -space-x-2">
                <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-[10px] font-bold text-white ring-2 ring-gray-900 shadow-lg">IA</div>
                <div class="w-8 h-8 rounded-full bg-purple-500 flex items-center justify-center text-[10px] font-bold text-white ring-2 ring-gray-900 shadow-lg">GP</div>
            </div>
            <span class="text-xs text-gray-400 px-2 font-bold uppercase tracking-tighter">Powered by Gemini 2.0</span>
        </div>
    </div>

    <!-- Buscador Futurista -->
    <div class="glass-panel p-10 rounded-[2.5rem] relative overflow-hidden mb-12 shadow-2xl">
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-blue-600/10 rounded-full blur-[80px]"></div>
        <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-purple-600/10 rounded-full blur-[80px]"></div>
        
        <div class="max-w-3xl mx-auto relative z-10">
            <h2 class="text-center text-gray-500 uppercase text-[10px] font-black tracking-[0.3em] mb-8">Ecosistema de Importación Inteligente</h2>
            
            <div class="flex flex-col md:flex-row gap-4">
                <div class="relative flex-1 group">
                    <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-blue-400 transition"></i>
                    <input type="text" id="searchInput" placeholder="Busca Netflix, Spotify, Minecraft..." 
                           class="w-full pl-14 pr-6 py-5 rounded-2xl bg-white/5 border border-white/10 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-transparent transition-all text-lg placeholder-gray-600 shadow-inner">
                </div>
                <button id="searchBtn" class="bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white px-10 py-5 rounded-2xl font-bold transition-all hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-3 shadow-xl shadow-blue-600/30">
                    <span>BUSCAR</span>
                    <i class="fas fa-magic text-yellow-300"></i>
                </button>
            </div>
            
            <div class="mt-8 flex items-center gap-4">
                <div class="h-px bg-white/5 flex-1"></div>
                <span class="text-[9px] text-gray-500 uppercase font-black tracking-widest bg-gray-900 px-4 py-1.5 rounded-full border border-white/5">O pega la URL directa</span>
                <div class="h-px bg-white/5 flex-1"></div>
            </div>

            <div class="mt-6 flex gap-3">
                <input type="text" id="directUrlInput" placeholder="https://play.google.com/store/apps/details?id=..." 
                       class="flex-1 px-5 py-3 rounded-xl bg-black/40 border border-white/5 text-xs text-blue-300 focus:outline-none focus:border-blue-500/50 transition font-mono">
                <button onclick="loadDetails(document.getElementById('directUrlInput').value)" 
                        class="bg-gray-800 hover:bg-white hover:text-black text-white px-6 py-3 rounded-xl text-[10px] font-black transition-all uppercase tracking-wider border border-white/10 shadow-lg">
                    EXTRAER
                </button>
            </div>
        </div>
    </div>

    <!-- Sección de Novedades -->
    <div class="mb-12">
        <div class="flex items-center justify-between mb-6 px-2">
            <h3 class="text-xl font-bold text-white flex items-center gap-3">
                <span class="w-10 h-10 rounded-xl bg-orange-500/10 flex items-center justify-center">
                    <i class="fas fa-fire text-orange-500 animate-pulse"></i>
                </span>
                Últimas Novedades
            </h3>
            <div class="flex bg-white/5 p-1.5 rounded-xl border border-white/10 backdrop-blur-md">
                <button onclick="loadDiscover('apps')" id="discoverAppsBtn" class="px-5 py-1.5 text-xs font-bold rounded-lg bg-blue-600 text-white shadow-lg transition-all duration-300">Apps</button>
                <button onclick="loadDiscover('games')" id="discoverGamesBtn" class="px-5 py-1.5 text-xs font-bold rounded-lg text-gray-400 hover:text-white transition-all duration-300">Juegos</button>
            </div>
        </div>
        
        <div id="discoverResults" class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-5">
            <?php for($i=0; $i<6; $i++): ?>
                <div class="glass-panel h-36 rounded-[2rem] animate-pulse border border-white/5"></div>
            <?php endfor; ?>
        </div>
    </div>

    <!-- Resultados de Búsqueda -->
    <div id="searchResults" class="hidden glass-panel p-10 rounded-[2.5rem] border border-blue-500/30 mb-12 relative overflow-hidden shadow-2xl">
        <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500/10 rounded-full blur-[80px]"></div>
        <div class="col-span-full mb-8 flex items-center justify-between relative z-10">
            <h3 class="font-black text-blue-400 flex items-center gap-3 uppercase tracking-tighter text-xl">
                <i class="fas fa-search-plus"></i> 
                Resultados del Radar
            </h3>
            <button onclick="document.getElementById('searchResults').classList.add('hidden')" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-gray-400 hover:bg-red-500/20 hover:text-red-400 transition-all border border-white/5">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 relative z-10">
            <!-- JS inyectará aquí -->
        </div>
    </div>

    <!-- Formulario de Importación (Oculto inicialmente) -->
    <form id="importForm" action="<?= url('admin/import/store') ?>" method="POST" class="hidden space-y-12 animate-fade-in-up">
        <input type="hidden" name="original_url" id="originalUrl">
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- Lado Izquierdo: Visual -->
            <div class="space-y-10">
                <div class="glass-panel p-10 rounded-[3rem] border border-white/5 relative overflow-hidden shadow-2xl">
                    <h3 class="text-[10px] font-black text-gray-500 uppercase tracking-[0.3em] mb-10 text-center">ADN Visual del Software</h3>
                    
                    <div class="flex flex-col items-center gap-8">
                        <div class="relative group">
                            <div class="w-40 h-40 rounded-[3rem] bg-black/40 border-2 border-white/10 p-3 overflow-hidden group-hover:border-blue-500/50 transition-all duration-700 shadow-[0_20px_50px_rgba(0,0,0,0.5)]">
                                <img id="previewIcon" src="" class="w-full h-full object-cover rounded-[2.2rem]">
                            </div>
                            <div class="absolute -bottom-2 -right-2 w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center text-white shadow-lg border-4 border-gray-900 group-hover:scale-110 transition-transform">
                                <i class="fas fa-fingerprint text-sm"></i>
                            </div>
                        </div>
                        
                        <div class="w-full space-y-6">
                            <div class="group">
                                <label class="block text-[9px] font-black text-gray-500 uppercase mb-3 tracking-widest px-2">Vector de Icono (URL)</label>
                                <input type="text" name="icon" id="iconUrl" class="w-full bg-white/5 border border-white/10 rounded-2xl px-5 py-4 text-xs text-blue-300 focus:outline-none focus:border-blue-500/50 transition-all group-hover:bg-white/10">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lado Derecho: Contenido -->
            <div class="lg:col-span-2 space-y-10">
                <div class="glass-panel p-12 rounded-[3.5rem] border border-white/5 relative overflow-hidden shadow-2xl">
                    <div class="absolute top-0 right-0 w-80 h-80 bg-blue-600/10 rounded-full blur-[100px] -mr-40 -mt-40"></div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                        <div class="md:col-span-2 relative group">
                            <label class="block text-[9px] font-black text-gray-500 uppercase mb-3 tracking-widest px-2">Denominación del Software</label>
                            <input type="text" name="name" id="softwareName" required class="w-full bg-white/5 border border-white/10 rounded-[1.5rem] px-8 py-5 text-white text-3xl font-black focus:outline-none focus:border-blue-500/50 transition-all shadow-inner group-hover:bg-white/10">
                        </div>
                        <div class="group">
                            <label class="block text-[9px] font-black text-gray-500 uppercase mb-3 tracking-widest px-2">Laboratorio / Desarrollador</label>
                            <input type="text" name="developer" id="developerName" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white font-bold focus:outline-none focus:border-blue-500/50 transition-all group-hover:bg-white/10">
                        </div>
                        <div class="group">
                            <label class="block text-[9px] font-black text-gray-500 uppercase mb-3 tracking-widest px-2">Versión de Lanzamiento</label>
                            <input type="text" name="version" id="softwareVersion" value="1.0.0" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white font-bold focus:outline-none focus:border-blue-500/50 transition-all group-hover:bg-white/10">
                        </div>
                    </div>

                    <!-- Enlaces de Descarga Estilo Premium -->
                    <div class="border-t border-white/5 pt-10">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-xl font-black text-white flex items-center gap-4">
                                <span class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center">
                                    <i class="fas fa-satellite-dish text-emerald-500"></i>
                                </span>
                                Canales de Distribución
                            </h3>
                            <button type="button" onclick="addDownloadLink()" class="bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-400 px-6 py-3 rounded-xl text-[10px] font-black transition-all flex items-center gap-3 border border-emerald-500/20 uppercase tracking-widest">
                                <i class="fas fa-plus"></i> Añadir Nodo
                            </button>
                        </div>
                        
                        <div id="linksContainer" class="space-y-6">
                            <!-- Inyectado dinámicamente -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel de Acción Inferior -->
        <div class="fixed bottom-10 left-1/2 -translate-x-1/2 z-50 w-full max-w-xl px-6">
            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 hover:from-blue-500 hover:via-indigo-500 hover:to-purple-500 text-white font-black py-6 rounded-[2rem] shadow-[0_25px_60px_rgba(79,70,229,0.4)] flex items-center justify-center gap-5 transition-all hover:scale-[1.03] hover:-translate-y-2 group border border-white/20 backdrop-blur-xl">
                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center group-hover:rotate-[360deg] transition-all duration-1000">
                    <i class="fas fa-rocket text-xl"></i>
                </div>
                <span class="text-xl tracking-tight uppercase font-outfit">Sincronizar y Publicar</span>
            </button>
        </div>
    </form>
</div>

<script>
    const searchInput = document.getElementById('searchInput');
    const searchBtn = document.getElementById('searchBtn');
    const searchResults = document.getElementById('searchResults');
    const importForm = document.getElementById('importForm');
    const linksContainer = document.getElementById('linksContainer');
    
    let linkCount = 1;

    // CARGAR NOVEDADES AL INICIO
    loadDiscover('apps');

    async function loadDiscover(type) {
        const container = document.getElementById('discoverResults');
        const appsBtn = document.getElementById('discoverAppsBtn');
        const gamesBtn = document.getElementById('discoverGamesBtn');

        if(type === 'apps') {
            appsBtn.className = 'px-5 py-1.5 text-xs font-bold rounded-lg bg-blue-600 text-white shadow-lg transition-all duration-300';
            gamesBtn.className = 'px-5 py-1.5 text-xs font-bold rounded-lg text-gray-400 hover:text-white transition-all duration-300';
        } else {
            gamesBtn.className = 'px-5 py-1.5 text-xs font-bold rounded-lg bg-blue-600 text-white shadow-lg transition-all duration-300';
            appsBtn.className = 'px-5 py-1.5 text-xs font-bold rounded-lg text-gray-400 hover:text-white transition-all duration-300';
        }

        container.innerHTML = '<?php for($i=0; $i<6; $i++): ?><div class="glass-panel h-36 rounded-[2rem] animate-pulse border border-white/5"></div><?php endfor; ?>';

        try {
            const response = await fetch(`<?= url('admin/import/discover') ?>?type=${type}`);
            const data = await response.json();
            
            if(data.success && data.results.length > 0) {
                container.innerHTML = '';
                data.results.forEach(app => {
                    const card = document.createElement('div');
                    card.className = 'glass-panel p-4 rounded-[2rem] border border-white/5 shadow-xl hover:shadow-blue-500/10 hover:border-blue-500/30 transition-all duration-500 cursor-pointer flex flex-col items-center text-center group active:scale-95';
                    card.innerHTML = `
                        <div class="relative mb-3">
                            <img src="${app.icon}" class="w-20 h-20 rounded-[1.5rem] shadow-2xl group-hover:scale-110 transition-transform duration-700 object-cover border-2 border-white/5">
                            <div class="absolute inset-0 bg-blue-600/20 opacity-0 group-hover:opacity-100 rounded-[1.5rem] transition-opacity duration-500"></div>
                        </div>
                        <h4 class="font-black text-white text-[10px] line-clamp-2 leading-tight uppercase tracking-tighter h-7 group-hover:text-blue-400 transition-colors">${app.title}</h4>
                    `;
                    card.onclick = () => loadDetails(app.url);
                    container.appendChild(card);
                });
            }
        } catch (e) { console.error(e); }
    }

    // BUSCAR EN GOOGLE PLAY
    searchBtn.addEventListener('click', async () => {
        const query = searchInput.value.trim();
        if(!query) return;

        searchBtn.disabled = true;
        searchBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        
        Array.from(searchResults.children).forEach(child => {
            if(!child.classList.contains('col-span-full')) child.remove();
        });
        
        searchResults.classList.remove('hidden');

        try {
            const response = await fetch(`<?= url('admin/import/search') ?>?q=${encodeURIComponent(query)}`);
            const data = await response.json();
            
            if(data.success && data.results.length > 0) {
                const grid = searchResults.querySelector('.grid');
                data.results.forEach(app => {
                    const card = document.createElement('div');
                    card.className = 'glass-panel p-5 rounded-3xl border border-white/5 shadow-2xl hover:shadow-blue-600/20 hover:border-blue-500/50 transition-all duration-500 cursor-pointer flex items-center gap-5 group relative overflow-hidden active:scale-95';
                    card.innerHTML = `
                        <div class="absolute top-0 left-0 w-1.5 h-full bg-blue-500 opacity-0 group-hover:opacity-100 transition-all"></div>
                        <img src="${app.icon}" class="w-16 h-16 rounded-2xl shadow-2xl group-hover:rotate-6 transition-transform duration-500 object-cover border border-white/10">
                        <div class="flex-1 min-w-0">
                            <h4 class="font-black text-white truncate text-sm mb-1 uppercase tracking-tighter">${app.title}</h4>
                            <p class="text-[9px] text-gray-500 font-black truncate italic uppercase tracking-widest">${app.developer}</p>
                            <div class="mt-2 flex items-center gap-2 text-[9px] text-blue-400 font-black uppercase tracking-[0.2em]">
                                <i class="fas fa-download animate-bounce"></i> SINCRONIZAR
                            </div>
                        </div>
                    `;
                    card.addEventListener('click', () => loadDetails(app.url));
                    grid.appendChild(card);
                });
                searchResults.scrollIntoView({ behavior: 'smooth', block: 'start' });
            } else {
                const grid = searchResults.querySelector('.grid');
                grid.innerHTML = '<div class="col-span-full p-16 text-center text-gray-500 font-black uppercase tracking-[0.3em] opacity-30"><i class="fas fa-radar text-5xl mb-4 block"></i> Sin señales del objetivo</div>';
            }
        } catch (e) { alert('Error de enlace con el radar'); } 
        finally {
            searchBtn.disabled = false;
            searchBtn.innerHTML = '<span>BUSCAR</span><i class="fas fa-bolt text-yellow-300"></i>';
        }
    });

    async function loadDetails(url) {
        if(!url) return;
        
        // Efecto de carga global
        const overlay = document.createElement('div');
        overlay.className = 'fixed inset-0 z-[100] bg-gray-900/80 backdrop-blur-md flex flex-col items-center justify-center';
        overlay.innerHTML = '<div class="w-16 h-16 border-4 border-blue-500 border-t-transparent rounded-full animate-spin mb-4"></div><p class="text-white font-black uppercase tracking-widest animate-pulse">Analizando Software...</p>';
        document.body.appendChild(overlay);

        try {
            const response = await fetch(`<?= url('admin/import/details') ?>?url=${encodeURIComponent(url)}`);
            const data = await response.json();
            
            if(data.success) {
                document.getElementById('originalUrl').value = url;
                document.getElementById('softwareName').value = data.data.title;
                document.getElementById('developerName').value = data.data.developer;
                document.getElementById('softwareVersion').value = data.data.version || '1.0.0';
                document.getElementById('iconUrl').value = data.data.icon;
                document.getElementById('previewIcon').src = data.data.icon;

                linksContainer.innerHTML = '';
                addDownloadLink();

                importForm.classList.remove('hidden');
                importForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
                searchResults.classList.add('hidden');
            } else {
                alert('Error: ' + (data.error || 'Falla desconocida en la extracción'));
            }
        } catch (e) { 
            console.error(e);
            alert('Falla crítica en la comunicación con el servidor'); 
        }
        finally { overlay.remove(); }
    }

    function addDownloadLink() {
        const index = linkCount++;
        const div = document.createElement('div');
        div.className = 'glass-panel p-6 rounded-3xl border border-white/5 shadow-xl relative group animate-fade-in-up';
        div.innerHTML = `
            <div class="flex items-center justify-between mb-5">
                <h4 class="text-[10px] font-black text-blue-400 uppercase tracking-widest flex items-center gap-2">
                    <i class="fas fa-link"></i> Canal de Descarga #${index}
                </h4>
                ${index > 1 ? `<button type="button" onclick="this.closest('.glass-panel').remove()" class="text-red-500 hover:text-red-400 transition-colors text-xs"><i class="fas fa-trash"></i></button>` : ''}
            </div>
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <div class="md:col-span-3">
                    <select name="download_links[${index}][platform]" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-xs focus:outline-none">
                        <option value="Windows">Windows</option>
                        <option value="Android">Android</option>
                        <option value="iOS">iOS</option>
                        <option value="Torrent">Torrent / Magnet</option>
                        <option value="Directo">Enlace Directo</option>
                    </select>
                </div>
                <div class="md:col-span-6">
                    <input type="text" name="download_links[${index}][url]" placeholder="URL de descarga o Magnet" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-xs focus:outline-none focus:border-blue-500/50 font-mono">
                </div>
                <div class="md:col-span-3">
                    <input type="text" name="download_links[${index}][size]" placeholder="Tamaño (ej: 50MB)" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-xs focus:outline-none">
                </div>
            </div>
        `;
        linksContainer.appendChild(div);
    }

    // Actualizar previews al cambiar inputs manuales
    document.getElementById('iconUrl').addEventListener('input', (e) => {
        document.getElementById('previewIcon').src = e.target.value;
    });
</script>

<style>
    @keyframes bounce-slow {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    .animate-bounce-slow {
        animation: bounce-slow 3s infinite ease-in-out;
    }
    .glass-panel {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
    }
    input, textarea, select {
        box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.05);
    }
    .font-outfit { font-family: 'Outfit', sans-serif; }
    .font-inter { font-family: 'Inter', sans-serif; }
</style>

<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/admin.php';
?>
