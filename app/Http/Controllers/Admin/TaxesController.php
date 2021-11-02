<?php


namespace App\Http\Controllers\Admin;


use App\Models\Taxe;
use App\Repository\TaxRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditTax;
use App\Http\Requests\StoreTax;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class TaxesController extends Controller
{
    private TaxRepository $taxRepository;

    /**
     * TaxesController constructor.
     * @param TaxRepository $taxRepository
     */
    public function __construct(TaxRepository $taxRepository)
    {
        $this->taxRepository = $taxRepository;
    }


    public function index(): View
    {
        $taxes = $this->taxRepository->getAll();

        return \view('pages.admin.taxes.index', [
            'taxes' => $taxes
        ]);
    }

    public function show(Taxe $taxe): View
    {
        $tax = $this->taxRepository->getOneById($taxe->id);

        return \view('pages.admin.taxes.show', [
            'tax' => $tax
        ]);
    }

    public function create()
    {
        return \view('pages.admin.taxes.create');
    }

    public function store(StoreTax $storeTax): RedirectResponse
    {
        $data = $storeTax->all();

        $this->taxRepository->store($data);

        return redirect()->route('taxes.index')->with('success', 'Taxe bien enregistrée');
    }

    public function update(EditTax $editTax, Taxe $taxe): RedirectResponse
    {
        $data = $editTax->all();

        $this->taxRepository->edit($taxe->id, $data);

        return redirect()->route('taxes.index')->with('success', 'Taxe mise à jour');
    }

    public function destroy(Taxe $taxe): RedirectResponse
    {
        $this->taxRepository->delete($taxe);

        return back()->with('success', 'Taxe bien supprimée');
    }

    public function status(Taxe $taxe)
    {
        $this->taxRepository->updateStatus($taxe);

        return back()->with('success', 'Taxe modifiée');
    }
}
