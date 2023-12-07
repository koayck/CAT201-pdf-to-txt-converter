import org.apache.pdfbox.pdmodel.PDDocument;

import java.io.File;

import org.apache.pdfbox.Loader;
import org.apache.pdfbox.text.PDFTextStripper;

public class test {

    public static void main(String[] args) throws Exception {
        if (args.length != 1) {
            System.err.println("Usage: java SimplePdfReader <pdf_file>");
            System.exit(1);
        }

        File file = new File("test.pdf");
        PDDocument doc = Loader.loadPDF(file);

        // Extract text using PDFTextStripper
        PDFTextStripper stripper = new PDFTextStripper();
        String text = stripper.getText(doc);

        System.out.println("Text extracted from " + file + ":");
        System.out.println(text);

        doc.close();
    }
}