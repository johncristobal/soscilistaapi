<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Talleres_model
 *
 * @author john.cristobal
 */
class Talleres_model extends CI_Model{
    
    public function getTalleres(){
        $this->db->select('*')->from('talleres')->where("estatus",1);
        $query = $this->db->get();

        if ($query->num_rows() > 0 )
        {
            $data = $query->result();
            return $data;
        }else{
            return "";
        }
    }
    
    public function insertTaller($data){
        $this->db->insert("talleres",$data);
        
        $id = $this->db->insert_id();
        return $id;
        
    }
    
    public function getCategorias(){
        $this->db->select('*')->from('categoria');
        $query = $this->db->get();

        if ($query->num_rows() > 0 )
        {
            $row = $query->result();
            return $row;
        }
    }
    
    public function getCategoriasById($id){
        $this->db->select('*')->from('productos')->where('categoria',$id);
        $query = $this->db->get();

        if ($query->num_rows() > 0 )
        {
            $row = $query->result();
            return $row;
        }
    }
    
    public function getNombreById($i){
        $last_row=$this->db->select('descripcion')->from('categoria')->where('id',$i)->get()->row();
        return $last_row;                           
    }
}
