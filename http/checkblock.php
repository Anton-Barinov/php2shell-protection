<?php
// PHP 5.2+ Apache multipart request-filtering test.
header('Content-Type: text/plain; charset=utf-8');
if (!function_exists('curl_init')) {
    die("ERROR: PHP cURL extension not installed.\n");
}
$host = $_SERVER['HTTP_HOST'];
$dir = dirname($_SERVER['SCRIPT_NAME']);
if ($dir == '/' || $dir == '\\') { $dir = ''; }
$url = 'http://' . $host . $dir . '/target.php';
function run_test($url, $multipart) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
    if ($multipart) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, array('test_field' => 'test_value'));
    } else {
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'test_field=test_value');
    }
    $response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
    curl_close($ch);
    echo "HTTP Status: " . $status . "\n";
    echo "Response Content-Type: " . ($contentType ? $contentType : 'unknown') . "\n";
    if ($response === false) {
        echo "cURL Error: " . $error . "\n";
    } else {
        echo "PHP Executed: " . (strpos($response, 'PHP_EXECUTED') !== false ? 'YES' : 'NO') . "\n";
        echo "Response:\n" . substr($response, 0, 500) . "\n";
    }
    echo "\n";
}
echo "Apache Multipart Protection Test\n================================\n\n";
echo "Target: " . $url . "\n\n";
echo "=== TEST 1: NORMAL POST ===\n";
run_test($url, false);
echo "=== TEST 2: MULTIPART POST ===\n";
run_test($url, true);
?>
