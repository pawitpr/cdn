<?php
// File: index.php

// Directory to serve files from
$dir = './cdn';

// Get the file name from the query parameter
if (isset($_GET['file'])) {
  $filename = basename($_GET['file']);
  $filepath = $dir . '/' . $filename;

  // Check if the file exists and is a file (not a directory)
  if (file_exists($filepath) && is_file($filepath)) {
    // Set appropriate headers for file download
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($filepath));
    readfile($filepath);
    exit;
  }
}

// List files in the directory
$files = scandir($dir);
?>
<!DOCTYPE html>
<html>
<head>
  <title>HTTP File Server</title>
</head>
<body>
  <h1>HTTP File Server</h1>
  <ul>
    <?php foreach ($files as $file): ?>
      <?php if ($file !== '.' && $file !== '..'): ?>
        <li><a href="?file=<?= urlencode($file) ?>"><?= $file ?></a></li>
      <?php endif; ?>
    <?php endforeach; ?>
  </ul>
</body>
</html>
