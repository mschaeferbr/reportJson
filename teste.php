<?
//ini_set("display_errors", 1);
/* * *************************************************************************** */
/**
 * cabeçalho
 */
$head->logo = 'reportJson/external/tcpdf/images/logo_example.png';
$head->info[0] = 'Empresa';
$head->info[1] = 'CNPJ';
$head->info[2] = 'Contato';
$head->info[3] = 'Endereço';
$head->page = true;
$json->head = $head;
unset($head);
/* * *************************************************************************** */
/**
 * titulo
 */
$title[0] = 'Relatório Modelo';
$title[1] = 'Segunda Linha do Titulo';
$title[2] = 'Terceira Linha do Titulo';
$json->title = $title;
unset($title);

/* * *************************************************************************** */
/**
 *  níveis
 */
//configuração do cabeçalho/rodapé das linhas
$config->align->code = 'center';
$config->align->name = 'center';
$config->width->code = 150;
$config->width->name = 350;
$config->backgroundColor->code = '006400';
$config->backgroundColor->name = '006400';
$config->color->code = 'FFFFFF';
$config->color->name = 'FFFFFF';
$json->level->config = $config;
unset($config);

//desccrição
$head->code = 'Código';
$head->name = 'Nome';
$json->level->head = $head;
unset($head);

//configuração das linhas
$row->align->code = 'center';
$row->align->name = 'left';
$row->backgroundColor[0]->code = '23FF23';
$row->backgroundColor[0]->name = '23FF23';
$row->backgroundColor[1]->code = '1ccc1c';
$row->backgroundColor[1]->name = '1ccc1c';
$row->color->code = '000000';
$row->color->name = '000000';
$json->level->rows[0] = $row;
unset($row);
$soma=0;
//linhas
for ($i = 1; $i < 101; $i++) {
    $row->code = $i;
    $row->name = 'Descrição ' . $i;

    //na linha 50 cria um sub nível 2
    if ($i == 50) {
        $config2->align->code = 'center';
        $config2->align->name = 'center';
        $config2->width->code = 150;
        $config2->width->name = 350;
        $config2->backgroundColor->code = 'b8860b';
        $config2->backgroundColor->name = 'b8860b';
        $config2->color->code = 'FFFFFF';
        $config2->color->name = 'FFFFFF';
        $level->config = $config2;
        unset($config2);
        //desccrição do nível 2
        $head2->code = 'Código';
        $head2->name = 'Nome';
        $level->head = $head2;
        unset($head2);
        //configuração das linhas do nível 2
        $row2->align->code = 'center';
        $row2->align->name = 'left';
        $row2->backgroundColor[0]->code = 'ffd700';
        $row2->backgroundColor[0]->name = 'ffd700';
        $row2->color->code = '000000';
        $row2->color->name = '000000';
        $level->rows[0] = $row2;
        for ($j = 1; $j < 10; $j++) {
            $row2->code = $j;
            $row2->name = 'Descrição nível dois ' . $j;
            $level->rows[$j] = $row2;
            unset($row2);
        }
        //rodapé do nível 2
        $footer2->code = 9;
        $footer2->name = 'Teste';
        $level->footer = $footer2;
        unset($footer2);
        $row->level = $level;
        unset($level);
    }
    $soma+=$i;
    $json->level->rows[$i] = $row;
    unset($row);
}

//rodapé do nível
$footer->code = $i-1;
$footer->name = $soma;
$json->level->footer = $footer;
unset($footer);


/* * *************************************************************************** */
/**
 * rodapé
 */
$footer->date = true;
$footer->time = true;
$footer->owner = 'By Marcelo Schaefer';
$json->footer = $footer;
unset($footer);
//converte o objeto json em texto
$json = json_encode($json);
    ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">

    <title>.:: Testes ::. </title>
</head>
<body>
    <table>
        <tr>
            <td id="json"></td>
        </tr>
    </table>
</body>
</html>
<?
echo "<script>document.getElementById('json').innerHTML=decodeURIComponent('$json');</script>";











































/*

include_once 'reportJson/report/ReportJson.php';
$obj = new ReportJson();
$obj->json = $json;
$obj->type = '.html'; //.pdf .xls
$obj->name = 'reportJson' . date('YmdHis');
$obj->file = 'reportJson/tmp/';
$caminho = $obj->file . $obj->name;
try {
    $obj->generate();
//    $obj->type = '.pdf'; //.pdf .xls
//    $obj->generate();
} catch (Exception $e) {
    echo "<script>alert('Erro: " . $e->getMessage() . "');</script>";
}
?>
<table cellpadding='0' cellspacing='0' width='100%' height='100%'>
<!--    <tr>
        <td style="height: 10px; font-family: Arial; font-size: 25; font-weight: bold; text-align: center;">
            <input
                type="radio"
                value=".html"
                id="html"
                name="tipo"
                onclick="exibe(this.value);"
                checked="true"
                />
            <label for="html">Html</label>
            <input
                type="radio"
                value=".pdf"
                id="pdf"
                name="tipo"
                onclick="exibe(this.value);"
                />
            <label for="pdf">Pdf</label>

        </td>
    </tr>-->
    <tr>
        <td id="reportJson"></td>
    </tr>
</table>
<script>
    function exibe(tipo){
        document.getElementById('reportJson').innerHTML='';
        var ifr=document.createElement('iframe');
        ifr.id='ifr';
        ifr.name='ifr';
        ifr.style.width='100%';
        ifr.style.height='100%';
        document.getElementById('reportJson').appendChild(ifr);
        ifr.src='<? echo $caminho; ?>'+tipo;
    }
    exibe('.html');
</script>