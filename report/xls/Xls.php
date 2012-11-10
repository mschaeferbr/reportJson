<?php

$GLOBALS['c'] = array('', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

class Xls {

    function __construct() {
        $this->obj = array();
        $this->buf = array();
        $this->file = '';
        $this->line = 10;
        $this->totCol = 0;
    }

    public function generate() {
        $this->validate();
        $this->config();
        $this->listLevel();
        $this->listFooter();
        $this->listHead();
        $this->listTitle();
        $this->createFile();
    }

    private function validate() {

    }

    private function config() {
        require_once dirname(__FILE__) . '/../../external/PHPExcel/Classes/PHPExcel.php';
        // Create new PHPExcel object
        $this->buf = new PHPExcel();
        // Set document properties
        $this->buf->getProperties()->setCreator("Maarten Balliauw")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("Office 2003 XLS ReportJsont Document")
                ->setSubject("Office 2003 XLS ReportJson Document")
                ->setDescription("ReportJson Document for Office 2003 XLS, generated using PHP classes.")
                ->setKeywords("office 2003 openxml php")
                ->setCategory("ReportJson");
        // Rename worksheet
        $this->buf->getActiveSheet()->setTitle('ReportXls');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $this->buf->setActiveSheetIndex(0);
        $this->buf->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);
    }

    private function listHead() {
        $this->line = 2;
        //largura colunas
        $this->buf->getActiveSheet()->getColumnDimension($GLOBALS['c'][1])->setWidth(3);
        $this->buf->getActiveSheet()->getStyle($GLOBALS['c'][2] . '2')->getFont()->setSize(10);
        $this->buf->getActiveSheet()->getStyle($GLOBALS['c'][$this->totCol] . '2')->getFont()->setSize(10);
        $i = 0;
        while ($i < 4) {
            $this->buf->getActiveSheet()->getStyle($GLOBALS['c'][3] . ($i + $this->line))->getFont()->setSize(8);
            $this->buf->getActiveSheet()->getStyle($GLOBALS['c'][3] . ($i + $this->line))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->buf->getActiveSheet()->setCellValueByColumnAndRow(2, ($i + $this->line), $this->obj->head->info[$i]);
            $this->buf->getActiveSheet()->mergeCells($GLOBALS['c'][3] . ($i + $this->line) . ':' . $GLOBALS['c'][$this->totCol + 2] . ($i + $this->line));
            $i++;
        }
        $this->line+=$i;
        $this->buf->getActiveSheet()->mergeCells($GLOBALS['c'][2] . '2:' . $GLOBALS['c'][2] . ($i + 1));
        $this->buf->getActiveSheet()->mergeCells($GLOBALS['c'][$this->totCol + 3] . '2:' . $GLOBALS['c'][$this->totCol + 3] . ($i + 1));
        $j = 2;
        while ($j < $this->totCol + 4) {
            $this->buf->getActiveSheet()->getStyle($GLOBALS['c'][$j] . '2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $this->buf->getActiveSheet()->getStyle($GLOBALS['c'][$j] . '2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->buf->getActiveSheet()->getStyle($GLOBALS['c'][$j] . '2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_HAIR);
            $this->buf->getActiveSheet()->getStyle($GLOBALS['c'][$j] . ($i + 1))->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_HAIR);
            $j++;
        }
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $objDrawing->setPath(dirname(__FILE__) . '/../../../' . $this->obj->head->logo);
//        $objDrawing->setPath('/home/www/' . $this->obj->head->logo);
        $objDrawing->setCoordinates('B2');
        $objDrawing->setHeight(50);
        $objDrawing->setWidth(50);
        $objDrawing->setOffsetY(10);
        $objDrawing->setOffsetX(5);
        $objDrawing->setWorksheet($this->buf->getActiveSheet());

        $this->buf->getActiveSheet()->setCellValueByColumnAndRow($this->totCol + 2, 2, '1 / 1');
    }

    private function listTitle() {
        $i = 0;
        $font->size[0] = '18';
        $font->size[1] = '16';
        $font->size[2] = '14';
        while ($this->obj->title[$i] && $i < 3) {
            $this->buf->getActiveSheet()->getStyle($GLOBALS['c'][2] . ($i + $this->line))->getFont()->setBold(true);
            $this->buf->getActiveSheet()->getStyle($GLOBALS['c'][2] . ($i + $this->line))->getFont()->setSize($font->size[$i]);
            $this->buf->getActiveSheet()->getRowDimension($i + $this->line)->setRowHeight(23);
            $this->buf->getActiveSheet()->mergeCells($GLOBALS['c'][2] . ($i + $this->line) . ':' . $GLOBALS['c'][$this->totCol + 3] . ($i + $this->line));
            $this->buf->getActiveSheet()->getStyle($GLOBALS['c'][2] . ($i + $this->line))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->buf->getActiveSheet()->setCellValueByColumnAndRow(1, ($i + $this->line), $this->obj->title[$i]);
            $i++;
        }
        $this->line+=$i;
    }

    private function listLevel() {
        include 'LevelXls.php';
        $objLevelXls = new LevelXls();
        $objLevelXls->obj = &$this->obj->level;
        $objLevelXls->buf = &$this->buf;
        $objLevelXls->line = &$this->line;
        $objLevelXls->totCol = &$this->totCol;
        $objLevelXls->generate();
    }

    private function listFooter() {
        $this->line++;
        $this->buf->getActiveSheet()->getStyle($GLOBALS['c'][2] . ($this->line))->getFont()->setSize(8);
        $this->buf->getActiveSheet()->getStyle($GLOBALS['c'][2] . ($this->line))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $j = 2;
        while ($j < 8) {
            $this->buf->getActiveSheet()->getStyle($GLOBALS['c'][$j] . ($this->line))->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_HAIR);
            $this->buf->getActiveSheet()->getStyle($GLOBALS['c'][$j] . ($this->line))->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_HAIR);
            $j++;
        }
        $this->buf->getActiveSheet()->mergeCells($GLOBALS['c'][2] . ($this->line) . ':' . $GLOBALS['c'][$this->totCol + 3] . ($this->line));
        $this->buf->getActiveSheet()->setCellValueByColumnAndRow(1, ($this->line), $this->obj->footer->owner . ($this->obj->footer->date ? '    ' . date('d/m/Y') : '') . ($this->obj->footer->time ? ' - ' . date('H:i:s') : ''));
        $i = 2;
        $this->line++;
        while ($i < $this->line) {
            $this->buf->getActiveSheet()->getStyle($GLOBALS['c'][2] . ($i))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_HAIR);
            $this->buf->getActiveSheet()->getStyle($GLOBALS['c'][$this->totCol + 3] . ($i))->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_HAIR);
            $i++;
        }
    }

    private function createFile() {
        $this->buf = PHPExcel_IOFactory::createWriter($this->buf, 'Excel5');
        $this->buf->save($this->file);
    }

}