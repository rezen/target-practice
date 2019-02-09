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

$files = rfiles(".");

foreach ($files as $file): ?>
 <a href="<?php echo $file; ?>"><?php echo $file; ?></a><br />
<?php endforeach;
