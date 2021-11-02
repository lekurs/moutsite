<?php


namespace App\Repository;


use App\Models\Client;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ContactRepository
{
    public function getOneBySlug(string $contactSlug): Contact
    {
        return Contact::whereSlug($contactSlug)->first();
    }

    public function getAllByClient(Client $client): Collection
    {
        return Contact::whereClientId($client->id)->get();
    }

    public function getOneBySlugWithClient(string $contactSlug): Contact
    {
        return Contact::with('client')->whereSlug($contactSlug)->first();
    }

    public function store(array $dataContacts, Client $client, UploadedFile $file = null): void
    {
        if(isset($dataContacts['contact-slug']) && !is_null($dataContacts['contact-slug'])) {
            $contact = $this->getOneBySlug($dataContacts['contactSlug']);
        } else {
            $contact = new Contact();
        }

        $contact->name = $dataContacts['contact-firstname'];
        $contact->lastname = $dataContacts['contact-lastname'];
        $contact->email = $dataContacts['contact-email'];
        $contact->phone = $dataContacts['contact-phone'];
        $contact->contact_function = $dataContacts['contact-function'];
        if(!is_null($file)) {
            $contact->picture_path = $file->getClientOriginalName();
        }
        $contact->slug = Str::slug($dataContacts['contact-firstname'] . '-' . $dataContacts['contact-lastname']);
        $contact->client_id = $client->id;

        $contact->save();
    }

    public function edit(array $data)
    {
        $contact = $this->getOneBySlug($data['contact-slug']);

        if ($data['contact-name'] != $contact->name || $data['contact-lastname'] != $contact->lastname) {

            if (!isset($data['contact-picture']) and !is_null($contact->picture_path)) {
                Storage::move('public/images/uploads/' . $contact->client->slug . '/' . $contact->slug . '/picture', 'public/images/uploads/' . $contact->client->slug . '/' . Str::slug($data['contact-name'] . '-' . $contact->lastname) . '/picture');
            }

            if(isset($data['contact-picture']) and !is_null($contact->picture_path)) {
                $contact->picture_path = $data['contact-picture']->getClientOriginalName();
            }
        }

        $contact->name = $data['contact-name'];
        $contact->lastname = $data['contact-lastname'];
        $contact->email = $data['contact-email'];
        $contact->phone = $data['contact-phone'];
        $contact->contact_function = $data['contact-function'];
        $contact->slug = Str::slug($data['contact-name'] . '-' . $contact->lastname);

        if(isset($data['contact-picture'])) {
            $contact->picture_path = $data['contact-picture']->getClientOriginalName();
        }

        $contact->save();

        return $contact;
    }

    public function delete(Contact $contact): void
    {
        $contact->delete();
    }
}
