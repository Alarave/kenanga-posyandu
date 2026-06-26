<?php
$file = "C:/Users/HP/.gemini/antigravity-ide/brain/d0d9d3a8-b094-498c-a3c0-9f3b309530bb/.system_generated/logs/transcript_full.jsonl";
$lines = file($file);
$lastContent = "";
foreach ($lines as $line) {
    $data = json_decode($line, true);
    if (isset($data["tool_calls"])) {
        foreach ($data["tool_calls"] as $call) {
            if ($call["name"] === "write_to_file") {
                if (strpos($call["args"]["TargetFile"] ?? "", "AdminDashboard.php") !== false) {
                    $lastContent = $call["args"]["CodeContent"];
                }
            }
        }
    }
}
file_put_contents("AdminDashboard_recovered.php", $lastContent);
echo "Recovered!";

