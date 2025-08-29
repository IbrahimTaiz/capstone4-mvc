<?php
namespace App\Core;
class Logger
{
public static function log(string $message): void
{
$cfg = App::config();
$logDir = $cfg['storage']['logs'] ?? __DIR__ . '/../../storage/logs';
$file = rtrim($logDir, '/\\') . '/app.log';
$line = sprintf("[%s] %s\n", date('Y-m-d H:i:s'), $message);
@file_put_contents($file, $line, FILE_APPEND | LOCK_EX);
}
}
