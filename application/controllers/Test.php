<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->model("Talleres_model");
    }
    
    public function index()
    {
        $this->db->select('valor')->from('parametria')->where("llave","jsontalleres");
        $query = $this->db->get();

        if ($query->num_rows() > 0)
        {
            $data = $query->result_array()[0];
            $res = json_decode(($data["valor"]));

            foreach ($res->features as $value) {
                //echo $value->geometry->coordinates[0];
                $arreglo = array();
                if($value->geometry->type == "Point"){
                    $arreglo["coordinates"] = $value->geometry->coordinates[0].",".$value->geometry->coordinates[1];
                    $arreglo["name"] = $value->properties->name; 
                    $arreglo["estatus"] = 1;
                    if(!isset($value->properties->description)){
                        $arreglo["description"] = ""; 
                    }else{
                        $arreglo["description"] = $value->properties->description; 
                    }
                    
                    if(!isset($value->properties->gx_media_links)){
                        $arreglo["gx_media_links"] = ""; 
                    }else{
                        $arreglo["gx_media_links"] = $value->properties->gx_media_links; 
                    }
                   
                    $id = $this->Talleres_model->insertTaller($arreglo);
                    echo $arreglo["name"]."<br>".$id;                    
                }
            }
        }else{
            return "";
        }
    }
    
}
