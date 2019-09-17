<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
//To Solve File REST_Controller not found
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Access-Control-Allow-Origin, X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");

/**
 * Description of Api
 *
 * @author john.cristobal
 */
class Api extends REST_Controller {
 
    public function __construct($config = 'rest') {
               
        /*header('HTTP/1.1 200 OK');
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Content-Length, Accept-Encoding, Accept");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
        die();
        }*/        

        parent::__construct($config);
        $this->load->model("Talleres_model");
                    
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Access-Control-Allow-Origin, X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Allow: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
            die();
        }

    }
    
    //validar usuarios
    public function validateReact_post(){
        $data = json_decode(file_get_contents("php://input"));
        $json = $data->correo;

        $correo = $data->correo;
        $pass = $data->pass;
        $res = false;
        if($this->Login_model->getUser($correo,$pass)){
            $res = true;
        }else{
            $res = false;
        }
        
        //$name = $this->input->post("correo");
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Access-Control-Allow-Origin, X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Allow: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
            die();
        }
        $this->response($res, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
    }
    
    //validar usuarios
    public function validate_post(){
        $data = json_decode(file_get_contents("php://input"));
        $json = json_decode($data->params);

        $correo = $json->updates[0]->value;
        $pass = $json->updates[1]->value;
        $res = false;
        if($this->Login_model->getUser($correo,$pass)){
            $res = true;
        }else{
            $res = false;
        }
        
        //$name = $this->input->post("correo");
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Access-Control-Allow-Origin, X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Allow: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
            die();
        }
        $this->response($res, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
    }
    
    //validar usuarios
    public function mail_post(){
        $data = json_decode(file_get_contents("php://input"));
        $correo = $data->params->correo;
        $message = $data->params->message;
        
        //$json = json_decode($data->params);

        
        $config = array(
            'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
            'smtp_host' => 'mail.sosciclista.com.mx',
            'smtp_port' => 587,
            'smtp_user' => 'info@sosciclista.com.mx',
            'smtp_pass' => 'w%$2+_,Kt9Xd',
            //'smtp_crypto' => 'ssl', //can be 'ssl' or 'tls' for example
            //'mailtype' => 'text', //plaintext 'text' mails or 'html'
            //'smtp_timeout' => '4', //in seconds
            'charset' => 'iso-8859-1',
            'wordwrap' => TRUE
        );
        
        $this->load->library('email');
        $this->email->initialize($config);
        $this->email->from('info@sosciclista.com.mx', 'Info ciclista');
        $this->email->to('info@sosciclista.com.mx');
        //$this->email->cc('info@sosciclista.com.mx');
        //$this->email->bcc('them@their-example.com');

        $this->email->subject('Comentarios');
        $this->email->message("Hemos recibido tu correo, en breve te resolveremos tus dudas<br>Gracias<br>".$message."");

        if ($this->email->send()) {
            header('Access-Control-Allow-Origin: *');
            header("Access-Control-Allow-Headers: Access-Control-Allow-Origin, X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
            header("Allow: GET, POST, OPTIONS, PUT, DELETE");
            $method = $_SERVER['REQUEST_METHOD'];
            if($method == "OPTIONS") {
                die();
            }
            $res = true;
            $this->response($res, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
            header('Access-Control-Allow-Origin: *');
            header("Access-Control-Allow-Headers: Access-Control-Allow-Origin, X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
            header("Allow: GET, POST, OPTIONS, PUT, DELETE");
            $method = $_SERVER['REQUEST_METHOD'];
            if($method == "OPTIONS") {
                die();
            }
            $res = false;
            $this->response($res, REST_Controller::HTTP_BAD_REQUEST); // OK (200) being the HTTP response code
        }
    }
    
    //recuperar productos
    public function talleres_get(){
        $datos = $this->Talleres_model->getTalleres();
        
        /*header('HTTP/1.1 200 OK');
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Content-Length, Accept-Encoding, Accept");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
        die();
        }*/        

        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Access-Control-Allow-Origin, X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Allow: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
            die();
        }
        //echo $datos;
        $this->response($datos, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
    }
    
    //validar usuarios
    public function finishCart_post(){
        $data = json_decode(file_get_contents("php://input"));
        $json = json_decode($data->params);

        foreach ($json->updates[0]->value as $value) {
            $id = $value->p->id;
            $actual = $value->p->cantidad;
            $pedido = $value->pedido;
            $total = $actual-$pedido;
            
            $this->Producto_model->updateShop($id,$total);
            //$res = $id;
        }
        
        $res = true;
        
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Access-Control-Allow-Origin, X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Allow: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
            die();
        }
        $this->response($res, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
    }
    
    //validar usuarios
    public function finishCartReact_post(){
        $data = json_decode(file_get_contents("php://input"));
        $json = json_decode($data->params);

        foreach ($json as $value) {
            $id = $value->producto->id;
            $actual = $value->producto->cantidad;
            $pedido = $value->q;
            $total = $actual-$pedido;
            
            $this->Producto_model->updateShop($id,$total);
            //$res = $id;
        }
        
        $res = true;
        
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Access-Control-Allow-Origin, X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Allow: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
            die();
        }
        $this->response($res, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
    }
    //shopNext90?    
}
