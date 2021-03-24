<?php

namespace Phapi\Model\Fields;

abstract class Field {
  private bool $private = false;
  private bool $readonly = false;
  private bool $required = false;
  private bool $auto = false;
  private $field = null;
  private $defaultValue;

  public function __construct(array $data = null) {
    if (!$data) return;
    if (isset($data["private"])) $this->private = $data["private"];
    if (isset($data["readonly"])) $this->readonly = $data["readonly"];
    if (isset($data["required"])) $this->required = $data["required"];
    if (isset($data["field"])) $this->field = $data["field"];
    if (isset($data["auto"])) $this->auto = $data["auto"];
    if (isset($data["default"])) $this->defaultValue = $data["default"];
    else $this->defaultValue = IgnoreField::instance();
  }

  public function getSQLType() {
    return null;
  }

  public function getFieldName($default) {
    return $this->field == null ? $default : $this->field;
  }

  public function isPrivate() {
    return $this->private;
  }

  public function isAuto() {
    return $this->auto;
  }

  public function isReadonly() {
    return $this->readonly;
  }

  public function isRequired() {
    return $this->required;
  }

  public function forceUpdate() {
    return false;
  }

  public function getDefault() {
    return $this->defaultValue;
  }

  public function onSave($value) {
    return $value;
  }

  public function onLoad($value, $key, $assoc, $populates) {
    return $value;
  }

  public function preUpdate($value, $key, $entity) {
  }

  public function postUpdate($value, $key, $entity) {
  }

  public function getSanitizedValue($value) {
    if ($this->isPrivate()) return IgnoreField::instance();
    return $value;
  }

  public function isVirtual() {
    return false;
  }

  public function getFilter($fieldName, $prefix, $memberName, $sql_mode) {
    return null;
  }

  public function isJoinable() {
    return false;
  }

  public function isDefaultPopulated() {
    return false;
  }

  public function getUiInfo() {
    return [
      "type" => "text",
      "private" => $this->isPrivate(),
      "required" => $this->isRequired(),
      "readonly" => $this->isReadonly(),
      "auto" => $this->isAuto(),
      "default" => $this->getDefault(),
    ];
  }
}
