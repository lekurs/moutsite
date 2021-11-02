<?php


namespace App\Repository;


use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UserRepository
{
    public function getAll(): Collection
    {
        return User::all();
    }

    public function getOne($id): User
    {
        return User::whereId($id)->first();
    }

    public function getOneBySlug(User $user): User
    {
        return User::WhereSlug($user->slug)->first();
    }

    public function store(array $dataContacts, Client $client, UploadedFile $file = null): void
    {
        if(isset($dataContacts['contact-slug']) && !is_null($dataContacts['contact-slug'])) {
            $user = $this->getOneBySlug($dataContacts['contactSlug']);
        } else {
            $user = new User();
        }

        $user->name = $dataContacts['contact-firstname'];
        $user->lastname = $dataContacts['contact-lastname'];
        $user->email = $dataContacts['contact-email'];
        $user->password = Hash::make('123456');
        $user->phone = $dataContacts['contact-phone'];
        $user->post_fonction = $dataContacts['contact-function'];
        if(!is_null($file)) {
            $user->avatar = $file->getClientOriginalName();
        }
        $user->slug = Str::slug($dataContacts['contact-firstname'] . '-' . $dataContacts['contact-lastname']);
        $user->client_id = $client->id;

        $user->save();
    }

    public function edit(array $data): bool
    {
        if (!is_null($data['profile-id'])) {
            $user = $this->getOne($data['profile-id']);
            $name = $user->name;
            $lastname = $user->lastname;
            $email = $user->email;

            if (!is_null($data['profile-name'])) {
                if ($name != $data['profile-name']) {
                    $name = $data['profile-name'];
                }
                $user->name = $data['profile-name'];
            }

            if (!is_null($data['profile-lastname'])) {
                if ($lastname != $data['profile-lastname']) {
                    $lastname = $data['profile-lastname'];
                }
                $user->lastName = $data['profile-lastname'];
            }

            if (!is_null($data['profile-email'])) {
                if ($email != $data['profile-email']) {
                    $email = $data['profile-email'];
                }
                $user->email = $data['profile-email'];
            }

            if (isset($data['profile-password']) && !is_null($data['profile-password'])) {
                $user->password = Hash::make($data['profile-password']);
            }

            if (isset($data['profile-img'])) {
                $user->avatar = $data['profile-img']->getClientOriginalName();
            }

            if (!is_null($data['profile-name']) || !is_null($data['profile-lastname'])) {
                $user->slug = Str::slug($name . '-' . $lastname);
            }

            $user->save();

            return true;
        }

        return false;
    }

    /**
     * @param array $data
     * @return User
     */
    public function update(array $data): User
    {
        if (!is_null($data['profile-id'])) {
            $user = $this->getOne($data['profile-id']);
            $name = $user->name;
            $lastname = $user->lastname;
            $email = $user->email;

            if (!is_null($data['profile-name'])) {
                if ($name != $data['profile-name']) {
                    $name = $data['profile-name'];
                }
                $user->name = $data['profile-name'];
            }

            if (!is_null($data['profile-lastname'])) {
                if ($lastname != $data['profile-lastname']) {
                    $lastname = $data['profile-lastname'];
                }
                $user->lastName = $data['profile-lastname'];
            }

            if (!is_null($data['profile-email'])) {
                if ($email != $data['profile-email']) {
                    $email = $data['profile-email'];
                }
                $user->email = $data['profile-email'];
            }

            if (isset($data['profile-password']) && !is_null($data['profile-password'])) {
                $user->password = Hash::make($data['profile-password']);
            }

            if (isset($data['profile-img'])) {
                $user->avatar = $data['profile-img']->getClientOriginalName();
            }

            if(isset($data['profile-phone'])) {
                $user->phone = $data['profile-phone'];
            }

            if (!is_null($data['profile-name']) || !is_null($data['profile-lastname'])) {
                $user->slug = Str::slug($name . '-' . $lastname);
            }

            if(!is_null($data['profile-fonction'])) {
                $user->post_fonction = $data['profile-fonction'];
            }

            $user->save();

            return $user;
        }
    }

    public function destroy(User $user): void
    {
        $user->delete();
    }
}
