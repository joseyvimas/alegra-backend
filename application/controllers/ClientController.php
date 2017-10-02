<?php

class ClientController extends MyRest_Controller
{
    public function init()
    {
        $this->_helper->viewRenderer->setNoRender(true);
    }
    
    public function alegrApi($metodo, $url, $data){
        $ch = curl_init();

        //Verificamos el metodo que realiza la peticion
        switch ($metodo) {    
            case 'POST':
                curl_setopt ($ch, CURLOPT_POST, true);

                if ($data)
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                break;

            case 'PUT':
                curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "PUT");

                if ($data)
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                break;

            case 'GET':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                break;

            case 'DELETE':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                break;
        }

        // Configurando el resto de las opciones curl 
            $options = array( 
                CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
                CURLOPT_USERPWD => "jyvimas@gmail.com:42efdcbda08c35b84384",
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,     
                CURLOPT_HTTPHEADER => array('Content-type: application/json', 'Accept: application/json')//, 
                //CURLOPT_SSL_VERIFYPEER => false      
            ); 

            //Aplicando configuraciones 
            curl_setopt_array($ch, $options);  

            //Obteniendo resultados
            $response = curl_exec($ch); // JSON resultado 

            // Cerrar el recurso cURL y liberar recursos del sistema 
            curl_close($ch);   

            return $response;
    }

    public function indexAction(){

        if($_SERVER['REQUEST_METHOD'] == "GET"){
            $url = "https://app.alegra.com/api/v1/contacts/";
            $response = $this->alegrApi("GET", $url, false);
            
        }
        else
        {
            $datos = array(
                'code' => 101,
                'error' => "Método no permitido"
            );
            
            $response = json_encode($datos, JSON_FORCE_OBJECT);
        }
        $this->getResponse()->setBody($response);
        $this->getResponse()->setHttpResponseCode(200)
                            ->setHeader('Content-Type', 'application/json');
    }

    public function postAction(){
        if($_SERVER['REQUEST_METHOD'] == "POST"){

            //Se obtiene el json
            $json = file_get_contents('php://input');

            $url = "https://app.alegra.com/api/v1/contacts/";

            $response = $this->alegrApi("POST", $url, $json);

        }
        else{
            $datos = array(
                'code' => 101,
                'error' => "Método no permitido"
            );
            
            $response = json_encode($datos, JSON_FORCE_OBJECT);
        }

        $this->getResponse()->setBody($response);
        $this->getResponse()->setHttpResponseCode(200)
                            ->setHeader('Content-Type', 'application/json');
    }
    

    public function getAction(){

        if($_SERVER['REQUEST_METHOD'] == "GET"){
            $idContact = $this->getRequest()->getParam('id');

            //Se verifica que el id sea un numero
            if (is_numeric($idContact)){
                $url = "https://app.alegra.com/api/v1/contacts/$idContact";
                $response = $this->alegrApi("GET", $url, false);

            }
            else{
                $datos = array(
                'code' => 102,
                'error' => "El id debe ser un entero"
                );

                $response = json_encode($datos, JSON_FORCE_OBJECT);

            }
        }
        else{
            $datos = array(
                'code' => 101,
                'error' => "Método no permitido"
            );
            
             $response = json_encode($datos, JSON_FORCE_OBJECT);
        }

        $this->getResponse()->setBody($response);
        $this->getResponse()->setHttpResponseCode(200)
                            ->setHeader('Content-Type', 'application/json');
    }

    public function putAction(){
        if($_SERVER['REQUEST_METHOD'] == "PUT"){

            $idContact = $this->getRequest()->getParam('id');

            //Se verifica que el id sea un numero
            if (is_numeric($idContact)){
                //Se obtiene el json
                $json_str = file_get_contents('php://input');

                $url = "https://app.alegra.com/api/v1/contacts/$idContact";
                $response = $this->alegrApi("PUT", $url, $json_str);

            }
            else{
                $datos = array(
                'code' => 102,
                'error' => "El id debe ser un entero"
                );

                $response = json_encode($datos, JSON_FORCE_OBJECT);

            }
        }
        else{
            $datos = array(
                'code' => 101,
                'error' => "Método no permitido"
            );
            
            $response = json_encode($datos, JSON_FORCE_OBJECT);
        }
        
        $this->getResponse()->setBody($response);
        $this->getResponse()->setHttpResponseCode(200)
                            ->setHeader('Content-Type', 'application/json');
    }

    public function deleteAction(){
        if($_SERVER['REQUEST_METHOD'] == "DELETE"){
            $idContact = $this->getRequest()->getParam('id');

            //Se verifica que el id sea un numero
            if (is_numeric($idContact)){
                $url = "https://app.alegra.com/api/v1/contacts/$idContact";
                $response = $this->alegrApi("DELETE", $url, false);

            }
            else{
                $datos = array(
                    'code' => 102,
                    'error' => "El id debe ser un entero"
                );
                
                $response = json_encode($datos, JSON_FORCE_OBJECT);
            }
        }
        else{
            $datos = array(
                'code' => 101,
                'error' => "Método no permitido"
            );

            $response = json_encode($datos, JSON_FORCE_OBJECT);
        }

        $this->getResponse()->setBody($response);
        $this->getResponse()->setHttpResponseCode(200)
                            ->setHeader('Content-Type', 'application/json');
    }
}