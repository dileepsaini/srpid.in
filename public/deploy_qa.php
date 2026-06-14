<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
// Secure auto-deploy script

$secret = 'PA_S3cr3t_T0ken_XYz098!'; // Use the same secret in your GitHub webhook

if (!isset($_GET['token']) || $_GET['token'] !== $secret) {
    http_response_code(403);
    exit('Access denied');
}

// Deployment path
$repoPath = '/home/ordextxb/srpid.in';
$branch = 'main'; // Change this if you're using a different branch

// Execute deployment steps independently to capture full stdout/stderr
$output = "";
$output .= "=== Git Pull ===\n";
$output .= shell_exec("cd $repoPath && git pull origin $branch 2>&1") ?: "No output\n";

$output .= "\n=== PHP Path & Version ===\n";
$output .= shell_exec("which php 2>&1") ?: "which php returned nothing\n";
$output .= shell_exec("php -v 2>&1") ?: "php -v returned nothing\n";

$output .= "\n=== Artisan Migrate ===\n";
$output .= shell_exec("cd $repoPath && php artisan migrate --force 2>&1") ?: "Migrate returned nothing\n";

$output .= "\n=== Optimize Clear ===\n";
$output .= shell_exec("cd $repoPath && php artisan optimize:clear 2>&1") ?: "Optimize returned nothing\n";

echo "<pre>$output</pre>";
?>
