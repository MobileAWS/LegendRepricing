<?php 

header('Access-Control-Allow-Origin: *'); 
class Login extends CI_Controller 
{
  private $data = array();
  public function __construct(){

    parent::__construct();

    //use_ssl();
    $this->load->library("form_validation");

//    if($this->session->userdata("logged_in")) redirect("content");
  }

  public function index(){


    if($_POST)
    {

      $this->form_validation->set_rules('email', 'Username', 'trim|xss_clean|required');
      $this->form_validation->set_rules('password', 'Password', 'trim|xss_clean|required');


      if ($this->form_validation->run() == TRUE){

        $details = $this->db->get_where("signup",array("email"=>$_POST['email'] , "password"=>md5($_POST['password'])));
        $passed = $details->num_rows();

        if($passed == 0)
        { 
         // $this->session->set_flashdata('errors', 'invalid username or password ');
echo 'invalid username or password';
return;
//          redirect('home');
          //   $this->data['error'] = "<font style='color:#FF0000; font-weight:bold; font-size:14px;'> Invalid username or password.</font>";
        }
        else {
          $detail = $details->row_array();
          if($detail['status']=='verified')
          {
            // log the values           
            $date = date('Y-m-d H:i:s');
            $log_array['email'] = $_POST['email'];
            $log_array['loggedin'] = 'true';
            $log_array['last_loggedin'] = $date;
//            $this->db->insert("login_details",$log_array);
            $this->db_mysql->on_duplicate_key_update()->insert("login_details",$log_array);
            $this->session->set_userdata(array("logged_in"=>$_POST['email']));
            echo 'Success';
        //  redirect("content");
          }
          else
          {
echo 'Account is not activated/verified yet';
         //   $this->session->set_flashdata('errors', 'Account is not activated yet...');
       //     redirect('home');
            //            $this->data['error'] = "<font style='color:#FF0000; font-weight:bold; font-size:14px;'>User account is  not activated .</font>";
          }


        }


      }
      else
      {
echo 'Some validation errors occured';
//            $this->session->set_flashdata('errors', validation_errors());
  //          redirect('home');
      }

    }else{
      //          $this->session->set_flashdata('error','incorrect loign details');
     // $this->session->set_flashdata('errors', 'Unexpected form post request');
     redirect('home');
echo 'Unexpected form post request';
    }
    //$this->session->set_flashdata('errors', validation_errors());
   // $this->session->set_flashdata('errors', 'OOPS FAILED LOGIN ATTEMPT Either the account is not activated or invlaid username/password combination');
//       redirect('home');
//   	$this->load->view('home',$this->data);
		}	
	
}
?>
