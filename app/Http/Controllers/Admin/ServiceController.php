<?php


namespace App\Http\Controllers\Admin;


use App\Models\Service;
use App\Repository\ServiceRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ServiceController extends Controller
{
    private ServiceRepository $serviceRepository;

    /**
     * ServiceController constructor.
     * @param ServiceRepository $serviceRepository
     */
    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }


    public function index(): View
    {
        $services = $this->serviceRepository->getAll();

        return view('pages.admin.services.index', [
            'services' => $services
        ]);
    }

    public function show(Service $service)
    {
        $oneService = $this->serviceRepository->getone($service->id);

        return \view('pages.admin.services.show', [
           'service' => $oneService
        ]);
    }

    public function store(StoreService $storeService): RedirectResponse
    {
        $this->serviceRepository->store($storeService->all());

        return redirect()->route('services.index')->with('success', 'La nouvelle prestation a été ajoutée');
    }

    public function edit(Service $service): View
    {
        $oneService = $this->serviceRepository->getone($service->id);

        return \view('pages.admin.services.edit', [
            'service' => $oneService
        ]);
    }

    public function update(StoreService $storeService): RedirectResponse
    {
        $this->serviceRepository->store($storeService->all());

        return redirect()->route('services.index')->with('success', 'Prestation mise à jour');
    }

    public function destroy(Service $service)
    {
        $this->serviceRepository->destroy($service);

        return back()->with('success', 'Prestation bien supprimée');
    }

    public function status(Service $service)
    {
        $this->serviceRepository->updateStatus($service->id);

        return back()->with('success', 'Status mis à jour');
    }
}
