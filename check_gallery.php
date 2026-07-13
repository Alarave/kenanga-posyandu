<?php
define('LARAVEL_START', microtime(true));
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Check gallery_folders
$folders = \DB::table('gallery_folders')->get(['id', 'name', 'cover_photo', 'posyandu_id']);
echo "=== GALLERY FOLDERS (" . $folders->count() . " total) ===\n";
foreach ($folders as $f) {
    $coverPath = $f->cover_photo ? storage_path('app/public/' . $f->cover_photo) : null;
    echo "ID: {$f->id} | Name: {$f->name} | Posyandu: {$f->posyandu_id}\n";
    echo "Cover: " . ($f->cover_photo ?: 'NONE') . "\n";
    if ($coverPath) {
        echo "Cover file exists: " . (file_exists($coverPath) ? 'YES' : 'NO') . "\n";
    }
    echo "\n";
}

// Check galleries
$galleries = \DB::table('galleries')->get(['id', 'title', 'photo', 'type', 'gallery_folder_id']);
echo "=== GALLERY ITEMS (" . $galleries->count() . " total) ===\n";
foreach ($galleries as $g) {
    $path = $g->photo ? storage_path('app/public/' . $g->photo) : null;
    echo "ID: {$g->id} | FolderID: {$g->gallery_folder_id} | Title: {$g->title} | Type: {$g->type}\n";
    echo "Photo: " . ($g->photo ?: 'NONE') . "\n";
    if ($path) {
        echo "File exists: " . (file_exists($path) ? 'YES' : 'NO') . "\n";
    }
    echo "\n";
}
