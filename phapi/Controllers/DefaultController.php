<?php

namespace Controllers;

use Exception;
use Phapi;
use Phapi\Controller;
use Phapi\Service;

class DefaultController extends Controller {
  protected Service $service;
  protected string $serviceName;

  public function __construct($serviceName = null) {
    if (!$serviceName)
      throw new Exception("Using defaultController without service is not allowed.");
    parent::__construct();

    // Initilalize model
    $this->serviceName = $serviceName;
    $service = Phapi::service($serviceName);
    if ($service == null || !$service->allowDefaultController())
      throw new Exception('Service ' . $serviceName . ' is not available.');
    $this->service = $service;

    // register handler functions
    $this->registerJsonHandler(':id', function ($p, $next) {
      if (!is_numeric($p['id'])) $next();
      return $this->findOne($p);
    }, 'GET');
    $this->registerJsonHandler(':id', function ($p, $next) {
      if (!is_numeric($p['id'])) $next();
      return $this->update($p);
    }, 'PUT');
    $this->registerJsonHandler(':id', function ($p, $next) {
      if (!is_numeric($p['id'])) $next();
      return $this->delete($p);
    }, 'DELETE');
    $this->registerJsonHandler(null, function ($p) {
      return $this->create();
    }, 'POST');
    $this->registerJsonHandler(null, function () {
      return  $this->find();
    }, 'GET');
    $this->registerJsonHandler('count', function ($p) {
      return $this->count($p);
    }, 'GET');
  }

  public function getName() {
    if (parent::getName() === "defaultcontroller")
      return $this->service->getName();
    return parent::getName();
  }

  public function findOne($params) {
    return $this->service->findOne(["id" => $params['id']]);
  }

  public function find() {
    $data = json_load_body();
    return $this->service->find($data);
  }

  public function create() {
    $data = json_load_body();
    return $this->service->create($data);
  }

  public function update($params) {
    $data = json_load_body();
    return $this->service->update(["id" => $params['id']], $data);
  }

  public function delete($params) {
    return $this->service->delete(["id" => $params['id']]);
  }

  public function count($params) {
    return $this->service->count(null);
  }
}
