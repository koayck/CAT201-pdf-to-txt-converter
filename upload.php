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

        // Check if conversion successful
        if (file_exists($outputFile)) {
            // Get the filename with extension
            $fileName = preg_replace('/\.[^.]+$/', '.txt', basename($_FILES['pdfFile']['name']));

            /// Set headers for download trigger
            header("Content-Type: application/txt");
            header("Content-Disposition: attachment; filename=" . $fileName);

            // Read the file content into a variable
            $fileContent = file_get_contents($outputFile);

            // Send the file content to the browser
            echo $fileContent;

            // Register a shutdown function to delete the file
            register_shutdown_function(function() use ($outputFile) {
                unlink($outputFile);
                // Unlink the input file
                unlink($inputPath);
            });
        } 
        else {
            echo "Error converting PDF!";
            if (file_exists($inputPath)) {
                unlink($inputPath);
            }
        }
    } 
    else {
        echo "Please select a PDF file to upload.";
    }
?>