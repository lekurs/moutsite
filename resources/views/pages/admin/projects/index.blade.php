@extends('layouts.master')

@section('title') Projets @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Projets @endslot
        @slot('title') Tous @endslot
    @endcomponent

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
                                <th scope="col">Client</th>
                                <th scope="col">Description</th>
                                <th scope="col">Status</th>
                                <th scope="col">Recettes</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach( $projects as $project )
                                <tr>
                                    <td>
                                        <div class="avatar-xs">
                                            <span class="avatar-title rounded-circle">
                                                {{ $loop->iteration }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <h5 class="font-size-14 mb-1"><a href="{{ route('pages.index', $project->slug) }}" class="text-dark">{{ $project->title }}</a></h5>
{{--                                        <p class="text-muted mb-0">{{ substr($project->description, 0, 30) }}</p>--}}
                                    </td>
                                    <td>{{ $project->client->name }}</td>
                                    <td>
                                        {{ \Illuminate\Support\Str::limit($project->description, 40) }}
                                    </td>
                                    <td>
                                        {{ $project->in_progress > 0 ? "Oui" : "Non" }}
                                    </td>
                                    <td>
                                        <div>
{{--                                            <a href="#" class="badge {{ $invoice->paid > 0 ? 'bg-success' : 'bg-danger' }} font-size-11 m-1">{{ $invoice->paid > 0 ? 'payée' : 'en attente' }}</a>--}}
                                        </div>
                                    </td>
                                    <td class="contact-links">
{{--                                        <a href="{{ route('invoices.validation', $invoice->estimation->id) }}" title="Payer"><i class="bx bx-receipt font-size-20"></i></a>--}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        {{ $projects->links() }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 m-lg-3">
                        <a href="{{ route('projects.create') }}" class="btn btn-primary">Créer Nouveau Projet</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

@endsection
