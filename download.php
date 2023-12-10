<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>OnlyPDF</title>
  <link rel="stylesheet" href="/styles.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet" />
</head>

<body>
  <nav class="navbar">
    <div class="nav_item">
      <ul class="nav_list">
        <a class="nav" href="/index.php">Home</a>
        <a class="nav" href="/pdf-to-txt.php">PDF to TXT</a>
        <a class="nav" href="/txt-to-pdf.php">TXT to PDF</a>
      </ul>
    </div>
  </nav>
  <section class="content">
    <div>
      <h1 class="download_title">
        Hooray! Your File(s) have been converted successfully!
      </h1>
      <br>
    </div>
    
    <?php
      ini_set('session.save_path', ($_SERVER['DOCUMENT_ROOT']) . '/sessions');
      
    session_start();
      
    if (isset($_GET['filename'])) {
      $name = $_GET['filename'];
      
      if (isset($_SESSION['outputFiles'][$name])) {
        $outputFile = $_SESSION['outputFiles'][$name];
        
        if (file_exists($outputFile)) {
          // Get the current time and the file's last modification time
          $currentTime = time();
          $fileModTime = filemtime($outputFile);
          
          // Calculate the time difference in hours
          $timeDiff = ($currentTime - $fileModTime) / 60;
          
          // If the time difference is more than 2 hours, unlink the file
          if ($timeDiff > 0.2) {
            unlink($outputFile);
            unset($_SESSION['outputFiles'][$name]);
            session_destroy();
            
            echo "The file is no longer available for download.";
          } else {
            
            // Remove root path from the output file path
            $outputFile = str_replace("/var/www/html", "", $outputFile);
            
            // If the file exists and is less than 2 hours old, display a download link
            echo "<a class='download_anchor' href=\"" . $outputFile . "\" download >Download " . basename($outputFile) . "</a><br>";
          }
        } else {
          echo "no output file";
        }
      } else {
        echo "The file is no longer available for download.";
        unlink($outputFile);
        unset($_SESSION['outputFiles'][$name]);
        session_destroy();
      }
    }
   ?>

  </section>
</body>

</html>