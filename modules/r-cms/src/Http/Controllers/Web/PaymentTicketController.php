<?php

namespace RSolution\RCms\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RSolution\RCms\Repositories\PaymentTicketRepository;

class PaymentTicketController extends Controller
{
    const PAGE_LIMIT = 20;

    private $paymentTicketRepository;


    public function __construct()
    {
        $this->paymentTicketRepository = new PaymentTicketRepository;
    }

    public function index(request $request)
    {
        $data = $this->paymentTicketRepository->filter($request);

        return view('rcms::pages.payment_ticket.index', ['data' => $data]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);

        return redirect()->back()->with(['success' => 'Thành công']);
    }

    public function show($id)
    {
        $data = $this->paymentTicketRepository->find($id);

        return view('rcms::pages.payment_ticket.detail', ['data' => $data]);
    }

    public function destroy($id)
    {
        $this->paymentTicketRepository->delete($id);
        return redirect()->route('rcms.payment-ticket.index');
    }

    public function update($id)
    {
        $this->paymentTicketRepository->approve(Auth::user(), $id);
        return redirect()->back();
    }
}
