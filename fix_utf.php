<?php
$path = "app/Livewire/Admin/AdminDashboard.php";
$content = file_get_contents($path);
if (substr($content, 0, 3) === "\xEF\xBB\xBF") {
    $content = substr($content, 3);
}
$content = str_replace("\x00", "", $content);
file_put_contents($path, $content);

