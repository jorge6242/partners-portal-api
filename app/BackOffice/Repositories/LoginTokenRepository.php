<?php

namespace App\BackOffice\Repositories;

use App\BackOffice\Models\LoginToken;

class LoginTokenRepository  {
  
    protected $post;

    public function __construct( LoginToken $model ) {
      $this->model = $model;

    }
  
    public function all() {
      return $this->model->all();
    }

    public function find($share) {
        return $this->model->where('Login', $share)->first();
    }
}