<?
if (isset($_FILES['fileUp']) && $_FILES['fileUp']['name']) {
    if (!move_uploaded_file($_FILES['fileUp']['tmp_name'], '../tmp/' . $_FILES['fileUp']['name'])){
        echo "<script>alert('Houve um erro ao gravar arquivo.');</script>";
    }
}