<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BusinessDirectory Category Controller
 *
 * This class handles category management functionality
 *
 * @package		Admin
 * @subpackage	Category
 * @author		dbcinfotech
 * @link		http://dbcinfotech.net
 */


class Categorypost_core extends CI_Controller {
	
	var $per_page = 10;
	
	public function __construct()
	{
		parent::__construct();
		is_installed(); #defined in auth helper
		checksavedlogin(); #defined in auth helper
		
		if(!is_admin())
		{
			if(count($_POST)<=0)
			$this->session->set_userdata('req_url',current_url());
			redirect(site_url('admin/auth'));
		}

		$this->per_page = get_per_page_value();#defined in auth helper

		$this->load->model('categorypost_model');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" style="margin:0">', '</div>');
	}
	
	public function index()
	{
		$this->all();
	}

	#load all services view with paging
	public function all($start='0')
	{
		$value['posts']  	 = $this->categorypost_model->get_all_categories_by_range($start,'id');

        $data['title'] = lang_key('all_categories');
        $data['content'] = load_admin_view('categories_post/allcategories_view_post',$value,TRUE);
		 load_admin_view('template/template_view',$data);		
	}

	#load new service view
	public function newcategory()
	{
        $data['title'] = lang_key('new_category');
        $data['content'] = load_admin_view('categories_post/newcategory_view_post','',TRUE);
		load_admin_view('template/template_view',$data);
	}
	
	#load edit service view
	public function edit($id='')
	{
		$value['post']  = $this->categorypost_model->get_category_by_id($id);
		$data['title'] = lang_key('edit_category');
		$data['content'] = load_admin_view('categories_post/editcategory_view_post',$value,TRUE);
		load_admin_view('template/template_view',$data);		
	}
	
	#delete a service
	public function delete($id='',$confirmation='')
	{
		if($confirmation=='')
		{
			$data['content'] = load_admin_view('confirmation_view',array('id'=>$id,'url'=>site_url('admin/categorypost/delete')),TRUE);
			 load_admin_view('template/template_view',$data);
		}
		else
		{
			if($confirmation=='yes')
			{
				if(constant("ENVIRONMENT")=='demo')
				{
					$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
				}
				else
				{
					$this->categorypost_model->delete_category_by_id($id);
					$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('data_updated').'</div>');
				}
			}
			redirect(site_url('admin/categorypost/all'));		
			
		}		
	}

	#add a service
	public function addcategory()
	{	

		$this->form_validation->set_rules('title', lang_key('title'), 'required');
		$this->form_validation->set_rules('featured_img', lang_key('featured_img'), 'required');

		if ($this->form_validation->run() == FALSE)
		{
			$this->newcategory();	
		}
		else
		{
			$this->load->helper('date');
			$format = 'DATE_RFC822';
			$time = time();
			$data 					= array();			
			$data['name'] 			= $this->input->post('title');
			$data['type'] 			= $this->input->post('type');
			$data['featured_img'] 	= $this->input->post('featured_img');
			$data['description'] 	 = $this->input->post('description');
			
			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{
				$this->categorypost_model->insert_category($data);
				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('data_inserted').'</div>');				
			}
			redirect(site_url('admin/categorypost/newcategory'));		
		}
	}
	
	
	#update a service
	public function updatecategory()
	{
		$this->form_validation->set_rules('title', lang_key('title'), 'required');
				$this->form_validation->set_rules('featured_img', lang_key('featured_img'), 'required');

		if ($this->form_validation->run() == FALSE)
		{
			$id = $this->input->post('id');
			$this->editcategory($id);	
		}
		else
		{
			$id = $this->input->post('id');

			$data 					= array();
			$data['name'] 			= $this->input->post('title');
			$data['type'] 			= $this->input->post('type');
			$data['featured_img'] 	= $this->input->post('featured_img');
			$data['description'] 	= $this->input->post('description');
			
			
			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{
				$this->categorypost_model->update_category($data,$id);
				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('data_updated').'</div>');
			}
			redirect(site_url('admin/categorypost/edit/'.$id));		
		}
	}

	public function featuredimguploader()

	{

		load_admin_view('categories_post/featured_img_uploader_view');

	}

	public function uploadfeaturedfile()
	{
		$dir_name 					= 'images/';
		$config['upload_path'] 		= './uploads/'.$dir_name;
		$config['allowed_types'] 	= 'gif|jpg|png';
		$config['max_size'] 		= '5120';
		$config['min_width'] 		= '100';
		$config['min_height'] 		= '100';

		$this->load->library('dbcupload', $config);
		$this->dbcupload->display_errors('', '');

		if($this->dbcupload->do_upload('photoimg'))
		{
			$data = $this->dbcupload->data();
			$this->load->helper('date');

			$format = 'DATE_RFC822';
			$time = time();
			create_rectangle_thumb('./uploads/'.$dir_name.$data['file_name'],'./uploads/thumbs/');

			$media['media_name'] 		= $data['file_name'];
			$media['media_url']  		= base_url().'uploads/'.$dir_name.$data['file_name'];
			$media['create_time'] 		= standard_date($format, $time);
			$media['status']			= 1;

			$status['error'] 	= 0;
			$status['name']	= $data['file_name'];
		}

		else

		{

			$errors = $this->dbcupload->display_errors();

			$errors = str_replace('<p>','',$errors);

			$errors = str_replace('</p>','',$errors);

			$status = array('error'=>$errors,'name'=>'');

		}



		echo json_encode($status);

		die;

	}

}

/* End of file admin.php */
/* Location: ./application/modules/admin/controllers/admin.php */