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
  <link rel="apple-touch-icon" sizes="180x180" href="/static/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/static/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/static/favicon-16x16.png">
  <link rel="manifest" href="/static/site.webmanifest">
</head>

<body>
  <nav class="navbar">
    <div class="nav_item">
      <ul class="nav_list">
        <a class="nav" style="color:#C69C3C;" href="/index.php">Home</a>
        <a class="nav" href="/pdf-to-txt.php">PDF to TXT</a>
        <a class="nav" href="/txt-to-pdf.php">TXT to PDF</a>
      </ul>
    </div>
    <div class="title">
      <div class="title_img">
        <img src="/static/android-chrome-512x512.png" alt="">
      </div>
      <h1>
        Your One-stop PDF solution
      </h1>
    </div>
  </nav>

  <section class="content">
    <div class="card_container">
      <a class="card_link" href="/pdf-to-txt.php">
        <div class="card">
          <p class="card_title">
            PDF to TXT
          </p>
          <p class="card_description">
            Turn your PDF into plain TXT file.
          </p>
        </div>
      </a>
      <a class="card_link" href="/txt-to-pdf.php">
        <div class="card">
          <p class="card_title">
            TXT to PDF
          </p>
          <p class="card_description">
            Turn your TXT into PDF file.
          </p>
        </div>
      </a>
    </div>
  </section>
</body>

</html>