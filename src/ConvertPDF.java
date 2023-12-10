import java.io.File;
import java.io.IOException;
import org.apache.pdfbox.Loader;
import org.apache.pdfbox.pdmodel.PDDocument;
import org.apache.pdfbox.text.PDFTextStripper;

public class ConvertPDF {

  public static void main(String[] args) throws IOException {
    if (args.length < 2) {
      System.err.println(
        "Usage: java PdfExtractor <pdf_file> <output_directory>"
      );
      System.exit(1);
    }

    // Define input and output paths
    String inputFile = args[0];
    String outputPath = args[1];

    // Load the PDF document
    File file = new File(inputFile);
    System.out.println(file);
    
    PDDocument document = Loader.loadPDF(file);

    // Create a text stripper
    PDFTextStripper textStripper = new PDFTextStripper();

    // Extract the text and save it to a file
    String text = textStripper.getText(document);

    // Extract the baseName of the file
    String baseName = file.getName().substring(0, file.getName().lastIndexOf("."));
    System.out.println(baseName);

    // Create output file in the output path
    File outputFile = new File(outputPath, baseName + ".txt");
    // outputFile.getParentFile().mkdirs(); // Create directory if it doesn't exist
    try (java.io.FileWriter writer = new java.io.FileWriter(outputFile)) {
      writer.write(text);
    }

    // Close the document
    document.close();

    System.out.println("PDF converted to TXT successfully!");
  }
}