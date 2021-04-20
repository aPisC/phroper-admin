<?php

namespace Phapi\Model\Fields;

use Phapi;

abstract class Relation extends Field {
  protected $relationModel = null;

  public function __construct($model, array $data = null) {
    parent::__construct($data);
    $this->relationModel = $model;
  }

  public function getModel() {
    return Phapi::model($this->relationModel);
  }

  public function isDefaultPopulated() {
    return true;
  }
}
