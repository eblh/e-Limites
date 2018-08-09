<?php

namespace lib;

class Router { //Configuração de rotas, determina a área padrão/raiz
    protected $routers = array(
        'site' => 'site', //Apelidos 
        'admin' => 'admin'
    );
    
    protected $routerOnRaiz = 'site';
    
    protected $onRaiz = true;
}