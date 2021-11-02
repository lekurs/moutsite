<?php


namespace App\Repository;


use App\Models\Client;
use App\Models\Estimation;
use App\Models\EstimationDetail;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class EstimationRepository
{
    public function getAll(): Collection
    {
        return Estimation::all();
    }

    public function getAllByClient(Client $client): Collection
    {
        return Estimation::with('clients')->whereClientId($client->id)->get();
    }

    public function getAllGroupByClient()
    {
        return Estimation::with(['client', 'estimationDetails'])->whereInProgress(1)->get()->groupBy('client.name');
    }

    public function getLatest(): ?Estimation
    {
        return Estimation::latest()->first();
    }

    public function getOneWithAllRelationsById(string $id): ?Estimation
    {
        return Estimation::with(['client', 'user', 'estimationDetails'])->whereId($id)->first();
    }

    public function editTitle(array $data, Estimation $estimation): void
    {
        $estimation->title = $data['title'];
        $estimation->save();
    }

    public function editContact(array $data, Estimation $estimation): void
    {
        $estimation->contact_id = $data['contact_id'];
        $estimation->save();
    }

    public function getTotalEstimationDetails(Estimation $estimation)
    {
        $total = 0;

        foreach ($estimation->estimationDetails as $detail) {
            $total += $detail->total_row_notax;
        }

        return $total;
    }

    public function store(array $data, Client $client, User $contact)
    {
        $estimation = new Estimation();
        $estimation->reference = $data['estimation-reference'];
        $estimation->validation_duration = $data['validation-duration-estimation'];
        $estimation->user_id = $contact->id;
        $estimation->title = $data['estimation-title'];
        $estimation->year = date('Y');
        $estimation->month = date('m');
        $estimation->client_id = $client->id;
        $estimation->contact_validator_id = $contact->id;

        $estimation->save();

        $id = $estimation->id;

        foreach($data['estimation-service'] as $service) {
            $estimation->EstimationsSkills()->sync($service, false);
        }

        foreach($data['outer-group'] as $repeatables) {
            foreach($repeatables['inner-group'] as $key => $product) {
                $detail = new EstimationDetail();
                $detail->estimation_id = $id;
                $detail->product = $product['estimation-product'];
                $detail->description = $product['product-detail'];
                $detail->quantity = $product['estimation-quantity'];
                $detail->unit_price = $product['estimation-price'];
                $detail->total_row_notax = $product['total-no-tax'];
                $detail->total_row_tax = $product['total-tax'];
                $detail->total_row = $product['total'];
                $detail->taxe_id = $product['tax-estimation'];
                $detail->display_order = $key;
                $detail->save();
            }
        }
    }

    public function destroy(Estimation $estimation)
    {
        $estimation->load('estimationDetails');
        $estimation->estimationDetails()->delete();
        $estimation->delete();
    }
}
