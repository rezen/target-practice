<?php

$endpoint = $_SERVER["REQUEST_URI"];
$endpoint = str_replace(['..'], '', $endpoint);
$endpoint = ltrim($endpoint, '/');


$csp = [
       "default-src 'self'",
	"style-src 'self'",
 	"report-uri http://127.0.0.1:8000/report.php",
        // "report-to csp",
];

header("Content-Security-Policy: " . implode(";", $csp));
header('Report-To: { "group": "csp","max_age": 10886400,"endpoints": [{ "url": "http://127.0.0.1:8000/report.php?from-report-to=1", "priority": 2 }] }');
?>
<html>
  <head>
    <script src="assets/app.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/core.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/d3@5.9.2/dist/d3.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/css/all.min.css" />
    <link rel="stylesheet" href="assets/app.css" />
  </head>
  <body>
   <h3>CSP</h3>
   <pre><?php print_r($csp); ?></pre>
   <hr />
   <h3>Request Headers</h3>
  <pre>
  <?php print_r(getallheaders()); ?>
  </pre>
  <hr />


  <style>
   .style-no-nonce{
       color: red;
  }
  </style>
    <p class="style-no-nonce">Inline style This will be red from style without nonce</p>
    <p class="js-no-nonce">Inline JavaScript no-nonce will change this color</p>
    
   <p><img src="assets/pic-1.jpg" height="200" alt="Same source" /></p>
 
   <p><img src="https://img.shields.io/badge/build-passing-brightgreen.svg" alt="From another domain" /></p>
 <script>
   document.addEventListener('DOMContentLoaded', function() {
     Array.from(document.querySelectorAll('.js-no-nonce')).map(function(el){ 
	el.style.color = 'orange'
     })
   });

 </script>
 
</body>
</html>
