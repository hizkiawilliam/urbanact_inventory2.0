<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Controller_Marketplace extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Marketplace';

		$this->load->model('model_marketplace');
	}

   	/* 
    * It only redirects to the manage marketplaces page
    */
	public function index()
	{
		if(!in_array('viewMarketplace', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->form_validation->set_rules('marketplace_name', 'Company name', 'trim|required');
		$this->form_validation->set_rules('link', 'Link', 'trim|required');
		if ($this->form_validation->run() == TRUE) {
            // true case

        	$data = array(
        		'marketplace_name' => $this->input->post('marketplace_name'),
                'link' => $this->input->post('link')
        	);

        	$update = $this->model_marketplace->update($data, 1);
        	if($update == true) {
        		$this->session->set_flashdata('success', 'Successfully created');
        		redirect('Controller_Marketplace/', 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('Controller_Marketplace/index', 'refresh');
        	}
        }
        else {
		$marketplace_data = $this->model_marketplace->getMarketplaceData();
		$this->data['marketplace_data'] = $marketplace_data;
		$this->render_template('marketplace/index', $this->data);	
		}
	}

	/*
	* It retrieve the specific marketplace information via a marketplace id
	* and returns the data in json format.
	*/
	public function fetchMarketplaceDataById($id) 
	{
		if($id) {
			$data = $this->model_marketplace->getMarketplaceData($id);
			echo json_encode($data);
		}
	}
	/*
	* It retrieves all the marketplace data from the database 
	* This function is called from the datatable ajax function
	* The data is return based on the json format.
	*/
	public function fetchMarketplaceData()
	{
		$result = array('data' => array());
		$marketplace_data = $this->model_marketplace->getMarketplaceData();
		$this->data['marketplace_data'] = $marketplace_data;
		$data = $this->model_marketplace->getMarketplaceData();

		foreach ($data as $key => $value) {
			// button
			$buttons = '';

			if(in_array('updateMarketplace', $this->permission)) {
				$buttons = '<button type="button" class="btn btn-warning btn-sm" onclick="editFunc('.$value['id'].')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>';
			}

			if(in_array('deleteMarketplace', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-danger btn-sm" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}

			$status = ($value['active'] == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>';

			$result['data'][$key] = array(
				$value['marketplace_name'],
				$value['link'],
				$status,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}
	
	/*	
    * If the validation is not valid, then it provides the validation error on the json format
    * If the validation for each input is valid then it inserts the data into the database and 
    returns the appropriate message in the json format.
    */
	public function create()
	{
		if(!in_array('createMarketplace', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		$this->form_validation->set_rules('marketplace_name', 'Marketplace name', 'trim|required');
		$this->form_validation->set_rules('link', 'Link', 'trim');
		$this->form_validation->set_rules('active', 'Active', 'trim|required');

		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'marketplace_name' => $this->input->post('marketplace_name'),
				'active' => $this->input->post('active'),
				'link' => $this->input->post('link'),	
        	);

        	$create = $this->model_marketplace->create($data);
        	if($create == true) {
				$this->session->set_flashdata('success', 'Successfully created');
        		redirect('Controller_Marketplace', 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('Controller_Marketplace/create', 'refresh');
        	}
        }
        else {
			// false case
			$this->render_template('marketplace/create', $this->data);
        }
        echo json_encode($response);
	}	

	/*
    * If the validation is not valid, then it provides the validation error on the json format
    * If the validation for each input is valid then it updates the data into the database and 
    returns a n appropriate message in the json format.
    */
	public function update($id)
	{
		if(!in_array('updateMarketplace', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		if($id) {
			$this->form_validation->set_rules('edit_marketplace_name', 'Marketplace name', 'trim|required');
			$this->form_validation->set_rules('edit_link', 'Link', 'trim|required');
			$this->form_validation->set_rules('edit_active', 'Active', 'trim|required');

			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

	        if ($this->form_validation->run() == TRUE) {
	        	$data = array(
	        		'marketplace_name' => $this->input->post('edit_marketplace_name'),
					'active' => $this->input->post('edit_active'),	
					'link' => $this->input->post('edit_link'),	
	        	);

	        	$update = $this->model_marketplace->update($data, $id);
	        	if($update == true) {
	        		$response['success'] = true;
	        		$response['messages'] = 'Succesfully updated';
	        	}
	        	else {
	        		$response['success'] = false;
	        		$response['messages'] = 'Error in the database while updated the information';			
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
	* If checks if the marketplace id is provided on the function, if not then an appropriate message 
	is return on the json format
    * If the validation is valid then it removes the data into the database and returns an appropriate 
    message in the json format.
    */
	public function remove()
	{
		if(!in_array('deleteMarketplace', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		
		$marketplace_id = $this->input->post('marketplace_id');

		$response = array();
		if($marketplace_id) {
			$delete = $this->model_marketplace->remove($marketplace_id);
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