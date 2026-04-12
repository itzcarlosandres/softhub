<?php
// Variables expected: $soft, $showIcon, $showBadges, $showDesc, $showRating, $showDownloads, $showPrice, $showButton, $isTrending
$iconPath = !empty($soft['icon']) ? $soft['icon'] : ($soft['image'] ?? '');
$isNew = !empty($soft['created_at']) ? strtotime($soft['created_at']) > strtotime('-7 days') : false;

$isUpdated = !empty($soft['badge_updated']) && $soft['badge_updated'] == 1;

$isPremium = !empty($soft['price']) && $soft['price'] > 0;
// Default to blue if $color is not provided
$color = $color ?? 'blue';
?>
<a href="<?= url('software/' . $soft['slug']) ?>" class="software-card group cursor-pointer block h-full flex flex-col" data-icon="<?= $iconPath ? url($iconPath) : '' ?>" data-card-id="card-<?= $soft['id'] ?>">
    <div class="card-inner relative overflow-hidden rounded-2xl bg-gradient-to-br from-gray-50 to-white dark:from-gray-800 dark:to-gray-900 p-5 border border-gray-100 dark:border-gray-700/50 transition-all duration-500 hover:shadow-xl dark:shadow-gray-900/50 h-full flex flex-col justify-between">
        <div>
            <!-- Icon -->
            <?php if ($showIcon): ?>
            <div class="mb-4 relative">
                <div class="w-14 h-14 bg-white dark:bg-gray-800 rounded-xl shadow-md dark:shadow-none border border-transparent dark:border-gray-700/50 flex items-center justify-center group-hover:scale-110 transition-transform duration-500 overflow-hidden">
                    <?php if ($iconPath): ?>
                        <img src="<?= url($iconPath) ?>" alt="<?= htmlspecialchars($soft['name']) ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                        <i class="fas fa-cube text-2xl text-<?= $color ?>-600"></i>
                    <?php endif; ?>
                </div>
                
                <!-- Badge superior derecho -->
                <?php if ($showBadges): ?>
                <div class="absolute -top-1 -right-1 w-7 h-7 rounded-full flex items-center justify-center shadow-md">
                    <?php if (!empty($soft['badge_editors_choice'])): ?>
                        <div class="w-7 h-7 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center shadow-lg" title="<?= __('editors_choice', "Editor's Choice") ?>">
                            <i class="fas fa-award text-white text-xs"></i>
                        </div>
                    <?php elseif ($isTrending): ?>
                        <div class="w-7 h-7 bg-gradient-to-br from-orange-500 to-red-500 rounded-full flex items-center justify-center animate-pulse" title="<?= __('trending', 'Trending') ?>">
                            <i class="fas fa-fire text-white text-xs"></i>
                        </div>
                    <?php elseif ($isNew): ?>
                        <div class="w-7 h-7 bg-gradient-to-br from-green-500 to-emerald-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-star text-white text-xs"></i>
                        </div>
                    <?php elseif ($isPremium): ?>
                        <div class="w-7 h-7 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-crown text-white text-xs"></i>
                        </div>
                    <?php else: ?>
                        <div class="w-7 h-7 bg-green-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            
            <!-- Content -->
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 transition line-clamp-1">
                <?= htmlspecialchars($soft['name']) ?>
            </h3>
            
            <?php if ($showDesc): ?>
            <p class="text-gray-600 dark:text-gray-400 mb-4 leading-relaxed line-clamp-2 text-sm">
                <?= htmlspecialchars(substr($soft['short_description'] ?? $soft['description'] ?? '', 0, 100)) ?>...
            </p>
            <?php endif; ?>
        </div>
        
        <div class="mt-auto">
            <!-- Stats -->
            <?php if ($showRating || $showDownloads): ?>
            <div class="flex items-center gap-4 text-xs text-gray-500 dark:text-gray-400 mb-4">
                <?php if ($showDownloads): ?>
                <span class="flex items-center gap-1">
                    <i class="fas fa-download text-<?= $color ?>-500"></i>
                    <span class="font-medium text-gray-700 dark:text-gray-300"><?= number_format($soft['downloads'] ?? 0) ?></span>
                </span>
                <?php endif; ?>
                
                <?php if ($showRating): ?>
                <span class="flex items-center gap-1">
                    <i class="fas fa-star text-yellow-500"></i>
                    <span class="font-medium text-gray-700 dark:text-gray-300"><?= number_format($soft['rating'] ?? 4.5, 1) ?></span>
                </span>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            
            <!-- Button -->
            <?php if ($showButton || $showPrice): ?>
            <div class="flex items-center justify-between mt-4">
                <?php if ($isUpdated): ?>
                    <span class="inline-flex items-center gap-1 bg-gray-100 dark:bg-white/10 text-gray-400 dark:text-gray-400 text-[10px] font-medium px-2 py-0.5 rounded-full">
                        <i class="fas fa-sync-alt text-[8px]"></i> <?= __('updated', 'Actualizado') ?>
                    </span>
                <?php else: ?>
                    <span></span>
                <?php endif; ?>
                
                <div class="flex items-center gap-2">
                    <?php 
                    // Determinar qué badge mostrar (prioridad al preset)
                    $bName = !empty($soft['badge_name']) ? $soft['badge_name'] : $soft['custom_badge'];
                    $bColor = !empty($soft['badge_color']) ? $soft['badge_color'] : 'cyan';
                    
                    $colorClasses = [
                        'cyan' => 'bg-cyan-500/10 dark:bg-cyan-400/10 border-cyan-500/20 text-cyan-600 dark:text-cyan-400',
                        'blue' => 'bg-blue-500/10 dark:bg-blue-400/10 border-blue-500/20 text-blue-600 dark:text-blue-400',
                        'purple' => 'bg-purple-500/10 dark:bg-purple-400/10 border-purple-500/20 text-purple-600 dark:text-purple-400',
                        'pink' => 'bg-pink-500/10 dark:bg-pink-400/10 border-pink-500/20 text-pink-600 dark:text-pink-400',
                        'orange' => 'bg-orange-500/10 dark:bg-orange-400/10 border-orange-500/20 text-orange-600 dark:text-orange-400',
                        'emerald' => 'bg-emerald-500/10 dark:bg-emerald-400/10 border-emerald-500/20 text-emerald-600 dark:text-emerald-400',
                        'rose' => 'bg-rose-500/10 dark:bg-rose-400/10 border-rose-500/20 text-rose-600 dark:text-rose-400',
                    ];
                    $cls = $colorClasses[$bColor] ?? $colorClasses['cyan'];
                    ?>

                    <?php if (!empty($bName)): ?>
                        <span class="px-2.5 py-1 border text-[10px] font-extrabold rounded-md uppercase tracking-wide <?= $cls ?>">
                            <?= htmlspecialchars($bName) ?>
                        </span>
                    <?php endif; ?>
                    
                    <?php if ($showButton): ?>
                    <span class="software-btn hidden md:inline-flex px-4 py-2 bg-gray-900 dark:bg-gray-700 text-white rounded-full text-xs font-medium transition-all transform group-hover:translate-x-1 items-center gap-1">
                        <?= __('view', 'Ver') ?> <i class="fas fa-arrow-right text-xs"></i>
                    </span>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Floating Badges (Left) -->
            <?php if ($showBadges && $isTrending): ?>
                <div class="absolute top-3 left-3 flex flex-col gap-2 z-20 pointer-events-none">
                    <span class="px-2 py-1 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-full text-[10px] font-extrabold shadow-lg flex items-center gap-1 uppercase tracking-wide">
                        <i class="fas fa-fire text-[10px]"></i> <?= __('hot', 'HOT') ?>
                    </span>
                </div>
            <?php endif; ?>
        </div>
    </div>
</a>