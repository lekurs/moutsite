@extends('layouts.master')

@section('title') Recettes @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Recettes @endslot
        @slot('title') Liste Pages @endslot
    @endcomponent

    @if( $pages->isEmpty())
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <a href="#" class="btn btn-primary waves-effect waves-light btn-sm" data-bs-toggle="modal"
                       data-bs-target=".create_page">Créer Nouvelle Page</a>
                </div>
            </div>
        </div>
    </div>

    @endif

    <!-- end row -->

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
                                <th scope="col">Recettes en cours</th>
                                <th scope="col">Recettes terminées</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach( $pages as $page )
                                <tr>
                                    <td>
                                        <div class="avatar-xs">
                                            <span class="avatar-title rounded-circle">
                                                {{ $loop->iteration }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <h5 class="font-size-14 mb-1"><a href="{{ route('recipes.index', [$page->slug, $project->slug]) }}" class="text-dark">{{ $page->label }}</a></h5>
                                        <p class="text-muted mb-0">{{ Str::substr($page->projects->title, 0, 30) }}</p>
                                    </td>
                                    <td>{{ $page->recipes->count() }}</td>
                                    <td>
                                        count 2
                                    </td>
                                    <td>
                                        <i class="far fa-eye"></i>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 m-lg-3">
                        <a href="{{ route('projects.create') }}" class="btn btn-primary waves-effect waves-light btn-sm" data-bs-toggle="modal"
                           data-bs-target=".create_page">Créer Nouvelle Page</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->


    <!--  Add page -->
    <div class="modal fade create_page" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Créer Une Page</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('pages.store') }}" class="form-horizontal" method="POST" id="create_page">
                        @csrf
                        <input type="hidden" value="{{ $project->id }}" id="project_id" name="project_id">
                        <div class="mb-3">
                            <label for="page_label" class="form-label">Titre</label>
                            <input type="text" class="form-control @error('text') is-invalid @enderror"
                                   id="page_label" name="page_label"
                                   placeholder="Entrer le nom de la page" autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="page_url_path" class="form-label">URL de la page</label>
                            <input type="text" class="form-control @error('page_url_path') is-invalid @enderror"
                                   id="page_url_path" name="page_url_path"
                                   placeholder="Entrer l'URL de la page">
                        </div>

                        <div class="mt-3 d-grid">
                            <button class="btn btn-primary waves-effect waves-light UpdateProfile"
                                    type="submit">Créer</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@endsection
@section('script')
    <!-- apexcharts -->
    <script src="{{ asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- dashboard init -->
    <script src="{{ asset('/assets/js/pages/tasklist.init.js') }}"></script>
@endsection
