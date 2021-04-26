<?php

namespace Phroper\Controllers;

use Error;
use Exception;
use Phroper\Controller;
use Phroper\Phroper;
use Throwable;

class Init extends Controller {
  private function initModel($modelName) {
    try {
      echo "[" . $modelName . "]\n";
      $model = Phroper::model($modelName);
      if ($model->init()) echo "done\n\n";
      else echo "already initialized \n\n";
    } catch (Throwable $ex) {
      echo $ex;
      echo "\n\n";
    }
  }

  public function __construct() {
    parent::__construct();

    $this->router->add("all", function ($params, $next) {
      $list = Phroper::getCachedTypes();
      foreach ($list as $model) {
        if (!str_starts_with($model, "Models\\")) continue;
        $this->initModel(substr($model, 7));
      }
      if (is_dir(Phroper::dir("Models"))) {
        foreach (scandir(Phroper::dir("Models")) as $file) {
          if (substr($file, 0, 1) == ".") continue;
          if (is_dir($file)) continue;
          if (str_ends_with($file, ".php"))
            $this->initModel(basename($file, ".php"));
          if (str_ends_with($file, ".json"))
            $this->initModel(basename($file, ".json"));
        }
      }
    }, "GET");

    $this->router->add(":model", function ($params, $next) {
      $this->initModel($params["model"]);
    }, "GET", -1);
  }
}