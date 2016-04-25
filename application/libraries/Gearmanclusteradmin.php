<?php
/**
* Monitoring Gearman over telnet port 4730
*
* So the only way to monitor Gearman is via doing a telnet to port 4730. The
* current monitoring supported commands are fairly basic.
* There are plans to include more set of commands in the next release.
*
* BigTent Design, Inc.
*
* @category BigTent
* @package GearmanTelnet
* @copyright Copyright (c) 2009 BigTent Design, Inc. (http://www.bigtent.com)
* @version 1.1 (Modified by Lior Ben-Kereth)
*/

/**
 * A class that contains seperated and aggragated workers and status data from all gearman server in a cluster
 * @author liorbk
 *
 */
class Gearmanclusteradmin
{
	private $accumaltiveJobs = array();
	private $accumaltiveWorkers = array();
	
	private $serversJobs = array();
	private $serversWorkers = array();
	
	private $hosts;
	private $orderFunction; 
	
	/**
	 * 
	 * @param array $hosts - array of host:port strings
	 * @param closure $orderFunction - a function that gets serversJob array return a manipulated array (for example, change job names, sort, etc)	 
	 */
	public function __construct(array $hosts, $orderFunction = null)
	{		
		$this->hosts = $hosts;
		$this->orderFunction = $orderFunction;
		

		$this->init();		
	}
	
	public function getAccumaltiveJobs() {return $this->accumaltiveJobs;}
	public function getAccumaltiveWorkers() {return $this->accumaltiveWorkers;}
	public function getServersJobs() {return $this->serversJobs;}
	public function getServersWorkers() {return $this->serversWorkers;}
		
	private function init()
	{
		// Run on all gearman servers and collect data and accumalate it				
		foreach ($this->hosts as $_server)
		{			
			try
			{
				$gm = new GearmanHost($_server);			
			}
			catch(Exception $ex)
			{				
				continue;
			}

			$serverWorkers = $gm->getWorkers();		
			$serverJobs = $gm->getJobs();
		
			if (!empty($this->orderFunction) && is_callable($this->orderFunction))
			{				
				$serverJobs = call_user_func($this->orderFunction,$serverJobs);			
			}
			
			$this->serversJobs[$_server] = $serverJobs;
			$this->serversWorkers[$_server] = $serverWorkers;
			
			foreach ($serverJobs as $jobName => $job)
			{
				$total = $job[GearmanHost::WORKER_TOTAL];
				$running = $job[GearmanHost::WORKER_RUNNING];
				$available = $job[GearmanHost::WORKER_AVAILABLE];
			
				if (!isset($this->accumaltiveJobs[$jobName]))
				{
					$this->accumaltiveJobs[$jobName][GearmanHost::WORKER_TOTAL] = 0;
					$this->accumaltiveJobs[$jobName][GearmanHost::WORKER_RUNNING] = 0;
					$this->accumaltiveJobs[$jobName][GearmanHost::WORKER_AVAILABLE] = 0;
				}
				
				$this->accumaltiveJobs[$jobName][GearmanHost::WORKER_TOTAL] += $total;
				$this->accumaltiveJobs[$jobName][GearmanHost::WORKER_RUNNING] += $running;
				$this->accumaltiveJobs[$jobName][GearmanHost::WORKER_AVAILABLE] = max($this->accumaltiveJobs[$jobName][GearmanHost::WORKER_AVAILABLE], $available);
			}
						
			foreach ($serverWorkers as $type => $worker)
			{
				$available = $worker[GearmanHost::WORKER_TOTAL];
				$running = $worker[GearmanHost::WORKER_RUNNING];
				$free = $worker[GearmanHost::WORKER_AVAILABLE];
				$queued = $worker[GearmanHost::WORKER_QUEUED];
							
				if (!isset($this->accumaltiveWorkers[$type]))
				{
					$this->accumaltiveWorkers[$type][GearmanHost::WORKER_TOTAL] = 0;
					$this->accumaltiveWorkers[$type][GearmanHost::WORKER_RUNNING] = 0;
					$this->accumaltiveWorkers[$type][GearmanHost::WORKER_AVAILABLE] = 0;
					$this->accumaltiveWorkers[$type][GearmanHost::WORKER_QUEUED] = 0;
				}
				
				$this->accumaltiveWorkers[$type][GearmanHost::WORKER_TOTAL] = max($available, $this->accumaltiveWorkers[$type][GearmanHost::WORKER_TOTAL]);
				$this->accumaltiveWorkers[$type][GearmanHost::WORKER_RUNNING] += $running;		
				$this->accumaltiveWorkers[$type][GearmanHost::WORKER_QUEUED] += $queued;											
			}
			
			foreach ($this->accumaltiveWorkers as $type => $worker)
			{ 
				$this->accumaltiveWorkers[$type][GearmanHost::WORKER_AVAILABLE] = ($worker[GearmanHost::WORKER_TOTAL] - $worker[GearmanHost::WORKER_RUNNING]);			
			}			
		}
						
	}
}

