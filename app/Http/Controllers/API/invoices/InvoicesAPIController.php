<?php

namespace App\Http\Controllers\API\invoices;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Collection;
use stdClass;

class InvoicesAPIController extends Controller
{
    protected function createData(Collection $data) {
        $byMonth = [];

        foreach($data as $dataByMonth) {
            $byMonth[intval($dataByMonth['month'])] = array_sum((array) $dataByMonth->amount);
        }


        for ($i = 1; $i<=12; $i++) {
            if (!isset($byMonth[$i])) {
                $byMonth[$i] = 0;
            }
        }

        ksort($byMonth, SORT_NATURAL);

        $values = array_values($byMonth);

        return $values;
    }

    protected function createSerie(string $name, array $data) {
        $o = new stdClass();
        $o->name = $name;
        $o->data = $data;

        return $o;
    }

    public function show()
    {
        $invoicesByMonth = $this->createData(Invoice::where('year', date('Y'))->wherePaid(true)->get());
        $invoicesNoPaid = $this->createData(Invoice::wherePaid(false)->where('year', date('Y'))->get());

        $json = [
            $this->createSerie('factures', $invoicesByMonth),
            $this->createSerie('factures impayées', $invoicesNoPaid)
        ];

        return json_encode($json);
    }
}
