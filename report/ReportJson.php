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
                include 'html/Html.php';
                $objHtml = new Html();
                $objHtml->obj = $this->obj;
                $objHtml->file=$this->file.$this->name.$this->type;
                $objHtml->generate();
                break;
            case '.pdf':
                include 'pdf/Pdf.php';
                $objPdf = new Pdf();
                $objPdf->obj = $this->obj;
                $objPdf->file=$this->file.$this->name.$this->type;
                $objPdf->generate();
                break;
            case '.xls':
                include 'xls/Xls.php';
                $objXls = new Xls();
                $objXls->obj = $this->obj;
                $objXls->file=$this->file.$this->name.$this->type;
                $objXls->generate();
                break;
        }
    }
}