<?php

namespace App\BackOffice\Repositories;

use App\BackOffice\Models\BancoReceptor;

class BancoReceptorRepository  {
  
    protected $post;

    public function __construct( BancoReceptor $model ) {
      $this->model = $model;

    }
    
    public function find($id) {
      return $this->model->find($id);
    }
  
    public function all() {
      return $this->model->all();
    }
}