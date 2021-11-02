@extends('layouts.master')

@section('title') Factures @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Devis @endslot
        @slot('title') Liste @endslot
    @endcomponent

    <div class="row">
        @foreach( $clients as $clientName => $estimations )
            <h5 class="font-size-15 mb-1">{{ $clientName }}</h5>
            @foreach($estimations as $estimation)
                <div class="col-xl-4 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="text-lg-center">
                                        <div class="avatar-sm me-3 mx-lg-auto mb-3 mt-1 float-start float-lg-none">
                                            <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-16">
                                                <img src="{{ isset($estimation->client->logo)
                                                                ?
                                                                asset('storage/images/uploads/' . $estimation->client->slug . '/logo/' . $estimation->client->logo) :
                                                                asset('/assets/images/users/avatar-1.jpg') }}" alt="{{ $estimation->client->name }}"
                                                     class="img-thumbnail rounded-circle header-profile-client">
                                            </span>
                                        </div>
                                        <h5 class="mb-1 font-size-12 text-truncate">{{ $clientName }}</h5>
{{--                                        <a href="#" class="text-muted">@Skote</a>--}}
                                    </div>
                                </div>

                                <div class="col-lg-8">
                                    <div>
                                        <a href="{{ route('estimations.show', [$estimation->client, $estimation->id]) }}"
                                           class="d-block text-primary text-decoration-underline mb-2">Devis N°{{ $estimation->reference }}</a>
                                        <h5 class="text-truncate mb-4 mb-lg-5">{{ $estimation->title }}</h5>
                                        <ul class="list-inline mb-0">
                                            <li class="list-inline-item me-2">
                                                <h5 class="font-size-12" data-toggle="tooltip" data-placement="top" title="Amount">
                                                    <i class="bx bx-money me-1 text-muted"></i> {{ $estimation->estimationDetails->sum('total_row') }}€ HT </h5>
                                            </li>
                                            <li class="list-inline-item">
                                                <h5 class="font-size-12" data-toggle="tooltip" data-placement="top"
                                                    title="Due Date"><i class="bx bx-calendar me-1 text-muted"></i> {{ $estimation->created_at->format('d M, y') }}</h5>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach

    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-lg-12">
            <a href="{{ route('estimations.create') }}" class="btn btn-primary">Créer Nouveau Devis</a>
        </div>
    </div>
    <!-- end row -->

@endsection
