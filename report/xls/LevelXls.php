<?php

$GLOBALS['objConfig'] = array();
$GLOBALS['c'] = array('', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

class LevelXls {

    function __construct() {
        $this->obj = array();
        $this->buf = '';
        $this->level = 1;
        $this->posCol = array();
        $this->line = 1;
        $this->totCol = 0;
    }

    public function generate() {
        $this->config();
        $this->validate();
        $this->listHead();
        $this->listRows();
        $this->listFooter();
    }

    private function validate() {
        if (!isset($this->obj->config)) {
            throw new Exception('Objeto config do nível ' . $this->level . ' não encontrado.');
        }
        if (!isset($this->obj->head)) {
            throw new Exception('Objeto head do nível ' . $this->level . ' não encontrado.');
        }
        if (!isset($this->obj->rows)) {
            throw new Exception('Objeto rows do nível ' . $this->level . ' não encontrado.');
        }
        if (!isset($this->obj->rows)) {
            throw new Exception('Objeto rows do nível ' . $this->level . ' não encontrado.');
        }
        if (!isset($this->obj->footer)) {
            throw new Exception('Objeto footer do nível ' . $this->level . ' não encontrado.');
        }
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
        $i = 0;
        $colPos = $this->level + 1;
        while ($this->posCol[$i]) {
            $col = $this->posCol[$i];
            $this->buf->getActiveSheet()->setCellValueByColumnAndRow($colPos, $this->line, $this->obj->head->$col);
            $i++;
            $colPos++;
            //width (setado quando coluna menor que largura especificada)
            $width = $this->buf->getActiveSheet()->getColumnDimension($GLOBALS['c'][$colPos])->getWidth();
            if ($width < ($this->obj->config->width->$col / 10)) {
                $this->buf->getActiveSheet()->getColumnDimension($GLOBALS['c'][$colPos])->setWidth(($this->obj->config->width->$col / 10));
            }
            //align
            $this->buf->getActiveSheet()->getStyle($GLOBALS['c'][$colPos] . $this->line)->getAlignment()->setHorizontal($this->obj->config->align->$col);
            //backgroundColor
            if ($this->obj->config->backgroundColor->$col) {
                $this->buf->getActiveSheet()->getStyle($GLOBALS['c'][$colPos] . $this->line)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB($this->obj->config->backgroundColor->$col);
            }
            //color
            if ($this->obj->config->color->$col) {
                $this->buf->getActiveSheet()->getStyle($GLOBALS['c'][$colPos] . $this->line)->getFont()->getColor()->setRGB($this->obj->config->color->$col);
            }
            //borders
            $this->buf->getActiveSheet()->getStyle($GLOBALS['c'][$colPos] . $this->line)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_HAIR);
            $this->buf->getActiveSheet()->getStyle($GLOBALS['c'][$colPos] . $this->line)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_HAIR);
            $this->buf->getActiveSheet()->getStyle($GLOBALS['c'][$colPos] . $this->line)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_HAIR);
            $this->buf->getActiveSheet()->getStyle($GLOBALS['c'][$colPos] . $this->line)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_HAIR);
        }
        $i+=($this->level - 1);
        if ($i > $this->totCol) {
            $this->totCol = $i;
        }
        $this->line++;
    }

    private function listRows() {
        $i = 1;
        $qtdBackgroundColor = count($this->obj->rows[0]->backgroundColor);
        while ($this->obj->rows[$i]) {
            $j = 0;
            $colPos = $this->level + 1;

            //duas cores de fundo faz intercalação entre elas
            if ($qtdBackgroundColor > 1) {
                $qtdBC = $i % 2;
            } else {
                $qtdBC = 0;
            }

            while ($this->posCol[$j]) {
                $col = $this->posCol[$j];
                $this->buf->getActiveSheet()->setCellValueByColumnAndRow($colPos, $this->line, $this->obj->rows[$i]->$col);
                $j++;
                $colPos++;
                //align
                $this->buf->getActiveSheet()->getStyle($GLOBALS['c'][$colPos] . $this->line)->getAlignment()->setHorizontal($this->obj->rows[0]->align->$col);
                //backgroundColor
                if ($this->obj->rows[0]->backgroundColor[$qtdBC]->$col) {
                    $this->buf->getActiveSheet()->getStyle($GLOBALS['c'][$colPos] . $this->line)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB($this->obj->rows[0]->backgroundColor[$qtdBC]->$col);
                }
                //text color
                if ($this->obj->rows[0]->color->$col) {
                    $this->buf->getActiveSheet()->getStyle($GLOBALS['c'][$colPos] . $this->line)->getFont()->getColor()->setRGB($this->obj->rows[0]->color->$col);
                }
                //borders
                $this->buf->getActiveSheet()->getStyle($GLOBALS['c'][$colPos] . $this->line)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_HAIR);
                $this->buf->getActiveSheet()->getStyle($GLOBALS['c'][$colPos] . $this->line)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_HAIR);
                $this->buf->getActiveSheet()->getStyle($GLOBALS['c'][$colPos] . $this->line)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_HAIR);
                $this->buf->getActiveSheet()->getStyle($GLOBALS['c'][$colPos] . $this->line)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_HAIR);
            }
            $this->line++;
            //chama a classe recursivamente se existir niveis internos
            if ($this->obj->rows[$i]->level) {
                $objLevelXls = new LevelXls();
                $objLevelXls->obj = &$this->obj->rows[$i]->level;
                $objLevelXls->buf = &$this->buf;
                $objLevelXls->level = $this->level + 1;
                $objLevelXls->line = &$this->line;
                $objLevelXls->totCol = &$this->totCol;
                $objLevelXls->generate();
            }
            $i++;
        }
    }

    private function listFooter() {
        if (isset($this->obj->footer) && !empty($this->obj->footer)) {
            $i = 0;
            $colPos = $this->level + 1;
            while ($this->posCol[$i]) {
                $col = $this->posCol[$i];
                $this->buf->getActiveSheet()->setCellValueByColumnAndRow($colPos, $this->line, $this->obj->footer->$col);
                $i++;
                $colPos++;
                //align
                $this->buf->getActiveSheet()->getStyle($GLOBALS['c'][$colPos] . $this->line)->getAlignment()->setHorizontal($this->obj->config->align->$col);
                //backgroundColor
                if ($this->obj->config->backgroundColor->$col) {
                    $this->buf->getActiveSheet()->getStyle($GLOBALS['c'][$colPos] . $this->line)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB($this->obj->config->backgroundColor->$col);
                }
                //color
                if ($this->obj->config->color->$col) {
                    $this->buf->getActiveSheet()->getStyle($GLOBALS['c'][$colPos] . $this->line)->getFont()->getColor()->setRGB($this->obj->config->color->$col);
                }
                //borders
                $this->buf->getActiveSheet()->getStyle($GLOBALS['c'][$colPos] . $this->line)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_HAIR);
                $this->buf->getActiveSheet()->getStyle($GLOBALS['c'][$colPos] . $this->line)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_HAIR);
                $this->buf->getActiveSheet()->getStyle($GLOBALS['c'][$colPos] . $this->line)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_HAIR);
                $this->buf->getActiveSheet()->getStyle($GLOBALS['c'][$colPos] . $this->line)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_HAIR);
            }
            $this->line++;
        }
    }

}