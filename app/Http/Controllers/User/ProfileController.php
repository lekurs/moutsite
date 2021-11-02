<?php


namespace App\Http\Controllers\User;


use App\Repository\UserRepository;
use App\Events\ResizeUploadedFile;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditProfileRequest;
use App\Services\Uploads\UploadedFilesService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    private UserRepository $userRepository;

    private UploadedFilesService $uploadedFilesService;

    /**
     * ProfileController constructor.
     * @param UserRepository $userRepository
     * @param UploadedFilesService $uploadedFilesService
     */
    public function __construct(UserRepository $userRepository, UploadedFilesService $uploadedFilesService)
    {
        $this->userRepository = $userRepository;
        $this->uploadedFilesService = $uploadedFilesService;
    }


    public function show(): View
    {
        return \view('pages.admin.users.show');
    }

    public function update(EditProfileRequest $request)
    {
        $validated = collect($request->validated());

        $user = $this->userRepository->getOne($validated->get('profile-id'));

        if ($this->userRepository->edit($request->validated())) {
            if ($request->hasFile('profile-img')) {
                $uploadedFile = $validated->get('profile-img')->storeAs('/public/images/uploads/profiles/img', $request['profile-img']->getClientOriginalName());
                $extension = $validated->get('profile-img')->extension();

                $from = '/public/images/uploads/profiles/img' . $user->profile_team_id . '/' . $request['profile-img']->getClientOriginalName();
                $destination = '/public/images/uploads/profiles/img' . $user->profile_team_id . '/' .uniqid() . '-' . $user->name . '.' . $extension;

                Storage::copy($from, $destination);

                ResizeUploadedFile::dispatch(Storage::path($destination));
            }

            $this->userRepository->edit($request->validated());

            return back()->with('success', 'Profil mis à jour');
        } else {
            return back()->with('error', 'Erreur, merci de vérifier les champs');
        }
    }
}
