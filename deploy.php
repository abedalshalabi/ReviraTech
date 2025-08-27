<?php
// ====== إعداد كلمة سر للوصول الآمن ======
$secret = "MY_DEPLOY_PASSWORD"; // غيّرها لشيء قوي 🔒

// تحقق من كلمة السر
if (!isset($_GET['key']) || $_GET['key'] !== $secret) {
    http_response_code(403);
    die("Unauthorized");
}

echo "<pre>🚀 Running Laravel deployment tasks...\n</pre>";

// تحديد المسار إلى مشروع Laravel (تأكد إنه صحيح عندك)
$basePath = realpath(__DIR__ . "/..");

// الأوامر المطلوب تنفيذها
$commands = [
    "cd $basePath",
    "php artisan config:clear",
    "php artisan cache:clear",
    "php artisan route:clear",
    "php artisan view:clear",
    "php artisan config:cache",
    "php artisan route:cache",
    "php artisan migrate",
];

// تنفيذ الأوامر
foreach ($commands as $command) {
    echo "<pre>$ $command\n</pre>";
    $output = shell_exec($command . " 2>&1");
    echo "<pre>$output</pre>";
}

echo "<pre>✅ Deployment finished successfully!</pre>";
