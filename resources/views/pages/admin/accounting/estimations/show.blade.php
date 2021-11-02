@extends('layouts.master')

@section('title') Factures @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Devis @endslot
        @slot('title') Voir @endslot
    @endcomponent

    <div class="row">
        <div class="col-md-10 mt-3 m-auto">
            <img src="http://moutwebagency.net/mout/logo-mout-factures.png" alt="Mout" class="img-fluid">
        </div>
    </div>
    <div class="row">
        <div class="col-10 mb-5 m-auto">
            <div class="row my-5">
                <div class="col-md-6 mout-accounting-header-container">
                    <p>Devis Réf: <span class="font-weight-semibold">{{ $estimation->reference}}</span></p>
                </div>
                <div class="col-md-6">
                    <p class="text-align-right">Fait à Le Chesnay le {{ $estimation->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mout-accounting-client-informations">
                    <p class="font-weight-semibold mb-0">{{ $estimation->client->name }}</p>
                    <p class="font-weight-light mb-0">{{ $estimation->client->address }}</p>
                    <p class="font-weight-light mb-0">{{ $estimation->client->zip }} {{ $estimation->client->city }}</p>
                    <p class="font-weight-light mb-0">N° SIRET : {{ $estimation->client->siren}}</p>
                    <p class="font-weight-light mb-0">N° TVA Intracommunautaire : {{ $estimation->client->siren}}</p>
                    <p class="font-weight-light mb-0">{{ $estimation->user->email }}</p>
                </div>
            </div>
            <div class="row mt-4 mout-accounting-thead-details-container">
                <div class="col-8 font-weight-bold text-uppercase ">
                    <h4 class="mb-sm-0 font-size-18">Description</h4>
                </div>
                <div class="col-1 font-weight-bold text-uppercase d-flex align-items-center justify-content-center">
                    <h4 class="mb-sm-0 font-size-18">Taxe</h4>
                </div>
                <div class="col-1 font-weight-bold text-uppercase d-flex align-items-center justify-content-center">
                    <h4 class="mb-sm-0 font-size-18">Quantité</h4>
                </div>
                <div class="col-1 font-weight-bold text-uppercase d-flex align-items-center justify-content-center">
                    <h4 class="mb-sm-0 font-size-18">PV HT</h4>
                </div>
                <div class="col-1 text-center">
                    <h4 class="mb-sm-0 font-size-18"><i class="fal fa-pen"></i></h4>
                </div>
            </div>
            <div class="row edit-estimation estimation-title-container">
                <div class="col-11 mout-accounting-body-details-container">
                    <H5 class="mout-accounting-title-description">{{ $estimation->title }}</H5>
                </div>
                <div class="col-1">
                    <div class="estimation-edit-pen-title " data-bs-toggle="modal" data-bs-target="#editTitle" data-estimation-id="{{ $estimation->id }}"><i class="fal fa-pen"></i></div>
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
                        <div class="col-1 text-right mout-accounting-detail-tax d-flex align-items-center justify-content-center" data-tax-id="{{ $detail->taxe->id }}">{{ $detail->taxe->tax }}%</div>
                        <div class="col-1 text-right mout-accounting-detail-quantity d-flex align-items-center justify-content-center">{{ $detail->quantity }}</div>
                        <div class="col-1 text-right mout-accounting-detail-total d-flex align-items-center justify-content-center">{{ $detail->unit_price }} €</div>
                        <div class="col-1 d-flex align-items-center justify-content-center">
                            <div class="estimation-edit-pen" data-bs-target="#editDetails" data-estimation-id="{{ $detail->id }}"><i class="fal fa-pen"></i></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="row">
        <div class="col-10 m-auto">
            <div class="row">
                <div class="col-8">
                    <p class="font-weight-light">Conditions de paiement : 30% à la validation du devis, le solde à la réception de la facture.</p>
                </div>
                <div class="col-4 mout-accounting-total-container">
                    <div class="row">
                        <div class="col-8">
                            <p class="font-weight-semibold text-align-right">Total HT :</p>
                            <p class="font-weight-semibold text-align-right">TVA :</p>
                            <p class="font-weight-semibold text-align-right">Total TTC :</p>
                        </div>
                        <div class="col-4">
                            <p class="font-weight-semibold text-align-right">{{ $total['total_row_notax'] }} €</p>
                            <p class="font-weight-semibold text-align-right">{{ $total['total_row_tax'] }} €</p>
                            <p class="font-weight-semibold text-align-right">{{ $total['total_row'] }} €</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <a href="{{ route('estimations.create.pdf', ['client' => $estimation->client, 'estimation' => $estimation ]) }}"
               class="btn btn-primary" target="_blank">
                Créer le devis en PDF
            </a>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editTitle" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Mise à jour du titre</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('estimations.title.update', $estimation->id) }}" method="post" class="form-horizontal">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Intitulé</label>
                            <input type="text" class="form-control" name="title" id="title">
                        </div>
                        <div class="mt-3 d-grid">
                            <button class="btn btn-primary waves-effect waves-light UpdateProfile" data-id="2" type="submit">Mettre à jour</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="editDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Mise à jour du produit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('estimations.details.update') }}" method="post">
                        @csrf
                        <input type="hidden" name="detail_id" id="detail_id">
                        <div class="mb-3">
                            <label for="product" class="form-label">Intitulé</label>
                            <input type="text" class="form-control" id="product" name="product" placeholder="Entrer le produit" autofocus="">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea rows="10" cols="30" class="form-control" name="description" id="description" placeholder="Description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="estimation-quantity" class="form-label">Quantité</label>
                            <input type="number" class="form-control calculate-estimation estimation-quantity" name="quantity" id="quantity" minlength="1">
                        </div>
                        <div class="mb-3">
                            <label for="tax" class="form-label">Taxes</label>
                            <select name="tax" id="tax" class="form-control">
                                @foreach($taxes as $tax)
                                    <option value="{{ $tax->id }}">{{ $tax->tax }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="estimation-price" class="form-label">Prix unitaire</label>
                            <input type="text" class="form-control calculate-estimation estimation-price" name="price" id="price" minlength="1">
                        </div>
                        <div class="mt-3 d-grid">
                            <button class="btn btn-primary waves-effect waves-light UpdateProfile" data-id="2" type="submit">Mettre à jour</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        let penTitle = $('.estimation-edit-pen-title');
        let pen = $('.estimation-edit-pen');

        // let penTitle = document.querySelectorAll('.estimation-edit-pen-title');
        // console.log(penTitle)
        // penTitle[0].addEventListener('click', (elt) => {
        //     let title = elt.closest('.estimation-title-container').querySelectorAll('.mout-accounting-title-description').text;
        //     console.log(title)
        // })
        penTitle.on('click', function () {
            let title = $(this).closest('.estimation-title-container').find('.mout-accounting-title-description').text();

            $('input#title').val(title);
        });

        pen.on('click', function () {

            let estimationId = $(this).attr('data-estimation-id');

            let parent = $(this).closest('.edit-estimation');
            let product = parent.find('.mout-accounting-detail-product p').text();
            let description = parent.find('.mout-accounting-detail-description p').text();
            let quantity = parent.find('.mout-accounting-detail-quantity').text();
            let total = parent.find('.mout-accounting-detail-total').text();
            let taxId = parent.find('.mout-accounting-detail-tax').attr('data-tax-id');

            let editDetailsModal = new bootstrap.Modal(document.getElementById('editDetails'))

            editDetailsModal.show();

            $('input#detail_id').val(estimationId);
            $('input#product').val(product);
            $('textarea#description').val(description);
            $('input#quantity').val(parseInt(quantity));
            $('input#price').val(parseFloat(total));
            $('select#tax').val(parseInt(taxId));
        });
    </script>
@endsection
