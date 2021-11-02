@extends('layouts.master')

@section('title') Recettes @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Recettes @endslot
        @slot('title') Liste @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('recipes.create', [$page->slug, $project->slug]) }}" class="btn btn-primary">Créer Nouvelle Recette</a>
                </div>
            </div>
        </div>
    </div>

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
                                <th scope="col">Device</th>
                                <th scope="col">Réponses en cours</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach( $recipes as $recipe )
                                <tr>
                                    <td>
                                        <div class="avatar-xs">
                                            <span class="avatar-title rounded-circle">
                                                {{ $loop->iteration }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <h5 class="font-size-14 mb-1"><a href="{{ route('recipes.show', $recipe->slug) }}" class="text-dark">{{ $recipe->label }}</a></h5>
                                        <p class="text-muted mb-0">{{ Str::substr($recipe->project->title, 0, 30) }}</p>
                                    </td>
                                    <td>
                                        <ul class="list-group device-list-group">
                                        @foreach( $recipe->devices as $device)
                                            @if ( $device->slug === "desktop") <li><i class="far fa-desktop font-size-18" title="{{ $device->libelle }}"></i></li>
                                            @elseif( $device->slug === "mobile" ) <li><i class="far fa-mobile font-size-18" title="{{ $device->libelle }}"></i></li>
                                            @elseif( $device->slug === "tablette" ) <li><i class="far fa-tablet font-size-18" title="{{ $device->libelle }}"></i></li>
                                            @endif
                                        @endforeach
                                        </ul>
                                    </td>
                                    <td>{{ count($recipes) }}</td>
                                    <td>
                                        <span class="badge
                                            @if($recipe->status === "En cours") bg-danger
                                            @elseif($recipe->status === "En attente validation client") bg-warning
                                            @elseif($recipe->status === "En attente validation Dev") bg-primary
                                            @elseif($recipe->status === "Terminé") bg-success
                                            @endif">
                                                    {{ $recipe->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
{{--                        {{ $projects->links() }}--}}
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 m-lg-3">
                        <a href="{{ route('projects.create', [$page->slug, $project->slug]) }}" class="btn btn-primary">Créer Nouveau Projet</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

@endsection
@section('script')
    <!-- apexcharts -->
    <script src="{{ asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- dashboard init -->
    <script src="{{ asset('/assets/js/pages/tasklist.init.js') }}"></script>
@endsection
