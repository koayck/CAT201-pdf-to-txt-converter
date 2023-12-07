import org.apache.pdfbox.pdmodel.PDDocument;
import org.apache.pdfbox.Loader;
import org.apache.pdfbox.text.PDFTextStripper;
import java.io.File;
import java.io.FileWriter;
import java.io.IOException;

public class App {

    static void extractAndSave(File pdfFile, String outputDir) throws IOException {
        PDDocument doc = Loader.loadPDF(pdfFile);
        String text = new PDFTextStripper().getText(doc);

        // Create a unique filename based on the PDF name and timestamp
        String timestamp = String.valueOf(System.currentTimeMillis());
        String fileName = pdfFile.getName().replaceFirst(".pdf$", "") + "_" + timestamp + ".txt";

        // Construct the full output file path
        File outputFile = new File(outputDir, fileName);

        // Create the directory if it doesn't exist
        outputFile.getParentFile().mkdirs();

        // Write the extracted text to the new file
        FileWriter writer = new FileWriter(outputFile);
        writer.write(text);
        writer.close();

        System.out.println("Text extracted from " + pdfFile.getName() + " and saved to " + outputFile.getAbsolutePath());
    }

    public static void main(String[] args) throws IOException {
        if (args.length < 2) {
            System.err.println("Usage: java PdfExtractor <pdf_file> <output_directory>");
            System.exit(1);
        }

        File pdfFile = new File(args[0]);
        String outputDir = args[1];

        if (!pdfFile.exists() || !pdfFile.isFile()) {
            System.err.println("Error: " + pdfFile + " is not a valid PDF file.");
            System.exit(1);
        }

        extractAndSave(pdfFile, outputDir);
    }
}