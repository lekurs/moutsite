<?php


namespace App\Http\Controllers\Admin\Accounting;


use App\Models\Client;
use App\Models\Estimation;
use App\Models\User;
use App\Repository\ClientRepository;
use App\Repository\EstimationDetailRepository;
use App\Repository\EstimationRepository;
use App\Repository\SkillRepository;
use App\Repository\TaxRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEstimation;
use Illuminate\Contracts\View\View;

class EstimationController extends Controller
{
    /**
     * EstimationController constructor.
     *
     * @param EstimationRepository $estimationRepository
     * @param ClientRepository $clientRepository
     * @param TaxRepository $taxRepository
     * @param SkillRepository $skillRepository
     * @param EstimationDetailRepository $estimationDetailRepository
     */
    public function __construct(
        private EstimationRepository $estimationRepository,
        private ClientRepository $clientRepository,
        private TaxRepository $taxRepository,
        private SkillRepository $skillRepository,
        private EstimationDetailRepository $estimationDetailRepository
    ) {}

    public function index(): View
    {
        $clients = $this->estimationRepository->getAllGroupByClient();

        return \view('pages.admin.accounting.estimations.index', [
            'clients' => $clients
        ]);
    }

    public function show(Client $client, Estimation $estimation): View
    {
        $oneEstimation = $this->estimationRepository->getOneWithAllRelationsById($estimation->id);
        $taxes = $this->taxRepository->getAll();
        $total = $this->estimationDetailRepository->getTotal($estimation);

        return  \view('pages.admin.accounting.estimations.show', [
            'estimation' => $oneEstimation,
            'taxes' => $taxes,
            'total' => $total
        ]);
    }

    public function create()
    {
        $skills = $this->skillRepository->getAll();

        $taxes = $this->taxRepository->getAll();

        $clients = $this->clientRepository->getAll();

        if(!is_null($this->estimationRepository->getLatest())) {
            $number = intval($this->estimationRepository->getLatest()->reference)+1;
        } else {
            $number = date('Ym') . '001';
        }

        return view('pages.admin.accounting.estimations.create', [
            'skills' => $skills,
            'taxes' => $taxes,
            'number' => $number,
            'clients' => $clients
        ]);
    }

    public function store(StoreEstimation $storeEstimation)
    {
        $data = $storeEstimation->all();

        $client = $this->clientRepository->getOneById($data['client-estimation']);
        $contact = User::whereId($data['estimation-contact'])->first();

        $this->estimationRepository->store($data, $client, $contact);

        return redirect()->route('clients.show', $client->slug)->with('success', 'Devis créé');
    }

    public function destroy(Client $client, Estimation $estimation)
    {
        $this->estimationRepository->destroy($estimation);

        return redirect()->route('clients.show', $client->slug)->with('success', 'Votre devis à bien été supprimé');
    }

    public function editDetail()
    {
        $data = request()->all();

        $this->estimationDetailRepository->update($data);

        return back()->with('success', 'Devis mis à jour');
    }

    public function editTitle(Estimation $estimation)
    {
        $this->estimationRepository->editTitle(request()->all(), $estimation);

        return back()->with('success', 'Intitulé du devis mis à jour');
    }

    public function editContact(Estimation $estimation)
    {
        $this->estimationRepository->editContact(request()->all(), $estimation);

        return back()->with('success', 'Votre contact à été mis à jour');
    }
}
