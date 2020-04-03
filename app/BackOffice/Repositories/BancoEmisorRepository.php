<?php

namespace App\BackOffice\Repositories;

use App\BackOffice\Models\BancoEmisor;

class BancoEmisorRepository  {
  
    protected $post;

    public function __construct( BancoEmisor $model ) {
      $this->model = $model;

    }
    
    public function find($id) {
      return $this->model->find($id);
    }
  
    public function all() {
      return $this->model->all();
    }
}