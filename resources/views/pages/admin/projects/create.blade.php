@extends('layouts.master')

@section('title') Créer un nouveau projet @endsection

@section('css')
    <!-- bootstrap datepicker -->
    <link href="{{ asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet">

    <!-- select2 css -->
    <link href="{{ asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Projets @endslot
        @slot('title') Créer un nouveau @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Créer Nouveau Projet</h4>
                    <form action="{{ route('projects.store') }}" method="post">
                        @csrf
                        @include('layouts.form_errors.errors')
                        <div class="row mb-4">
                            <label for="client-id" class="col-form-label col-lg-2">Client</label>
                            <div class="col-lg-10">
                                <select class="select2 form-control select2-multiple select-client" data-placeholder="Choisissez ..." name="client-id" id="client-id">
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
                                <select class="select2 form-control select2-multiple select-contacts" data-placeholder="Choisissez ..." name="project-contact[]" id="project-contact[]" multiple="multiple">

                                </select>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-form-label col-lg-2">Dates Du Projet</label>
                            <div class="col-lg-10">
                                <div class="input-daterange input-group" id="project-date-inputgroup"
                                     data-provide="datepicker" data-date-format="dd M, yyyy"
                                     data-date-container='#project-date-inputgroup' data-date-autoclose="true">
                                    <input type="text" class="form-control" placeholder="Date De Départ" name="project-start" />
                                    <input type="text" class="form-control" placeholder="Date De Fin" name="project-end" />
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="project-title" class="col-form-label col-lg-2">Nom du Project</label>
                            <div class="col-lg-10">
                                <input id="project-title" name="project-title" type="text" class="form-control"
                                       placeholder="Entrer Nom Du Project...">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="project-description" class="col-form-label col-lg-2">Description Du Projet</label>
                            <div class="col-lg-10">
                                <textarea class="form-control" id="project-description" name="project-description" rows="3"
                                          placeholder="Entrer La Description Du Project..."></textarea>
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-lg-10">
                                <button type="submit" class="btn btn-primary">Créer Nouveau Projet</button>
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
    <!-- bootstrap datepicker -->
    <script src="{{ asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <!-- select 2 plugin -->
    <script src="{{ asset('/assets/libs/select2/select2.min.js') }}"></script>
    <!-- init js -->
    <script src="{{ asset('/assets/js/pages/ecommerce-select2.init.js') }}"></script>

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
@endsection
