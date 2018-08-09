<?php

namespace lib;

class System extends Router { //Erdou tudo da classe Router(Rotas) que não é private
    private $url;
    private $exploder;
    private $area;
    private $controller;
    private $action;
    private $params;
    private $runController;
    
    public function __construct() { //Método construtor seta
        $this->setUrl();
        $this->setExploder();
        $this->setArea();
        $this->setController();
        $this->setAction();
        $this->setParams();
    }

        private function setUrl(){ //Direcionar acesso inicial
        $this->url = isset($_GET['url']) ? $_GET['url'] : 'home/index'; //Se url existir inseri ela, senão será o Controller home/index que é Action
    }
    
    private function setExploder(){ //
        $this->exploder = explode('/', $this->url);
    }
    
    private function setArea(){
        foreach ($this->routers as $i => $v){ //Fazer uma varredura no array de Router
            if ($this->onRaiz && $this->exploder[0] == $i){
                $this->area = $v;
                $this->onRaiz = false; //para sair do if
            }
        }
        
        $this->area = empty($this->area) ? $this->routerOnRaiz : $this->area; //Se área for vazia, Atribui a área o valor raiz
        
        if (!defined('APP_AREA')){ //Se não for definido a área
            define ('APP_AREA', $this->area); //
        }
    }
    
    public function getArea(){
        return $this->area;
    }

    private function setController(){
        $this->controller = $this->onRaiz ? $this->exploder[0] : //Se onRaiz for true ele recebe exploder[0]
           (empty($this->exploder[1]) || is_null($this->exploder[1] || !isset($this->exploder[1]) ? 'home' : $this->exploder[1])); //isset = existe
    }
    // O controller é 0 do exploder
    // A action é 1 do exploder
    
    public function getController(){
        return $this->controller;
    }


    private function setAction(){
        $this->action = $this->onRaiz ? //se onRaiz é true
            (!isset($this->exploder[1]) || is_null($this->exploder[1]) || empty($this->exploder[1]) ? 'index' : $this->exploder[1]) :
            (!isset($this->exploder[2]) || is_null($this->exploder[2]) || empty($this->exploder[2]) ? 'index' : $this->exploder[2]);
    }
    
    public function getAction(){
        return $this->action;
    }
    
    private function setParams(){
        if ($this->onRaiz){
            unset($this->exploder[0], $this->exploder[1]); //Destruir o controller e o action
        } else {
            unset($this->exploder[0], $this->exploder[1], $this->exploder[2]); //Destruir a area tbm
        }
        
        if (end($this->exploder) == null){
            arra_pop($this->exploder);
        }
        
        if (empty($this->exploder)){
            $this->params = array();
        } else {
            foreach($this->exploder as $val){
                $params[]= $val;
            }
            $this->params = $params;
        }
    }
    
    public function getParams($indice){
        return isset($this->params[$indice]) ? $this->params[$indice] : null;
    }
    
    private function validarController(){ //Verificar se a classe controller existe
        if (!(class_exists($this->runController))){ //Se ela não existe
            die('Controller não existe ' . $this->runController); //die = Stop no sistema
        }
    }
    
    private function validarAction(){ //Verficar se não existe o método
        if(!(method_exists($this->runController, $this->action))){
            die('Action não existe ' . $this->action);
        }
    }


    public function Run(){ //Caminho auxiliar
        $this->runController = 'controller\\' . $this->area . '\\' . $this->controller . 'Controller';
        
        $this->validarController();
        
        $this->runController = new $this->runController; //Inicia o controller
        
        $this->validarAction();
        
        $act = $this->action;
        
        $this->runController->$act(); //Inicia o action
    }
}