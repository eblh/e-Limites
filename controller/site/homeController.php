<?php

namespace controller\site;

use lib\Controller;

class homeController extends Controller {
    
    public function __construct() {
        parent::__construct();
        
        $this->layout = '_layout';
    }

    public function index(){
        $this->title = "Meu novo título";
        $this->view(); // Se quiser que puxe outro arquivo é só colocar como o 'teste'
    }
    
    
}