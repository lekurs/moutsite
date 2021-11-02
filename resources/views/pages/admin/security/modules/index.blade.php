@extends('layouts.master')

@section('title') Modules @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Modules @endslot
        @slot('title') Liste @endslot
    @endcomponent

    @can('admin.modules.index')
    <div class="row">
        // je veux que le client puisse voir sa page
        @can(  )
        @endcan
{{--        can(client.show)--}}
        je suis sur ma page client
        foreach $clients as $client
        endcan
        @foreach( $modules as $module )
        <div class="col-xl-4 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="media">
                        <div class="avatar-md me-4">
                            <span class="avatar-title rounded-circle bg-light text-danger font-size-16">
                                <img src="{{ asset('/assets/images/companies/img-1.png') }}" alt="" height="30">
                            </span>
                        </div>

                        <div class="media-body overflow-hidden">
                            <h5 class="text-truncate font-size-15"><a href="#" class="text-dark">{{ $module->label }}</a></h5>
                            <p class="text-muted mb-4">{{ Str::limit($module->description, 30) }}</p>
                            <div class="avatar-group">
                                <div class="avatar-group-item">
                                    <a href="javascript: void(0);" class="d-inline-block">
                                        <img src="{{ URL::asset('/assets/images/users/avatar-4.jpg') }}" alt=""
                                             class="rounded-circle avatar-xs">
                                    </a>
                                </div>
                                <div class="avatar-group-item">
                                    <a href="javascript: void(0);" class="d-inline-block">
                                        <img src="{{ URL::asset('/assets/images/users/avatar-5.jpg') }}" alt=""
                                             class="rounded-circle avatar-xs">
                                    </a>
                                </div>
                                <div class="avatar-group-item">
                                    <a href="javascript: void(0);" class="d-inline-block">
                                        <div class="avatar-xs">
                                            <span class="avatar-title rounded-circle bg-success text-white font-size-16">
                                                A
                                            </span>
                                        </div>
                                    </a>
                                </div>
                                <div class="avatar-group-item">
                                    <a href="javascript: void(0);" class="d-inline-block">
                                        <img src="{{ URL::asset('/assets/images/users/avatar-2.jpg') }}" alt=""
                                             class="rounded-circle avatar-xs">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 border-top">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item me-3">
                            <span class="badge bg-success">Completed</span>
                        </li>
                        <li class="list-inline-item me-3">
                            <i class="bx bx-calendar me-1"></i> 15 Oct, 19
                        </li>
                        <li class="list-inline-item me-3">
                            <i class="bx bx-comment-dots me-1"></i> 214
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row">
        <div class="col-lg-12">
            <a href="{{ route('invoices.create') }}" class="btn btn-primary">Créer Nouveau Module</a>
        </div>
    </div>
    @endcan
    <!-- end row -->

    <div class="row">
        <div class="col-lg-12">
            <ul class="pagination pagination-rounded justify-content-center mt-2 mb-5">
                <li class="page-item disabled">
                    <a href="#" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                </li>
                <li class="page-item">
                    <a href="#" class="page-link">1</a>
                </li>
                <li class="page-item active">
                    <a href="#" class="page-link">2</a>
                </li>
                <li class="page-item">
                    <a href="#" class="page-link">3</a>
                </li>
                <li class="page-item">
                    <a href="#" class="page-link">4</a>
                </li>
                <li class="page-item">
                    <a href="#" class="page-link">5</a>
                </li>
                <li class="page-item">
                    <a href="#" class="page-link"><i class="mdi mdi-chevron-right"></i></a>
                </li>
            </ul>
        </div>
    </div>
    <!-- end row -->

@endsection
