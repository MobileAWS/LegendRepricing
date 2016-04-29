<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 


// This library class adds MySQL proprietary functionality on top
// of CodeIgniter's native DB and Active Record class.

class Db_mysql {


  var $insert_clause  = NULL;
  var $insert_style = NULL;
  var $update_subset    = Array();


  public function __construct()
  {
  }


  /**
   * Resets the active record "write" values.
   * Called by the insert() update() insert_batch() update_batch() and delete() functions
   * @return  void
   */
  protected function _reset_write()
  {
    $this->_reset_run(
      array(
        'insert_clause' => NULL,
        'insert_style'  => NULL,
        'update_subset' => Array()
      ),
      array(
        'ar_set'      => array(),
        'ar_from'     => array(),
        'ar_where'        => array(),
        'ar_like'     => array(),
        'ar_orderby'  => array(),
        'ar_keys'     => array(),
        'ar_limit'        => FALSE,
        'ar_order'        => FALSE
      ));
  }

  /**
   * Resets the active record values.  Have to manually reset CI
   * ActiveRecord fields as well, since their _reset_run function is protected.
   *
   * @param array   An array of our fields to reset
   * @param   array   An array of CodeIgniter ActiveRecord fields to reset
   * @return    void
   */
  protected function _reset_run($our_items,$ar_reset_items)
  {
    // Reset our values
    foreach($our_items as $item => $default_value)
      $this->$item = $default_value;

    // Reset the codeIgniter values
    $CI =& get_instance();
    foreach($ar_reset_items as $item => $default_value)
      if(!in_array($item, $CI->db->ar_store_array))
        $CI->db->$item = $default_value;
  }




  // TODO: allow escaping of column names to enable counter functions.
  public function on_duplicate_key_update($update_subset=NULL)
  {
    $this->insert_clause = 'on_duplicate_key_update';

    if($update_subset)
    {
      if(is_string($update_subset))
        $update_subset = explode(',', $update_subset);

      foreach($update_subset as $val)
      {
        $val = trim($val);

        if ($val != '')
          $this->update_subset[] = $val;
      }
    }

    return $this;
  }


  public function on_duplicate_key_ignore()
  {
    $this->insert_clause = 'on_duplicate_key_ignore';

    return $this;
  }






  function insert($table = '', $set = NULL)
  {
    $CI =& get_instance();

    if (!is_null($set))
      $CI->db->set($set);

    if (count($CI->db->ar_set) == 0)
    {
      if ($CI->db->db_debug)
        return $CI->db->display_error('db_must_use_set');

      return FALSE;
    }

    $sql = $CI->db->_insert($CI->db->_protect_identifiers($table, TRUE, NULL, FALSE), array_keys($CI->db->ar_set), array_values($CI->db->ar_set));

    if($this->insert_clause)
    {
      $function = '_'.$this->insert_clause.'_clause';
      $sql .= $this->$function($CI->db->_protect_identifiers($table, TRUE, NULL, FALSE), array_keys($CI->db->ar_set), array_values($CI->db->ar_set));
    }

    $this->_reset_write();
    return $CI->db->query($sql);
  }


  public function insert_batch($table ='', $set = NULL)
  {
    $CI =& get_instance();

    if( ! is_null($set))
      $CI->db->set_insert_batch($set);

    if(count($CI->db->ar_set) == 0)
    {
      if($CI->db->db_debug)
        return $CI->display_error('db_must_use_set');

      return FALSE;
    }

    // Batch this baby
    for($i = 0, $total = count($CI->db->ar_set); $i < $total; $i = $i + 100)
    {
      $function = '_insert'.$this->insert_style.'_batch';

      $sql = $CI->db->_insert_batch($CI->db->_protect_identifiers($table, TRUE, NULL, FALSE), $CI->db->ar_keys, array_slice($CI->db->ar_set, $i, 100));

      if($this->insert_clause)
      {
        $function = '_'.$this->insert_clause.'_clause';
        $sql .= $this->$function($CI->db->_protect_identifiers($table, TRUE, NULL, FALSE), $CI->db->ar_keys, array_slice($CI->db->ar_set, $i, 100));
      }

      $CI->db->query($sql);
    }

    $this->_reset_write();
  }







  protected function _on_duplicate_key_update_clause($table, $keys, $values)
  {
    // TODO: On duplicate key update is often used for counters or to otherwise
    // modify values.  Replace $modify_subset with something more robust for
    // defining what to do ... need to put somet thought into this.

    foreach($keys as $key)
    {
      $keyunescaped = trim($key,'`'); // This is sloppy?
      if(!count($this->update_subset) OR in_array($keyunescaped,$this->update_subset))
        $update_fields[] = $key.'=VALUES('.$key.')';
    }

    if(isset($update_fields))
      return ' ON DUPLICATE KEY UPDATE '.implode(', ', $update_fields);
  }




  protected function _on_duplicate_key_ignore_clause($table, $keys, $values)
  {
    /* return ' ON DUPLICATE KEY IGNORE'; */
    // Apparently this doesn't exist? Or is malformed?

    // My research tells me that doing a meaningless tautology
    // will get it ignored by the MySQL optimizer, thus accomplishing the same.
    foreach($keys as $key)
    {
      $key_tautology = $key.'='.$key;
      break;
    }

    return ' ON DUPLICATE KEY UPDATE '.$key_tautology;
  }





}

