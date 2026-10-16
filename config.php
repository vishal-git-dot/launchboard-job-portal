<?php
// Update these values to match your local MySQL setup.
const DB_HOST = '127.0.0.1';
const DB_NAME = 'launchboard';
const DB_USER = 'root';
const DB_PASS = '';
const APP_NAME = 'Launchboard';
const MAX_RESUME_SIZE = 5 * 1024 * 1024;

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax', 'secure' => !empty($_SERVER['HTTPS'])]);
    session_start();
}

try {
    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    exit('Database connection failed. Import database.sql and check the credentials in config.php.');
}

function e($value): string { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
function redirect(string $url): never { header('Location: ' . $url); exit; }
function csrf_token(): string { if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32)); return $_SESSION['csrf']; }
function verify_csrf(): void { if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) { http_response_code(419); exit('Your session token expired. Please go back and try again.'); } }
function current_user(): ?array { return $_SESSION['user'] ?? null; }
function require_login(): void { if (!current_user()) { flash('error', 'Please sign in to continue.'); redirect('login.php'); } }
function require_role(string $role): void { require_login(); if ((current_user()['role'] ?? '') !== $role) { http_response_code(403); exit('You do not have permission to access this page.'); } }
function flash(string $type, string $message): void { $_SESSION['flash'] = ['type' => $type, 'message' => $message]; }
function take_flash(): ?array { $f = $_SESSION['flash'] ?? null; unset($_SESSION['flash']); return $f; }
function initials(string $name): string { $parts = preg_split('/\s+/', trim($name)); return strtoupper(substr($parts[0] ?? 'U', 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : '')); }
function job_is_open(array $job): bool { return empty($job['deadline']) || $job['deadline'] >= date('Y-m-d'); }
