<?php 
header('Access-Control-Allow-Origin: *'); 


class Signup extends CI_Controller 
{
  private $data = array();
	public function __construct(){

		parent::__construct();
		$this->load->library("form_validation");
        // 	if(!$this->session->userdata("logged_in")) redirect("home");

    }
    
    private function sendMail($email,$verificationText)
    {
      /*
      $config = Array(
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://smtp.googlemail.com',
        'smtp_port' => 465,
        'smtp_user' => 'jimmycarter256@gmail.com', // change it to yours
        'smtp_pass' => 'winner!@#$%^', // change it to yours
        'mailtype' => 'html',
        'charset' => 'iso-8859-1',
        'wordwrap' => TRUE
      );
       */

      $this->data['email'] = $email;
      $this->data['link'] = $verificationText;
      $message_new = $this->load->view('emails/signup_email',$this->data,TRUE); // this will return you html data as message
//      $this->load->library('email', $config);
      $this->email->set_newline("\r\n");
      $this->email->from('admin@legendrepricing.com'); // change it to yours
      $this->email->to($email);// change it to yours
      $this->email->subject('Email Verification');
//      $this->email->message("Dear User,\nPlease click on below URL or paste into your browser to verify your Email Address\n\n ".$verificationText."\n"."\n\nThanks\nAdmin Team");
      $this->email->message($message_new);
      if($this->email->send())
      {
        echo 'Email sent.';
      }
      else
      {
        show_error($this->email->print_debugger());
      }

      return $this->email->print_debugger();
    }

    public function index(){

      if($_POST)
      {
			
			$this->form_validation->set_rules('email', 'User', 'trim|xss_clean|required');
//			$this->form_validation->set_rules('principle_account', 'Cuenta Principal', 'trim|xss_clean|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|xss_clean|required');
            //			$this->form_validation->set_rules('type', 'Type', 'trim|xss_clean|required');


            if ($this->form_validation->run() == TRUE){

              $array['email'] = $_POST['email'];
              //					$array['type'] = $_POST['type'];
              $array['password'] = md5($_POST['password']);
              $array['verification_code'] =mt_rand();

              $recaptcha = $this->input->post('g-recaptcha-response');
              if (!empty($recaptcha)) {
                $response = $this->recaptcha->verifyResponse($recaptcha);
                if (isset($response['success']) and $response['success'] === true) {
                  log_message('error', "You got it!");
                }
                else
                {
                echo 'Wrong google recaptcha response.Please reload the page and signup again';
                return;
                }
              }
              else
              {
                echo 'Complete google recaptcha response';
                return;
              }
              $details = $this->db->get_where("signup",array("email"=>$_POST['email'] ));
              $passed = $details->num_rows();
              if($passed >0)
              {
                // ops alredy taken
                echo 'Oops email address already exists';
		return;
             //   $this->session->set_flashdata('errors', 'Oops Already taken username please try different email address'); 
              //  redirect('home');
              }

              $result=$this->db->insert("signup",$array); 
              if ($this->db->_error_message())
              {
                echo $this->db->_error_message();
              }
              else
              {
//              $this->session->set_flashdata('errors',$this->db->_error_message());
  //            redirect('home');
              $this->session->set_flashdata('errors', $this->sendMail($_POST['email'],$this->config->base_url('verify/'.$array["verification_code"])));
//              $this->session->set_flashdata('errors', $this->sendMail());
              $id = mysql_insert_id();
              if($id)
              {
               /* 		if($_POST['principle_account'] !='')
                        {
                            $arr_acounts['logged_in'] = $id;
                            $arr_acounts['principle_account'] = $_POST['principle_account'];
                            $arr_acounts['alternative_account'] = $_POST['alternative_accounts'];
                            $arr_acounts['create_date'] = time();

                            $this->db->insert("user_accounts",$arr_acounts);

                        }
                */
              }
              error_log("New user has signed up ".$_POST['email'], 1, "legendpricing@gmail.com");
              echo 'Success';
              }
              //$this->session->set_flashdata('errors', 'Success..Check your email and click the link to activate your account'); 
             // redirect('home');
            }
            else
            {
             echo 'Unknown error has occurred';
            //  $this->session->set_flashdata('errors', validation_errors()); 
             // redirect('home');
            }
            }
            else
            {
            // echo 'Unknown error has occurred';
              redirect('home');
            }

    }	

}
?>
