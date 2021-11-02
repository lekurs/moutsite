@extends('layouts.master')

{{--@lang('translation.Dashboards')--}}
@section('title') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Dashboards @endslot
        @slot('title') Dashboard @endslot
    @endcomponent

{{--    @dd(auth()->user()->hasPermission('show.one.client'))--}}

{{--    <div class="row">--}}
{{--        <div class="col-xl-4">--}}
{{--            <div class="card overflow-hidden">--}}
{{--                <div class="bg-primary bg-soft">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-7">--}}
{{--                            <div class="text-primary p-3">--}}
{{--                                <h5 class="text-primary">Welcome Back !</h5>--}}
{{--                                <p>Skote Dashboard</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-5 align-self-end">--}}
{{--                            <img src="{{ URL::asset('/assets/images/profile-img.png') }}" alt="" class="img-fluid">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection
