<?php

function processSendQueue($socket, $sendQueue) { 
  while (!$sendQueue->isEmpty()) { 
    //shift() is the same as dequeue() 
    $senditem = $sendQueue->shift(); 

    //returns the number of bytes written. 
    $rtn = socket_write($socket, $senditem); 
    if ($rtn === false) { 
      $sendQueue->unshift($senditem); 
      throw new exception("send error: " . socket_last_error($socket)); 
      return; 
    } 
    if ($rtn < strlen($senditem) { 
        $sendQueue->unshift(substr($senditem, $rtn); 
          break; 
          } 
        } 
      } 
          $q = new SplQueue();
          $q->push(1);
          $q->push(2);
          $q->push(3);
          $q->pop();
          print_r($q);


?>
