<?
//ini_set("display_errors", 1);

/******************************************************************************/
/**
 * cabeçalho
 */
$json->head->logo = 'reportJson/external/tcpdf/images/logo_example.png';
$json->head->info[0] = 'Empresa';
$json->head->info[1] = 'CNPJ';
$json->head->info[2] = 'Contato';
$json->head->info[3] = 'Endereço';
$json->head->page = true;

/******************************************************************************/
/**
 * titulo
 */
$json->title[0] = 'Relatório Modelo';
$json->title[1] = 'Segunda Linha do Titulo';
$json->title[2] = 'Terceira Linha do Titulo';

/******************************************************************************/
/**
 *  níveis
 */

//configuração do cabeçalho/rodapé das linhas
$json->level->config->align->code='center';
$json->level->config->align->name='center';
$json->level->config->width->code=150;
$json->level->config->width->name=350;
$json->level->config->backgroundColor->code='006400';
$json->level->config->backgroundColor->name='006400';
$json->level->config->color->code='FFFFFF';
$json->level->config->color->name='FFFFFF';

//desccrição
$json->level->head->code='Código';
$json->level->head->name='Nome';

//configuração das linhas
$json->level->rows[0]->align->code='center';
$json->level->rows[0]->align->name='left';
$json->level->rows[0]->backgroundColor->code='23FF23';
$json->level->rows[0]->backgroundColor->name='23FF23';
$json->level->rows[0]->color->code='000000';
$json->level->rows[0]->color->name='000000';

//linhas
for ($i=1;  $i<11; $i++){
    $json->level->rows[$i]->code= $i;
    $json->level->rows[$i]->name='Descrição '.$i;
}

//rodapé do nível
$json->level->footer->code=12;
$json->level->footer->name='Teste';

/******************************************************************************/
/**
 * rodapé
 */
$json->footer->date = true;
$json->footer->time = true;
$json->footer->owner = 'By Marcelo Schaefer';

//converte o objeto json em texto
$json=json_encode($json);

include 'ReportJson.php';
$obj = new ReportJson();
$obj->json = $json;
$obj->type = '.xls'; //.pdf .xls
$obj->name = 'teste_relatorio';
$obj->file = '../tmp/';

try {
    $obj->generate();


    echo $obj->file.$obj->name.$obj->type;


} catch (Exception $e) {
    echo "alert('Erro: " . $e->getMessage() . "');";
}