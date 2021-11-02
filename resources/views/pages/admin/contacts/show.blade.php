@extends('layouts.master')

@section('title') CLient @endsection

@section('css')
    <link href="{{ asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet"
          type="text/css">
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Contact @endslot
        @slot('title') {{ $user->lastname . ' ' . $user->name }} @endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-4">
            <div class="card overflow-hidden">
                <div class="bg-primary bg-soft">
                    <div class="row">
                        <div class="col-7">
                            <div class="text-primary p-3">
                                <h5 class="text-primary">Welcome Back !</h5>
                                <p>It will seem like simplified</p>
                            </div>
                        </div>
                        <div class="col-5 align-self-end">
{{--                            <img src="{{ asset('/assets/images/profile-img.png') }}" alt="" class="img-fluid">--}}
                            <img src="{{ asset('storage/images/uploads/' . $user->client->slug . '/logo/' . $user->client->logo) }}" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="avatar-md profile-user-wid mb-4">
                                <img src="{{ isset($user->avatar) ? asset('storage/images/uploads/' . $user->client->slug . '/users/' . $user->slug . '/picture/' . $user->avatar) : asset('/assets/images/users/avatar-1.jpg') }}" alt="{{ $user->name }}" class="img-thumbnail rounded-circle header-profile-client">
                            </div>
                            <h5 class="font-size-15 text-truncate">{{ $user->client->name }}</h5>
                            <p class="text-muted mb-0 text-truncate">Nombre de contacts</p>
                        </div>

                        <div class="col-sm-8">
                            <div class="pt-4">

                                <div class="row">
                                    <div class="col-6">
                                        <h5 class="font-size-15">125</h5>
                                        <p class="text-muted mb-0">Projects</p>
                                    </div>
                                    <div class="col-6">
                                        <h5 class="font-size-15">$1245</h5>
                                        <p class="text-muted mb-0">Revenue</p>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('contacts.index', $user->slug) }}" class="btn btn-primary waves-effect waves-light btn-sm">Voir contacts <i
                                            class="mdi mdi-arrow-right ms-1"></i></a>

                                    <a href="" class="btn btn-primary waves-effect waves-light btn-sm" data-bs-toggle="modal"
                                       data-bs-target=".update-profile">Edit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end card -->

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Informations</h4>

                    <div class="table-responsive">
                        <table class="table table-nowrap mb-0">
                            <tbody>
                            <tr>
                                <th scope="row">Nom :</th>
                                <td>{{ $user->lastname . ' ' . $user->name }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Email :</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Téléphone :</th>
                                <td>{{ $user->client->phone }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Adresse :</th>
                                <td>{{ $user->client->address }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Ville :</th>
                                <td>{{ $user->client->zip . ' ' . $user->client->city }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Siren :</th>
                                <td>{{ $user->client->siren }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end card -->

{{--            <div class="card">--}}
{{--                <div class="card-body">--}}
{{--                    <h4 class="card-title mb-5">Outils</h4>--}}
{{--                    <div class="table-responsive">--}}
{{--                        <table class="table table-nowrap mb-0">--}}
{{--                            <tbody>--}}
{{--                            <tr>--}}
{{--                                <th scope="row">Projet :</th>--}}
{{--                                <td>--}}
{{--                                    <a href="#" class="btn btn-primary inner">Ajouter</a>--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                            </tbody>--}}
{{--                        </table>--}}
{{--                    </div>--}}

{{--                </div>--}}
{{--            </div>--}}
            <!-- end card -->
        </div>

        <div class="col-xl-8">

            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('contacts.update') }}" class="form-horizontal" method="POST" enctype="multipart/form-data" id="update-profile">
                            @csrf
                            <input type="hidden" value="{{ $user->slug }}" name="contact-slug" id="contact-slug">
                            <input type="hidden" value="{{ $user->id }}" name="profile-id" id="profile-id">

                            <div class="mb-3">
                                <label for="profile-lastname" class="form-label">Prénom</label>
                                <input type="text" class="form-control @error('profile-lastname') is-invalid @enderror"
                                       value="{{ $user->lastname }}" name="profile-lastname" id="profile-lastname" autofocus
                                       placeholder="Entrer prénom">
                                <div class="text-danger" id="lastnameError" data-ajax-feedback="lastname"></div>
                            </div>

                            <div class="mb-3">
                                <label for="profile-name" class="form-label">Prénom</label>
                                <input type="text" class="form-control @error('profile-lastname') is-invalid @enderror"
                                       value="{{ $user->name }}" name="profile-name" id="profile-name" autofocus
                                       placeholder="Entrer nom">
                                <div class="text-danger" id="nameError" data-ajax-feedback="name"></div>
                            </div>

                            <div class="mb-3">
                                <label for="profile-email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('profile-email') is-invalid @enderror"
                                       id="profile-email" value="{{ $user->email }}" name="profile-email"
                                       placeholder="Entrer email" autofocus>
                                <div class="text-danger" id="emailError" data-ajax-feedback="email"></div>
                            </div>

                            <div class="mb-3">
                                <label for="profile-phone" class="form-label">Téléphone</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror"
                                       id="profile-phone" value="{{ $user->phone }}" name="profile-phone"
                                       placeholder="Entrer téléphone" autofocus>
                                <div class="text-danger" id="phoneError" data-ajax-feedback="phone"></div>
                            </div>

                            <div class="mb-3">
                                <label for="profile-fonction" class="form-label">Fonction du poste</label>
                                <input type="text" class="form-control @error('profile-fonction') is-invalid @enderror"
                                       id="profile-fonction" value="{{ $user->post_fonction }}" name="profile-fonction"
                                       placeholder="Entrer fonction du poste" autofocus>
                                <div class="text-danger" id="fonctionError" data-ajax-feedback="profile-fonction"></div>
                            </div>

                            <div class="mb-3">
                                <label for="avatar">Image De Profile</label>
                                <div class="input-group">
                                    <input type="file"
                                           class="form-control @error('avatar') is-invalid @enderror"
                                           id="profile-img" name="profile-img"  autofocus>
                                    <label class="input-group-text" for="profile-img">Upload</label>
                                </div>
                                <div class="text-start mt-2">
                                    <img src="{{ isset($user->avatar) ? asset('storage/images/uploads/' . $user->client->slug . '/users/' . $user->slug . '/picture/' . $user->avatar) : "" }}" alt="{{ $user->name }}"
                                         class="rounded-circle avatar-lg">
                                </div>
                                <div class="text-danger" role="alert" id="avatarError" data-ajax-feedback="avatar"></div>
                            </div>

                            <div class="mt-3 d-grid">
                                <button class="btn btn-primary waves-effect waves-light UpdateProfile" data-id="{{ Auth::user()->id }}"
                                        type="submit">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
@endsection
@section('script')

@endsection
