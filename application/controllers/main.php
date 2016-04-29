<?php 

class Main extends CI_Controller 
{

	public function __construct(){

		parent::__construct();
		
      //use_ssl();
		$this->load->library("form_validation");
         $this->load->library('recaptcha');

		if($this->session->userdata("deck_id")) redirect("deck");
	}

	public function index(){
			
				
		if($_POST)
		{
		
			$this->form_validation->set_rules('username', 'Username', 'trim|xss_clean|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|xss_clean|required');
               $this->recaptcha->recaptcha_check_answer();

                 
					if ($this->form_validation->run() == TRUE){
					
						$details = $this->db->get_where("deck_user",array("name"=>$_POST['username'] , "password"=>md5($_POST['password'])));
						$passed = $details->num_rows();
						
						if($passed == 0)	$data['error'] = "<font style='color:#FF0000; font-weight:bold; font-size:14px;'> Invalid username or password.</font>";
						else {
						$detail = $details->row_array();
						
						$this->session->set_userdata(array("deck_id"=>$detail['deck_id']));
						
						redirect("deck");
						}
						
					
					}
		                                             
                 }else{
                     $this->session->set_flashdata('error','incorrect captcha');
                               }
//                 redirect(base_url());
	

		
		}
		

                            //Store the captcha HTML for correct MVC pattern use.
                            $data['recaptcha_html'] = $this->recaptcha->recaptcha_get_html();


			$data['title'] = 'Admin Login';
			
			$this->load->view('newlogin',$data);
		}	
	
}
?>
