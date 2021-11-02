<?php


namespace App\Http\Controllers\Admin;


use App\Models\Client;
use App\Models\Contact;
use App\Models\User;
use App\Repository\ClientRepository;
use App\Repository\ContactRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditContact;
use App\Http\Requests\StoreContact;
use App\Repository\UserRepository;
use App\Services\Uploads\UploadedFilesService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ContactController extends Controller
{
//    private ContactRepository $contactRepository;
//
//    private UploadedFilesService $uploadedFilesService;
//
//    private ClientRepository $clientRepository;
//
//    private UserRepository $userRepository;

    /**
     * ContactController constructor.
     * @param UploadedFilesService $uploadedFilesService
     * @param ClientRepository $clientRepository
     * @param UserRepository $userRepository
     */
    public function __construct(
        private UploadedFilesService $uploadedFilesService,
        private ClientRepository     $clientRepository,
        private UserRepository $userRepository
    ) {}

    public function index(Client $client)
    {
        $contacts = User::whereClientId($client->id)->get();

        return view('pages.admin.contacts.index', [
            'contacts' => $contacts
        ]);
    }

    public function show(User $user): View
    {
        return \view('pages.admin.contacts.show', [
           'user' => $user
        ]);
    }

    public function create(Client $client)
    {
        return \view('pages.admin.contacts.create', [
            'client' => $client
        ]);
    }

    public function update(EditContact $data): RedirectResponse
    {
        $user = $this->userRepository->update($data->all());

        if (isset($data['profile-img'])) {
            $this->uploadedFilesService->moveFile($data['profile-img'], 'public/images/uploads/' . $user->client->slug . '/users/' . $user->slug . '/picture');
        }

        return redirect()->route('clients.show', $user->client->slug);
    }

    /**
     * @param StoreContact $storeContact
     * @param Client $client
     * @return RedirectResponse
     */
    public function store(StoreContact $storeContact, Client $client): RedirectResponse
    {
        $oneClient = $this->clientRepository->getOneBySlug($client->slug);

        if(isset($storeContact['contact-picture']) && !is_null($storeContact['contact-picture'])) {
            $file = $storeContact['contact-picture'];

            $this->userRepository->store($storeContact->all(), $oneClient, $file);

            $this->uploadedFilesService->moveFile($file, '/public/images/uploads/' . $oneClient->slug . '/' . Str::slug($storeContact['contact-firstname'] . '-' . $storeContact['contact-lastname']) . '/picture');
        } else {
            $this->userRepository->store($storeContact->all(), $oneClient, null);

        }

        return redirect()->route('clients.show', $oneClient->slug)->with('success', 'Le contact a été ajouté');
    }

    /**
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {

        $this->userRepository->destroy($user);

        Storage::delete('public/images/uploads/' . $user->client->slug . '/' . $user->slug . '/picture');

        return redirect()->route('clients.show', $user->client->slug)->with('success', 'Contact supprimé');
    }
}
