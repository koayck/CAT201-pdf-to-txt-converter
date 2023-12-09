<!DOCTYPE html>
<html>

<body>
  <p>Your file is ready for download.</p>

  <?php
  session_start();

  if (isset($_GET['filename'])) {
    $filename = $_GET['filename'];

    if (isset($_SESSION['outputFiles'][$filename])) {
      $outputFile = $_SESSION['outputFiles'][$filename];

      if (file_exists($outputFile)) {
        // Get the current time and the file's last modification time
        $currentTime = time();
        $fileModTime = filemtime($outputFile);

        // // Calculate the time difference in hours
        $timeDiff = ($currentTime - $fileModTime) / 3600;

        // If the time difference is more than 2 hours, unlink the file
        if ($timeDiff > 2) {
          unlink($outputFile);
          unset($_SESSION['outputFiles'][$name]);
        } else {
          // If the file exists and is less than 2 hours old, display a download link
          echo "<a href=\"" . $outputFile . "\" download>Download " . basename($outputFile) . "</a><br>";
        }
      }
    }
  }
  ?>

</body>

</html>