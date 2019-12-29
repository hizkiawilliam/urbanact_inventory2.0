<?php 

class Dashboard extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Dashboard';
		
		$this->load->model('model_products');
		$this->load->model('model_orders');
		$this->load->model('model_users');
		$this->load->model('model_marketplace');
		
	}

	/* 
	* It only redirects to the manage category page
	* It passes the total product, total users, and total marketplace information
	into the frontend.
	*/
	public function index()
	{
		$this->data['total_products'] = $this->model_products->countTotalProducts();
		$this->data['total_users'] = $this->model_users->countTotalUsers();
		$this->data['total_marketplace'] = $this->model_marketplace->countTotalMarketplace();

		$this->data['total_items'] = $this->model_products->countTotalItems();
		$this->data['total_category'] = $this->model_products->countTotalcategory();
		$this->data['total_attribures'] = $this->model_products->countTotalattribures();
		$this->data['total_marketplace'] = $this->model_marketplace->countTotalMarketplace();

		$user_id = $this->session->userdata('id');
		$is_admin = ($user_id == 1) ? true :false;

		$this->data['is_admin'] = $is_admin;
		$this->render_template('dashboard', $this->data);
	}
}