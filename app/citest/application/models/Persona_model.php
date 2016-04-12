<?php
class Persona_model extends CI_Model {

	public $Cuil;
	public $Nombre;
	public $Apellido;
	public $Mail;
	
	public function __construct()
	{
		$this->load->database();
	}
	
	public function traer_persona($cuil)
	{
		$sp = 'call persona_consulta(?)';
		$query = $this->db->query($sp, array('cuil' => $cuil));
		if ($query->num_rows() > 0) {
			$row=$query->row_array();
			$this->Cuil=$row["CUIL"];
			$this->Nombre=$row["Nombre"];
			$this->Apellido=$row["Apellido"];
			$this->Mail=$row["Mail"];
		}
		return $this;
	}
	
	public function buscar_personas()
	{
		$sp = 'call persona_consulta(?)';
		$query = $this->db->query($sp, array('cuil' => NULL));
		return $query->result_array();
	}
	
	public function insert_persona()
	{	
		$sp = 'call persona_alta(?, ?, ?, ?)';
		if($this->db->query($sp, 
				array(
						'cuil' 		=> $this->input->post('cuil'), 
						'Nombre' 	=> $this->input->post('nombre'), 
						'Apellido' 	=> $this->input->post('apellido'), 
						'Mail' 		=> $this->input->post('mail')))
				)
			$resultado['resultado']='OK';
		else
			$resultado['resultado']='ERROR';
		return $resultado;
	}
	
	public function update_persona()
	{
		$sp = 'call persona_editar(?, ?, ?, ?)';
		if($this->db->query($sp, array
				(
					'cuil' 		=> '20336206238', 
					'Nombre' 	=> 'Pedro', 
					'Apellido' 	=> 'ChotaLarga', 
					'Mail' 		=> 'jchot@larga.com')))
			$resultado['resultado']='OK';
		else
			$resultado['resultado']='ERROR';
		return $resultado;
	}
	
	public function delete_personas($cuil = FALSE)
	{
		$sp = 'call persona_baja(?)';
		if($query = $this->db->query($sp, array('cuil' => $cuil)))
			$resultado['resultado']='OK';
		else
			$resultado['resultado']='ERROR';
		return $resultado;
	}
}