@extends('layouts.master')

@section('title') Recettes @endsection

@section('css')
    <link href="{{ asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet">

    <!-- select2 css -->
    <link href="{{ asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Recettes @endslot
        @slot('title') Créer Nouvelle @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Créer Nouvelle Recette</h4>
                    <form action="{{ route('recipes.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @include('layouts.form_errors.errors')
                        <input type="hidden" name="recipe_project_id" id="recipe_project_id" value="{{ $project->id }}">
                        <input type="hidden" name="recipe_page_id" id="recipe_page_id" value="{{ $page->id }}">
                        <input type="hidden" name="recipe_client_id" id="recipe_client_id" value="{{ $project->client->id }}">
                        <div class="form-group row mb-4">
                            <label for="recipe_label" class="col-form-label col-lg-2">Titre</label>
                            <div class="col-lg-10">
                                <input id="recipe_label" name="recipe_label" type="text" class="form-control" placeholder="Entrer Titre Recette...">
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label col-lg-2">Description</label>
                            <div class="col-lg-10">
                                <textarea id="taskdesc-editor" name="recipe_description"></textarea>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label for="client-id" class="col-form-label col-lg-2">Status</label>
                            <div class="col-lg-10">
                                <select class="select2 form-control select-status" data-placeholder="Choisissez ..." name="recipe_status" id="recipe_status">
                                    <option value="En cours" name="recipe_status">En cours</option>
                                    <option value="En attente validation client" name="recipe_status">En attente validation client</option>
                                    <option value="En attente validation Dev" name="recipe_status">En attente validation Dev</option>
                                    <option value="Terminé" name="">Terminé</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label col-lg-2">Device</label>
                            <div class="col-lg-10">
                                <select class="select2 form-control select-status select-multiple" multiple data-placeholder="Choisissez ..." name="recipe_device_id[]" id="recipe_device_id">
                                    @foreach( $devices as $device)
                                    <option value="{{ $device->id }}" name="recipe_device_id[]" id="recipe_device_id[{{ $device->id }}]">{{ $device->libelle }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-group mb-0 row">
                                <label class="col-form-label col-lg-2">Ajouter des membres</label>
                                <div  class="col-lg-10 ms-md-auto">
                                    <div class="mb-3 row align-items-center">
                                        <div class="col-md-12 d-flex">
                                        @foreach( $project->client->users as $user )
                                                <div class="form-check mb-3" style="padding-right: 30px">
                                                    <input class="form-check-input" type="checkbox" id="recipe_member-{{ $user->id }}" value="{{ $user->id }}" name="recipe_member[]">
                                                    <label class="form-check-label" for="recipe_member-{{ $user->id }}">
                                                        {{ $user->lastname . ' ' . $user->name }}
                                                    </label>
                                                </div>
                                        @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-4 row">
                            <label for="recipe_image" class="col-form-label col-lg-2">Image</label>
                            <div class="col-lg-10">
                                <input class="form-control" type="file" id="recipe_image" name="recipe_image">
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-lg-10">
                                <button type="submit" class="btn btn-primary">Créer Recette</button>
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

    <!-- Summernote js -->
    <script src="{{ asset('/assets/libs/tinymce/tinymce.min.js') }}"></script>

    <!-- select 2 plugin -->
    <script src="{{ asset('/assets/libs/select2/select2.min.js') }}"></script>

    <!-- init js -->
    <script src="{{ asset('/assets/js/pages/ecommerce-select2.init.js') }}"></script>

    <script src="{{ asset('/assets/js/pages/task-create.init.js') }}"></script>
@endsection
