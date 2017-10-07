<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    public function _initRoutes(){
        $front = Zend_Controller_Front::getInstance();
    
        $router = $front->getRouter();
    
        $restRoute = new Zend_Rest_Route($front);
        $router->addRoute('default', $restRoute);

        $this->_initApiUserInformation();
    }

    //Se inicializa la informacion de usuario para acceder a la Api de Alegra
    public function _initApiUserInformation(){
    	$user_alegrapi = $this->getOption('user_alegrapi');
    	Zend_Registry::set('user_alegrapi', $user_alegrapi);

    	$pwd_alegrapi = $this->getOption('pwd_alegrapi');
    	Zend_Registry::set('pwd_alegrapi', $pwd_alegrapi);
    }

}

