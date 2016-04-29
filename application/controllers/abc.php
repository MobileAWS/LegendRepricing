<?php

class Abc extends CI_Controller {
 
    function __construct()
    {
        parent::__construct();
        set_exception_handler(array('Abc', 'exception_handler'));
        //also you can use array($this, 'exception_handler')     
    }       
 
    function exception_handler(Exception $ex)
    {        
        echo $ex->getMessage();
    }
 
    function Index()
    {
        throw new Exception('hehe');
    }
}

?>
