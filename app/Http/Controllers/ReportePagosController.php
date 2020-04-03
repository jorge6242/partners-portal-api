<?php

namespace App\Http\Controllers;

use App\BackOffice\Services\ReportePagosService;

use Illuminate\Http\Request;

class ReportePagosController extends Controller
{
    public function __construct(ReportePagosService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll(Request $request)
    {
        $DATA = $this->service->index($request->query('perPage'));
        return response()->json([
            'success' => true,
            'data' => $DATA
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = $request->all();
        $data = $this->service->create($data, $request);
        return $data;
    }
}
