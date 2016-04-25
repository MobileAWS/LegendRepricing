<?php 

class Home extends CI_Controller 
{
  private $data = array();
  private $gearman_server='localhost';
  private $gearman_port='4730';
  public function __construct(){

    parent::__construct();

    if($this->session->userdata("logged_in")) redirect("content");     
    $this->data = array(
      'widget' => $this->recaptcha->getWidget(),
      'script' => $this->recaptcha->getScriptTag(),
    );
  }   
       /*
  private function gen_uuid() {
  return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
    // 32 bits for "time_low"
    mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

    // 16 bits for "time_mid"
    mt_rand( 0, 0xffff ),

    // 16 bits for "time_hi_and_version",
    // four most significant bits holds version number 4
    mt_rand( 0, 0x0fff ) | 0x4000,

    // 16 bits, 8 bits for "clk_seq_hi_res",
    // 8 bits for "clk_seq_low",
    // two most significant bits holds zero and one for variant DCE1.1
    mt_rand( 0, 0x3fff ) | 0x8000,

    // 48 bits for "node"
    mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
  );
} 
   private function backup_link($option,$function_name)
  {    
    $log_array['unique_key']=$this->gen_uuid();
    $log_array['function_name']=$function_name;
    $log_array['priority']=1;
    $log_array['data']=serialize($option);
    $this->db->insert("table_name",$log_array);           

    // now restart the service
    exec("/etc/init.d/gearman-job-server restart", $output, $return);
    if ($return == 0) {
      log_message('info', "Ok, process is re-running\n");
    }   else
    {
      log_message('error',"FAILED TO STRT THE GEARMAN SERVICE");
    }


  }           
    private function checkservers()
    {
      $client= new GearmanClient();
      $client->addServer($this->gearman_server,$this->gearman_port);
      $result=@$client->ping('data testing');
      //echo $client->getErrno();
      return $client->returnCode();
    }    
        */  
    private function send_email($option)
    {
      // add the clients jobss
      // we have the seelr id , mkplace id and token
      if(checkservers()==0)
      {
        // create new client
        $client= new GearmanClient();
        $client->addServer($this->gearman_server,$this->gearman_port);
        // serialaize the data
        $result=$client->doBackground("send_email", serialize($option));
        log_message("error","created send email client ...waiting for the workrs");
        return TRUE;
      }                    
      else
      { 
    backup_link($option,"send_email");
  }

  return TRUE;

}                          

