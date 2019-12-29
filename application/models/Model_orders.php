<?php 

class Model_orders extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/* get the orders data */
	public function getOrdersData($id = null)
	{
		if($id) {
			$sql = "SELECT O.*, M.marketplace_name as marketplace_name FROM orders O
			left join marketplace M ON O.marketplace = M.id
			WHERE O.id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT O.*, M.marketplace_name as marketplace_name FROM orders O
		left join marketplace M ON O.marketplace = M.id
		ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	// get the orders item data
	public function getOrdersItemData($order_id = null)
	{
		if(!$order_id) {
			return false;
		}

		$sql = "SELECT * FROM orders_item WHERE order_id = ?";
		$query = $this->db->query($sql, array($order_id));
		return $query->result_array();
	}
	
	public function getNamaMarketplace($order_id){
		$sql = "SELECT M.marketplace_name, M.id FROM marketplace M LEFT JOIN orders O on M.id = O.marketplace WHERE O.id = ?";
		$query = $this->db->query($sql, array($order_id));
		return $hasil = $query->row_array();
	}
	
	public function create()
	{
		$user_id = $this->session->userdata('id');
		$bill_no = 'UA-'.strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 4));
    	$data = array(
    		'bill_no' => $bill_no,
    		'customer_name' => $this->input->post('customer_name'),
    		'customer_address' => $this->input->post('customer_address'),
    		'customer_phone' => $this->input->post('customer_phone'),
			'date' => $this->input->post('date'),
			'marketplace' => $this->input->post('marketplace_id'),
    		'gross_amount' => $this->input->post('gross_amount_value'),
    		'net_amount' => $this->input->post('net_amount_value'),
    		'discount' => $this->input->post('discount'),
    		'user_id' => $user_id
    	);

		$insert = $this->db->insert('orders', $data);
		$order_id = $this->db->insert_id();
		
		$this->load->model('model_products');
		$svc = $this->load->model('model_marketplace');
		
		$count_product = count($this->input->post('product'));
    	for($x = 0; $x < $count_product; $x++) {
    		$items = array(
    			'order_id' => $order_id,
    			'product_id' => $this->input->post('product')[$x],
    			'qty' => $this->input->post('qty')[$x],
    			'rate' => $this->input->post('rate_value')[$x],
    			'amount' => $this->input->post('amount_value')[$x],
    		);

    		$this->db->insert('orders_item', $items);

    		//  decrease the stock from the product
    		$product_data = $this->model_products->getProductData($this->input->post('product')[$x]);
    		$qty = (int) $product_data['qty'] - (int) $this->input->post('qty')[$x];
			
    		$update_product = array('qty' => $qty);

    		$this->model_products->update($update_product, $this->input->post('product')[$x]);
    	}
		return ($order_id) ? $order_id : false;
	}

	public function countOrderItem($order_id)
	{
		if($order_id) {
			$sql = "SELECT * FROM orders_item WHERE order_id = ?";
			$query = $this->db->query($sql, array($order_id));
			return $query->num_rows();
		}
	}

	public function update($id)
	{
		if($id) {
			$user_id = $this->session->userdata('id');
			// fetch the order data 

			$data = array(
				'customer_name' => $this->input->post('customer_name'),
	    		'gross_amount' => $this->input->post('gross_amount_value'),
				'marketplace' => $this->input->post('marketplace_id'),
	    		'net_amount' => $this->input->post('net_amount_value'),
	    		'discount' => $this->input->post('discount'),
	    		'user_id' => $user_id
	    	);

			$this->db->where('id', $id);
			$update = $this->db->update('orders', $data);

			// replace the product qty to original and subtract the qty again
			$this->load->model('model_products');
			$get_order_item = $this->getOrdersItemData($id);
			foreach ($get_order_item as $k => $v) {
				$product_id = $v['product_id'];
				$qty = $v['qty'];
				// get the product 
				$product_data = $this->model_products->getProductData($product_id);
				$update_qty = $qty + $product_data['qty'];
				$update_product_data = array('qty' => $update_qty);
				
				// update the product qty
				$this->model_products->update($update_product_data, $product_id);
			}

			// now remove the order item data 
			$this->db->where('order_id', $id);
			$this->db->delete('orders_item');

			// now decrease the product qty
			$count_product = count($this->input->post('product'));
	    	for($x = 0; $x < $count_product; $x++) {
	    		$items = array(
	    			'order_id' => $id,
	    			'product_id' => $this->input->post('product')[$x],
	    			'qty' => $this->input->post('qty')[$x],
	    			'rate' => $this->input->post('rate_value')[$x],
	    			'amount' => $this->input->post('amount_value')[$x],
	    		);
	    		$this->db->insert('orders_item', $items);

	    		// now decrease the stock from the product
	    		$product_data = $this->model_products->getProductData($this->input->post('product')[$x]);
	    		$qty = (int) $product_data['qty'] - (int) $this->input->post('qty')[$x];

	    		$update_product = array('qty' => $qty);
	    		$this->model_products->update($update_product, $this->input->post('product')[$x]);
	    	}

			return true;
		}
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('orders');
	
			$this->db->where('order_id', $id);
			$delete_item = $this->db->delete('orders_item');
			return ($delete == true && $delete_item) ? true : false;
		
		// replace the product qty to original and subtract the qty again
		$this->load->model('model_products');
		$get_order_item = $this->getOrdersItemData($id);
			foreach ($get_order_item as $k => $v) {
			$product_id = $v['product_id'];
			$qty = $v['qty'];
		
			// get the product 
			$product_data = $this->model_products->getProductData($product_id);
			$update_qty = $qty + $product_data['qty'];
			$update_product_data = array('qty' => $update_qty);
						
			// update the product qty
			$this->model_products->update($update_product_data, $product_id);
		}
		
		// now rollback the stock from the product
		$product_data = $this->model_products->getProductData($this->input->post('product')[$id]);
		$qty = (int) $product_data['qty'] + (int) $this->input->post('qty')[$id];
			$update_product = array('qty' => $qty);
		$this->model_products->update($update_product, $this->input->post('product')[$id]);
	}
}
}