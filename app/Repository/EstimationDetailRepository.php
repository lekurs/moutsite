<?php


namespace App\Repository;


use App\Models\Client;
use App\Models\Estimation;
use App\Models\EstimationDetail;
use App\Models\Invoice;
use App\Models\Taxe;
use Illuminate\Database\Eloquent\Builder;

class EstimationDetailRepository
{
    public function getTotal(Estimation $estimation): array
    {
        return [
            'estimation' => $estimation,
            'total_row' => EstimationDetail::whereEstimationId($estimation->id)->sum('total_row'),
            'total_row_notax' => EstimationDetail::whereEstimationId($estimation->id)->sum('total_row_notax'),
            'total_row_tax' => EstimationDetail::whereEstimationId($estimation->id)->sum('total_row_tax'),
            'invoices' => Invoice::whereEstimationId($estimation->id)->get(),
            'total_invoices' => Invoice::whereEstimationId($estimation->id)->get()->sum('amount'),
            'total_advance_invoices' => Invoice::whereEstimationId($estimation->id)->whereAdvance(true)->get()->sum('amount'),
            'total_advance_invoices_no_tax' => Invoice::whereEstimationId($estimation->id)->whereAdvance(true)->get()->sum('amount_no_tax'),
            'total_advance_invoices_tax' => Invoice::whereEstimationId($estimation->id)->whereAdvance(true)->get()->sum('amount_tax'),
        ];
    }

    public function getTotalOnThisYear(Client $client)
    {
        return [
            'total_row' => EstimationDetail::with(['estimation'], function ($q) use($client) {
                $q->whereClientId($client->id);
            })
                ->where('created_at', '>=', date('Y-m-d', strtotime('-1 years')))
                ->sum('total_row'),
        ];
    }

    public function getTotalByIdEstimation(int $id): array
    {
        return [
            'total_row' => EstimationDetail::whereEstimationId($id)->sum('total_row'),
            'total_row_notax' => EstimationDetail::whereEstimationId($id)->sum('total_row_notax'),
            'total_row_tax' => EstimationDetail::whereEstimationId($id)->sum('total_row_tax'),
        ];
    }

    public function update(array $data)
    {
        $detail = EstimationDetail::whereId($data['detail_id'])->first();
        $detail->product = $data['product'];
        $detail->description = $data['description'];
        $detail->quantity = $data['quantity'];
        $detail->unit_price = $data['price'];
        $detail->taxe_id = $data['tax'];

        //ici faire le calcul
        $tax = Taxe::whereId($data['tax'])->first();
        $detail->total_row_notax = $data['quantity'] * $data['price'];
        $detail->total_row_tax = ($data['quantity'] * $data['price']) * ($tax->tax / 100);
        $detail->total_row = $detail->total_row_notax + $detail->total_row_tax;

        $detail->save();

    }
}