class GearmanHost
{
	private $host;
	private $port = 4730;
	private $jobs = array();
	private $workers = array();
	
	private $rawStatus;
	private $rawWorkers;
	
	const WORKER_AVAILABLE = "AVAILABLE";
	const WORKER_RUNNING = "RUNNING";
	const WORKER_TOTAL = "TOTAL";
	const WORKER_QUEUED = "QUEUED";
	
	const FACER_WORKER = "facer";
	const OTHER_WORKER = "other";
	
	public function __construct($host, $port = null)
	{
		if (strstr($host,":") !== false)
		{
			$server = explode(":", $host);
			$this->host = $server[0];
			$this->port = $server[1];
		}
		else
		{
			$this->host = $host;
		}
		
		if ($port != null)
			$this->port = $port;
			
		$gearman_telnet = new GearmanTelnet($this->host, $this->port);
		$this->rawStatus = $gearman_telnet->getStatus();
		$this->rawStatus = explode(PHP_EOL, $this->rawStatus);
		
		$this->rawWorkers = $gearman_telnet->getWorkers();
		$this->rawWorkers = explode(PHP_EOL, $this->rawWorkers);		
				
		$this->initWorkers();
		$this->initJobs();
	}
	
	public function getJobs()
	{
		if (empty($this->jobs) || count($this->jobs) == 0)
			$this->initJobs();
		
		return $this->jobs;
	}
	
	public function getWorkers()
	{
		if (empty($this->workers) || count($this->workers) == 0)
			$this->initWorkers();
		
		return $this->workers;
	}
	
	
	private function initJobs()
	{
		$this->workers = $this->getWorkers();			
		$status = $this->rawStatus;
		
		for($i=0; $i<count($status); $i++)
		{
			@list($job, $total, $running, $available) = explode("	", $status[$i]);
			if (!empty($job))
			{
				$available = trim($available);
				$total = trim($total);
				$running = trim($running);
				
				$this->jobs[$job] = array(
										GearmanHost::WORKER_AVAILABLE => $available,
										GearmanHost::WORKER_TOTAL => $total,
										GearmanHost::WORKER_RUNNING=> $running
									);

				$workerType = self::OTHER_WORKER;
				if (strpos($job, self::FACER_WORKER) !== false)				
					$workerType = self::FACER_WORKER;
				
				$this->workers[$workerType][GearmanHost::WORKER_RUNNING] += $running;
				$this->workers[$workerType][GearmanHost::WORKER_AVAILABLE] -= $running;
				$this->workers[$workerType][GearmanHost::WORKER_QUEUED] += ($total - $running);				
			}
		}		
		
//		print_r($this->workers);
	}
	
