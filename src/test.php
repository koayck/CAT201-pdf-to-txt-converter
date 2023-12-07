<?php
        $inputPath = "/home/yicheng/CAT201/Ass1/input/" . $_FILES['pdfFile']['name'];
        $outputPath = "/home/yicheng/CAT201/Ass1/output/";
        $outputFile = "/home/yicheng/CAT201/Ass1/output/" . $_FILES['pdfFile']['name'];


        $executeCommand = "java -cp ./lib/pdfbox-app-3.0.1.jar:./bin ConvertPDF " . $inputPath . " " . $outputPath;

        echo $executeCommand;
?>