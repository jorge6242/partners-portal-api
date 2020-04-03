<?php

namespace App\BackOffice\Services;

use App\BackOffice\Repositories\ReportePagosRepository;
use Illuminate\Http\Request;

class ReportePagosService {

	public function __construct(ReportePagosRepository $repository) {
		$this->repository = $repository ;
	}

	public function index($pagination) {
		return $this->repository->all($pagination);
    }
    
    public function find($share) {
		return $this->repository->find($share);
	}

	public function create($attributes) {
		return $this->repository->create($attributes);
	  }

}