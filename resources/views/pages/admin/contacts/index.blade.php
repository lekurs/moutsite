@extends('layouts.master')

@section('title') Contact @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Clients @endslot
        @slot('title') Contacts @endslot
    @endcomponent

    <div class="row">
        @foreach( $contacts as $contact )
            <div class="col-xl-3 col-sm-6">
                <div class="card text-center">
                    <div class="card-body">
                        @if( isset($contact->avatar) )
                            <div class="mb-4">
                                <img class="rounded-circle avatar-sm" src="{{ asset('storage/images/uploads/' . $contact->client->slug . '/users/' . $contact->slug . '/picture/' . $contact->avatar) }}" alt="{{ $contact->name }}">
                            </div>
                        @else
                            <div class="avatar-sm mx-auto mb-4">
                        <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-16">
                            {{ substr($contact->lastname, 0, 1) . substr($contact->name, 0, 1) }}
                        </span>
                            </div>
                        @endif
                        <h5 class="font-size-15 mb-1"><a href="{{ route('contacts.show', $contact->slug) }}" class="text-dark">{{ $contact->lastname . ' ' . $contact->name }}</a></h5>
                        <p class="text-muted">{{ $contact->post_fonction }}</p>

                        <div>
                            @foreach( $contact->roles as $role)
                            <a href="#" class="badge bg-primary font-size-11 m-1">{{ $role->name }}</a>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top">
                        <div class="contact-links d-flex font-size-20">
                            <div class="flex-fill">
                                <a href=""><i class="bx bx-message-square-dots"></i></a>
                            </div>
                            <div class="flex-fill">
                                <a href=""><i class="bx bx-pie-chart-alt"></i></a>
                            </div>
                            <div class="flex-fill">
                                <a href=""><i class="bx bx-user-circle"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <!-- end row -->

@endsection
