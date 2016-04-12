<?php
class Persona extends CI_Controller {
	
	public $datos_formulario;

	public function __construct()
	{
		parent::__construct();
		//Instancio una clase vacia para evitar el warning "Creating default object from empty value"
		$this->datos_formulario = new stdClass();
		$this->load->model('Persona_model');
		$this->load->helper('url_helper');
		$this->load->helper('form');
	}
	
	public function index()
	{
		$data['personas'] = $this->Persona_model->buscar_personas();
		$data['titulo'] = 'Personas';
		$template = array(
				'table_open' => '<table border="0" cellpadding="4" cellspacing="0" class="table table-striped">'
		);
		$this->load->view('templates/header', $data);
		$this->load->library('table');
		$this->table->set_template($template);
		$this->table->set_heading('CUIL', 'Nombre', 'Apellido', 'Mail', 'Acciones');
		foreach ($data['personas'] as $persona)
		{
			$this->table->add_row($persona['CUIL'], $persona['Nombre'], $persona['Apellido'], $persona['Mail'],
					anchor('persona/ver/'.$persona['CUIL'],'ver',array('class'=>'view')).' '.
					anchor('persona/editar/'.$persona['CUIL'],'modificar',array('class'=>'update')).' '.
					anchor('persona/eliminar/'.$persona['CUIL'],'eliminar',array('class'=>'delete','onclick'=>"return confirm('¿Esta seguro que desea eliminar esta persona?')"))
					);
		}
		$data['tabla'] = $this->table->generate();
		$this->load->view('personas/buscar_persona', $data);
		$this->load->view('templates/footer');
	}

	public function buscar($cuil=NULL)
	{
		$data['titulo'] = 'Busqueda de Personas';
		$cuil = $this->input->post('cuil');
		
		if ($cuil!=NULL){
			$persona = $this->Persona_model->traer_persona($cuil);
			$template = array(
					'table_open' => '<table border="0" cellpadding="4" cellspacing="0" class="table table-striped">'
			);
			$this->load->view('templates/header', $data);
			$this->load->library('table');
			$this->table->set_template($template);
			$this->table->set_heading('CUIL', 'Nombre', 'Apellido', 'Mail', 'Acciones');
			$this->table->add_row($persona->Cuil, $persona->Nombre, $persona->Apellido, $persona->Mail,
					anchor('persona/ver/'.$persona->Cuil,'ver',array('class'=>'view')).' '.
					anchor('persona/editar/'.$persona->Cuil,'modificar',array('class'=>'update')).' '.
					anchor('persona/eliminar/'.$persona->Cuil,'eliminar',array('class'=>'delete','onclick'=>"return confirm('¿Esta seguro que desea eliminar esta persona?')"))
					);
			$data['tabla'] = $this->table->generate();
			$this->load->view('personas/buscar_persona', $data);
			$this->load->view('templates/footer');
		}
	}
	
	public function agregar()
	{
		$this->_setear_campos();
		$data['titulo'] = 'Alta de Personas';
		$data['mensaje'] = '';
		$data['cancelar'] = anchor('persona','Cancelar',array('class'=>'btn btn-danger', 'role'=> 'button'));
		$data['accion'] = site_url('persona/insert');
		$this->load->view('templates/header', $data);
		$this->load->view('personas/grabar_persona', $data);
		$this->load->view('templates/footer');
	}
	
	public function insert()
	{
		$data['titulo'] = 'Alta de Personas';
		$data['cancelar'] = anchor('persona','Cancelar',array('class'=>'btn btn-danger', 'role'=> 'button'));
		$data['accion'] = site_url('persona/insert');
		$this->_setear_campos();
		if($this->Persona_model->insert_persona()['resultado']='OK')
		{
			$data['mensaje'] = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Persona guardada correctamente!</div>';
		}
		else
		{
			$data['mensaje'] = '<div class="alert alert-danger">Error al guardar persona</div>';
		}
		$this->load->view('templates/header', $data);
		$this->load->view('personas/grabar_persona', $data);
		$this->load->view('templates/footer');
	}
	
	public function ver($cuil = NULL)
	{
		$data['personas_item'] = $this->Persona_model->traer_persona($cuil);
		$data['titulo'] = 'Personas';
	
		if (empty($data['personas_item']))
		{
			show_404();
		}
	
		$data['nombre'] = $data['personas_item']->Nombre;
	
		$this->load->view('templates/header', $data);
		$this->load->view('personas/ver_persona', $data);
		$this->load->view('templates/footer');
	}
	
	public function ax_insert()
	{
		echo json_encode($this->Persona_model->insert_personas());
	}
	
	public function update()
	{
		$this->Persona_model->update_personas();
	}
	
	public function eliminar($cuil = NULL)
	{
		$this->Persona_model->delete_personas($cuil);
	}
	
	function _setear_campos()
	{
		$this->datos_formulario->cuil = '';
		$this->datos_formulario->nombre = '';
		$this->datos_formulario->apellido = '';
		$this->datos_formulario->mail = '';
	}
}