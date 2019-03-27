<?php

function rfiles($dir) {
    $files = [];
    $tree = glob(rtrim($dir, '/') . '/{,.}[!.,!..]*', GLOB_MARK|GLOB_BRACE);
    if (is_array($tree)) {
        foreach($tree as $file) {
            if (is_dir($file)) {
                $files = array_merge($files, rfiles($file));
            } elseif (is_file($file)) {
                $files[] = $file;
            }
        }
    }
    return $files;
}

$endpoint = $_SERVER["REQUEST_URI"];
$endpoint = str_replace(['..'], '', $endpoint);
$endpoint = ltrim($endpoint, '/');

if (strpos($endpoint, "api") !== false) {
  header('Content-Type: application/json');
  echo json_encode([
      [
        'id' => 27,
        'name' => 'example',
        'meta' => [ 
           'source' => 'db',
           'details' => [
             'password' => 'password123',
           ],
        ],
      ],
      [
         'id' => 29,
         'ssn' => '00-000-0000'
      ]
  ]);
  return;
}

if ($endpoint === "") {
    $endpoint = ".";
}

if (!file_exists($endpoint)) {
    header("HTTP/1.0 404 Not Found");
    echo "404";
    return;
}   

print_r(getallheaders());
if (is_file($endpoint)) {
    echo file_get_contents($endpoint);
    return;
}


$files = rfiles($endpoint);

foreach ($files as $file): ?>
    <a href="<?php echo $file; ?>">
        <?php echo $file; ?>
    </a>
    <br />
<?php endforeach;   
