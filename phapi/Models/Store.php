<?php

namespace Models;

use Model;

class Store extends Model {
  public function __construct() {
    parent::__construct('store');

    $this->fields = [];
    $this->fields["key"] = new Model\Fields\TextKey();
    $this->fields["value"] = new Model\Fields\Json();
  }

  public function allowDefaultService() {
    return false;
  }
}
