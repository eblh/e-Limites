<?php

namespace lib;

class Controller extends System {
    public $dados;
    public $layout;
    private $path;
    private $pathRender;
    //View Web
    protected $title = null;
    protected $description = null;
    protected $keywords;
    protected $image;
    protected $captionController;
    protected $captionAction;
    protected $captionParams;
    
    public function __construct() {
        parent::__construct();
    }
    
    private function setPath($render){
        if(is_array($render)){ //se for um array
            foreach ($render as $li){
                $path = 'view/' . $this->getArea() . '/' . $this->getController() . '/' . $li . 'phtml'; //Criando caminho
                $this->fileExists($path);
                $this->path[] = $path;
            }
        } else {
            $this->pathRender = is_null($render) ? $this->getAction() : render;
            $this->path = 'view/' . $this->getArea() . '/' . $this->getController() . '/' . $this->pathRender . 'phtml';
            $this->fileExists($this->path);
        }
    }
    
    private function fileExists($file){
        if(!file_exists($file)){ //Se o arquivo não existir
            die('Não foi localizado o arquivo ' . $file); //Interrompe o programa
        }
    }
    
    public function view($render = null){
        $this->title = is_null($this->title) ? 'Meu Título' : $this->title;
        $this->description = is_null($this->description) ? 'Minha Descrição' : $this->description;
        $this->keywords = is_null($this->keywords) ? 'Minha Palavra Chave' : $this->keywords;
        
        $this->setPath($render);
        
        if (is_null($this->layout)){
            $this->render();
        }else{
            $this->layout = "content/{$this->getArea()}/shared/{$this->layout}.phtml";
            if (file_exists($this->layout)){ //Se existir o layout
                $this->render($this->layout);
            } else { 
                die("Não foi possível localizar o layout!");
            }
        }
    }
    
    public function render($file = null){
        if (is_array($this->dados) && count($this->dados) > 0){ //Se a qtde for maior que zero
            extract($this->dados, EXTR_PREFIX_ALL, 'view');
            extract(array (
                'controller'=>(is_null($this->captionController) ? '' : $this->captionController),
                'action'=>(is_null($this->captionAction) ? '' : $this->captionAction),
                'params'=>(is_null($this->captionParams) ? '' : $this->captionParams)
            ), EXTR_PREFIX_ALL, 'caption');
        }
        
        if (!is_null($file) && is_array($file)){
            foreach ($file as $li){
                include ($li);
            }
        } elseif (is_null($file) && is_array($this->path)) {
            foreach ($this->path as $li){
                include ($li);
            }
        } else {
            $file = is_null($file) ? $this->path : $file;
            file_exists($file) ? include ($file) : die($file); //Se existir inclui, senão mata
        }
    }
}

