<?php

class Html {

    function __construct() {
        $this->obj = array();
        $this->buf = '';
        $this->file = '';
    }

    public function generate() {
        $this->config();
        $this->validate();
        $this->listHead();
        $this->listTitle();
        $this->listLevel();
        $this->listFooter();
        $this->createFile();
    }

    private function validate() {
        if (!isset($this->obj->head)) {
            throw new Exception('Objeto head não encontrado.');
        }
        if (!isset($this->obj->title)) {
            throw new Exception('Vetor title não encontrado.');
        }
        if (!isset($this->obj->level)) {
            throw new Exception('Objeto level não encontrado.');
        }
        if (!isset($this->obj->footer)) {
            throw new Exception('Objeto footer não encontrado.');
        }
    }

    private function config() {

    }

    private function dash() {
        $this->buf .= '<tr><td colspan="100%"><hr style="width: 100%;"></td></tr>';
    }

    private function listHead() {
        $this->buf .= '<tr>';
        $this->buf .= '<td style="width: 50px; text-align: center; vertical-align: middle;">' . ($this->obj->head->logo ? '<img src="http://localhost/' . $this->obj->head->logo . '" style="height:50px;width:50px;"/>' : '') . '</td>';
        $this->buf .= '<td style="width: 100%; text-align: center;">';
        $this->buf .= '<table style="width: 100%; text-align: center; font-size: x-small;">';
        $i = 0;
        while ($i < 4) {
            $this->buf .= '<tr>';
            $this->buf .= '<td>';
            $this->buf .= '<label>' . $this->obj->head->info[$i] . '</label>';
            $this->buf .= '</td>';
            $this->buf .= '</tr>';
            $i++;
        }
        $this->buf .= '</table>';
        $this->buf .= '</td>';
        $this->buf .= '<td style="width: 50px; text-align: center; vertical-align: middle; font-size: medium;"><label>' . ($this->obj->head->page ? '1&nbsp;/&nbsp;1' : '') . '</label></td>';
        $this->buf .= '</tr>';
        $this->dash();
    }

    private function listTitle() {
        $fontSize[0] = 'xx-large';
        $fontSize[1] = 'x-large';
        $fontSize[2] = 'large';
        $i = 0;
        while ($this->obj->title[$i] && $i < 3) {
            $this->buf .= '<tr style="font-size: ' . $fontSize[$i] . '; font-weight:bold;">';
            $this->buf .= '<td colspan="100%" style="text-align: center;"><label>' . $this->obj->title[$i] . '</label></td>';
            $this->buf .= '</tr>';
            $i++;
        }
    }

    private function listLevel() {
        $this->buf .= '<tr>';
        $this->buf .= '<td colspan="100%">';
        $this->buf .= '<center>';
        $this->buf .= '<ol>';
        include 'LevelHtml.php';
        $objLevelHtml = new LevelHtml();
        $objLevelHtml->obj = &$this->obj->level;
        $objLevelHtml->buf = &$this->buf;
        $objLevelHtml->generate();
        $this->buf .= '</ol>';
        $this->buf .= '</center>';
        $this->buf .= '</td>';
        $this->buf .= '</tr>';
    }

    private function listFooter() {
        $this->dash();
        $this->buf .= '<tr style="font-size: x-small; font-style: italic,bold;">';
        $this->buf .= '<td colspan="100%" style="width: 100%; text-align: center;"><label>' . $this->obj->footer->owner . ($this->obj->footer->date ? '&nbsp;&nbsp;&nbsp;&nbsp;' . date('d/m/Y') : '') . ($this->obj->footer->time ? '&nbsp;-&nbsp;' . date('H:i:s') : '') . '</label></td>';
        $this->buf .= '</tr>';
    }

    private function createFile() {
        $this->buf = '
            <html>
                <head>
                    <META HTTP-EQUIV="CONTENT-TYPE" CONTENT="text/html; charset=utf-8">
                    <TITLE></TITLE>
                    <META NAME="GENERATOR" CONTENT="ReportJson">
                    <META NAME="CREATED" CONTENT="0;0">
                    <META NAME="CHANGEDBY" CONTENT="Marcelo Schaefer">
                </head>
                <body>
                    <table style="font-family: Arial; border: 1px solid;">
                        ' . $this->buf . '
                    </table>
                </body>
            </html>
        ';
        if (!$file = fopen($this->file, 'w')) {
            throw new Exception('Não foi possível criar arquivo.');
        }
        fwrite($file, $this->buf);
        fclose($file);
    }

}