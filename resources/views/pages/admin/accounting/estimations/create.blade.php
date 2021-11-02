@extends('layouts.master')

@section('title') Création d'un devis @endsection

@section('css')
    <!-- select2 css -->
    <link href="{{ asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Devis @endslot
        @slot('title') Nouveau devis @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Créer un nouveau devis</h4>
                    <form action="{{ route('estimations.store') }}" method="post" enctype="multipart/form-data" class="outer-repeater">
                        @csrf
                        @include('layouts.form_errors.errors')
                        <div class="row mb-4">
                            <label for="validation-duration-estimation" class="col-form-label col-lg-2">Validité Du Devis</label>
                            <div class="col-lg-10">
                                <input id="validation-duration-estimation" name="validation-duration-estimation" type="number" class="form-control"
                                       placeholder="Validité Du Devis..." value="30">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="estimation-reference" class="col-form-label col-lg-2">Numéro De Devis</label>
                            <div class="col-lg-10">
                                <input id="estimation-reference" name="estimation-reference" type="text" class="form-control"
                                       placeholder="Numéro De Devis..." value="{{ $number }}" readonly>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="estimation-service[]" class="col-form-label col-lg-2">Catégorie</label>
                            <div class="col-lg-10">
                                <select class="select2 form-control select2-multiple" name="estimation-service[]" data-placeholder="Choisissez ..." id="estimation-service[]" multiple>
                                    @foreach( $skills as $skill )
                                        <option value="{{ $skill->id }}">{{ $skill->libelle }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="client-id" class="col-form-label col-lg-2">Client</label>
                            <div class="col-lg-10">
                                <select class="select2 form-control select2-multiple select-client" data-placeholder="Choisissez ..." name="client-estimation" id="client-estimation">
                                    <option value="" selected>Choisissez...</option>
                                    @foreach( $clients as $client )
                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="client-id" class="col-form-label col-lg-2">Contact(s)</label>
                            <div class="col-lg-10">
                                <select class="select2 form-control select2-multiple select-contacts" data-placeholder="Choisissez ..." name="estimation-contact" id="project-contact">

                                </select>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="estimation-title" class="col-form-label col-lg-2">Intitulé du devis</label>
                            <div class="col-lg-10">
                                <input id="estimation-title" name="estimation-title" type="text" class="form-control"
                                       placeholder="Entrez l'intitulé du devis...">
                            </div>
                        </div>
                        <div data-repeater-list="outer-group" class="outer">
                            <div data-repeater-item class="outer">
                                <div class="inner-repeater mb-4 product-line">
                                    <div data-repeater-list="inner-group" class="inner form-group mb-0 row">
                                        <label class="col-form-label col-lg-2">Ajouter Produit</label>
                                        <div  data-repeater-item class="inner col-lg-10 ms-md-auto">
                                            <div class="mb-3 row align-items-center">
                                                <div class="col-md-4">
                                                    <input type="text" class="inner form-control calculate-estimation estimation-product" name="estimation-product" id="estimation-product" placeholder="Entrer Produit..."/>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" class="inner form-control calculate-estimation estimation-quantity" name="estimation-quantity" id="estimation-quantity" placeholder="Quantité..."/>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="mt-4 mt-md-0">
                                                        <input type="text" class="inner form-control calculate-estimation estimation-price" name="estimation-price" id="estimation-price" placeholder="Prix Unitaire..."/>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="mt-4 mt-md-0">
                                                        <select class=" form-control calculate-estimation-select" data-placeholder="Choisissez ..." name="tax-estimation" id="tax-estimation">
                                                            @foreach( $taxes as $tax )
                                                                <option value="{{ $tax->id }}">{{ $tax->tax }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="d-none">
                                                    <div class="mt-4 mt-md-0">
                                                        <p class="estimation-total-zone"></p>
                                                        <input type="hidden" name="product-detail[][total-no-tax]" id="total-row-no-tax">
                                                        <input type="hidden" name="product-detail[][total-tax]" id="total-row-tax" class="total_row_tax">
                                                        <input type="hidden" name="product-detail[][total]" id="total-row">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="mt-2 mt-md-0 d-grid">
                                                        <input data-repeater-delete type="button" class="btn btn-primary inner" value="Delete"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mt-4 input-group">
                                                    <textarea name="product-detail" rows="3" style="width: 100%; height: 150px;" class="form-control"></textarea>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-end">
                                        <div class="col-lg-10">
                                            <input data-repeater-create type="button" class="btn btn-success inner" value="Ajouter Un Produit"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row justify-content-end">
                                    <div class="col-lg-10">
                                        Total HT : <input type="hidden" name="estimation-total-input" id="grandtotal"> <span id="grandtotal-txt"></span>
                                        TVA : <input type="hidden" name="estimation-total-tax" id="estimation-total-tax"><span id="total-tax"></span>
                                        Total TTC : <input type="hidden" name="estimation-total-with-taxes" id="estimation-total-with-taxes"><span id="total-with-taxes"></span>
                                    </div>
                                </div>

                                <div class="row justify-content-end">
                                    <div class="col-lg-10">
                                        <button type="submit" class="btn btn-primary">Créer Devis</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

@endsection
@section('script')

    <!-- select 2 plugin -->
    <script src="{{ asset('/assets/libs/select2/select2.min.js') }}"></script>
    <!-- init js -->
    <script src="{{ asset('/assets/js/pages/ecommerce-select2.init.js') }}"></script>

    <!-- form repeater js -->
    <script src="{{ asset('/assets/libs/jquery-repeater/jquery-repeater.min.js') }}"></script>

    <script src="{{ asset('/assets/js/pages/task-create.init.js') }}"></script>

    <script>
        let client = $('.select-client');

        $(client).on('change', (e) => {
            let idClient = $(client).select2('data')[0].id;

            $.ajax({
                url: `/api/client/${idClient}/contacts/`,
                method: "GET",
            }).done((data) => {
                let selectContacts = $('.select-contacts');
                selectContacts.empty();

                $.each(data, function(index, contact) {
                    selectContacts.append(`<option value="${contact.id}">${contact.name}</option>`)
                });
            });
        });
    </script>

    <script>
        $('body').on('change', '.calculate-estimation', function () {
            let row = $(this).closest('.product-line');
            let qty = row.find('.estimation-quantity');
            let price = row.find('.estimation-price');
            let total = qty.val() * price.val();
            let totalInput = $('.estimation-total-input');
            let ranktax = row.find('.calculate-estimation-select').children('option:selected').text();

            totalInput.val(qty.val() * price.val());

            if ( price.val().length !== 0) {
                row.find('p.estimation-total-zone').html(parseFloat(total).toFixed(2));
                row.find('input#total-row-no-tax').val(parseFloat(total).toFixed(2));
                row.find('input#total-row-tax').val(parseFloat((total * (ranktax / 100))).toFixed(2));
                row.find('input#total-row').val(parseFloat((total * (ranktax / 100)) + total).toFixed(2));
            }


            grandTotal = 0;
            totalTax = 0;

            $('p.estimation-total-zone').each(function () {
                if(!isNaN(parseFloat($(this).html()))) {
                    grandTotal = grandTotal+parseFloat($(this).html());
                }
            });

            $('input.total_row_tax').each(function () {
                if(!isNaN(parseFloat($(this).val()))) {
                    totalTax = totalTax+parseFloat($(this).val());
                }
            })

            $('#grandtotal').val(parseFloat(grandTotal).toFixed(2));
            $('#grandtotal-txt').html(parseFloat(grandTotal).toFixed(2));
            $('#estimation-total-tax').val(parseFloat(totalTax).toFixed(2));
            $('#total-tax').html(parseFloat(totalTax).toFixed(2));
            $('#estimation-total-with-taxes').val(parseFloat(grandTotal + totalTax).toFixed(2));
            $('#total-with-taxes').html(parseFloat((grandTotal + totalTax).toFixed(2)));
        });
    </script>
@endsection
