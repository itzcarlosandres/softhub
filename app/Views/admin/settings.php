<?php
$currentPage = 'settings';
$pageTitle = 'Configuración del Sitio';
$pageDescription = 'Ajusta las configuraciones generales';

// Obtener configuraciones
$settingsModel = new \App\Models\SiteSetting();
$settings = [];
foreach ($settingsModel->getAll() as $setting) {
    $settings[$setting['setting_key']] = $setting;
}

// Stats Simples para Sidebar
$totalSoftware = $db->query("SELECT COUNT(*) as total FROM software WHERE status = 'approved'")->fetch()['total'];
$totalCategories = $db->query("SELECT COUNT(*) as total FROM categories")->fetch()['total'];
$totalDownloads = $db->query("SELECT SUM(downloads) as total FROM software")->fetch()['total'];

ob_start();
?>

<div class="max-w-7xl animate-fade-in-up pb-24">
    
    <!-- Title -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white font-outfit flex items-center gap-3">
            <i class="fas fa-sliders-h text-blue-400"></i> Configuración
        </h1>
        <p class="text-gray-400 mt-1">Personaliza cada aspecto de SoftHub.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <!-- Main Form -->
        <div class="lg:col-span-3 space-y-8">
            <form method="POST" action="" enctype="multipart/form-data" class="space-y-6">
            
            <!-- License Section -->
            <div class="glass-panel p-6 relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <i class="fas fa-key text-6xl text-yellow-500"></i>
                </div>
                
                <h3 class="text-sm font-bold text-white mb-4 flex items-center gap-2">
                    <i class="fas fa-shield-alt text-yellow-400"></i> Licencia del Producto
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Clave de Activación</label>
                        <div class="flex gap-2">
                            <input type="text" name="setting_license_key" 
                                   value="<?= htmlspecialchars($settings['license_key']['setting_value'] ?? '') ?>"
                                   placeholder="XXXX-XXXX-XXXX-XXXX"
                                   class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-2 text-white placeholder-gray-600 focus:outline-none focus:border-yellow-500/50 transition-colors font-mono">
                            <!-- El botón de validación se haría vía AJAX o al guardar -->
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Introduce la clave recibida en tu compra para recibir actualizaciones.</p>
                    </div>

                    <div class="bg-white/5 rounded-xl p-4 border border-white/5 flex items-center justify-between">
                        <div>
                            <div class="text-xs text-gray-400 mb-1">Estado de Licencia</div>
                            <?php 
                                $licenseStatus = $settings['license_status']['setting_value'] ?? 'inactive';
                                $isActive = $licenseStatus === 'active';
                            ?>
                            <div class="font-bold text-lg <?= $isActive ? 'text-green-400' : 'text-red-400' ?> flex items-center gap-2">
                                <i class="fas fa-circle text-[10px]"></i>
                                <?= $isActive ? 'LICENCIA ACTIVA' : 'NO ACTIVADO' ?>
                            </div>
                        </div>
                        <?php if($isActive): ?>
                            <div class="text-green-500 bg-green-500/10 p-2 rounded-lg">
                                <i class="fas fa-check-circle text-2xl"></i>
                            </div>
                        <?php else: ?>
                            <div class="text-red-500 bg-red-500/10 p-2 rounded-lg">
                                <i class="fas fa-lock text-2xl"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

                <!-- General Settings -->
                <div class="glass-panel p-8 rounded-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/10 rounded-full blur-[50px] -mr-10 -mt-10"></div>
                    
                    <h2 class="text-xl font-bold text-white font-outfit mb-6 flex items-center gap-2 relative z-10">
                        <i class="fas fa-globe text-blue-400"></i> General
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative z-10">
                        <div class="col-span-2">
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Nombre del Sitio</label>
                            <input type="text" name="setting_site_name" id="site_name"
                                   value="<?= htmlspecialchars($settings['site_name']['setting_value'] ?? 'SoftHub') ?>"
                                   class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500/50 focus:bg-white/10 transition-all placeholder-gray-600">
                        </div>

                        <div class="col-span-2">
                            <div class="flex justify-between items-center mb-2">
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Descripción</label>
                                <button type="button" onclick="generateSiteInfo('description')" class="text-[10px] bg-blue-500/10 hover:bg-blue-500/20 text-blue-400 px-2 py-1 rounded border border-blue-500/20 transition-all flex items-center gap-1">
                                    <i class="fas fa-magic"></i> Auto-generar con IA
                                </button>
                            </div>
                            <textarea name="setting_site_description" id="site_description" rows="2"
                                      class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500/50 focus:bg-white/10 transition-all placeholder-gray-600 resize-none"><?= htmlspecialchars($settings['site_description']['setting_value'] ?? 'Descarga el mejor software gratis') ?></textarea>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Programas por Página</label>
                            <input type="number" name="setting_items_per_page" 
                                   value="<?= $settings['items_per_page']['setting_value'] ?? 24 ?>"
                                   min="12" max="48" step="6"
                                   class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500/50 transition-all">
                        </div>
                    </div>
                </div>

                <!-- Homepage Settings -->
                <div class="glass-panel p-8 rounded-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-purple-500/10 rounded-full blur-[50px] -mr-10 -mt-10"></div>
                    
                    <h2 class="text-xl font-bold text-white font-outfit mb-6 flex items-center gap-2 relative z-10">
                        <i class="fas fa-home text-purple-400"></i> Página de Inicio
                    </h2>

                    <div class="space-y-6 relative z-10 mb-8 border-b border-white/5 pb-8">
                        <h4 class="text-sm font-bold text-white mb-4 flex items-center gap-2">
                             <i class="fas fa-magic text-purple-400"></i> Título Dinámico (Efecto Typewriter)
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-2">
                                <label class="flex items-center gap-3 cursor-pointer p-3 bg-white/5 rounded-xl border border-white/5 hover:bg-white/10 transition-colors mb-4">
                                    <input type="checkbox" name="setting_home_hero_dynamic_active" value="1" 
                                           <?= ($settings['home_hero_dynamic_active']['setting_value'] ?? '0') == '1' ? 'checked' : '' ?>
                                           class="w-5 h-5 rounded border-gray-600 text-purple-500 focus:ring-purple-500 bg-gray-700">
                                    <span class="text-sm text-gray-300 font-medium">Habilitar Título Dinámico</span>
                                </label>
                            </div>
                            
                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Texto del Título (Antes del cambio)</label>
                                <input type="text" name="setting_home_hero_dynamic_prefix" 
                                       value="<?= htmlspecialchars($settings['home_hero_dynamic_prefix']['setting_value'] ?? 'Descubre') ?>"
                                       placeholder="Ej: Descubre"
                                       class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-purple-500/50 transition-all">
                                <p class="text-[10px] text-gray-500 mt-1">Texto que permanece fijo antes de las palabras que cambian.</p>
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Palabras a Cambiar</label>
                                <input type="text" name="setting_home_hero_dynamic_text" 
                                       value="<?= htmlspecialchars($settings['home_hero_dynamic_text']['setting_value'] ?? 'Programas Full, Apps Premium, Juegos PC') ?>"
                                       placeholder="Separadas por comas"
                                       class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-purple-500/50 transition-all font-mono text-sm">
                                <p class="text-[10px] text-gray-500 mt-1">Escribe las palabras separadas por comas. Ej: Programas Full, Apps Premium, Juegos PC</p>
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Texto del Título (Después del cambio)</label>
                                <input type="text" name="setting_home_hero_dynamic_suffix" 
                                       value="<?= htmlspecialchars($settings['home_hero_dynamic_suffix']['setting_value'] ?? '') ?>"
                                       placeholder="Opcional. Ej: Totalmente Gratis"
                                       class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-purple-500/50 transition-all">
                                <p class="text-[10px] text-gray-500 mt-1">Texto fijo que irá después de las palabras dinámicas.</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6 relative z-10 mb-8 border-b border-white/5 pb-8">
                        <h4 class="text-sm font-bold text-white mb-4 flex items-center gap-2">
                             <i class="fas fa-layer-group text-blue-400"></i> Efectos Visuales del Hero
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <label class="flex items-center gap-3 cursor-pointer p-3 bg-white/5 rounded-xl border border-white/5 hover:bg-white/10 transition-colors">
                                <input type="checkbox" name="setting_home_hero_dots_active" value="1" 
                                       <?= ($settings['home_hero_dots_active']['setting_value'] ?? '0') == '1' ? 'checked' : '' ?>
                                       class="w-5 h-5 rounded border-gray-600 text-blue-500 focus:ring-blue-500 bg-gray-700">
                                <span class="text-sm text-gray-300 font-medium">Habilitar Fondo de Puntos (Dots)</span>
                            </label>
                            
                            <label class="flex items-center gap-3 cursor-pointer p-3 bg-white/5 rounded-xl border border-white/5 hover:bg-white/10 transition-colors">
                                <input type="checkbox" name="setting_home_hero_spotlight_active" value="1" 
                                       <?= ($settings['home_hero_spotlight_active']['setting_value'] ?? '0') == '1' ? 'checked' : '' ?>
                                       class="w-5 h-5 rounded border-gray-600 text-blue-500 focus:ring-blue-500 bg-gray-700">
                                <span class="text-sm text-gray-300 font-medium">Habilitar Efecto Luz (Spotlight)</span>
                            </label>
                        </div>
                    </div>

                    <div class="space-y-6 relative z-10 mb-8 border-b border-white/5 pb-8">
                        <h4 class="text-sm font-bold text-white mb-4">Textos Principales (Hero)</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Título Principal (Fijo)</label>
                                <input type="text" name="setting_home_hero_title" 
                                       value="<?= htmlspecialchars($settings['home_hero_title']['setting_value'] ?? 'Descubre Software Premium & Verificado') ?>"
                                       class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-purple-500/50 transition-all font-bold text-lg placeholder-white/20">
                                <p class="text-[10px] text-gray-500 mt-1">Título que se muestra si el título dinámico está desactivado.</p>
                            </div>
                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Subtítulo</label>
                                <textarea name="setting_home_hero_subtitle" rows="2"
                                          class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-purple-500/50 transition-all resize-none placeholder-white/20"><?= htmlspecialchars($settings['home_hero_subtitle']['setting_value'] ?? 'Catálogo curado de las mejores herramientas digitales.') ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 relative z-10 mb-8">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Últimos Agregados</label>
                            <input type="number" name="setting_home_latest_count" 
                                   value="<?= $settings['home_latest_count']['setting_value'] ?? 12 ?>"
                                   class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-purple-500/50 transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Software Destacado</label>
                            <input type="number" name="setting_home_featured_count" 
                                   value="<?= $settings['home_featured_count']['setting_value'] ?? 8 ?>"
                                   class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-purple-500/50 transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Top Descargas</label>
                            <input type="number" name="setting_home_top_downloads" 
                                   value="<?= $settings['home_top_downloads']['setting_value'] ?? 10 ?>"
                                   class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-purple-500/50 transition-all">
                        </div>
                    </div>

                    <!-- Layout Selector -->
                    <div class="mb-8 relative z-10">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Diseño de "Últimos agregados"</label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="relative flex flex-col items-center p-4 border rounded-xl cursor-pointer transition-all group <?= ($settings['home_latest_layout']['setting_value'] ?? 'grid') == 'grid' ? 'border-purple-500 bg-purple-500/10' : 'border-white/10 bg-white/5 hover:bg-white/10' ?>" onclick="selectLayout('grid')">
                                <input type="radio" name="setting_home_latest_layout" value="grid" class="hidden" <?= ($settings['home_latest_layout']['setting_value'] ?? 'grid') == 'grid' ? 'checked' : '' ?>>
                                <i class="fas fa-th text-2xl mb-2 <?= ($settings['home_latest_layout']['setting_value'] ?? 'grid') == 'grid' ? 'text-purple-400' : 'text-gray-500' ?>"></i>
                                <span class="text-xs font-bold <?= ($settings['home_latest_layout']['setting_value'] ?? 'grid') == 'grid' ? 'text-purple-300' : 'text-gray-400' ?>">Cuadrícula (Grid)</span>
                            </label>
                            
                            <label class="relative flex flex-col items-center p-4 border rounded-xl cursor-pointer transition-all group <?= ($settings['home_latest_layout']['setting_value'] ?? 'grid') == 'list' ? 'border-purple-500 bg-purple-500/10' : 'border-white/10 bg-white/5 hover:bg-white/10' ?>" onclick="selectLayout('list')">
                                <input type="radio" name="setting_home_latest_layout" value="list" class="hidden" <?= ($settings['home_latest_layout']['setting_value'] ?? 'grid') == 'list' ? 'checked' : '' ?>>
                                <i class="fas fa-list text-2xl mb-2 <?= ($settings['home_latest_layout']['setting_value'] ?? 'grid') == 'list' ? 'text-purple-400' : 'text-gray-500' ?>"></i>
                                <span class="text-xs font-bold <?= ($settings['home_latest_layout']['setting_value'] ?? 'grid') == 'list' ? 'text-purple-300' : 'text-gray-400' ?>">Lista (List)</span>
                            </label>
                        </div>
                    </div>

                    <!-- Grid Customization -->
                    <div class="relative z-10 border-t border-white/5 pt-6">
                        <h3 class="text-sm font-bold text-white mb-4 flex items-center gap-2">
                            <i class="fas fa-border-all text-purple-400"></i> Configuración de Columnas
                        </h3>
                        <div class="space-y-6">
                            <!-- Desktop -->
                            <div>
                                <div class="flex justify-between mb-2">
                                    <label class="text-xs text-gray-400">Escritorio (Desktop)</label>
                                    <span class="text-xs font-mono text-purple-400 bg-purple-500/10 px-2 rounded" id="grid_cols_val"><?= $settings['home_latest_grid_cols']['setting_value'] ?? 8 ?> cols</span>
                                </div>
                                <input type="range" name="setting_home_latest_grid_cols" 
                                       id="grid_cols_slider" oninput="updateRangeVal(this, 'grid_cols_val')"
                                       value="<?= $settings['home_latest_grid_cols']['setting_value'] ?? 8 ?>"
                                       min="4" max="12" step="1"
                                       class="w-full h-1 bg-white/10 rounded-lg appearance-none cursor-pointer accent-purple-500">
                            </div>

                            <!-- Tablet -->
                            <div>
                                <div class="flex justify-between mb-2">
                                    <label class="text-xs text-gray-400">Tablet</label>
                                    <span class="text-xs font-mono text-blue-400 bg-blue-500/10 px-2 rounded" id="grid_cols_md_val"><?= $settings['home_latest_grid_cols_md']['setting_value'] ?? 4 ?> cols</span>
                                </div>
                                <input type="range" name="setting_home_latest_grid_cols_md" 
                                       id="grid_cols_slider_md" oninput="updateRangeVal(this, 'grid_cols_md_val')"
                                       value="<?= $settings['home_latest_grid_cols_md']['setting_value'] ?? 4 ?>"
                                       min="2" max="6" step="1"
                                       class="w-full h-1 bg-white/10 rounded-lg appearance-none cursor-pointer accent-blue-500">
                            </div>

                            <!-- Mobile -->
                            <div>
                                <div class="flex justify-between mb-2">
                                    <label class="text-xs text-gray-400">Móvil</label>
                                    <span class="text-xs font-mono text-green-400 bg-green-500/10 px-2 rounded" id="grid_cols_sm_val"><?= $settings['home_latest_grid_cols_sm']['setting_value'] ?? 2 ?> cols</span>
                                </div>
                                <input type="range" name="setting_home_latest_grid_cols_sm" 
                                       id="grid_cols_slider_sm" oninput="updateRangeVal(this, 'grid_cols_sm_val')"
                                       value="<?= $settings['home_latest_grid_cols_sm']['setting_value'] ?? 2 ?>"
                                       min="1" max="3" step="1"
                                       class="w-full h-1 bg-white/10 rounded-lg appearance-none cursor-pointer accent-green-500">
                            </div>
                        </div>
                        
                        <!-- Card Elements Configuration -->
                        <div class="mt-6 pt-6 border-t border-white/5">
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Elementos Visibles en Tarjetas</label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <label class="flex items-center p-3 bg-white/5 rounded-lg border border-white/5 hover:bg-white/10 transition-colors cursor-pointer group">
                                    <input type="checkbox" name="setting_card_show_icon" value="1" <?= ($settings['card_show_icon']['setting_value'] ?? '1') == '1' ? 'checked' : '' ?> class="w-4 h-4 rounded border-gray-600 text-purple-500 focus:ring-purple-500 bg-gray-700">
                                    <span class="ml-2 text-sm text-gray-300 group-hover:text-white transition-colors">Icono</span>
                                </label>
                                <label class="flex items-center p-3 bg-white/5 rounded-lg border border-white/5 hover:bg-white/10 transition-colors cursor-pointer group">
                                    <input type="checkbox" name="setting_card_show_description" value="1" <?= ($settings['card_show_description']['setting_value'] ?? '1') == '1' ? 'checked' : '' ?> class="w-4 h-4 rounded border-gray-600 text-purple-500 focus:ring-purple-500 bg-gray-700">
                                    <span class="ml-2 text-sm text-gray-300 group-hover:text-white transition-colors">Descripción</span>
                                </label>
                                <label class="flex items-center p-3 bg-white/5 rounded-lg border border-white/5 hover:bg-white/10 transition-colors cursor-pointer group">
                                    <input type="checkbox" name="setting_card_show_rating" value="1" <?= ($settings['card_show_rating']['setting_value'] ?? '1') == '1' ? 'checked' : '' ?> class="w-4 h-4 rounded border-gray-600 text-purple-500 focus:ring-purple-500 bg-gray-700">
                                    <span class="ml-2 text-sm text-gray-300 group-hover:text-white transition-colors">Valoración</span>
                                </label>
                                <label class="flex items-center p-3 bg-white/5 rounded-lg border border-white/5 hover:bg-white/10 transition-colors cursor-pointer group">
                                    <input type="checkbox" name="setting_card_show_downloads" value="1" <?= ($settings['card_show_downloads']['setting_value'] ?? '1') == '1' ? 'checked' : '' ?> class="w-4 h-4 rounded border-gray-600 text-purple-500 focus:ring-purple-500 bg-gray-700">
                                    <span class="ml-2 text-sm text-gray-300 group-hover:text-white transition-colors">Descargas</span>
                                </label>
                                <label class="flex items-center p-3 bg-white/5 rounded-lg border border-white/5 hover:bg-white/10 transition-colors cursor-pointer group">
                                    <input type="checkbox" name="setting_card_show_price" value="1" <?= ($settings['card_show_price']['setting_value'] ?? '1') == '1' ? 'checked' : '' ?> class="w-4 h-4 rounded border-gray-600 text-purple-500 focus:ring-purple-500 bg-gray-700">
                                    <span class="ml-2 text-sm text-gray-300 group-hover:text-white transition-colors">Precio/Gratis</span>
                                </label>
                                <label class="flex items-center p-3 bg-white/5 rounded-lg border border-white/5 hover:bg-white/10 transition-colors cursor-pointer group">
                                    <input type="checkbox" name="setting_card_show_badges" value="1" <?= ($settings['card_show_badges']['setting_value'] ?? '1') == '1' ? 'checked' : '' ?> class="w-4 h-4 rounded border-gray-600 text-purple-500 focus:ring-purple-500 bg-gray-700">
                                    <span class="ml-2 text-sm text-gray-300 group-hover:text-white transition-colors">Badges</span>
                                </label>
                                <label class="flex items-center p-3 bg-white/5 rounded-lg border border-white/5 hover:bg-white/10 transition-colors cursor-pointer group">
                                    <input type="checkbox" name="setting_card_show_button" value="1" <?= ($settings['card_show_button']['setting_value'] ?? '1') == '1' ? 'checked' : '' ?> class="w-4 h-4 rounded border-gray-600 text-purple-500 focus:ring-purple-500 bg-gray-700">
                                    <span class="ml-2 text-sm text-gray-300 group-hover:text-white transition-colors">Botón</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Download Settings -->
                <div class="glass-panel p-8 rounded-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/10 rounded-full blur-[50px] -mr-10 -mt-10"></div>
                    
                    <h2 class="text-xl font-bold text-white font-outfit mb-6 flex items-center gap-2 relative z-10">
                        <i class="fas fa-download text-blue-400"></i> Configuración de Descargas
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative z-10">
                        <div>
                            <div class="flex justify-between mb-2">
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Tiempo de Espera (Segundos)</label>
                                <span class="text-xs font-mono text-blue-400 bg-blue-500/10 px-2 rounded" id="download_wait_val"><?= $settings['download_countdown']['setting_value'] ?? 15 ?>s</span>
                            </div>
                            <input type="range" name="setting_download_countdown" 
                                   oninput="updateRangeVal(this, 'download_wait_val')"
                                   value="<?= $settings['download_countdown']['setting_value'] ?? 15 ?>"
                                   min="5" max="60" step="1"
                                   class="w-full h-1 bg-white/10 rounded-lg appearance-none cursor-pointer accent-blue-500">
                            <p class="text-[10px] text-gray-500 mt-2">Segundos que el usuario debe esperar en la página de redirección antes de que se habilite la descarga.</p>
                        </div>
                    </div>
                </div>

                <!-- Logo & Branding Settings -->
                <div class="glass-panel p-8 rounded-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-orange-500/10 rounded-full blur-[50px] -mr-10 -mt-10"></div>
                    
                    <h2 class="text-xl font-bold text-white font-outfit mb-6 flex items-center gap-2 relative z-10">
                        <i class="fas fa-paint-brush text-orange-400"></i> Branding & Logo
                    </h2>

                    <div class="relative z-10 space-y-8">
                        <!-- Logo Style Selector -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Estilo del Logo</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="relative flex items-center p-4 border rounded-xl cursor-pointer transition-all group <?= ($settings['logo_type']['setting_value'] ?? 'image') == 'image' ? 'border-orange-500 bg-orange-500/10' : 'border-white/10 bg-white/5 hover:bg-white/10' ?>" onclick="selectLogoStyle('image')">
                                    <input type="radio" name="setting_logo_type" value="image" class="hidden" <?= ($settings['logo_type']['setting_value'] ?? 'image') == 'image' ? 'checked' : '' ?>>
                                    <div class="ml-2">
                                        <span class="block text-sm font-bold text-white">Imagen Completa</span>
                                        <span class="block text-xs text-gray-500 mt-1">Sube una imagen (PNG/SVG).</span>
                                    </div>
                                </label>

                                <label class="relative flex items-center p-4 border rounded-xl cursor-pointer transition-all group <?= ($settings['logo_type']['setting_value'] ?? 'image') == 'text' ? 'border-orange-500 bg-orange-500/10' : 'border-white/10 bg-white/5 hover:bg-white/10' ?>" onclick="selectLogoStyle('text')">
                                    <input type="radio" name="setting_logo_type" value="text" class="hidden" <?= ($settings['logo_type']['setting_value'] ?? 'image') == 'text' ? 'checked' : '' ?>>
                                    <div class="ml-2">
                                        <span class="block text-sm font-bold text-white">Icono + Texto (Glass)</span>
                                        <span class="block text-xs text-gray-500 mt-1">Generado con CSS y fuentes.</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Text Logo Options -->
                        <div id="logo_text_options" class="<?= ($settings['logo_type']['setting_value'] ?? 'image') == 'text' ? '' : 'hidden' ?> p-6 bg-white/5 rounded-xl border border-white/10">
                            <h4 class="text-sm font-bold text-white mb-4 flex items-center">
                                <i class="fas fa-font text-blue-400 mr-2"></i> Configuración de Texto
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs text-gray-400 mb-1">Texto Principal</label>
                                    <input type="text" name="setting_logo_text_1" 
                                           value="<?= htmlspecialchars($settings['logo_text_1']['setting_value'] ?? 'Soft') ?>" 
                                           class="w-full bg-black/20 border border-white/10 rounded-lg px-3 py-2 text-white">
                                </div>
                                <div>
                                    <label class="block text-xs text-blue-400 mb-1">Texto Secundario</label>
                                    <input type="text" name="setting_logo_text_2" 
                                           value="<?= htmlspecialchars($settings['logo_text_2']['setting_value'] ?? 'Hub') ?>" 
                                           class="w-full bg-black/20 border border-blue-500/30 rounded-lg px-3 py-2 text-blue-400">
                                </div>
                                <div class="col-span-2">
                                    <label class="block text-xs text-gray-400 mb-1">Icono (FontAwesome)</label>
                                    <div class="relative">
                                        <i class="absolute left-3 top-2.5 text-gray-500 <?= htmlspecialchars($settings['logo_icon_class']['setting_value'] ?? 'fas fa-cube') ?>"></i>
                                        <input type="text" name="setting_logo_icon_class" 
                                               value="<?= htmlspecialchars($settings['logo_icon_class']['setting_value'] ?? 'fas fa-cube') ?>" 
                                               class="w-full pl-9 bg-black/20 border border-white/10 rounded-lg px-3 py-2 text-white placeholder-gray-600">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Uploads -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Logo Upload -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Archivo de Logo</label>
                                <?php if (!empty($settings['site_logo']['setting_value'])): ?>
                                    <div class="flex items-center gap-3 mb-3 p-2 bg-white/5 rounded-lg">
                                        <img src="<?= url($settings['site_logo']['setting_value']) ?>" class="h-8 object-contain">
                                        <label class="flex items-center gap-2 cursor-pointer ml-auto">
                                            <input type="checkbox" name="remove_logo" value="1" class="rounded bg-white/10 border-white/20 text-red-500 focus:ring-red-500">
                                            <span class="text-xs text-red-400">Eliminar</span>
                                        </label>
                                    </div>
                                <?php endif; ?>
                                <input type="file" name="site_logo" accept="image/*" class="block w-full text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-white/10 file:text-white hover:file:bg-white/20 cursor-pointer">
                            </div>

                            <!-- Favicon Upload -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Favicon</label>
                                <?php if (!empty($settings['site_favicon']['setting_value'])): ?>
                                    <div class="flex items-center gap-3 mb-3 p-2 bg-white/5 rounded-lg">
                                        <img src="<?= url($settings['site_favicon']['setting_value']) ?>" class="h-6 w-6 object-contain">
                                        <label class="flex items-center gap-2 cursor-pointer ml-auto">
                                            <input type="checkbox" name="remove_favicon" value="1" class="rounded bg-white/10 border-white/20 text-red-500 focus:ring-red-500">
                                            <span class="text-xs text-red-400">Eliminar</span>
                                        </label>
                                    </div>
                                <?php endif; ?>
                                <input type="file" name="site_favicon" accept="image/*" class="block w-full text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-white/10 file:text-white hover:file:bg-white/20 cursor-pointer">
                            </div>
                        </div>

                        <!-- Logo Height Slider -->
                        <div>
                             <div class="flex justify-between mb-2">
                                <label class="text-xs text-gray-400">Altura del Logo (Header)</label>
                                <span class="text-xs font-mono text-white bg-white/10 px-2 rounded" id="logo_h_val"><?= $settings['logo_height']['setting_value'] ?? 48 ?>px</span>
                            </div>
                            <input type="range" name="setting_logo_height" 
                                   oninput="updateRangeVal(this, 'logo_h_val')"
                                   value="<?= $settings['logo_height']['setting_value'] ?? 48 ?>"
                                   min="30" max="100" step="2"
                                   class="w-full h-1 bg-white/10 rounded-lg appearance-none cursor-pointer accent-orange-500">
                        </div>
                    </div>
                </div>

                <!-- SEO Settings (Extended) -->
                <div class="glass-panel p-8 rounded-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-green-500/10 rounded-full blur-[50px] -mr-10 -mt-10"></div>
                    
                    <h2 class="text-xl font-bold text-white font-outfit mb-6 flex items-center gap-2 relative z-10">
                        <i class="fas fa-search text-green-400"></i> SEO & Metadatos
                    </h2>

                    <div class="space-y-6 relative z-10">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Meta Título Global</label>
                            <input type="text" name="setting_seo_title" 
                                   value="<?= htmlspecialchars($settings['seo_title']['setting_value'] ?? '') ?>"
                                   class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-green-500/50 transition-all">
                        </div>
                        
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Meta Keywords</label>
                            <input type="text" name="setting_seo_keywords" 
                                   value="<?= htmlspecialchars($settings['seo_keywords']['setting_value'] ?? '') ?>"
                                   class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-green-500/50 transition-all">
                        </div>

                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Meta Descripción</label>
                                <button type="button" onclick="syncWithGeneral()" class="text-[10px] bg-green-500/10 hover:bg-green-500/20 text-green-400 px-2 py-1 rounded border border-green-500/20 transition-all flex items-center gap-1">
                                    <i class="fas fa-sync-alt"></i> Usar descripción general
                                </button>
                            </div>
                            <textarea name="setting_seo_description" id="seo_description" rows="3"
                                      class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-green-500/50 transition-all resize-none"><?= htmlspecialchars($settings['seo_description']['setting_value'] ?? '') ?></textarea>
                        </div>

                        <!-- Advanced SEO Templates -->
                        <div class="pt-6 border-t border-white/5">
                            <h3 class="text-sm font-bold text-white mb-4">Plantillas de Títulos</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs text-gray-400 mb-2">Plantilla Descarga</label>
                                    <input type="text" name="setting_seo_download_title_template" 
                                           value="<?= htmlspecialchars($settings['seo_download_title_template']['setting_value'] ?? 'Descargar {TITULO}') ?>"
                                           placeholder="Descargar {TITULO}"
                                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-green-500/50">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-400 mb-2">Separador de Versión</label>
                                    <select name="setting_seo_version_separator" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-green-500/50 [&>option]:bg-gray-900">
                                        <option value=" v" <?= ($settings['seo_version_separator']['setting_value'] ?? ' v') == ' v' ? 'selected' : '' ?>>Espacio + v (v1.0)</option>
                                        <option value=" - " <?= ($settings['seo_version_separator']['setting_value'] ?? ' v') == ' - ' ? 'selected' : '' ?>>Guión ( - 1.0)</option>
                                        <option value=" | " <?= ($settings['seo_version_separator']['setting_value'] ?? ' v') == ' | ' ? 'selected' : '' ?>>Barra ( | 1.0)</option>
                                    </select>
                                </div>
                                <div class="col-span-full">
                                    <label class="flex items-center gap-3 cursor-pointer p-3 bg-white/5 rounded-xl border border-white/5 hover:bg-white/10 transition-colors">
                                        <input type="checkbox" name="setting_seo_show_version_in_title" value="1"
                                               <?= isset($settings['seo_show_version_in_title']) && $settings['seo_show_version_in_title']['setting_value'] == '1' ? 'checked' : '' ?>
                                               class="w-5 h-5 rounded border-gray-600 text-green-500 focus:ring-green-500 bg-gray-700">
                                        <span class="text-sm text-gray-300">Mostrar versión numérica después del título</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Social Media Settings -->
                <div class="glass-panel p-8 rounded-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/10 rounded-full blur-[50px] -mr-10 -mt-10"></div>
                    
                    <h2 class="text-xl font-bold text-white font-outfit mb-6 flex items-center gap-2 relative z-10">
                        <i class="fas fa-users text-blue-400"></i> Redes Sociales & Comunidad
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative z-10">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Discord (Enlace)</label>
                            <div class="flex">
                                <span class="bg-white/5 border border-white/10 border-r-0 rounded-l-xl px-4 py-3 text-gray-500">
                                    <i class="fab fa-discord"></i>
                                </span>
                                <input type="text" name="setting_social_discord" 
                                       value="<?= htmlspecialchars($settings['social_discord']['setting_value'] ?? '#') ?>"
                                       class="w-full bg-white/5 border border-white/10 rounded-r-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500/50 transition-all text-sm">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Twitter / X (Enlace)</label>
                            <div class="flex">
                                <span class="bg-white/5 border border-white/10 border-r-0 rounded-l-xl px-4 py-3 text-gray-500">
                                    <i class="fab fa-twitter"></i>
                                </span>
                                <input type="text" name="setting_social_twitter" 
                                       value="<?= htmlspecialchars($settings['social_twitter']['setting_value'] ?? '#') ?>"
                                       class="w-full bg-white/5 border border-white/10 rounded-r-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500/50 transition-all text-sm">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Instagram (Enlace)</label>
                            <div class="flex">
                                <span class="bg-white/5 border border-white/10 border-r-0 rounded-l-xl px-4 py-3 text-gray-500">
                                    <i class="fab fa-instagram"></i>
                                </span>
                                <input type="text" name="setting_social_instagram" 
                                       value="<?= htmlspecialchars($settings['social_instagram']['setting_value'] ?? '#') ?>"
                                       class="w-full bg-white/5 border border-white/10 rounded-r-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500/50 transition-all text-sm">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Facebook (Enlace)</label>
                            <div class="flex">
                                <span class="bg-white/5 border border-white/10 border-r-0 rounded-l-xl px-4 py-3 text-gray-500">
                                    <i class="fab fa-facebook"></i>
                                </span>
                                <input type="text" name="setting_social_facebook" 
                                       value="<?= htmlspecialchars($settings['social_facebook']['setting_value'] ?? '#') ?>"
                                       class="w-full bg-white/5 border border-white/10 rounded-r-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500/50 transition-all text-sm">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- AI Settings -->
                <div class="glass-panel p-8 rounded-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-pink-500/10 rounded-full blur-[50px] -mr-10 -mt-10"></div>
                    
                    <div class="flex items-center justify-between mb-6 relative z-10">
                        <h2 class="text-xl font-bold text-white font-outfit flex items-center gap-2">
                            <i class="fas fa-robot text-pink-400"></i> Inteligencia Artificial
                        </h2>
                        <div class="flex items-center gap-2 text-xs bg-pink-500/10 px-3 py-1 rounded-full border border-pink-500/20 text-pink-300">
                            <i class="fas fa-bolt"></i> Powered by Gemini
                        </div>
                    </div>

                    <div class="space-y-6 relative z-10">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Gemini API Key</label>
                            <div class="flex gap-2">
                                <input type="password" name="setting_gemini_api_key" id="gemini_api_key"
                                       value="<?= htmlspecialchars($settings['gemini_api_key']['setting_value'] ?? '') ?>"
                                       class="flex-1 bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-pink-500/50 transition-all placeholder-gray-600">
                                <button type="button" onclick="toggleApiKey()" class="bg-white/5 hover:bg-white/10 border border-white/10 text-gray-400 w-12 rounded-xl flex items-center justify-center transition-all">
                                    <i class="fas fa-eye" id="eye-icon"></i>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 p-4 bg-white/5 rounded-xl border border-white/5">
                            <input type="checkbox" id="ai_enabled" name="setting_ai_enabled" value="1" 
                                   <?= ($settings['ai_enabled']['setting_value'] ?? '0') == '1' ? 'checked' : '' ?>
                                   class="w-5 h-5 rounded border-gray-600 text-pink-500 focus:ring-pink-500 bg-gray-700">
                            <label for="ai_enabled" class="text-sm text-gray-300 cursor-pointer select-none">
                                Habilitar generación automática de contenido
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Save Button (Floating) -->
                <div class="fixed bottom-6 right-6 z-50">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-4 px-8 rounded-full shadow-lg shadow-blue-600/30 flex items-center gap-3 transition-all hover:scale-105 hover:-translate-y-1 backdrop-blur-md border border-white/10">
                        <i class="fas fa-save text-xl"></i>
                        <span class="text-lg">Guardar Configuración</span>
                    </button>
                    <!-- Loading Indicator (Hidden by default) -->
                    <div id="save-loader" class="absolute inset-0 bg-blue-700/80 rounded-full flex items-center justify-center hidden">
                        <i class="fas fa-spinner fa-spin text-white"></i>
                    </div>
                </div>

            </form>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-6">
            <div class="glass-panel p-6 rounded-2xl sticky top-24">
                <h3 class="font-bold text-white font-outfit mb-4">Información del Sistema</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between items-center py-2 border-b border-white/5">
                        <span class="text-gray-500">PHP Version</span>
                        <span class="text-blue-400 font-mono"><?= phpversion() ?></span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-white/5">
                        <span class="text-gray-500">Software Total</span>
                        <span class="text-purple-400 font-mono"><?= number_format($totalSoftware) ?></span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-white/5">
                        <span class="text-gray-500">Descargas</span>
                        <span class="text-green-400 font-mono"><?= number_format($totalDownloads) ?></span>
                    </div>
                     <div class="flex justify-between items-center py-2 border-b border-white/5">
                        <span class="text-gray-500">Categorías</span>
                        <span class="text-pink-400 font-mono"><?= number_format($totalCategories) ?></span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-500">Server</span>
                        <span class="text-gray-300 font-mono text-xs"><?= $_SERVER['SERVER_SOFTWARE'] ?? 'Apache' ?></span>
                    </div>
                </div>
            </div>
            
             <a href="<?= url() ?>" target="_blank" class="glass-panel p-4 rounded-2xl flex items-center justify-center gap-2 text-gray-400 hover:text-white hover:bg-white/5 transition-all group">
                <i class="fas fa-external-link-alt group-hover:-translate-y-0.5 transition-transform"></i>
                <span class="font-medium">Ir al Sitio Web</span>
             </a>
        </div>

    </div>
</div>

<script>
// Toggle Password
function toggleApiKey() {
    const input = document.getElementById('gemini_api_key');
    const icon = document.getElementById('eye-icon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'fas fa-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'fas fa-eye';
    }
}

// Layout Selection
function selectLayout(layout) {
    const radios = document.getElementsByName('setting_home_latest_layout');
    for(let r of radios) {
        if(r.value === layout) {
            r.checked = true;
            r.parentElement.classList.add('border-purple-500', 'bg-purple-500/10');
            r.parentElement.classList.remove('border-white/10', 'bg-white/5');
            // Update Icon Color
            r.parentElement.querySelector('i').classList.add('text-purple-400');
            r.parentElement.querySelector('i').classList.remove('text-gray-500');
        } else {
            r.parentElement.classList.remove('border-purple-500', 'bg-purple-500/10');
            r.parentElement.classList.add('border-white/10', 'bg-white/5');
             // Reset Icon Color
            r.parentElement.querySelector('i').classList.remove('text-purple-400');
            r.parentElement.querySelector('i').classList.add('text-gray-500');
        }
    }
}

// Logo Style Selection
function selectLogoStyle(style) {
    const radios = document.getElementsByName('setting_logo_type');
    const textOptions = document.getElementById('logo_text_options');
    
    for(let r of radios) {
        if(r.value === style) {
            r.checked = true;
            r.parentElement.classList.add('border-orange-500', 'bg-orange-500/10');
            r.parentElement.classList.remove('border-white/10', 'bg-white/5');
        } else {
            r.parentElement.classList.remove('border-orange-500', 'bg-orange-500/10');
            r.parentElement.classList.add('border-white/10', 'bg-white/5');
        }
    }
    
    if(style === 'text') {
        textOptions.classList.remove('hidden');
    } else {
        textOptions.classList.add('hidden');
    }
}

