<?php

namespace RSolution\RCms\Http\Controllers\Api;

use RSolution\RCms\Repositories\InvoiceRepository;

class InvoiceController extends ApiController
{
    private $invoiceRepository;

    public function __construct()
    {
        $this->invoiceRepository = new InvoiceRepository;
    }

    public function index()
    {
        return response()->json([
            'status' => 200,
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'status' => 200,
            'data' => $this->invoiceRepository->retrieveInvoice($id)
        ]);
    }
}
