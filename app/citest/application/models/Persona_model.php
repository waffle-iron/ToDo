<?php
class Persona_model extends CI_Model {

	/*
	 * Variables para los stored procedures usados por el modelo
	 */
	private $sp_consulta 	= 'call persona_consulta(?)';
	private $sp_alta 		= 'call persona_alta(?, ?, ?, ?)';
	private $sp_editar 		= 'call persona_editar(?, ?, ?, ?)';
	private $sp_baja 		= 'call persona_baja(?)';
	
	/*
	 * Variables para los atributos del modelo
	 */
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
		$query = $this->db->query($this->sp_consulta, array('cuil' => $cuil));
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
		$query = $this->db->query($this->sp_consulta, array('cuil' => NULL));
		return $query->result_array();
	}
	
	public function insert_persona()
	{	
		if($this->db->query($this->sp_alta, 
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
		if($this->db->query($this->sp_editar, 
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
	
	public function delete_personas($cuil = FALSE)
	{
		if($query = $this->db->query($this->sp_baja, array('cuil' => $cuil)))
			$resultado['resultado']='OK';
		else
			$resultado['resultado']='ERROR';
		return $resultado;
	}
}