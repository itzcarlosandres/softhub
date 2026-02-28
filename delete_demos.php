<?php
$files = [
    'c:/MAMP/htdocs/programas/app/Views/pages/demo_admin.php',
    'c:/MAMP/htdocs/programas/app/Views/pages/demo_footers.php',
    'c:/MAMP/htdocs/programas/app/Views/pages/demo_headers.php',
    'c:/MAMP/htdocs/programas/app/Views/pages/demo_heroes.php',
    'c:/MAMP/htdocs/programas/app/Views/pages/demo_software.php',
    'c:/MAMP/htdocs/programas/app/Views/pages/demo_titles.php',
    'c:/MAMP/htdocs/programas/app/Views/pages/home_backup.php',
    'c:/MAMP/htdocs/programas/sidebar_designs_demo.html'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        if (unlink($file)) {
            echo "Deleted: $file\n";
        } else {
            echo "Failed: $file\n";
        }
    } else {
        echo "Not found: $file\n";
    }
}
unlink(__FILE__);
