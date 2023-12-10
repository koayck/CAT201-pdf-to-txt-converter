
// Import necessary libraries
import org.apache.pdfbox.pdmodel.PDDocument;
import org.apache.pdfbox.pdmodel.PDPage;
import org.apache.pdfbox.pdmodel.PDPageContentStream;
import org.apache.pdfbox.pdmodel.font.PDType1Font;
import org.apache.pdfbox.pdmodel.font.Standard14Fonts;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.io.IOException;

public class ConvertTXT {
    public static void main(String[] args) {
        // Check if the correct number of arguments are provided
        if (args.length < 2) {
            System.err.println("Usage: java TxtToPdf <txt_file> <output_directory>");
            System.exit(1);
        }

        // Get the input file and output directory from the arguments
        String inputFile = args[0];
        String outputDirectory = args[1];

        // Extract the base name of the input file
        File inputFileObj = new File(inputFile);
        String baseName = inputFileObj.getName().substring(0, inputFileObj.getName().lastIndexOf("."));

        // Define the output file path
        String outputFile = outputDirectory + File.separator + baseName + ".pdf";

        try (PDDocument doc = new PDDocument()) {
            PDPage page = new PDPage();
            doc.addPage(page);

            PDPageContentStream contentStream = new PDPageContentStream(doc, page);
            contentStream.setFont(new PDType1Font(Standard14Fonts.FontName.HELVETICA), 12);
            contentStream.beginText();
            contentStream.newLineAtOffset(50, 700);

            try (BufferedReader br = new BufferedReader(new FileReader(inputFile))) {
                String line;
                float yPosition = 700.0f;

                while ((line = br.readLine()) != null) {
                    // Add the line to the content stream and move to the next line
                    contentStream.showText(line);
                    yPosition -= 12;
                    contentStream.newLineAtOffset(0, -12);

                    // If the end of the page is reached, create a new page
                    if (yPosition < 50) {
                        contentStream.endText();
                        contentStream.close();
                        page = new PDPage();
                        doc.addPage(page);
                        contentStream = new PDPageContentStream(doc, page);
                        contentStream.setFont(new PDType1Font(Standard14Fonts.FontName.HELVETICA), 12);
                        contentStream.beginText();
                        contentStream.newLineAtOffset(50, 700);
                        yPosition = 700.0f;
                    }
                }
            }

            contentStream.endText();
            contentStream.close();

            doc.save(outputFile);
            System.out.println("TXT converted to PDF successfully!");
        } catch (IOException e) {
            e.printStackTrace();
        }

    }
}
