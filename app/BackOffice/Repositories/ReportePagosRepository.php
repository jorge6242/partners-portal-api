<?php

namespace App\BackOffice\Repositories;

use App\BackOffice\Models\ReportePagos;

class ReportePagosRepository  {

    public function __construct( ReportePagos $model ) {
      $this->model = $model;

    }
  
    public function all($perPage) {
        return $this->model->query()->with(['cuenta'])->paginate($perPage);
    }

    public function find($share) {
        return $this->model->where('Login', $share)->first();
    }

    public function create($attributes) {
        return $this->model->create($attributes);
      }
}