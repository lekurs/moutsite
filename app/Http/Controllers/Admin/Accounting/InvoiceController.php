<?php


namespace App\Http\Controllers\Admin\Accounting;


use App\Models\Estimation;
use App\Models\Invoice;
use App\Repository\EstimationDetailRepository;
use App\Repository\InvoiceRepository;
use App\Repository\TaxRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInvoice;

class InvoiceController extends Controller
{
    /**
     * @param TaxRepository $taxRepository
     * @param EstimationDetailRepository $estimationDetailRepository
     * @param InvoiceRepository $invoiceRepository
     */
    public function __construct(
        private TaxRepository $taxRepository,
        private EstimationDetailRepository $estimationDetailRepository,
        private InvoiceRepository $invoiceRepository
    ){}


    public function index()
    {
        $invoices = Invoice::with('estimation')->wherePaid(false)->paginate(15);
        $totalCurrentYear = $this->invoiceRepository->getTotalCurrentYear();
        $totalWaiting = $this->invoiceRepository->getTotalWaitingPaiment();
        $totalTwelveMonth = $this->invoiceRepository->getTotal12Month();

        return view('pages.admin.accounting.invoices.index', [
            'invoices' => $invoices,
            'totalCurrentYear' => $totalCurrentYear,
            'totalWaitingPaiment' => $totalWaiting,
            'totalTwelveMonth' => $totalTwelveMonth
        ]);
    }

    public function show(Invoice $invoice)
    {

    }

    public function create()
    {
        $estimations = Estimation::with('invoice', 'estimationDetails')->whereValidation(1)->get();

        return view('pages.admin.accounting.invoices.create', [
            'estimations' => $estimations,
        ]);
    }

    public function validation(Estimation $estimation)
    {
        $total = $this->estimationDetailRepository->getTotal($estimation);
        $taxes = $this->taxRepository->getAll();
        if(!is_null($this->invoiceRepository->getLatest())) {
            $number = intval($this->invoiceRepository->getLatest()->reference)+1;
        } else {
            $number = date('Ym') . '001';
        }

        $advances = $this->invoiceRepository->getAdvances($estimation);

        return view('pages.admin.accounting.invoices.validation', [
            'estimation' => $estimation,
            'taxes' => $taxes,
            'number' => $number,
            'total' => $total,
            'advances' => $advances,
        ]);
    }

    public function store(StoreInvoice $data, Estimation $estimation)
    {
        $this->invoiceRepository->store($data->validated(), $estimation);

        return redirect()->route('invoices.index')->with('sucess', 'Facture enregistrée');
    }

    public function edit()
    {

    }

    public function destroy()
    {

    }
}
