<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modelo_datos extends CI_Model {

	function __construct() {
	    parent::__construct();

}

   public function acceso($correo, $pass){
      $this->db->select('nombre');
      $this->db->from('usuarios');
      $this->db->where('correo', $correo);
      $this->db->where('pass', $pass);
      $consulta = $this->db->get();
      $resultado = $consulta->row();
      return $resultado;
   }

	/*
	$this->db->select("nombre");
	$this->db->where("correo",$correo);
	$this->db->where("pass",$pass);
	$consulta = $this->db->get("usuarios");
	return $consulta->result();
	if ($consulta->num_rows() > 0) {

		$this->load->view('inicio');
	}else{
        echo ("<script language='JavaScript'>
        window.alert('Usuario o contraseña inválidos')
        window.location.href='/ci_crud';
        </script>");

	}
*/


	public function alias($value){
	 	$this->db->select('alias');
	 	$this->db->where('correo',$value);
	 	$consulta = $this->db->get('contactos');

	 	if ($consulta->num_rows() > 0) {
	 		return $consulta->row_array();
	 	}else{
	 		echo "No hay datos asociados";
	 	}
	 }


 public function mostrar($valor){
 	$this->db->like("nombre", $valor);

 	$consulta = $this->db->get("contactos");

 	if ($consulta->num_rows() > 0) {
 		return $consulta->result();
 	}else{
 		echo "No hay datos";
 	}

 }
public function buscar($buscar)
	{
		$this->db->like("categoria",$buscar);
		$this->db->or_like("nombre_empresa",$buscar);
		$this->db->or_like("contacto",$buscar);
		$this->db->or_like("correo",$buscar);
		$this->db->or_like("celular",$buscar);
		$this->db->or_like("alias",$buscar);
		$this->db->select("contacto, correo, nombre_empresa");
			$consulta = $this->db->get("contactos");
			return $consulta->result();
	}

public function buscarContactos()
	{
		$consulta = $this->db->get("contactos");
		return $consulta->result();
	}
}