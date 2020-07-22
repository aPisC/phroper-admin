<?php 
namespace Models;
use Model;

class Role extends Model{
  public function __construct() {    
    parent::__construct('role');

    $this->fields['name'] = array(
      'type' => 'text',
      'sqltype' => 'VARCHAR(100)',
    );
    $this->fields['users'] = array(
      'type' => 'relation',
      'model' => 'User',
      'via' => 'role',
    );
  }

  public function allowDefaultService()
  {
    return true;
  }
}