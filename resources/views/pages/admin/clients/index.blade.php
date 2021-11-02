@extends('layouts.master')

@section('title')@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Clients @endslot
        @slot('title') Clients @endslot
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
                                <th scope="col">Téléphone</th>
                                <th scope="col">Contacts</th>
                                <th scope="col">Projets</th>
                                <th scope="col">CA {{ date('Y') }}</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach( $clients as $client )
                                <tr>
                                    <td>
                                        <div class="avatar-xs">
                                            <span class="avatar-title rounded-circle">
                                                <img src="{{ asset('storage/images/uploads/' . $client->slug . '/logo/' . $client->logo) }}" alt="{{ $client->initial() }}">
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <h5 class="font-size-14 mb-1"><a href="{{ route('clients.show', $client->slug) }}" class="text-dark">{{ $client->name }}</a></h5>
                                        <p class="text-muted mb-0">{{ $client->city }}</p>
                                    </td>
                                    <td>{{ $client->phone }}</td>
                                    <td>
                                        {{ count($client->users) }}
                                    </td>
                                    <td>
                                        {{ count($client->projects) }}
                                    </td>
                                    <td>
                                        <div>
{{--                                            <a href="#" class="badge {{ $invoice->paid > 0 ? 'bg-success' : 'bg-danger' }} font-size-11 m-1">{{ $invoice->paid > 0 ? 'payée' : 'en attente' }}</a>--}}
                                        </div>
                                    </td>
                                    <td class="contact-links">
                                        <a href="{{ route('clients.show', $client->slug) }}" class="text-decoration-underline text-reset"><i class="mdi mdi-eye font-size-20"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        {{ $clients->links() }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-body">
                            <a href="{{ route('clients.create') }}" class="btn btn-primary">Créer Nouveau Client</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
