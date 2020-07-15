<?php

namespace App\BackOffice\Repositories;

use App\BackOffice\Models\ReportePagos;

class ReportePagosRepository  {

    public function __construct( ReportePagos $model ) {
      $this->model = $model;

    }
  
    public function all($perPage) {
        $payments = $this->model->query()->with(['cuenta','bancoOrigen'])->paginate($perPage);
        foreach ($payments as $key => $value) {
          if($value->Archivos !== null) {
            $payments[$key]->Archivos = url('storage/partners/'.$value->Archivos);
          }
        }
        return $payments;
    }

    public function find($id) {
        return $this->model->where('idPago', $id)->first();
    }

    public function create($attributes) {
        return $this->model->create($attributes);
      }

    public function update($id, array $attributes) {
        $user = auth()->user()->username;
        if($attributes['status'] == 1) {
          return \DB::connection('sqlsrv_backoffice')->statement('exec sp_PortalProcesarPago ?', array($id));
        }
        return $this->model->where('idPago', $id)->update($attributes);
    }

    public function filter($queryFilter) {
      $searchQuery = $queryFilter;
      $search = $this->model->query()->where(function($q) use($searchQuery) {
        if ($searchQuery->query('banco') !== NULL) {
          $query = $searchQuery->query('banco');
          $q->whereHas('bancoOrigen', function($qr) use ($query) {
            $qr->where('cNombreBanco', 'like', "%{$query}%");
          });
        }
        if ($searchQuery->query('status') !== NULL) {
          $q->where('status', $searchQuery->query('status'));
        }

        if ($searchQuery->query('referencia') !== NULL) {
          $q->where('NroReferencia', 'like', "%{$searchQuery->query('referencia')}%");
        }

        if ($searchQuery->query('bancoDestino') !== NULL) {
          $q->where('codCuentaDestino', $searchQuery->query('bancoDestino'));
        }

        if ($searchQuery->query('accion') !== NULL) {
          $q->where('Login', 'like', "%{$searchQuery->query('accion')}%");
        }
      })->with(['cuenta','bancoOrigen'])->paginate($searchQuery->query('perPage'));

      foreach ($search as $key => $value) {
        if($value->Archivos !== '') {
          $search[$key]->Archivos = url('storage/partners/'.$value->Archivos);
        } else {
          $value->Archivos = null;
        }
      }

      return $search;
    }
}