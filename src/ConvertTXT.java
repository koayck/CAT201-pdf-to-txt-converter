import java.io.IOException;
import java.util.Scanner;
import java.io.File;
import java.io.FileNotFoundException;

import org.apache.pdfbox.pdmodel.PDDocument;
import org.apache.pdfbox.pdmodel.PDPage;

import org.apache.pdfbox.pdmodel.PDPageContentStream;

import org.apache.pdfbox.pdmodel.font.PDFont;
import org.apache.pdfbox.pdmodel.font.PDType1Font;
import org.apache.pdfbox.pdmodel.font.Standard14Fonts;

public class ConvertTXT {
    public static void main(String[] args) throws IOException {
        // Check if filename is supplied
        if (args.length != 1) {
            System.out.println("Please provide a file as a command line argument.");
            System.exit(1);
        }
        File file = new File(args[0]);
        String filename = "Text2PDF.pdf";

        PDDocument doc = new PDDocument();
        try {
            PDPage page = new PDPage();
            doc.addPage(page);

            PDFont font = new PDType1Font(Standard14Fonts.FontName.HELVETICA);

            PDPageContentStream contents = new PDPageContentStream(doc, page);
            contents.beginText();
            contents.setFont(font, 30);
            contents.newLineAtOffset(50, 700);

            try (Scanner scanner = new Scanner(file)) {
                // Read the file line by line
                while (scanner.hasNextLine()) {
                    String line = scanner.nextLine();
                    contents.showText(line);
                    contents.newLineAtOffset(0, -15);
                }
            } catch (FileNotFoundException e) {
                System.out.println("File not found: " + file.toString());
            }

            contents.endText();
            contents.close();

            doc.save(filename);
        } finally {
            doc.close();
        }
    }
}