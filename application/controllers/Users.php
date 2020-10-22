<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('users_model','users');
	}

	public function index()
	{
		$this->load->helper('url');
		$this->load->view('users_view');
	}

	public function ajax_list()
	{
		$this->load->helper('url');

		$list = $this->users->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $users) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $users->firstName.' '.$users->lastName;
			$row[] = $users->name;
			$row[] = $users->email;
			$row[] = $users->contrasenia;
			$row[] = $users->estado;
			
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$users->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$users->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->users->count_all(),
						"recordsFiltered" => $this->users->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}


}
