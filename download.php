<!DOCTYPE html>
<html>

<body>
  <p>Your file is ready for download.</p>

  <?php
  ini_set('session.save_path', ($_SERVER['DOCUMENT_ROOT']) . '/sessions');

  if (isset($_GET['filename'])) {
    session_start();
    $filename = $_GET['filename'];

    if (isset($_SESSION['outputFiles'][$filename])) {
      $outputFile = $_SESSION['outputFiles'][$filename];

      if (file_exists($outputFile)) {
        // Get the current time and the file's last modification time
        $currentTime = time();
        $fileModTime = filemtime($outputFile);

        // // Calculate the time difference in hours
        $timeDiff = ($currentTime - $fileModTime) / 60;

        // If the time difference is more than 2 hours, unlink the file
        if ($timeDiff > 0.3) {
          unlink($outputFile);
          unset($_SESSION['outputFiles'][$filename]);
          session_destroy();

          echo "The file is no longer available for download.";
        } else {
          // If the file exists and is less than 2 hours old, display a download link
          echo "<a href=\"" . $outputFile . "\" download>Download " . basename($outputFile) . "</a><br>";
        }
      }
    } else {
      echo "The file is no longer available for download.";
      unlink($outputFile);
      unset($_SESSION['outputFiles'][$filename]);
      session_destroy();
    }
  }
  ?>

</body>

</html>