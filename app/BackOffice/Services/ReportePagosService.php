<?php

namespace App\BackOffice\Services;

use App\BackOffice\Repositories\ReportePagosRepository;

use Illuminate\Http\Request;
use Storage;
use Carbon\Carbon;


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

	public function update($request, $id) {
		return $this->repository->update($id, $request);
	  }

	public function validateFile($file) {

		$fileToParse = preg_replace('/^data:application\/\w+;base64,/', '', $file);
		$ext = explode(';', $file)[0];
		$ext = explode('/', $ext)[1];

		$find = 'data:application/vnd.openxmlformats-officedocument.wordprocessingml.document;base64,';
		$pos = strpos($file, $find);
		if($pos !== false) {
			$fileToParse = str_replace('data:application/vnd.openxmlformats-officedocument.wordprocessingml.document;base64,', '', $file);
			$ext = 'docx';
		}
		$base64File = base64_decode($fileToParse);
		
		return (object)['ext' => $ext, 'content' => $base64File];
	}

	public function create($attributes) {
		$date = Carbon::now()->format('Y-m-d');
		$attributes['dFechaRegistro'] = Carbon::now()->format('Y-m-d H:i:s');
		$data = $this->repository->create($attributes);
		if($attributes['file1'] !== null) {
			$parseFile = $this->validateFile($attributes['file1']);
			$filename = $date.'-'.$data->id.'.'.$parseFile->ext;
			$indice = rand(1,5);
			
			if($parseFile->ext === 'png' || $parseFile->ext === 'jpg' || $parseFile->ext === 'jpeg' ) {
				if($parseFile->ext === 'jpg' || $parseFile->ext === 'jpeg') {
					$filename = $date.'-'.$data->id.'.png';
				}
				\Image::make($attributes['file1'])->save(public_path('storage/reportedPayments/').$filename);
			} else {
				//Storage::disk('payments')->put($filename,$parseFile->content);
				\File::put(public_path(). '/storage/reportedPayments/' . $filename, $parseFile->content);
			}
			$attr = [ 'Archivos' => $filename, 'status' => $attributes['status']];
			$this->repository->update($data->id, $attr);
		}

		return $data;
	  }

	public function read($id) {
		return $this->repository->find($id);
	}

	public function filter($queryFilter) {
		return $this->repository->filter($queryFilter);
	}

}