	private function initWorkers()
	{		
		$workers = $this->rawWorkers;
		
		$this->workers[self::FACER_WORKER] = array(
										GearmanHost::WORKER_AVAILABLE => 0,
										GearmanHost::WORKER_TOTAL => 0,
										GearmanHost::WORKER_RUNNING => 0,
										GearmanHost::WORKER_QUEUED => 0
									);
		
		$this->workers[self::OTHER_WORKER] = array(
										GearmanHost::WORKER_AVAILABLE => 0,
										GearmanHost::WORKER_TOTAL => 0,
										GearmanHost::WORKER_RUNNING => 0,
										GearmanHost::WORKER_QUEUED => 0
									);			
		
		for($i=0; $i<count($workers); $i++)
		{
			@list($ip, $jobTypes) = explode(" : ", $workers[$i]);
						
			if (!empty($jobTypes))
			{			
				$workerType = self::OTHER_WORKER;
				if (strpos($jobTypes, self::FACER_WORKER) !== false)
					$workerType = self::FACER_WORKER;
				
				$this->workers[$workerType][GearmanHost::WORKER_TOTAL] += 1;
				$this->workers[$workerType][GearmanHost::WORKER_AVAILABLE] += 1;						
			}
		}			
	}
}

class GearmanTelnet {
 
	/**
	 * Default Values
	 */
	private $_gearmand = null;
	private $_gearmand_host = 'localhost';
	private $_gearmand_port = 4730;
	private $_timeout = 3;
	private $_errno = null;
	private $_errstr = '';
	private $_buffer = array();
 
    private $CI;
	public function __construct($gearmand_host = null, $gearmand_port = null, $timeout = null) {
 
		$this->CI = & get_instance();
		$this->_gearmand_host = (!empty($gearmand_host)) ? $gearmand_host : $this->_gearmand_host;
		$this->_gearmand_port = (!empty($gearmand_port)) ? $gearmand_port : $this->_gearmand_port;
		$this->_timeout = (!empty($timeout)) ? $timeout : $this->_timeout;
 
		$this->_connect();
	}

    private function sendAdminEmail($host,$port)
    {
      // send the mail 
      $email='akshay_agarwal2012@yahoo.com';
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
      $message_new = "GEARMAN server is down $host $port";
//      $this->CI->load->library('email', $config);
      $this->CI->email->set_newline("\r\n");
      $this->CI->email->from('admin@legendrepricing.com'); // change it to yours
      $this->CI->email->to('legendpricing@gmail.com');// change it to yours
      $this->CI->email->subject('Urgent Immediate response required');
      //      $this->email->message("Dear User,\nPlease click on below URL or paste into your browser to verify your Email Address\n\n ".$verificationText."\n"."\n\nThanks\nAdmin Team");
      $this->CI->email->message($message_new);
      if($this->CI->email->send())
      {
        echo 'Email sent.';
      }
      else
      {
        //      show_error($this->email->print_debugger());
      }

      //      return $this->email->print_debugger();             

    }
    private function _connect() {
      $this->_gearmand = @fsockopen($this->_gearmand_host, $this->_gearmand_port, $this->_errno, $this->_errstr, $this->_timeout);

      if(!$this->_gearmand) {
        //          echo "Send the email to admin";
        // shall we trtry it

	log_message('debug', "Pagination11 Class Initialized");
    exec("pgrep gearman", $output, $return);
    if ($return == 0) {
      //          echo "Ok, process is running\n";
      $this->_gearmand = @fsockopen($this->_gearmand_host, $this->_gearmand_port, $this->_errno, $this->_errstr, $this->_timeout);
      if(!$this->_gearmand) {
        // send the mail so then
        $this->sendAdminEmail($this->_gearmand_host,$this->_gearmand_port);
        throw new Exception("Failed to connect to gearmand_host at " . $this->_gearmand_host);
      }                  
      //     $this->sendAdminEmail($this->_gearmand_host,$this->_gearmand_port);
      //   throw new Exception("Failed to connect to gearmand_host at " . $this->_gearmand_host);

      }
      else
      {
        //            echo "restart the server now";
        if(stristr(php_uname(),'ubuntu')!==false)
          exec("/etc/init.d/gearman-job-server restart",$output,$return);
        else
          exec("service gearmand restart",$output,$return);
        if($return==0)
        {
          // recvonnect
          $this->_gearmand = @fsockopen($this->_gearmand_host, $this->_gearmand_port, $this->_errno, $this->_errstr, $this->_timeout);
          if(!$this->_gearmand) {
            // send the mail so then
            $this->sendAdminEmail($this->_gearmand_host,$this->_gearmand_port);
            throw new Exception("Failed to connect to gearmand_host at " . $this->_gearmand_host);
          }
        }
        else
        {
          error_log("Error message133", 3, "/tmp/gearman.log");
          $this->sendAdminEmail($this->_gearmand_host,$this->_gearmand_port);
          throw new Exception("Failed to connect to gearmand_host at " . $this->_gearmand_host);
          // send the email now
        }
      }
    }
}

