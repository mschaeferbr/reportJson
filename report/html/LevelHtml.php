<?php

$GLOBALS['objConfig'] = array();

class LevelHtml {

    function __construct() {
        $this->obj = array();
        $this->buf = '';
        $this->level = 1;
        $this->posCol = array();
        $this->width = 0;
        $this->col = 0;
    }

    public function generate() {
        $this->validate();
        $this->config();
        $this->listHead();
        $this->listRows();
        $this->listFooter();
    }

    private function validate() {

    }

    private function config() {
        //grava configurações do nivel em uma variável global se não existir
        if (empty($GLOBALS['objConfig'][$this->level])) {
            $GLOBALS['objConfig'][$this->level]->head = $this->obj->head;
            $GLOBALS['objConfig'][$this->level]->config = $this->obj->config;
            $GLOBALS['objConfig'][$this->level]->rows = $this->obj->rows[0];
        } else {
            //se o nivel se repetir e não tiver configurações seta as configurações recuperadas do primeiro equivalente
            $this->obj->head = $GLOBALS['objConfig'][$this->level]->head;
            $this->obj->config = $GLOBALS['objConfig'][$this->level]->config;
            $this->obj->rows[0] = $GLOBALS['objConfig'][$this->level]->rows;
        }
        $i = 0;
        //ordem das colunas de acordo com o head
        foreach ($this->obj->head as $key => $value) {
            $this->posCol[$i] = $key;
            $i++;
        }
    }

    private function listHead() {
        $width = 0;
        $buf = '';
        $i = 0;
        while ($this->posCol[$i]) {
            $col = $this->posCol[$i];
            $width+= (float) $this->obj->config->width->$col;
            $buf .= '<td border="1" style="border: 1px solid; color: #' . ($this->obj->config->color->$col?$this->obj->config->color->$col:'000000') . '; background-color: #' . ($this->obj->config->backgroundColor->$col?$this->obj->config->backgroundColor->$col:'FFFFFF') . '; width: ' . $this->obj->config->width->$col . 'px; text-align: ' . $this->obj->config->align->$col . '; vertical-align: middle;"><label>' . $this->obj->head->$col . '</label></td>';
            $i++;
        }
        if ($this->level != 1) {
            $width+=20;
        }
        $this->width = $width;
        $this->col = $i;
        $this->buf .= '<table style="font-family: Arial; width: ' . $width . 'px; text-align: center;">';
        $this->buf .= '<tr style="font-size: medium; font-weight:bold;">';
        $this->buf .=$buf;
        $this->buf .= '</tr>';
    }

    private function listRows() {
        $i = 1;
        while ($this->obj->rows[$i]) {
            $this->buf .= '<tr style="font-size: small;">';
            $j = 0;
            while ($this->posCol[$j]) {
                $col = $this->posCol[$j];
                $this->buf .= '<td border="1" style="border: 1px solid; color: #' . ($this->obj->rows[0]->color->$col?$this->obj->rows[0]->color->$col:'FFFFFF') . '; background-color: #' . ($this->obj->rows[0]->backgroundColor->$col?$this->obj->rows[0]->backgroundColor->$col:'FFFFFF') . '; width: ' . $this->obj->config->width->$col . 'px; text-align: ' . $this->obj->rows[0]->align->$col . '; vertical-align: middle;"><label>' . $this->obj->rows[$i]->$col . '</label></td>';
                $j++;
            }
            $this->buf .= '</tr>';
            //chama a classe recursivamente se existir niveis internos
            if ($this->obj->rows[$i]->level) {
                $this->buf .= '<tr>';
                $this->buf .= '<td border="0" colspan= "100%" style="width: 100%; text-align: center;">';
                $this->buf .= '<ol>';
                $objLevelHtml = new LevelHtml();
                $objLevelHtml->obj = &$this->obj->rows[$i]->level;
                $objLevelHtml->buf= &$this->buf;
                $objLevelHtml->level = $this->level + 1;
                $objLevelHtml->generate();
                $this->buf .= '</ol>';
                $this->buf .= '</td>';
                $this->buf .= '</tr>';
            }
            $i++;
        }
    }

    private function listFooter() {
        if (isset($this->obj->footer) && !empty($this->obj->footer)) {
            $this->buf .= '<tr style="font-size: medium; font-weight:bold;">';
            $i = 0;
            while ($this->posCol[$i]) {
                $col = $this->posCol[$i];
                $this->buf .= '<td border="1" style="border: 1px solid; color: #' . ($this->obj->config->color->$col?$this->obj->config->color->$col:'000000') . '; background-color: #' . ($this->obj->config->backgroundColor->$col?$this->obj->config->backgroundColor->$col:'FFFFFF') . '; width: ' . $this->obj->config->width->$col . 'px; text-align: ' . $this->obj->config->align->$col . '; vertical-align: middle;"><label>' . $this->obj->footer->$col . '</label></td>';
                $i++;
            }
            $this->buf .= '</tr>';
            $this->buf .= '</table>';
        }
    }

}