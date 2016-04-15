<?php
class Persona_test extends CI_Controller {
	
	/**
	 * Cuil existente en la base
	 * @var string
	 */
	public $cuil_prueba = '20336206228';
	
	public $cuil;
	public $nombre;
	public $apellido;
	public $mail;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Persona_model');
		$this->load->library('unit_test');
	}
	
	/**
	 * Funcion que se carga por default al invocar al controlador sin especificar la URL completa
	 * @return void
	 */
	public function index()
	{
		/*$test = 1 + 1;
		$expected_result = 2;
		$test_name = 'Adds one plus one';
		$this->unit->run($test, $expected_result, $test_name);*/
		$this->consulta_test();
		mysqli_next_result($this->db->conn_id);
		$this->consulta_test_por_cuil();
		echo $this->unit->report();
	}
	
	public function consulta_test()
	{
		$test = $this->Persona_model->consulta();
		$expected_result = 'is_array';
		$test_name = 'Consulta persona';
		$this->unit->run($test, $expected_result, $test_name);
	}
	
	public function consulta_test_por_cuil()
	{
		$test = $this->Persona_model->consulta($this->cuil_prueba);
		$expected_result = 'is_object';
		$test_name = 'Consulta persona por cuil';
		$this->unit->run($test, $expected_result, $test_name);
	}
	
	public function alta_test()
	{
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		$params = array(
				"cuil"=>"2323223",
				"nombre"=>"Curl",
				"apellido"=>"Larry",
				"mail"=>"curl@hotmail.com",
		);
		curl_setopt($ch,CURLOPT_URL,"http://localhost:8080/citest/persona/alta");
		curl_setopt($ch,CURLOPT_POST,true);
		curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($params));
		$result = curl_exec($ch);
		
	}
}