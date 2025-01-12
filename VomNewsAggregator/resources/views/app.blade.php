<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Aggregator</title>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    @vite(['resources/js/app.js'])
    <style>
        body {
          font-family: Arial, sans-serif;
          margin: 0;
          padding: 0;
          background-color: #f4f4f4;
        }
        #app {
          max-width: 1200px;
          margin: auto;
          padding: 20px;
        }
        .overview {
          text-align: center;
          padding: 20px;
          background-color: #fff;
          margin-bottom: 20px;
          border-radius: 8px;
          box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
      </style>

</head>
<body>
    <div id="app">
        <div class="overview">
            <h1>News Aggregator</h1>
            <p>Sources: The Guardian, NewsAPI, New York Times</p>
        </div>
        <swiper-component></swiper-component>
        <articles-list></articles-list>
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
