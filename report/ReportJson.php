<?

class ReportJson {

    function __construct() {
        $this->json = '';
        $this->type = '';
        $this->name = '';
        $this->file = '';
        $this->obj = array();
    }

    public function generate() {
        $this->read();
        $this->validate();
        $this->typeReport();
    }

    private function read() {
        //retira slaches se tiver abilitado por padrão no php.ini
        if(get_magic_quotes_gpc()) {
            $this->json=stripslashes($this->json);
        }
        $obj = json_decode($this->json);
        if (!$obj) {
            throw new Exception('Json inválido.');
        } else {
            $this->obj = $obj;
        }
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

    private function typeReport() {
        switch ($this->type) {
            case '.html':
                include_once 'html/Html.php';
                $objHtml = new Html();
                $objHtml->obj = $this->obj;
                $objHtml->file=$this->file.$this->name.$this->type;
                $objHtml->generate();
                break;
            case '.pdf':
                include_once 'pdf/Pdf.php';
                $objPdf = new Pdf();
                $objPdf->obj = $this->obj;
                $objPdf->file=$this->file.$this->name.$this->type;
                $objPdf->generate();
                break;
            case '.xls':
                include_once 'xls/Xls.php';
                $objXls = new Xls();
                $objXls->obj = $this->obj;
                $objXls->file=$this->file.$this->name.$this->type;
                $objXls->generate();
                break;
        }
    }
}