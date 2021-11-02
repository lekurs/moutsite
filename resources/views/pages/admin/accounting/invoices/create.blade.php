@extends('layouts.master')

@section('title') Création d'une facture @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Facturation @endslot
        @slot('title') Devis validés @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
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
                                        <th scope="col">Total Devis</th>
                                        <th scope="col">Facture(s)</th>
                                        <th scope="col">Acompte(s)</th>
                                        <th scope="col">Tags</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach( $estimations as $estimation )
                                    <tr>
                                        <td>
                                            <div class="avatar-xs">
                                            <span class="avatar-title rounded-circle">
                                                {{ substr($estimation->client->name, 0, 1) }}
                                            </span>
                                            </div>
                                        </td>
                                        <td>
                                            <h5 class="font-size-14 mb-1"><a href="#" class="text-dark">{{ $estimation->client->name }}</a></h5>
                                            <p class="text-muted mb-0">{{ substr($estimation->title, 0, 30) }}</p>
                                        </td>
                                        <td>{{ $estimation->reference }}</td>
                                        <td>
                                            @if( !empty( $estimation->invoice) )
                                                @foreach( $estimation->estimationDetails->groupBy($estimation->id) as $detail)
                                                    {{ $detail->sum('total_row') }} €
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            {{ $estimation->invoice ? count($estimation->invoice) : 0 }}
                                        </td>
                                        <td>
                                            @if (!empty($estimation->invoice))
                                                    {{ $estimation->invoice->sum('amount') }} €
                                                @else
                                                0
                                            @endif
                                        </td>
                                        <td>
                                            <div>
                                                <a href="#" class="badge {{ $estimation->validation > 0 ? 'bg-success' : 'bg-danger' }} font-size-11 m-1">{{ $estimation->validation > 0 ? 'validé' : 'en attente' }}</a>
                                            </div>
                                        </td>
                                        <td class="contact-links">
                                            <a href="{{ route('invoices.validation', $estimation->id) }}" title="Facturer"><i class="bx bx-receipt font-size-20"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <!-- select 2 plugin -->
    <script src="{{ asset('/assets/libs/select2/select2.min.js') }}"></script>
    <!-- init js -->
    <script src="{{ asset('/assets/js/pages/ecommerce-select2.init.js') }}"></script>
@endsection
