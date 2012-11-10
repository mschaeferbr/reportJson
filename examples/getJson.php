<?
if (isset($_POST['fileUp']) && $_POST['fileUp']) {
    $caminho='../tmp/' . $_POST['fileUp'];
    $file = file_get_contents($caminho);
    echo $file;
    unlink($caminho);
}else{
    $caminho='model.json';
    $file = file_get_contents($caminho);
    echo $file;
}