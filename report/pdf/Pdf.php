<?php

class Pdf {

    function __construct() {
        $this->obj = array();
        $this->buf = array();
        $this->file = '';
    }

    public function generate() {
        $this->validate();
        $this->config();
        $this->listHead();
        $this->listTitle();
        $this->listLevel();
        $this->listFooter();
        $this->createFile();
    }

    private function validate() {

    }

    private function config() {
        require_once( dirname(__FILE__) . '/../../external/tcpdf/config/lang/eng.php');
        require_once( dirname(__FILE__) . '/../../external/tcpdf/tcpdf.php');
        // create new PDF document
        $this->buf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // set document information
        $this->buf->SetCreator(PDF_CREATOR);
        // set header and footer fonts
        $this->buf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 8));
        $this->buf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', 8));
        // set default monospaced font
        $this->buf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        //set margins
        $this->buf->SetMargins(10, 25, 10);
        $this->buf->SetHeaderMargin(5);
        $this->buf->SetFooterMargin(10);
        //set auto page breaks
        $this->buf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //set image scale factor
        $this->buf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        // set font
        $this->buf->SetFont('dejavusans', '', 10);
    }

    private function listHead() {
        $i = 0;
        $head = '';
        while ($i < 4) {
            $head .= ($head ? "\n" : "") . $this->obj->head->info[$i];
            $i++;
        }
        $this->buf->SetHeaderData(dirname(__FILE__).'/../../../' . $this->obj->head->logo, 25, 12, '', $head);
//        $this->buf->SetHeaderData('/home/www/' . $this->obj->head->logo, 25, 12, '', $head);
        // add a page
        $this->buf->AddPage();
    }

    private function listTitle() {
        $fontSize[0] = 'xx-large';
        $fontSize[1] = 'x-large';
        $fontSize[2] = 'large';
        $i = 0;
        $htmlBuf = '<table>';
        while ($this->obj->title[$i] && $i < 3) {
            $htmlBuf .= '<tr style="font-size: ' . $fontSize[$i] . '; font-weight:bold;">';
            $htmlBuf .= '<td colspan="100%" style="text-align: center;"><label>' . $this->obj->title[$i] . '</label></td>';
            $htmlBuf .= '</tr>';
            $i++;
        }
        $htmlBuf .= '</table>';
        $this->buf->writeHTML($htmlBuf, true, false, true, false, '');
    }

    private function listLevel() {
        include dirname(__FILE__) . '/../html/LevelHtml.php';
        $objLevelHtml = new LevelHtml();
        $objLevelHtml->obj = &$this->obj->level;
        $objLevelHtml->generate();
        $this->buf->writeHTML($objLevelHtml->buf, true, false, true, false, '');
    }

    private function listFooter() {
        $footer = $this->obj->footer->owner . ($this->obj->footer->date ? '    ' . date('d/m/Y') : '') . ($this->obj->footer->time ? ' - ' . date('H:i:s') : '');
        $this->buf->SetFooterData(null, null, $footer);
    }

    private function createFile() {
        $this->buf->Output($this->file, 'F');
    }

}