// Update Range Value Display
function updateRangeVal(input, displayId) {
    const display = document.getElementById(displayId);
    let unit = displayId.includes('logo') ? 'px' : ' cols';
    display.textContent = input.value + unit;
}

// Generate Site Info with IA
async function generateSiteInfo(type) {
    if (type !== 'description') return;
    
    const siteName = document.getElementById('site_name').value;
    const btn = event.currentTarget;
    const originalHtml = btn.innerHTML;
    
    if (!siteName) {
        alert('Por favor, ingresa el nombre del sitio primero.');
        return;
    }
    
    try {
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generando...';
        
        const response = await fetch('<?= url('api/ai/generate-descriptions') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                type: 'site',
                site_name: siteName
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            document.getElementById('site_description').value = data.description;
            // Opcional: También actualizar SEO si está vacío
            const seoDesc = document.getElementsByName('setting_seo_description')[0];
            if (seoDesc && !seoDesc.value) {
                seoDesc.value = data.description;
            }
        } else {
            alert('Error: ' + data.error);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al conectar con el servidor');
    } finally {
        btn.disabled = false;
        btn.innerHTML = originalHtml;
    }
}

// Sync SEO with General
function syncWithGeneral() {
    const generalDesc = document.getElementById('site_description').value;
    const seoDesc = document.getElementById('seo_description');
    if (generalDesc) {
        seoDesc.value = generalDesc;
    } else {
        alert('La descripción general está vacía.');
    }
}
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/admin.php';
?>
