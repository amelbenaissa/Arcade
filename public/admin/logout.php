<?php
session_start();
session_unset();
session_destroy();

$script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
$dir = rtrim(dirname($script), '/');
if ($dir === '/') { $dir = ''; }
$BASE_URL = preg_replace('#/admin(/.*)?$#', '', $dir);

header("Location: {$BASE_URL}/admin/login.php");
exit;
