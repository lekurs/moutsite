@extends('layouts.master')

@section('title') @lang('translation.Projects_List') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Projects @endslot
        @slot('title') Projects List
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="">
                <div class="table-responsive">
                    <table class="table project-list-table table-nowrap align-middle table-borderless">
                        <thead>
                        <tr>
                            <th scope="col" style="width: 100px">#</th>
                            <th scope="col">Taux de taxe</th>
                            <th scope="col">Par défaut</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $taxes as $tax )
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <h5 class="text-truncate font-size-14"><a href="#" class="text-dark">{{ $tax->tax }}</a></h5>
                                </td>
                                <td>{{ $tax->main == 1 ? 'principal' : '' }}</td>
                                <td><span class="badge {{ $tax->status == 1 ? 'bg-success' : 'bg-danger' }}">{{ $tax->status == 1 ? 'Actif' : 'Inactif' }}</span></td>
                                <td>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown"
                                           aria-expanded="false">
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
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <a href="{{ route('taxes.create') }}" class="btn btn-primary">Créer Nouveau Taux De Taxe</a>
        </div>
    </div>
    <!-- end row -->

@endsection
