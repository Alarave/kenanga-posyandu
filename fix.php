<?php
$content = file_get_contents("rebuild_dashboard.php");
$content = rtrim($content);
if (substr($content, -1) === "}") {
    $content = substr($content, 0, -1);
}
$content .= "\n    public function render()\n    {\n        return view(\"livewire.admin.admin-dashboard\")->layout(\"layouts.app\");\n    }\n}\n";
file_put_contents("app/Livewire/Admin/AdminDashboard.php", $content);

