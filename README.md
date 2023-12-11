# PDF to TXT & TXT to PDF Converter

This project is a PDF to TXT & TXT to PDF converter implemented using PHP, Apache web server, Ubuntu, Docker, Java, and PDFBox.

## Prerequisites

Make sure you have Docker installed on your system.

## Usage

1. Clone the repository:

```bash
git clone https://github.com/koayck/pdf-to-txt.git
```

2. Navigate to the project directory:

```bash
cd pdf-to-txt
```

3. Run the Docker container:

```bash
docker run -d --rm --name pdf-to-txt:1.0 -p 80:80 httpd
```

4. Visit localhost:80 in your web browser to access the PDF to TXT converter.