  public function feedback()
  {

    $email='legendpricing@gmail.com';
    /*
    $config = Array(
      'protocol' => 'smtp',
      'smtp_host' => 'ssl://smtp.googlemail.com',
      'smtp_port' => 465,
      'smtp_user' => 'jimmycarter256@gmail.com', // change it to yours
      'mailtype' => 'html',
      'charset' => 'iso-8859-1',
      'wordwrap' => TRUE
    );

    $this->load->library('email', $config);
     */
///    $this->email->set_newline("\r\n");
//    $this->email->from('jimmycarter256@gmail.com'); // change it to yours
 //   $this->email->to($email);// change it to yours
  //  $this->email->subject('Feedback Request');
//    $this->email->message($_POST['message']);
    $create_array=array("reply_to"=>$_POST['email'],"to"=>$email,"subject"=>'Feedback Request',"message"=>$_POST['message']);
    $this->send_email($create_array);
    ///    if($this->email->send())
    if(1)
    {
      ///      echo 'Email sent.';
      // now update the database  
      $sql = $this->db->insert("feedback",array("name"=>$_POST['name'],'email' => $_POST['email'],"phone" => $_POST['contact_no'],"message" => $_POST['message']));
      $noRecords= $this->db->affected_rows(); 
      if ($noRecords > 0){
        echo  'Feedback updated success';

      }else{
        echo 'Feedback not updated on database.. please try again later';
      }                          

    }
    else
    {
      //      show_error($this->email->print_debugger());
     // log_message('error',$this->email->print_debugger());
    //  echo 'Feedback not sent.. please try again later';
    }                                                                          
    //load the views now 
//    $this->session->set_flashdata('errors', 'Feedback sent successfully');
  //  redirect('home');


  }
  public function sendMail_forgot()
  {
    $email=$_POST['email'];
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
    $new_password=mt_rand();
    $this->data['email'] = $email;
    $this->data['new_password'] = $new_password;

      $myemail=$this->db->get_where("signup",array('email' => $_POST['email']))->row_array();
    if($myemail)  
    {
    $this->data['link'] = $this->config->base_url('home/reset_password/'.md5($email.$myemail['created'].$myemail['verification_code']));
    }
    else
    {
      echo 'failed';
      return ;
    }
    
    $message_new = $this->load->view('emails/forgot_password',$this->data,TRUE); // this will return you html data as message
//    $this->load->library('email', $config);
   $this->email->set_newline("\r\n");
    $this->email->from('admin@legendrepricing.com'); // change it to yours
  $this->email->to($email);// change it to yours
  $this->email->subject('Password Reset');
    //$this->email->message("Dear User,\nThis is your new password\n\n ".$new_password."\n"."\n\nThanks\nAdmin Team");
   $this->email->message($message_new);
  //  $create_array=array("to"=>$email,"subject"=>'Password Reset',"message"=>$message_new);
    try{
//    $this->send_email($create_array);
 if($this->email->send())
      {


      }
    //    if($this->email->send())
    if(1)
    {
        echo  'Passsword updated successfully An email has been sent';
      ///      echo 'Email sent.';

      // now update the database  
      /*
      $sql = $this->db->update("signup",array("password"=>md5($new_password)),array('email' => $_POST['email']));
      $noRecords= $this->db->affected_rows(); 
      if ($noRecords > 0){
        echo  'Passsword updated successfully An email has been sent';

      }else{
        echo 'Password not updated.Plesae try again later';
      }                          
       */
    }
    }
    catch(Exception $e)
    {
      //      show_error($this->email->print_debugger());
      echo 'Password failed to update';
    //    return $this->email->print_debugger();
  }

  }
	public function faq()
	{
		$this->load->view('homepage/faq');
	}
   public function reset_password($value=NULL)
//  public function forgotpassword()
  {
//    $this->load->view('homepage/header',$this->data);
  //  $this->load->view('homepage/nav',$this->data);
    if($value==NULL)
    {
    }
    else
    {
    $this->data['key'] =$value;
    $this->load->view('homepage/reset',$this->data);
    //$this->load->view('homepage/footer',$this->data);
    }
    // 			redirect("deck");                               
  }                   
  public function forgot_pass()
//  public function forgotpassword()
  {
//    $this->load->view('homepage/header',$this->data);
  //  $this->load->view('homepage/nav',$this->data);
    $this->load->view('homepage/forgot',$this->data);
    //$this->load->view('homepage/footer',$this->data);
    // 			redirect("deck");                               
  }
  public  function verify($verificationText=NULL){  

    $sql = "update signup set status='verified' WHERE verification_code=?";
    $this->db->query($sql, array($verificationText));
    $noRecords= $this->db->affected_rows(); 
    if ($noRecords > 0){
      $myemail=$this->db->get_where("signup",array('verification_code' => $verificationText))->row_array();
    ///  bettere create free subscritoion and profiels table
      $sql = $this->db->insert("subscription",array('email' => $myemail['email']));
      $sql = $this->db->insert("user_profiles",array("name"=>explode("@",$myemail['email'])[0],'email' => $myemail['email']));
   //   $this->session->set_flashdata('errors',$this->db->_error_message());
      $this->session->set_flashdata('errors', 'Your account has been verified. please Login <a href='. $this->config->base_url().'#myModal'.'> HERE </a> to continue.');

    }else{
    $this->session->set_flashdata('errors', 'Either email has been verified previously or Email verification failed');
    }

    //$this->load->view('homepage/index',$this->data);
    redirect('home/#verifymsg');
  }
  public function sendMail_reset()
  {
    if($_POST['email'] && $_POST['password'] && $_POST['cpassword'])
    {
      $email=$_POST['email'];
      $pass=$_POST['password'];
      $cpass=$_POST['cpassword'];
      $value=$_POST['key'];
      $myemail=$this->db->get_where("signup",array('email' => $_POST['email']))->row_array();
      if($myemail)
      {
        $val=md5($email.$myemail['created'].$myemail['verification_code']); 
        if($value==$val){
          // now update the password               
          $sql = $this->db->update("signup",array("password"=>md5($pass)),array('email' => $_POST['email']));
          $noRecords= $this->db->affected_rows(); 
          if ($noRecords > 0){
            echo  'Passsword updated successfully An email has been sent';

          }else{
            echo 'Password not updated.Plesae try again later';
          }                                      
        }
        else
        {
          echo 'Invalid email address or invalid link';
        }
      }
      else
      {
        echo 'failed ..Wrong email address';
      }
    }
    else
    {
      echo 'Please fill the fields';
    }


  }

  public function index(){

    //    $this->data[""]="";
    //load the vewd
//    $this->load->view('homepage/header',$this->data);
 //   $this->load->view('homepage/nav',$this->data);
    $this->load->view('homepage/index',$this->data);
   /// $this->load->view('homepage/footer',$this->data);
    // 			redirect("deck");



    //    $this->session->set_flashdata('error','incorrect captcha');



  }	           
  public function pricing()
{
    $this->load->view('homepage/pricing',$this->data);
}
  public function inventory()
{
    $this->load->view('homepage/inventory-management',$this->data);
}
  public function legendrepricing()
{
    $this->load->view('homepage/legendrepricing',$this->data);
}
  public function repricingfeatures()
{
    $this->load->view('homepage/repricing-features',$this->data);
}
  public function tos()
{
		$this->data['title'] = 'TOS';
    $this->load->view('homepage/tos',$this->data);
}
  public function refund_policy()
{
		$this->data['title'] = 'Refund Policy';
    $this->load->view('homepage/refund_policy',$this->data);
}
  public function privacy()
{
		$this->data['title'] = 'Privacy';
    $this->load->view('homepage/privacy',$this->data);
}
  public function contact()
  {         
//    $this->data[""]="";
    //load the vewd
		$this->data['title'] = 'Contact';
//    $this->load->view('homepage/header',$this->data);
 //   $this->load->view('homepage/nav',$this->data);
    $this->load->view('homepage/contact',$this->data);
//    $this->load->view('homepage/footer',$this->data);
    // 			redirect("deck");
                                                                              
  }                                   

  public function about()
  {         
	{
		$this->data['title'] = 'About';
		$this->load->view('homepage/about',$data);
	}

  //  $this->data[""]="";
    //load the vewd
//    $this->load->view('homepage/header',$this->data);
 //   $this->load->view('homepage/nav',$this->data);
  //  $this->load->view('homepage/about',$this->data);
    //$this->load->view('homepage/footer',$this->data);
    // 			redirect("deck");
                                                                              
  }

}
?>
