
<?php
// Compatible with PHP 5.2+

if (isset($_GET['probe'])) {
    header('Content-Type: text/plain');
    echo 'MULTIPART_REACHED_PHP';
    exit;
}

header('Content-Type: text/html; charset=utf-8');

$self = htmlspecialchars(
    $_SERVER['SCRIPT_NAME'],
    ENT_QUOTES,
    'UTF-8'
);
?>
<!DOCTYPE html>
<html>
<head>
<title>Multipart Protection Test</title>
</head>
<body>

<h2>Apache Multipart Protection Test</h2>

<p>
This test submits a multipart/form-data
POST request to this same PHP script.
</p>

<form action="<?php echo $self; ?>?probe=1"
      method="post"
      enctype="multipart/form-data"
      target="test_result">

    <input type="hidden"
           name="test_field"
           value="multipart_test">

    <input type="submit"
           value="Test Multipart Blocking">
</form>

<h3>Server Response</h3>

<iframe name="test_result"
        style="width:100%;height:180px;border:1px solid #ccc;">
</iframe>

<p>
<strong>Expected results:</strong>
</p>

<ul>
<li>
<strong>403 Forbidden:</strong>
Apache blocked the multipart request.
</li>
<li>
<strong>MULTIPART_REACHED_PHP:</strong>
The request reached PHP. Blocking is not working.
</li>
</ul>

</body>
</html>
