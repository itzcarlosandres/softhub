<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rediseño Home Demo | Play Store Style</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-dark: #0f1014;
            --card-dark: #1a1d24;
            --accent-green: #22c55e;
            --accent-blue: #3b82f6;
            --text-muted: #9ca3af;
        }

        body {
            background-color: var(--bg-dark);
            color: #fff;
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Premium Floating Menu */
        .premium-nav {
            position: sticky;
            top: 20px;
            z-index: 100;
            background: rgba(26, 29, 36, 0.7);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 12px 24px;
            margin-bottom: 60px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-link {
            position: relative;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 0.85rem;
            padding: 8px 16px;
            border-radius: 12px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-link:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.05);
        }

        .nav-link.active {
            color: #fff;
            background: rgba(34, 197, 94, 0.15);
            color: var(--accent-green);
        }

        .nav-link i {
            font-size: 1rem;
            transition: transform 0.3s ease;
        }

        .nav-link:hover i {
            transform: translateY(-2px);
        }

        .search-pill {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 14px;
            padding: 8px 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .search-pill:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        /* Section Header */
        .section-title {
            font-size: 1.25rem;
            font-weight: 800;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .section-title a {
            font-size: 0.75rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            text-decoration: none;
        }

        /* Recommended Card (Large) */
        .rec-card {
            background: var(--card-dark);
            border-radius: 20px;
            overflow: hidden;
            position: relative;
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .rec-card:hover {
            transform: scale(1.02);
        }

        .rec-image {
            width: 100%;
            height: 160px;
            background-size: cover;
            background-position: center;
            background-color: #2a2d35;
        }

        .rec-info {
            padding: 12px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .rec-meta {
            flex: 1;
            min-width: 0;
        }

        .rec-title {
            font-size: 0.9rem;
            font-weight: 700;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .rec-category {
            font-size: 0.7rem;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .download-btn-small {
            background: var(--accent-green);
            color: #000;
            font-weight: 800;
            font-size: 0.7rem;
            padding: 6px 14px;
            border-radius: 8px;
            text-transform: capitalize;
            border: none;
            cursor: pointer;
        }

        /* Best Games/Apps (Numbered List) */
        .top-item {
            position: relative;
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background: var(--card-dark);
            border-radius: 16px;
            overflow: hidden;
            min-width: 260px;
            cursor: pointer;
        }

        .top-number {
            position: absolute;
            left: -10px;
            bottom: -25px;
            font-size: 8rem;
            font-weight: 900;
            line-height: 1;
            opacity: 0.15;
            pointer-events: none;
            z-index: 0;
        }

        .top-icon {
            width: 55px;
            height: 55px;
            border-radius: 14px;
            object-fit: cover;
            z-index: 1;
            background: #2a2d35;
        }

        .top-details {
            z-index: 1;
        }

        .top-title {
            font-size: 0.85rem;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .top-sub {
            font-size: 0.65rem;
            color: var(--text-muted);
        }

        /* New Apps Grid */
        .icon-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
            gap: 24px;
        }

        .icon-item {
            text-align: center;
            transition: transform 0.2s;
            cursor: pointer;
        }

        .icon-item:hover {
            transform: translateY(-5px);
        }

        .icon-img {
            width: 80px;
            height: 80px;
            border-radius: 18px;
            margin: 0 auto 10px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.3);
            object-fit: cover;
            background: #2a2d35;
        }

        .icon-title {
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 4px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 2.2em;
        }

        .icon-meta {
            font-size: 0.6rem;
            color: var(--text-muted);
        }

        /* Collections */
        .coll-card {
            background: var(--card-dark);
            border-radius: 20px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 15px;
            cursor: pointer;
        }

        .coll-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
        }

        .coll-thumb {
            aspect-ratio: 1;
            background: rgba(255,255,255,0.05);
            border-radius: 8px;
            overflow: hidden;
            background-image: url('https://placehold.co/100x100/2a2d35/white?text=App');
            background-size: cover;
        }

        /* Comments */
        .comment-card {
            background: var(--card-dark);
            border-radius: 16px;
            padding: 20px;
            font-size: 0.8rem;
        }

        .comment-user {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .comment-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #333;
            background-image: url('https://ui-avatars.com/api/?name=User&background=random');
            background-size: cover;
        }

        /* Footer SEO Box */
        .seo-box {
            background: var(--card-dark);
            border-radius: 20px;
            padding: 40px;
            margin-top: 60px;
            font-size: 0.85rem;
            line-height: 1.6;
            color: var(--text-muted);
        }

        .seo-box h2 {
            color: #fff;
            margin-bottom: 20px;
        }

        /* Horizontal Scroller */
        .horizontal-scroll {
            display: flex;
            overflow-x: auto;
            gap: 20px;
            padding-bottom: 15px;
            scrollbar-width: none;
        }

        .horizontal-scroll::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>
<body>

<div class="max-w-[1200px] mx-auto px-5">
    
    <!-- Premium Floating Navigation -->
    <nav class="premium-nav flex items-center justify-between">
        <div class="flex items-center gap-8">
            <a href="<?= url('') ?>" class="text-white font-black flex items-center gap-2 text-xl no-underline group">
                <div class="w-8 h-8 bg-gradient-to-tr from-green-500 to-blue-600 rounded-lg flex items-center justify-center group-hover:rotate-12 transition-transform">
                    <i class="fas fa-play text-xs text-white"></i>
                </div>
                <span class="tracking-tighter">play</span>
            </a>
            
            <div class="hidden lg:flex items-center gap-2">
                <a href="#" class="nav-link active">
                    <i class="fas fa-home"></i> Inicio
                </a>
                <a href="#" class="nav-link">
                    <i class="fas fa-gamepad text-green-500"></i> Juegos
                </a>
                <a href="#" class="nav-link">
                    <i class="fas fa-th-large text-blue-500"></i> Apps
                </a>
                <a href="#" class="nav-link">
                    <i class="fas fa-trophy text-yellow-500"></i> Ranking
                </a>
                <a href="#" class="nav-link">
                    <i class="fas fa-newspaper text-red-500"></i> Blog
                </a>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <div class="search-pill hidden md:flex">
                <i class="fas fa-search text-xs"></i>
                <span class="text-xs">Buscar apps...</span>
            </div>
            <div class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center text-gray-400 hover:text-white hover:border-white/30 transition-all cursor-pointer">
                <i class="fas fa-user-circle text-xl"></i>
            </div>
        </div>
    </nav>

    <!-- Section 1: Recommended Games -->
    <section class="mb-12">
        <div class="section-title">
            Recommended Games
            <a href="<?= url('software') ?>">See all</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            <?php foreach(array_slice($featured, 0, 4) as $soft): ?>
            <div class="rec-card" onclick="window.location='<?= url('software/' . $soft['slug']) ?>'">
                <div class="rec-image" style="background-image: url('<?= !empty($soft['image']) ? url($soft['image']) : 'https://placehold.co/600x400/1a1d24/white?text=' . urlencode($soft['name']) ?>')"></div>
                <div class="rec-info">
                    <div class="rec-meta">
                        <p class="rec-title"><?= $soft['name'] ?></p>
                        <p class="rec-category"><?= $soft['category_name'] ?></p>
                    </div>
                    <button class="download-btn-small">Download</button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Section 2: Best Games -->
    <section class="mb-12">
        <div class="section-title">Best Games</div>
        <div class="horizontal-scroll">
            <?php $i=1; foreach(array_slice($mostDownloaded, 0, 8) as $soft): 
                $numColor = ['#22c55e', '#3b82f6', '#ec4899', '#f59e0b'][$i%4];
            ?>
            <div class="top-item" onclick="window.location='<?= url('software/' . $soft['slug']) ?>'">
                <span class="top-number" style="background: linear-gradient(to top, <?= $numColor ?>, transparent); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"><?= $i++ ?></span>
                <img src="<?= url($soft['icon']) ?>" class="top-icon" onerror="this.src='https://placehold.co/100x100/2a2d35/white?text=Icon'">
                <div class="top-details">
                    <p class="top-title"><?= $soft['name'] ?></p>
                    <p class="top-sub"><?= number_format($soft['downloads']) ?> downloads</p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Section 3: New Games -->
    <section class="mb-12">
        <div class="section-title">New Games</div>
        <div class="icon-grid">
            <?php foreach(array_slice($latest, 0, 8) as $soft): ?>
            <div class="icon-item" onclick="window.location='<?= url('software/' . $soft['slug']) ?>'">
                <img src="<?= url($soft['icon']) ?>" class="icon-img" onerror="this.src='https://placehold.co/100x100/2a2d35/white?text=Icon'">
                <p class="icon-title"><?= $soft['name'] ?></p>
                <p class="icon-meta"><?= $soft['version'] ?> • <?= $soft['category_name'] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Section 4: Recommended Apps -->
    <section class="mb-12">
        <div class="section-title">Recommended Apps</div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            <?php foreach(array_slice($featured, 4, 4) as $soft): ?>
            <div class="rec-card" onclick="window.location='<?= url('software/' . $soft['slug']) ?>'">
                <div class="rec-image" style="background-image: url('<?= !empty($soft['image']) ? url($soft['image']) : 'https://placehold.co/600x400/1a1d24/white?text=' . urlencode($soft['name']) ?>')"></div>
                <div class="rec-info">
                    <div class="rec-meta">
                        <p class="rec-title"><?= $soft['name'] ?></p>
                        <p class="rec-category"><?= $soft['category_name'] ?></p>
                    </div>
                    <button class="download-btn-small">Download</button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Section 5: Best Apps -->
    <section class="mb-12">
        <div class="section-title">Best Apps</div>
        <div class="horizontal-scroll">
            <?php $i=1; foreach(array_slice($mostDownloaded, 4, 8) as $soft): 
                $numColor = ['#10b981', '#6366f1', '#f43f5e', '#8b5cf6'][$i%4];
            ?>
            <div class="top-item" onclick="window.location='<?= url('software/' . $soft['slug']) ?>'">
                <span class="top-number" style="background: linear-gradient(to top, <?= $numColor ?>, transparent); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"><?= $i++ ?></span>
                <img src="<?= url($soft['icon']) ?>" class="top-icon" onerror="this.src='https://placehold.co/100x100/2a2d35/white?text=Icon'">
                <div class="top-details">
                    <p class="top-title"><?= $soft['name'] ?></p>
                    <p class="top-sub"><?= number_format($soft['downloads']) ?> downloads</p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Section 6: Collections -->
    <section class="mb-12">
        <div class="section-title">Collections</div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            <?php foreach(array_slice($categories, 0, 4) as $cat): ?>
            <div class="coll-card" onclick="window.location='<?= url('category/' . $cat['slug']) ?>'">
                <div class="coll-grid">
                    <?php for($k=0;$k<4;$k++): ?>
                    <div class="coll-thumb"></div>
                    <?php endfor; ?>
                </div>
                <div class="flex items-center justify-between">
                    <span class="font-bold text-sm"><?= $cat['name'] ?></span>
                    <i class="fas fa-chevron-right text-xs text-gray-600"></i>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Section 7: Latest Comments -->
    <section class="mb-12">
        <div class="section-title">Latest comments</div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="comment-card">
                <div class="comment-user">
                    <div class="comment-avatar"></div>
                    <div>
                        <p class="font-bold text-sm">carlosandres</p>
                        <p class="text-[10px] text-gray-500">December 22, 2023</p>
                    </div>
                </div>
                <p class="text-gray-300">sample comment with reply as the and dhilla</p>
                <div class="mt-4 text-right text-green-500 font-bold text-[10px] cursor-pointer uppercase tracking-widest">Replies &rarr;</div>
            </div>
            <div class="comment-card">
                <div class="comment-user">
                    <div class="comment-avatar"></div>
                    <div>
                        <p class="font-bold text-sm">softhub_user</p>
                        <p class="text-[10px] text-gray-500">December 22, 2023</p>
                    </div>
                </div>
                <p class="text-gray-300">This is a great app, thanks for the upload!</p>
                <div class="mt-4 text-right text-green-500 font-bold text-[10px] cursor-pointer uppercase tracking-widest">Replies &rarr;</div>
            </div>
            <div class="comment-card">
                <div class="comment-user">
                    <div class="comment-avatar"></div>
                    <div>
                        <p class="font-bold text-sm">gamer_pro</p>
                        <p class="text-[10px] text-gray-500">November 17, 2023</p>
                    </div>
                </div>
                <p class="text-gray-300">im playing this game and it works perfectly.</p>
                <div class="mt-4 text-right text-green-500 font-bold text-[10px] cursor-pointer uppercase tracking-widest">Replies &rarr;</div>
            </div>
        </div>
    </section>

    <!-- SEO Box -->
    <footer class="seo-box">
        <h2 class="text-xl font-bold">Android games and apps for free: virus-free APKs, offline/online, "unlimited money" mods.</h2>
        <p>Want to download Android games and apps for free? Here you'll find only vetted APK and XAPK packages: fresh releases, popular hits, and handy utilities. Every file undergoes antivirus scanning and signature verification, each page includes a description, requirements, and screenshots. Easy navigation by games and categories, plus mod availability, helps you quickly find what you need. Direct links, high speeds, and honest reviews save you time. Bookmark the site—we add something interesting every day.</p>
        <p class="mt-4"><a href="#" class="text-green-500 font-bold no-underline uppercase text-[10px] tracking-widest">More view</a></p>
        
        <div class="mt-12 p-8 bg-blue-600/10 border border-blue-500/20 rounded-2xl flex items-center justify-between">
            <div>
                <p class="font-black text-xl">Our Telegram</p>
                <p class="text-sm text-gray-400">Stay up to date with the latest updates and exclusive content.</p>
            </div>
            <a href="#" class="bg-blue-600 text-white px-8 py-3 rounded-xl font-bold text-sm no-underline hover:bg-blue-500 transition">Join now</a>
        </div>
    </footer>

    <!-- Bottom Navigation & Copyright -->
    <div class="py-12 text-center text-xs text-gray-600 border-t border-gray-800 mt-12 flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="flex gap-6 font-bold uppercase tracking-widest">
            <a href="#" class="hover:text-white no-underline">Bookmark</a>
            <a href="#" class="hover:text-white no-underline">Register</a>
            <a href="#" class="hover:text-white no-underline">Order</a>
            <a href="#" class="hover:text-white no-underline">TOP 100</a>
        </div>
        <p>© 2025 play.softhub.es. All rights reserved. Using Zulu Themes v.1.0.0</p>
    </div>

</div>

</body>
</html>
<?php 
$content = ob_get_clean();
echo $content;
?>
