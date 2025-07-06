<?php

// Set Indian Time Zone
date_default_timezone_set('Asia/Kolkata');

// Database Configuration
$dbHost = 'localhost';
$dbUser = 'amitparik';
$dbPass = 'Qw#1erty';
$dbName = 'db_ecopack_database';

// Backup Folder
$backupDir = __DIR__ . '/dbbackup/';
if (!file_exists($backupDir)) {
    mkdir($backupDir, 0777, true);
}

// Backup File Name
$date = date("Y-m-d_H-i-s");
$backupFile = $backupDir . $dbName . "_" . $date . ".sql.gz"; // GZIP format

// Export Database with GZIP Compression
$command = "mysqldump --user=$dbUser --password=$dbPass --host=$dbHost $dbName | gzip > $backupFile";
exec($command, $output, $returnVar);

if ($returnVar !== 0) {
    die("Database backup failed!");
}

// Delete Old Backups (Only Keep Last 7 Days)
$files = glob($backupDir . "*.sql.gz"); // All backup files
$now = time();
foreach ($files as $file) {
    if (is_file($file) && ($now - filemtime($file) > 7 * 24 * 60 * 60)) { // 7 days in seconds
        unlink($file); // Delete old backup
    }
}

// Email Configuration
$to = "parikachevier2013@gmail.com, talk2parik@gmail.com";
$subject = "Database Backup - " . $dbName . date("Y-m-d H:i:s");
$message = "Database backup file attached.\nDate: " . date("Y-m-d H:i:s");
$from = "backupecopackservices@ecopackservices.com";
$boundary = md5(time());

// Read backup file content
$fileContent = file_get_contents($backupFile);
$encodedContent = chunk_split(base64_encode($fileContent));
$filename = basename($backupFile);

// Email Headers
$headers = "From: $from\r\n";
$headers .= "Reply-To: $from\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";

// Email Body
$body = "--$boundary\r\n";
$body .= "Content-Type: text/plain; charset=UTF-8\r\n";
$body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
$body .= $message . "\r\n\r\n";
$body .= "--$boundary\r\n";
$body .= "Content-Type: application/octet-stream; name=\"$filename\"\r\n";
$body .= "Content-Disposition: attachment; filename=\"$filename\"\r\n";
$body .= "Content-Transfer-Encoding: base64\r\n\r\n";
$body .= $encodedContent . "\r\n\r\n";
$body .= "--$boundary--";

// Send Email
if (mail($to, $subject, $body, $headers)) {
    echo "Backup email sent successfully!";
} else {
    echo "Failed to send backup email!";
}
?>
