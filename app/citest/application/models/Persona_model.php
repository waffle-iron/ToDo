<?php
class Persona_model extends CI_Model {

	public $cuil;
	public $nombre;
	public $apellido;
	public $mail;
	
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
			$this->cuil=$row["CUIL"];
			$this->nombre=$row["Nombre"];
			$this->apellido=$row["Apellido"];
			$this->mail=$row["Mail"];
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
	
	public function update_persona($persona)
	{
		$sp = 'call persona_editar(?, ?, ?, ?)';
		if($this->db->query($sp, array
				(
					'cuil' 		=> $persona->cuil, 
					'Nombre' 	=> $persona->nombre, 
					'Apellido' 	=> $persona->apellido, 
					'Mail' 		=> $persona->mail)))
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