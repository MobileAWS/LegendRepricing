<?php
class Cron extends CI_Controller {
 
    function __construct()
    {
        parent::__construct();
 
        // this controller can only be called from the command line
        if (!$this->input->is_cli_request()) show_error('Direct access is not allowed');
    }
 
    function foo($bar = 'bar')
    {
        echo "foo = $bar";
    }
}

?>
