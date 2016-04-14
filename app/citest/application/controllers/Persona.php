<?php
class Persona extends CI_Controller {
	
	public $datos_formulario;

	public function __construct()
	{
		parent::__construct();
		//Instancio una clase vacia para evitar el warning "Creating default object from empty value"
		$this->datos_formulario = new stdClass();
		$this->load->model('Persona_model');
		$this->load->helper(array('url_helper', 'form'));
		$this->load->library('form_validation');
	}
	
	public function index()
	{
		$data['personas'] = $this->Persona_model->consulta();
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
					anchor('persona/actualizar/'.$persona['CUIL'],'modificar',array('class'=>'update')).' '.
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
			$persona = $this->Persona_model->consulta($cuil);
			$template = array(
					'table_open' => '<table border="0" cellpadding="4" cellspacing="0" class="table table-striped">'
			);
			$this->load->view('templates/header', $data);
			$this->load->library('table');
			$this->table->set_template($template);
			$this->table->set_heading('CUIL', 'Nombre', 'Apellido', 'Mail', 'Acciones');
			$this->table->add_row($persona->cuil, $persona->nombre, $persona->apellido, $persona->mail,
					anchor('persona/ver/'.$persona->cuil,'ver',array('class'=>'view')).' '.
					anchor('persona/actualizar/'.$persona->cuil,'modificar',array('class'=>'update')).' '.
					anchor('persona/eliminar/'.$persona->cuil,'eliminar',array('class'=>'delete','onclick'=>"return confirm('¿Esta seguro que desea eliminar esta persona?')"))
					);
			$data['tabla'] = $this->table->generate();
			$this->load->view('personas/buscar_persona', $data);
			$this->load->view('templates/footer');
		}
	}
	
	public function agregar()
	{
		$data['titulo'] = 'Alta de Personas';
		$data['mensaje'] = '';
		$data['cancelar'] = anchor('persona','Cancelar',array('class'=>'btn btn-danger', 'role'=> 'button'));
		$data['accion'] = site_url('persona/agregar');
		$this->_setear_campos();
		$this->_setear_reglas();
		if($this->form_validation->run() == FALSE)
		{
			$data['mensaje']= validation_errors();
		}
		else if($this->Persona_model->alta()['resultado']='OK')
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
		$data['personas_item'] = $this->Persona_model->consulta($cuil);
		$data['titulo'] = 'Personas';
		if (empty($data['personas_item']))
		{
			show_404();
		}
		$data['nombre'] = $data['personas_item']->nombre;
		$this->load->view('templates/header', $data);
		$this->load->view('personas/ver_persona', $data);
		$this->load->view('templates/footer');
	}
	
	public function actualizar($cuil=NULL)
	{
		$data['titulo'] = 'Modificar persona';
		$data['mensaje'] = '';
		$data['accion'] = site_url('persona/actualizar');
		$data['cancelar'] = anchor('persona','Cancelar',array('class'=>'btn btn-danger', 'role'=> 'button'));
		//Si no es un post, no se llama al actualizar y solo se muestran los campos para editar
		if(!$this->input->post('cuil'))
		{	
			$persona = $this->Persona_model->consulta($cuil);
			$this->datos_formulario->cuil = $persona->cuil;
			$this->datos_formulario->nombre = $persona->nombre;
			$this->datos_formulario->apellido = $persona->apellido;
			$this->datos_formulario->mail = $persona->mail;
		}
		else
		{
			$this->_setear_campos();
			$this->_setear_reglas();
			$persona = new stdClass();
			if($this->form_validation->run() == FALSE)
			{
				$data['mensaje']= validation_errors();
			}
			else if($this->Persona_model->editar()['resultado']='OK')
			{
			
				$data['mensaje'] = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Persona guardada correctamente!</div>';
			}
			else
			{
				$data['mensaje'] = '<div class="alert alert-danger">Error al guardar persona</div>';
			}
		}
		$this->load->view('templates/header', $data);
		$this->load->view('personas/grabar_persona', $data);
		$this->load->view('templates/footer');
	}
	
	public function eliminar($cuil = NULL)
	{
		$this->Persona_model->baja($cuil);
		$this->index();
	}
	
	function _setear_campos()
	{
		$this->datos_formulario->cuil = '';
		$this->datos_formulario->nombre = '';
		$this->datos_formulario->apellido = '';
		$this->datos_formulario->mail = '';
	}
	
	function _setear_reglas()
	{
		$this->form_validation->set_rules('cuil', 'Cuil', 'trim|required');
		$this->form_validation->set_rules('nombre', 'Nombre', 'trim|required');
		$this->form_validation->set_rules('apellido', 'Apellido', 'trim|required');
		$this->form_validation->set_rules('mail', 'Mail', 'trim|required|valid_email');
	
		$this->form_validation->set_message('required', 'El {field} es obligatorio');
		$this->form_validation->set_message('isset', 'El {field} es obligatorio');
		$this->form_validation->set_message('valid_email', 'El {field} debe ser valido');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>');
	}
	
	public function ax_insert()
	{
		echo json_encode($this->Persona_model->alta());
	}
}