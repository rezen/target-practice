<?php

$endpoint = $_SERVER["REQUEST_URI"];
$endpoint = str_replace(['..'], '', $endpoint);
$endpoint = ltrim($endpoint, '/');

$nonce = uniqid('nonce.', true);
$nonce = explode(".", $nonce)[1];

require 'inc/lib.php';
require 'inc/elements.php';

$elements = fixElements($elements, $nonce);

$csp = [
  "default-src 'self' ",
	"style-src 'self' 'nonce-{$nonce}' fonts.googleapis.com",
  // "script-src 'self' 'nonce-{$nonce}' 'report-sample'",
  "script-src 'unsafe-eval'  'nonce-{$nonce}'", 
  "font-src",
  "img-src 'self' 'nonce-{$nonce}'",
 	"object-src 'none'", // What iframes will we allow?
  "child-src www.youtube.com", 
  "media-src 'self'",
  "connect-src 'self'",
  "form-action 'self'",

  "report-uri http://127.0.0.1:8000/report.php",
  // "report-to csp",
];


// Content-Security-Policy-Report-Only:
// header("Content-Security-Policy-Report-Only: " . implode(";", $csp));
header('Report-To: { "group": "csp","max_age": 10886400,"endpoints": [{ "url": "http://127.0.0.1:8000/report.php?from-report-to=1", "priority": 2 }] }');
?>
<html>
  <head>
    <title>CSP</title>
    <script src="assets/app.js"></script>
    <script src=""></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Alfa+Slab+One" />
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
    <h3>Response Headers</h3>
    <pre><?php print_r(headers_list()); ?></pre>
    <table border="1">
    <tr>
      <th>idx</th>
      <th>label</th>
      <th>el</th>
      <th>code</th>
      <th></th>
    </tr>
    <?php foreach ($elements as $idx => $el): ?>
      <tr data-id="<?php echo $el['id']; ?>">
        <td>
          <?php echo $idx; ?>
        </td>
        <td>
          <?php echo $el['label']; ?>
        </td>
        <td>
          <?php echo $el['html']; ?>
        </td>
        <td>
          <?php echo $el['script']['output']; ?>
          <pre><?php echo trim(str_replace("&gt;&lt;", "&gt;&lt;", htmlentities($el['html']))); ?></pre>
          <?php if (isset($el['script']['src'])): ?>
            js: <?php echo $el['script']['src']; ?>
          <?php endif; ?>
          <pre><?php echo @$el['script']['source']; ?></pre>
        </td>
        <td>
          <?php echo $el['category']; ?>
        </td>
      </tr>
    <?php endforeach; ?>
    <tr>
  </table>
</body>
</html>
