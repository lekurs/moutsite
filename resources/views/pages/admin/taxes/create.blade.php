@extends('layouts.master')

@section('title') Créer une nouvelle taxe @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Taxes @endslot
        @slot('title') Créer une nouvelle @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Créer Nouvelle Taxe</h4>
                    <form action="{{ route('taxes.store') }}" method="post">
                        @csrf
                        @include('layouts.form_errors.errors')
                        <div class="row mb-4">
                            <label for="tax" class="col-form-label col-lg-2">Taux</label>
                            <div class="col-lg-10">
                                <input id="tax" name="tax" type="text" class="form-control"
                                       placeholder="Entrer Nom Du Project...">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="project-description" class="col-form-label col-lg-2">Définir comme taxe principale</label>
                            <div class="col-lg-10">
                                    <input class="form-check-input" type="checkbox" id="main-tax" name="main-tax" value="1">
                                    <label class="form-check-label" for="main-tax">
                                        Oui
                                    </label>
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-lg-10">
                                <button type="submit" class="btn btn-primary">Créer Nouveau Taux De Taxe</button>
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

@endsection
