<?
//ini_set("display_errors", 1);

include 'ReportJson.php';
$obj = new ReportJson();
$obj->json = $_POST['json'];
$obj->type = $_POST['type'];
$obj->name = 'ReportJson';
$obj->file = '../tmp/' . $obj->name;

try {
    $obj->generate();
    echo "document.getElementById('fileDown').value='" . $obj->name . "';";
    echo "document.getElementById('fileType').innerHTML='" . $obj->type . "';";
    echo "document.getElementById('fileName').value='" . $obj->name . "';";
} catch (Exception $e) {
    echo "alert('Erro: " . $e->getMessage() . "');";
//    echo  'Código Erro:' . $e->getCode() .
//    ', Arquivo:' . $e->getFile() .
//    ', Linha:' . $e->getLine() .
//    ', Trace:' . $e->getTraceAsString() .
//    ', Previous:' . $e->getPrevious();
}