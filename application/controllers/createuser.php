<?php 

class Createuser extends CI_Controller 
{

	public function __construct(){

		parent::__construct();
		$this->load->library("form_validation");
		if(!$this->session->userdata("deck_id")) redirect("main");

	}

	public function index(){
				
			if($_POST['create'])
			{
			
			$this->form_validation->set_rules('username', 'Username', 'trim|xss_clean|required');
			$this->form_validation->set_rules('principle_account', 'Cuenta Principal', 'trim|xss_clean|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|xss_clean|required');
			$this->form_validation->set_rules('type', 'Type', 'trim|xss_clean|required');
		
	

				if ($this->form_validation->run() == TRUE){
				
					$array['name'] = $_POST['username'];
					$array['type'] = $_POST['type'];
					$array['password'] = md5($_POST['password']);
					$array['create_date'] =time();
					
					$this->db->insert("deck_user",$array);
					$id = mysql_insert_id();
					if($id)
					{
						if($_POST['principle_account'] !='')
						{
							$arr_acounts['deck_id'] = $id;
							$arr_acounts['principle_account'] = $_POST['principle_account'];
							$arr_acounts['alternative_account'] = $_POST['alternative_accounts'];
							$arr_acounts['create_date'] = time();
							
							$this->db->insert("user_accounts",$arr_acounts);
							
						}
					}
					
					redirect('deck');exit;
					}
			}

			if($_POST['submit'])
			{
			//d($_POST,1);
			$this->form_validation->set_rules('admin_message', 'admin message', 'trim|xss_clean|required');
			$this->form_validation->set_rules('favorite', 'favorite', 'trim|xss_clean|required');
			$this->form_validation->set_rules('rules', 'reglas', 'trim|xss_clean|required');
			$this->form_validation->set_rules('retweet_limit','Limite de RTs','required|xss_clean');
			$this->form_validation->set_rules('close_deck', 'Cerrar Deck', 'trim|xss_clean|required');
	

				if ($this->form_validation->run() == TRUE){
				
					$array2['admin_message'] = $_POST['admin_message'];
					$array2['rules'] = $_POST['rules'];
					$array2['favorite'] = $_POST['favorite'];
					$array2['autounret_time'] = $_POST['autounret_time'];
					$array2['retweet_limit'] = $_POST['retweet_limit'];
					$array2['close_deck'] = $_POST['close_deck'];

					$id_setting = $setting_info = $this->db->get_where("settings")->row_array();
					if($setting_info['setting_id'])
					{
						 $this->db->update("settings",$array2,array("setting_id"=>$setting_info['setting_id']));

					}
					else 
					{
					$this->db->insert("settings",$array2);
					$id_setting = mysql_insert_id();
					}
					
					if($id_setting)
						{
							$data['success'] = 'Tus ajustes fueron guardados exitosamente!';
						}

					}
			}
			$data['setting_info'] = $this->db->get_where("settings")->row_array();

			$data['title'] = 'The deck - Create User';
			$data['user_info'] = $this->db->get_where("deck_user",array("deck_id"=>$this->session->userdata("deck_id")))->row_array();
			$this->load->view('createuser3',$data);
		}	
	
}
?>