@extends('layouts.master')

@section('title')
Recettes clients
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Clients @endslot
        @slot('title') Liste @endslot
    @endcomponent
@endsection
