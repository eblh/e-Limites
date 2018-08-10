<?php

namespace controller\site;

use lib\Controller;

class homeController extends Controller {
    public function index(){
        $this->view(); // Se quiser que puxe outro arquivo é só colocar como o 'teste'
    }
    
    
}