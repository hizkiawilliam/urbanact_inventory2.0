<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Controller_Items extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Items';

		$this->load->model('model_items');
	}

	/* 
	* It only redirects to the manage product page and
	*/
	public function index()
	{
		if(!in_array('viewItems', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$result = $this->model_items->getItemsData();
		$this->data['results'] = $result;

		$this->render_template('items/index', $this->data);
	}

	/*
	* Fetches the item data from the item table 
	* this function is called from the datatable ajax function
	*/
	public function fetchItemsData()
	{
		$result = array('data' => array());

		$data = $this->model_items->getItemsData();
		foreach ($data as $key => $value) {

			// button
			$buttons = '';

			if(in_array('updateItems', $this->permission)) {
				$buttons .= '<button type="button" class="btn btn-warning btn-sm" onclick="editItems('.$value['id'].')" data-toggle="modal" data-target="#editItemsModal"><i class="fa fa-pencil"></i></button>';	
			}
			
			if(in_array('deleteItems', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-danger btn-sm" onclick="removeItems('.$value['id'].')" data-toggle="modal" data-target="#removeItemsModal"><i class="fa fa-trash"></i></button>
				';
			}				

			$status = ($value['active'] == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>';

			$result['data'][$key] = array(
				$value['name'],
				$status,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	/*
	* It checks if it gets the Items id and retreives
	* the Items information from the Items model and 
	* returns the data into json format. 
	* This function is invoked from the view page.
	*/
	public function fetchItemsDataById($id)
	{
		if($id) {
			$data = $this->model_items->getItemsData($id);
			echo json_encode($data);
		}
		return false;
	}

	/*
	* Its checks the Items form validation 
	* and if the validation is successfully then it inserts the data into the database 
	* and returns the json format operation messages
	*/
	public function create()
	{

		if(!in_array('createItems', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		$this->form_validation->set_rules('items_name', 'Item name', 'trim|required');
		$this->form_validation->set_rules('active', 'Active', 'trim|required');

		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'name' => $this->input->post('items_name'),
        		'active' => $this->input->post('active'),	
        	);

        	$create = $this->model_items->create($data);
        	if($create == true) {
        		$response['success'] = true;
        		$response['messages'] = 'Succesfully created';
        	}
        	else {
        		$response['success'] = false;
        		$response['messages'] = 'Error in the database while creating the information';			
        	}
        }
        else {
        	$response['success'] = false;
        	foreach ($_POST as $key => $value) {
        		$response['messages'][$key] = form_error($key);
        	}
        }

        echo json_encode($response);
	}

	/*
	* Its checks the item form validation 
	* and if the validation is successfully then it updates the data into the database 
	* and returns the json format operation messages
	*/
	public function update($id)
	{
		if(!in_array('updateItems', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		if($id) {
			$this->form_validation->set_rules('edit_items_name', 'Item name', 'trim|required');
			$this->form_validation->set_rules('edit_active', 'Active', 'trim|required');

			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
			
	        if ($this->form_validation->run() == TRUE) {
	        	$data = array(
	        		'name' => $this->input->post('edit_items_name'),
	        		'active' => $this->input->post('edit_active'),	
	        	);

	        	$update = $this->model_items->update($data, $id);
	        	if($update == true) {
	        		$response['success'] = true;
	        		$response['messages'] = 'Succesfully updated';
	        	}
	        	else {
	        		$response['success'] = false;
	        		$response['messages'] = 'Error in the database while updated the item information';			
	        	}
	        }
	        else {
	        	$response['success'] = false;
	        	foreach ($_POST as $key => $value) {
	        		$response['messages'][$key] = form_error($key);
	        	}
	        }
		}
		else {
			$response['success'] = false;
    		$response['messages'] = 'Error please refresh the page again!!';
		}
		echo json_encode($response);
	}

	/*
	* It removes the item information from the database 
	* and returns the json format operation messages
	*/
	public function remove()
	{
		if(!in_array('deleteItems', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		
		$items_id = $this->input->post('items_id');
		$response = array();
		if($items_id) {
			$delete = $this->model_items->remove($items_id);

			if($delete == true) {
				$response['success'] = true;
				$response['messages'] = "Successfully removed";	
			}
			else {
				$response['success'] = false;
				$response['messages'] = "Error in the database while removing the information";
			}
		}
		else {
			$response['success'] = false;
			$response['messages'] = "Refresh the page again!!";
		}
		echo json_encode($response);
	}
}