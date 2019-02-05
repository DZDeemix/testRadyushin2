<?php
require_once __DIR__ . '/vendor/autoload.php';

$library = new App\Controllers\Library();
if (method_exists($library, $argv[1])) {
    $param = null;
    if (!empty($argv[2])) {
        $param = $argv[2];
    }

    call_user_func_array(array($library, $argv[1]), [$param]);
}
?>

