<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>OnlyPDF</title>
  <link rel="stylesheet" href="/styles.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet" />
</head>

<script>
  // Reload the page to avoid form resubmission
  if (performance.navigation.type == 2) {
    location.reload(true);
  }

  // avoid form resubmission
  if (window.history.replaceState && performance.navigation.type != 1) {
    window.history.replaceState(null, null, window.location.href);
  }
</script>

<body>
  <nav class="navbar">
    <h1 class="nav-item">OnlyPDF - Your One-stop PDF solution</h1>
  </nav>
  <h1>Convert PDF to TXT file, or vice versa</h1>
  <form action="" method="POST" enctype="multipart/form-data">
    <input type="file" name="file[]" accept=".pdf,.txt" multiple />
    <button type="submit" name="conversionType" value="pdfToTxt">PDF to TXT</button>
    <button type="submit" name="conversionType" value="txtToPdf">TXT to PDF</button>
  </form>
  <?php
  if (isset($_FILES['file']['name']) && isset($_POST['conversionType'])) {
    $conversionType = $_POST['conversionType'];
    $inputPath = "/home/dejie/pdf-to-txt/input/";
    $outputPath = "/home/dejie/pdf-to-txt/output/";
    // Create a new zip archive
    $zip = new ZipArchive();
    $zipFile = $outputPath . '/converted_files.zip';
    if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
      exit("Cannot open <$zipFile>\n");
    }

    // Loop over each submitted file
    foreach ($_FILES['file']['tmp_name'] as $i => $tmp_name) {
      $name = $_FILES['file']['name'][$i];

      $inputFile = $inputPath . $name;
      $outputFile = $outputPath . preg_replace('/\.[^.]+$/', $conversionType === 'pdfToTxt' ? '.txt' : '.pdf', $name);

      // Move the uploaded file to the input directory
      move_uploaded_file($tmp_name, $inputFile);

      // Define the command to compile and execute the Java program
      $executeCommand = "java -cp " . $_SERVER['DOCUMENT_ROOT'] . "/lib/pdfbox-app-3.0.1.jar:" . $_SERVER['DOCUMENT_ROOT'] . "/bin/ ConvertPDF \"" . $inputFile . "\" \"" . $outputPath . "\"";

      // Execute the Java program
      exec($executeCommand);

      // Check if the conversion was successful
      if (file_exists($outputFile)) {
        // Add the file to the zip archive if there are multiple files
        if (isset($zip)) {
          $zip->addFile($outputFile, basename($outputFile));
        }

        // Delete the input file
        unlink($inputFile);
      } else {
        // If the conversion failed, display an error message and delete the input file
        echo "PDF conversion failed. Please make sure the PDF file contain no images.";
        if (file_exists($inputFile)) {
          unlink($inputFile);
        }
      }
    }

    // Close the zip archive if there are multiple files
    if (isset($zip) && $zip->numFiles > 0) {
      $zip->close();
      $name = basename($zipName);
      $filename = $outputPath . basename($zipName);
    } else {
      $name = preg_replace('/\.[^.]+$/', '.txt', $name);
      $filename = $outputFile;
    }

    // Store the output file in the session so we can download it later
    $_SESSION['outputFiles'][$name] = $filename;

    echo $name;
    echo $_SESSION['outputFiles'][$name];

    // Redirect to the download page
    header('Location: download.php?filename=' . urlencode($name));

    exit;
  } else {
    // If the conversion failed, display an error message and delete the input file
    echo "PDF conversion failed. Please make sure the PDF file contain no images.";
    if (file_exists($inputFile)) {
      unlink($inputFile);
    }
  }
  ?>

</body>

</html>

<script>
  window.onload = function() {
    var fileInput = document.getElementById('fileInput');
    var submitButton = document.getElementById('submitButton');

    // Disable the submit button if no file is selected
    if (fileInput.files.length === 0) {
      submitButton.disabled = true;
    }

    // Add an event listener for the change event on the file input
    fileInput.addEventListener('change', function() {
      if (this.files.length > 0) {
        submitButton.disabled = false;
      } else {
        submitButton.disabled = true;
      }
    });
  };
</script>