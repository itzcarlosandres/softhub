<?php
// Variables expected: $soft, $showIcon, $showBadges, $showDesc, $showRating, $showDownloads, $showPrice, $showButton, $isTrending
$iconPath = !empty($soft['icon']) ? $soft['icon'] : ($soft['image'] ?? '');
$isNew = !empty($soft['created_at']) ? strtotime($soft['created_at']) > strtotime('-7 days') : false;

$isUpdated = false;
if (!empty($soft['updated_at'])) {
    $updatedTime = strtotime($soft['updated_at']);
    $createdTime = !empty($soft['created_at']) ? strtotime($soft['created_at']) : 0;
    if ($updatedTime > strtotime('-48 hours') && ($updatedTime - $createdTime > 60)) {
        $isUpdated = true;
    }
}

$isPremium = !empty($soft['price']) && $soft['price'] > 0;
$color = $color ?? 'blue';
?>
<a href="<?= url('software/' . $soft['slug']) ?>" class="software-list-item group flex flex-col sm:flex-row items-start sm:items-center p-4 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700/60 hover:border-blue-500 dark:hover:border-gray-500 hover:shadow-xl dark:shadow-gray-900/50 transition-all duration-300 w-full mb-4" data-card-id="list-<?= $soft['id'] ?>">
    
    <div class="flex items-start sm:items-center flex-1 w-full sm:w-auto min-w-0 mb-3 sm:mb-0">
        
        <!-- Left: Icon & Abs Badges -->
        <div class="relative shrink-0">
            <div class="w-14 h-14 bg-gray-50 dark:bg-gray-700/50 rounded-xl shadow-sm border border-transparent dark:border-gray-600/50 flex items-center justify-center group-hover:scale-105 transition-transform duration-500 overflow-hidden p-1">
                <?php if ($iconPath): ?>
                    <img src="<?= url($iconPath) ?>" alt="<?= htmlspecialchars($soft['name']) ?>" class="w-full h-full object-contain rounded-lg">
                <?php else: ?>
                    <i class="fas fa-cube text-xl text-<?= $color ?>-500"></i>
                <?php endif; ?>
            </div>
            
            <?php if ($showBadges): ?>
            <div class="absolute -top-2 -right-2 flex flex-col gap-1 z-10">
                <?php if (!empty($soft['badge_editors_choice'])): ?>
                    <div class="w-5 h-5 bg-indigo-600 rounded-full flex items-center justify-center shadow-lg border-2 border-white dark:border-gray-800" title="<?= __('editors_choice', "Editor's Choice") ?>">
                        <i class="fas fa-award text-white text-[9px]"></i>
                    </div>
                <?php endif; ?>
                <?php if ($isTrending): ?>
                    <div class="w-5 h-5 bg-orange-500 rounded-full flex items-center justify-center shadow-lg border-2 border-white dark:border-gray-800 animate-pulse" title="<?= __('trending', 'Trending') ?>">
                        <i class="fas fa-fire text-white text-[9px]"></i>
                    </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- Middle: Title, Tags & Desc -->
        <div class="ml-4 flex-1 min-w-0 mr-4">
            <div class="flex items-center gap-1.5 mb-1 flex-wrap">
                <h3 class="font-black text-gray-900 dark:text-gray-100 text-base leading-none group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors line-clamp-1 mr-1">
                    <?= htmlspecialchars($soft['name']) ?>
                </h3>
                
                <?php if ($isNew): ?>
                    <span class="px-1.5 py-[1px] bg-blue-500 text-white text-[9px] font-black rounded uppercase tracking-widest mt-0.5"><?= __('new', 'NUEVO') ?></span>
                <?php endif; ?>
                <?php if ($isUpdated): ?>
                    <span class="px-1.5 py-[1px] bg-emerald-500 text-white text-[9px] font-black rounded uppercase tracking-widest mt-0.5"><?= __('updated_badge', 'ACTUALIZADO') ?></span>
                <?php endif; ?>
                
                <?php 
                $bName = !empty($soft['badge_name']) ? $soft['badge_name'] : ($soft['custom_badge'] ?? '');
                if (!empty($bName)): 
                    $bColor = !empty($soft['badge_color']) ? $soft['badge_color'] : 'cyan';
                    $colorClasses = [
                        'cyan' => 'bg-cyan-500/10 border-cyan-500/20 text-cyan-600 dark:text-cyan-400',
                        'blue' => 'bg-blue-500/10 border-blue-500/20 text-blue-600 dark:text-blue-400',
                        'purple' => 'bg-purple-500/10 border-purple-500/20 text-purple-600 dark:text-purple-400',
                        'pink' => 'bg-pink-500/10 border-pink-500/20 text-pink-600 dark:text-pink-400',
                        'orange' => 'bg-orange-500/10 border-orange-500/20 text-orange-600 dark:text-orange-400',
                        'emerald' => 'bg-emerald-500/10 border-emerald-500/20 text-emerald-600 dark:text-emerald-400',
                        'rose' => 'bg-rose-500/10 border-rose-500/20 text-rose-600 dark:text-rose-400',
                    ];
                    $cls = $colorClasses[$bColor] ?? $colorClasses['cyan'];
                ?>
                    <span class="px-1.5 py-[1px] border border-transparent text-[9px] font-black rounded uppercase tracking-widest mt-0.5 <?= $cls ?>"><?= htmlspecialchars($bName) ?></span>
                <?php endif; ?>
            </div>

            <?php if ($showDesc): ?>
            <p class="text-gray-500 dark:text-gray-400 text-[12px] line-clamp-1 mb-1.5 leading-snug">
                <?= htmlspecialchars(empty($soft['short_description']) ? ($soft['description'] ?? '') : $soft['short_description']) ?>
            </p>
            <?php endif; ?>
            
            <div class="text-[10px] text-gray-500 font-semibold tracking-wider flex items-center gap-x-3 gap-y-1 flex-wrap">
                <!-- Category -->
                <span class="flex items-center gap-1 shrink-0">
                    <i class="fas fa-folder text-blue-400"></i>
                    <?php $catText = $soft['category_name'] ?? 'General'; ?>
                    <?= htmlspecialchars(__($catText, $catText)) ?>
                </span>
                
                <?php if ($showRating): ?>
                <span class="text-gray-300 dark:text-gray-600">•</span>
                <span class="flex items-center gap-1 shrink-0">
                    <i class="fas fa-star text-yellow-400"></i>
                    <?= number_format($soft['rating'] ?? 4.5, 1) ?>
                </span>
                <?php endif; ?>
                
                <?php if ($showDownloads): ?>
                <span class="text-gray-300 dark:text-gray-600">•</span>
                <span class="flex items-center gap-1 shrink-0">
                    <i class="fas fa-download text-emerald-500"></i>
                    <?= number_format($soft['downloads'] ?? 0) ?>
                </span>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Right Area: Price/License & Button -->
    <div class="w-full sm:w-auto shrink-0 flex items-center justify-between sm:justify-end gap-5 border-t sm:border-t-0 border-gray-100 dark:border-gray-700/60 pt-3 sm:pt-0 pl-0 sm:pl-5 sm:border-l relative mt-1 sm:mt-0">
        <?php if ($showPrice): ?>
        <div class="text-left sm:text-right flex flex-col justify-center">
            <div class="text-[9px] text-gray-400 dark:text-gray-500 uppercase tracking-widest font-black mb-0.5">
                <?= $isPremium ? __('premium', 'Prémium') : __('license', 'Licencia') ?>
            </div>
            <div class="<?= $isPremium ? 'text-purple-500' : 'text-emerald-500' ?> font-black text-sm tracking-tight leading-none">
                <?php 
                    if ($isPremium) {
                        echo '$' . number_format($soft['price'], 2);
                    } else {
                        $lic = !empty($soft['license_name']) ? $soft['license_name'] : '';
                        if (strtolower($lic) === 'gratis' || empty($lic)) {
                            echo __('free', 'Gratis');
                        } else {
                            echo htmlspecialchars($lic);
                        }
                    }
                ?>
            </div>
        </div>
        <?php endif; ?>
        
        <?php if ($showButton): ?>
        <div class="bg-gray-50 dark:bg-gray-700/30 hover:bg-black hover:border-black dark:hover:bg-blue-600 dark:hover:border-blue-600 border border-gray-200 dark:border-gray-600 text-gray-400 hover:text-white w-10 h-10 rounded-xl transition-all duration-300 flex items-center justify-center shrink-0 shadow-sm group-hover:scale-105">
            <i class="fas fa-download text-[13px]"></i>
        </div>
        <?php endif; ?>
    </div>
</a>
