<?
$url=$_GET['fileDown'];

//echo "<script>alert('$url');</script>";

header('Content-Length:'.filesize($url));
header('Content-Disposition: attachment; filename="'.$_GET['fileName'].'"');
header('Expires: 0');
readfile($url);
unlink($url);