      /**
	 * Command: STATUS
	 *
	 * The output format of this function is tab separated columns as follows, 
	 * below are the columns shown:
	 *
	 * - Function name : A string denoting the name of the function of the job
	 * - Number in queue : A positive integer indicating the total number of 
	 * jobs for this function in the queue. This includes currently running ones 
	 * as well (next column)
	 * - Number of jobs running : A positive integer showing how many jobs of 
	 * this function are currently running
	 * - Number of capable workers : A positive integer denoting the maximum 
	 * possible count of workers that could be doing this job. Though they may 
	 * not all be working on it due to other tasks holding them busy.
	 *
	 */
 
	/* GEARMAN_COMMAND_GET_STATUS */
	public function getStatus() {
		if ($this->exec('STATUS')) {
			$get_status = $this->_getBuffer();
			return implode("", $get_status);
		}
	}
 
	/**
	 * Command : Workers
	 *
	 * This command show the details of various clients registered with the 
	 * gearmand server. For each worker it shows the following info:
	 *
	 * - Peer IP: Client remote host
	 * - Client ID: Unique ID assigned to client
	 * - Functions: List of functions this client has registered for.
	 */
 
	/* GEARMAN_COMMAND_WORK_STATUS */
	public function getWorkers() {
		if ($this->exec('WORKERS')) {
			$get_status = $this->_getBuffer();
			return implode("", $get_status);
		}
	}
 
	private function _getBuffer() {
		return $this->_buffer;
	}
 
	/** 
	 * The output format of this function is tab separated columns, 
	 * followed by a line consisting of a full stop and a newline (".\n") to 
	 * indicate the end of output.
	 *
	 * Any other command text throws a error "ERR unknown_command Unknown+server+command"
	 *
	 */
	private function exec($command) {
		$this->_buffer = array();
		if($this->_gearmand) {
			fputs ($this->_gearmand, $command . PHP_EOL);
			while (!feof($this->_gearmand)) {
				$l = fgets($this->_gearmand, 128);
				if ($l === '.' . PHP_EOL) {
					break;
				}
				else {
					$this->_buffer[] = $l;
				}
			}
			return true;
		}
		else {
			throw new Exception("Failed to connect to gearmand_host at " . $this->_gearmand_host);
		}
	}
 
	private function _disconnect() {
		fclose($this->_gearmand);
	}
 
 	/**
     * Destructor. Cleans up socket connection and command buffer
     * 
     * @return void 
     */
    public function __destruct() {
    	
    	// cleanup resources
    	$this->_disconnect();
    	$this->_buffer = array();
    }
}
/// startiing

//$test=new GearmanClusterAdmin(array('localhost:4730','localhost:4734'));
//$test=new GearmanClusterAdmin(array('localhost:4730'));
//print_r ($test->getAccumaltiveJobs());
//echo "displaying server workers ";
//print_r ($test->getAccumaltiveWorkers());
/*
echo "displaying server jobs ";
print_r ($test->getServersJobs());
echo "displaying server workers ";
print_r ($test->getServersWorkers());
 */
//print_r ($test->getServersWorkers());
//echo $test->getStatus();
?>
