<html>
    <head>
        <title>OnlyPDF</title>
        <link rel="stylesheet" href="/src/styles.css">
    </head>
    <body>
        <div class="Hero">
            <h1 class="Hero_Title">
                OnlyPDF - Your One-stop PDF solution
            </h1>
        </div>
        <h1>Convert your PDF to TXT</h1>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="pdfFile" accept=".pdf">
            <button type="submit">Convert</button>
        </form>
    </body>
</html>

<?php
    if (isset($_FILES['pdfFile']['name'])) {
        $inputPath = "/home/yicheng/CAT201/Ass1/input/" . $_FILES['pdfFile']['name'];
        $outputPath = "/home/yicheng/CAT201/Ass1/output/";
        $outputFile = "/home/yicheng/CAT201/Ass1/output/output.txt";

        // Move uploaded file to uploads directory
        move_uploaded_file($_FILES['pdfFile']['tmp_name'], $inputPath);

        $executeCommand = "java -cp /home/yicheng/CAT201/Ass1/lib/pdfbox-app-3.0.1.jar:/home/yicheng/CAT201/Ass1/bin/ ConvertPDF " . $inputPath . " " . $outputPath;
        
        // Call Java program to convert
        exec($executeCommand);
    } 
    else {
        echo "Please select a PDF file to upload.";
    }
    // Check if conversion successful
    if (file_exists($outputFile)) {
        // Get the filename with extension
        $fileName = preg_replace('/\.[^.]+$/', '.txt', basename($_FILES['pdfFile']['name']));

        // Set session variable with output file path
        $_SESSION['outputFile'] = $outputFile;

        echo "<form action='download.php' method='post'>";
        echo "<button type='submit' name='download'>Download Text File</button>";
        echo "</form>";
        
        if (isset($_POST['download']) || isset($_GET['download'])) {
            // Download logic as before
            header("Content-Type: application/txt");
            header("Content-Disposition: attachment; filename=" . $fileName);
            // Read the file content into a variable
            $fileContent = file_get_contents($outputFile);

            // Send the file content to the browser
            echo $fileContent;

            // Unlink input file only when leaving the page
            register_shutdown_function(function() use ($outputFile) {
                if (isset($_SESSION['outputFile']) && $_SESSION['outputFile'] === $outputFile) {
                    unlink($outputFile);
                    unset($_SESSION['outputFile']);
                }
            });
        }
    }
    if (isset($_FILES['pdfFile']['name']) && !file_exists($outputFile)) {
        echo "Error converting PDF!";
        if (file_exists($inputPath)) {
            unlink($inputPath);
        }
    }
    // Unlink the input file
    unlink($inputPath);
?>