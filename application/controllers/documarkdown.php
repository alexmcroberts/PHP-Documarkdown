<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	#Documarkdown Controller {#documarkdown}
	*this class contains all controller methods relating to PHP DocuMarkdown*
	**alex mcroberts 2011**
 */	
class Documarkdown extends CI_Controller
{
	/*
		##index
		*index page*
		###variables
		* none
		###returns
		* none
		**alex mcroberts 2011**
	 */	
	public function index()
	{
		$this->load->model('Documarkdown_model');
		$data['model_documentation_output'] = $this->Documarkdown_model->read_models();
		$data['controller_documentation_output'] = $this->Documarkdown_model->read_controllers();

		$this->load->view('documarkdown/index.php', $data);
	}
}

/* End of file documarkdown.php */
/* Location: ./application/controllers/documarkdown.php */