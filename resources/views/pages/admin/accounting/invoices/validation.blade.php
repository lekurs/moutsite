@extends('layouts.master')

@section('title') Création d'une facture @endsection

@section('css')
    <!-- select2 css -->
    <link href="{{ asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Facturation @endslot
        @slot('title') Validation @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-10 m-auto">
            <div class="row">
                <div class="col-md-12 mt-3">
                    <img src="http://moutwebagency.net/mout/logo-mout-factures.png" alt="Mout" class="img-fluid">
                </div>
            </div>
            <div class="row">
                <form action="{{ route('invoices.store', $estimation->id) }}">
                @csrf
                    <input type="hidden" name="invoice_client_id" id="invoice_client_id" value="{{ $estimation->client->id }}">
                @include('layouts.form_errors.errors')
                <div class="row">
                    <div class="col-12 m-auto mb-3">
                        <div class="row  mt-5">
                            <div class="col-md-6 mout-accounting-header-container">
                                <p>Facture Réf: <input class="form-control" type="text" name="invoice_reference" id="invoice_reference" aria-label="Numéro de la facture" placeholder="Numéro de la facture" @isset($number) value="{{ $number }}" @endisset readonly></p>
                            </div>
                            <div class="col-md-6 text-align-right">
                                Fait à Le Chesnay le {{ date('d/m/Y') }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mout-accounting-client-informations">
                                <p class="font-weight-semibold">{{ $estimation->client->name }}</p>
                                <p class="font-weight-light">{{ $estimation->client->address }}</p>
                                <p class="font-weight-light">{{ $estimation->client->zip }} {{ $estimation->client->city }}</p>
                                <p class="font-weight-light">N° SIRET : {{ $estimation->client->siren}}</p>
                                <p class="font-weight-light">N° TVA Intracommunautaire : {{ $estimation->client->siren}}</p>
                                <p class="font-weight-light">{{ $estimation->user->email }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 invoice-details-container">
                        <div class="row mt-4 mout-accounting-thead-details-container">
                            <div class="col-8 font-weight-semibold text-uppercase ">Description</div>
                            <div class="col-1 font-weight-semibold text-uppercase d-flex align-items-center justify-content-center">Taxe</div>
                            <div class="col-1 font-weight-semibold text-uppercase d-flex align-items-center justify-content-center">Quantité</div>
                            <div class="col-2 font-weight-semibold text-uppercase d-flex align-items-center justify-content-center">PV HT</div>
                        </div>
                        <div class="row edit-estimation estimation-title-container">
                            <div class="col-12 mout-accounting-body-details-container">
                                <H5 class="mout-accounting-title-description">{{ $estimation->title }}</H5>
                            </div>
                        </div>
                        @foreach($estimation->estimationDetails as $detail)
                            <div class="edit-estimation" id="{{ $detail->id }}" data-id="{{ $detail->id }}">
                                <div class="row">
                                    <div class="col-12 mout-accounting-detail-product">
                                        <p class="font-weight-semibold">{{ $detail->product }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8 mout-accounting-detail-description">
                                        <p>{!! nl2br($detail->description) !!}</p>
                                    </div>
                                    @if ( is_null($advances) )
                                        <div class="col-1 text-right mout-accounting-detail-tax d-flex align-items-center justify-content-center" data-tax-id="{{ $detail->taxe->id }}">{{ $detail->taxe->tax }}%</div>
                                        <div class="col-1 text-right mout-accounting-detail-quantity d-flex align-items-center justify-content-center">{{ $detail->quantity }}</div>
                                        <div class="col-2 text-right mout-accounting-detail-total d-flex align-items-center justify-content-center">{{ $detail->unit_price }} €</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        <div class="row">
                            <div class="col-12 mt-5">
                                <div class="row">
                                    <div class="col-6">
                                        <p class="invoice_observation">
                                            @if (!is_null($advances))
                                                Pour rappel,
                                                @if( count($advances['references']) > 1)
                                                    les factures d'acomptes précédentes sont les suivantes :
                                                    @foreach($advances['references'] as $invoicesReferences)
                                                        {{ $invoicesReferences->reference }} {{ !$loop->last ? '/' : '' }}
                                                    @endforeach
                                                @elseif( count($advances['references']) <= 1)
                                                    la facture d'acompte est la suivante : {{ $advances['references'][0]->reference }}
                                                @else Observations
                                                @endif
                                            @endif
                                        </p>
                                        <textarea name="invoice_observation" id="invoice_observation" cols="30" rows="10" class="d-none">@if (!is_null($advances))
                                                Pour rappel,
                                                @if( count($advances['references']) > 1)
                                                    les factures d'acomptes précédentes sont les suivantes :
                                                    @foreach($advances['references'] as $invoicesReferences)
                                                        {{ $invoicesReferences->reference }} {{ !$loop->last ? '/' : '' }}
                                                    @endforeach
                                                @elseif( count($advances['references']) <= 1)
                                                    la facture d'acompte est la suivante : {{ $advances['references'][0]->reference }}
                                                @else Observations
                                                @endif
                                            @endif</textarea>
                                    </div>
                                    <div class="col-6 mout-accounting-total-container">
                                        <div class="row">
                                            @if ( !is_null($advances ))
                                                <div class="col-12">
                                                    <h6>Vous avez {{ $advances['count'] }} facture{{ $advances['count'] > 1 ? 's' : '' }} d'acompte N°
                                                        @foreach($advances['references'] as $invoicesReferences)
                                                            {{ $invoicesReferences->reference }} {{ !$loop->last ? '/' : '' }}
                                                        @endforeach
                                                        | le solde est de {{ $total['total_row_notax'] - $advances['total_row_notax'] }} €</h6>
                                                </div>
                                                <div class="col-4">
                                                    <p class="font-weight-semibold text-right">Total HT :</p>
                                                    <p class="font-weight-semibold text-right">TVA :</p>
                                                    <p class="font-weight-semibold text-right">Total TTC :</p>
                                                </div>
                                                <div class="col-8">
                                                    <p class="font-weight-semibold text-right">{{ $total['total_row_notax'] - $advances['total_row_notax'] }} €</p>
                                                    <input type="hidden" name="invoice_amount_no_tax" id="invoice_amount_no_tax" value="{{ $total['total_row_notax'] - $advances['total_row_notax'] }}">
                                                    <p class="font-weight-semibold text-right">{{ $total['total_row_tax'] - $advances['total_row_tax'] }} €</p>
                                                    <input type="hidden" name="invoice_amount_tax" id="invoice_amount_tax" value="{{ $total['total_row_tax'] - $advances['total_row_tax'] }}">
                                                    <p class="font-weight-semibold text-right">{{ $total['total_row'] - $advances['total_row'] }} €</p>
                                                    <input type="hidden" name="invoice_amount" id="invoice_amount" value="{{ $total['total_row'] - $advances['total_row'] }}">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row my-3">
                                    <div class="col-6">
                                        <p class="observation-container">Ajouter une observation</p>
                                    </div>
                                    <div class="col-2">
                                        <div class="estimation-edit-pen-title" data-toggle="modal" data-target="#invoice_observation_modal"><i class="fal fa-pen"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-end">
                    <div class="col-lg-12">
                        <a href="" class="btn btn-primary waves-effect waves-light btn-sm" data-bs-toggle="modal" data-bs-target=".advance-invoice">Créer Facture D'acompte</a>
                    </div>
                </div>

                <div class="row my-3">
                    <div class="col-10 ml-auto mr-auto d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </div>

                <div class="row my-3 d-none">
                    <input type="checkbox" name="invoice_advance" id="invoice_advance">
                    <input type="number" name="invoice_advance_amount_no_tax" id="invoice_advance_amount_no_tax" class="form-control">
                    <input type="number" name="invoice_advance_amount_tax" id="invoice_advance_amount_tax" class="form-control">
                    <input type="number" name="invoice_advance_amount" id="invoice_advance_amount" class="form-control">
                </div>
            </form>
            </div>
        </div>
    </div>


    <div class="modal fade advance-invoice" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Créer Facture d'acompte</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
{{--                    <form class="form-horizontal" action="#" method="POST" enctype="multipart/form-data" id="update-profile">--}}
                        <div class="mb-3">
                            <label for="invoice_advance_amount_no_tax" class="form-label">Montant en € HT</label>
                            <input type="number" name="invoice_advance_amount_no_tax_informations" id="invoice_advance_amount_no_tax_informations" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="invoice_advance_amount_tax" class="form-label">TVA</label>
                            <input type="number" name="invoice_advance_amount_tax_invormations" id="invoice_advance_amount_tax_informations" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="invoice_advance_amount" class="form-label">Montant total en € TTC</label>
                            <input type="number" name="invoice_advance_amount_informations" id="invoice_advance_amount_informations" class="form-control">
                        </div>

                        <div class="mt-3 d-grid">
                            <button class="btn btn-primary waves-effect waves-light UpdateProfile" data-id="2" type="submit">Enregistrer</button>
                        </div>
{{--                    </form>--}}
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
@endsection

@section('script')

    <script>
        //Create advance invoice
        let myModal = new bootstrap.Modal(document.querySelectorAll('.advance-invoice')[0]);

        let closeModalElt = document.querySelectorAll('.UpdateProfile')[0];

        let advanceCheckbox = document.querySelector('#invoice_advance');
        let notaxValue = document.querySelector('#invoice_advance_amount_no_tax_informations');
        let notaxValueElt= document.querySelector('#invoice_advance_amount_no_tax');
        let taxValue = document.querySelector('#invoice_advance_amount_tax_informations');
        let taxValueElt = document.querySelector('#invoice_advance_amount_tax');
        let amountValue = document.querySelector('#invoice_advance_amount_informations');
        let amountValueElt = document.querySelector('#invoice_advance_amount');

        notaxValue.addEventListener('blur', () => {

            taxValue.value = parseFloat((notaxValue.value * 1.2) - notaxValue.value);
            amountValue.value = parseFloat(notaxValue.value) * 1.2;
        })

        closeModalElt.addEventListener('click', () => {

            notaxValueElt.value = notaxValue.value;
            taxValueElt.value = taxValue.value;
            amountValueElt.value = amountValue.value;

            myModal.hide();

            notaxValue.length === 0 ? advanceCheckbox.checked = false : advanceCheckbox.checked = true;
        })

    </script>

@endsection
