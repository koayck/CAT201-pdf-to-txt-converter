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
            $executeCommand = "java -cp /home/dejie/pdf-to-txt/lib/pdfbox-app-3.0.1.jar:/home/dejie/pdf-to-txt/bin/ " . ($conversionType === 'pdfToTxt' ? 'ConvertPDF' : 'ConvertTXT') . " \"" . $inputFile . "\" \"" . $outputPath . "\"";
            // Execute the Java program
            exec($executeCommand);

            // Check if the conversion was successful
            if (file_exists($outputFile)) {
                // Add the file to the zip
                $zip->addFile($outputFile, basename($outputFile));
            } else {
                // If the conversion failed, display an error message and delete the input file
                echo "Error converting PDF!";
                if (file_exists($inputFile)) {
                    unlink($inputFile);
                }
            }
        }

        // Close the zip file
        $zip->close();

        // Provide a download link for the zip file
        $url = str_replace('/home/dejie/pdf-to-txt/', '', $zipFile);
        echo "<a href=\"" . $url . "\" download>Download " . basename($zipFile) . "</a><br>";
    } else {
        echo "Please select a PDF file to upload.";
    }
    ?>
</body>

</html>