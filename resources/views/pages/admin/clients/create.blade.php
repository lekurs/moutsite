@extends('layouts.master')

@section('title') Ajout d'un nouveau client @endsection

@section('css')
    <!-- Bootstrap -->
    <link href="{{ asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet">

    <!-- dropzone css -->
    <link href="{{ asset('/assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Client @endslot
        @slot('title') Nouveau client @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Créer un nouveau client</h4>
                    <form action="{{ route('clients.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @include('layouts.form_errors.errors')
                        <div class="row mb-4">
                            <label for="client-name" class="col-form-label col-lg-2">Nom du client</label>
                            <div class="col-lg-10">
                                <input id="client-name" name="client-name" type="text" class="form-control"
                                       placeholder="Entrez le nom du client...">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="client-phone" class="col-form-label col-lg-2">Téléphone du client</label>
                            <div class="col-lg-10">
                                <input id="client-phone" name="client-phone" type="text" class="form-control"
                                       placeholder="Entrez le télphone du client...">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="client-address" class="col-form-label col-lg-2">Adresse du client</label>
                            <div class="col-lg-10">
                                <input id="client-address" name="client-address" type="text" class="form-control"
                                       placeholder="Entrez l'adresse du client...">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="client-zip" class="col-form-label col-lg-2">Code postal du client</label>
                            <div class="col-lg-10">
                                <input id="client-zip" name="client-zip" type="text" class="form-control"
                                       placeholder="Entrez le code postal du client...">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="client-city" class="col-form-label col-lg-2">Ville du client</label>
                            <div class="col-lg-10">
                                <input id="client-city" name="client-city" type="text" class="form-control"
                                       placeholder="Entrez la ville du client...">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="client-siren" class="col-form-label col-lg-2">Numéro de SIREN du client</label>
                            <div class="col-lg-10">
                                <input id="client-siren" name="client-siren" type="text" class="form-control"
                                       placeholder="Entrez le SIREN du client...">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="client-logo" class="col-form-label col-lg-2">Logo du client</label>
                            <div class="col-lg-10">
                                <input class="form-control" name="client-logo" id="client-logo" type="file">
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-lg-10">
                                <button type="submit" class="btn btn-primary">Créer Client</button>
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
    <!-- dropzone plugin -->
    <script src="{{ asset('/assets/libs/dropzone/dropzone.min.js') }}"></script>
@endsection
