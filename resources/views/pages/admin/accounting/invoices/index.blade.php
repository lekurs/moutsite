@extends('layouts.master')

@section('title') @lang('translation.Wallet') @endsection

@section('css')
    <!-- DataTables -->
    <link href="{{ asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Facturation @endslot
        @slot('title') Facturation @endslot
    @endcomponent
<div class="row">
    <div class="col-xl-12">
        <div class="row">
            <div class="col-sm-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="media">
                            <div class="me-3 align-self-center">
                                <i class="fal fa-money-bill h2 text-warning mb-0"></i>
                            </div>
                            <div class="media-body">
                                <p class="text-muted mb-2">Factures {{ date('Y') }}</p>
                                <h5 class="mb-0">{{ $totalCurrentYear }} € </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="media">
                            <div class="me-3 align-self-center">
                                <i class="fal fa-money-bill h2 text-primary mb-0"></i>
                            </div>
                            <div class="media-body">
                                <p class="text-muted mb-2">Factures 12 mois glissants</p>
                                <h5 class="mb-0">{{ $totalTwelveMonth }} €
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="media">
                            <div class="me-3 align-self-center">
                                <i class="fal fa-money-bill h2 text-danger mb-0"></i>
                            </div>
                            <div class="media-body">
                                <p class="text-muted mb-2">Factures impayées</p>
                                <h5 class="mb-0">{{ $totalWaitingPaiment }} €
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-3">Overview</h4>

                <div>
                    <div id="overview-chart" class="apex-charts" dir="ltr"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap table-hover">
                                <thead class="table-light">
                                <tr>
                                    <th scope="col" style="width: 70px;">#</th>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Référence</th>
                                    <th scope="col">Total Facture</th>
                                    <th scope="col">Acompte</th>
                                    <th scope="col">Avancement</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach( $invoices as $invoice )
                                    <tr>
                                        <td>
                                            <div class="avatar-xs">
                                            <span class="avatar-title rounded-circle">
                                                {{ substr($invoice->estimation->client->name, 0, 1) }}
                                            </span>
                                            </div>
                                        </td>
                                        <td>
                                            <h5 class="font-size-14 mb-1"><a href="#" class="text-dark">{{ $invoice->estimation->client->name }}</a></h5>
                                            <p class="text-muted mb-0">{{ substr($invoice->title, 0, 30) }}</p>
                                        </td>
                                        <td>{{ $invoice->reference }}</td>
                                        <td>
                                            {{ $invoice->amount }} €
                                        </td>
                                        <td>
                                            {{ $invoice->advance > 0 ? "Oui" : "Non" }}
                                        </td>
                                        <td>
                                            <div>
                                                <a href="#" class="badge {{ $invoice->paid > 0 ? 'bg-success' : 'bg-danger' }} font-size-11 m-1">{{ $invoice->paid > 0 ? 'payée' : 'en attente' }}</a>
                                            </div>
                                        </td>
                                        <td class="contact-links">
                                            <a href="{{ route('invoices.validation', $invoice->estimation->id) }}" title="Payer"><i class="bx bx-receipt font-size-20"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            {{ $invoices->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <a href="{{ route('invoices.create') }}" class="btn btn-primary">Créer Nouvelle Facture</a>
            </div>
        </div>

    </div>
</div>
    <!-- end row -->
@endsection

@section('script')
    <!-- apexcharts -->
    <script src="{{ asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Required datatable js -->
{{--    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>--}}
    <script>

    </script>
    <script>
        var options = {
            series: [],
            chart: {
                height: 240,
                type: 'area',
                toolbar: {
                    show: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2,
                dashArray: [0, 0, 3]
            },
            fill: {
                type: 'solid',
                opacity: [0.15, 0.05, 1]
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            colors: ['#f1b44c', '#3452e1', '#50a5f1']
        };

        var chartOverview = new ApexCharts(document.querySelector("#overview-chart"), options);
        chartOverview.render(); // datatable

        $.ajax({
            url: '/api/factures/annee',
        }).done(function (data) {
            console.log(data)
            chartOverview.updateSeries(JSON.parse(data));
        });

        $(document).ready(function () {

            $('#datatable').DataTable();
            $(".dataTables_length select").addClass('form-select form-select-sm');
        });
    </script>
@endsection
