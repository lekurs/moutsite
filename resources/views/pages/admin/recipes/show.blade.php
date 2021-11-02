@extends('layouts.master')

@section('title') Recettes @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Recettes @endslot
        @slot('title') Détail @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="media">
                        <img src="{{ isset($recipe->client->logo) ? asset('storage/images/uploads/' . $recipe->client->slug . '/logo/' . $recipe->client->logo) : asset('/assets/images/companies/img-1.png') }}" alt="{{ $recipe->client->name }}" class="avatar-sm me-4">

                        <div class="media-body overflow-hidden">
                            <h5 class="text-truncate font-size-15">{{ $recipe->label }}</h5>
                            <p class="text-muted">{{ $recipe->status }}</p>
                        </div>
                    </div>

                    <h5 class="font-size-15 mt-4">Description :</h5>

                    <p class="text-muted">{!! $recipe->description !!}</p>

                    <div class="row task-dates">
                        <div class="col-sm-4 col-6">
                            <div class="mt-4">
                                <h5 class="font-size-14"><i class="bx bx-calendar me-1 text-primary"></i> Date Début</h5>
                                <p class="text-muted mb-0">{{ \Carbon\Carbon::parse($recipe->start_date)->format('j M, Y') }}</p>
                            </div>
                        </div>

                        <div class="col-sm-4 col-6">
                            <div class="mt-4">
                                <h5 class="font-size-14"><i class="bx bx-calendar-check me-1 text-primary"></i> Date Fin
                                </h5>
                                <p class="text-muted mb-0">{{ !is_null($recipe->end_date) ? \Carbon\Carbon::parse($recipe->end_date)->format('j M, Y') : "En cours" }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Membres</h4>

                    <div class="table-responsive">
                        <table class="table align-middle table-nowrap">
                            <tbody>
                            @foreach( $recipe->users as $user)
                                <tr>
                                    <td style="width: 50px;">
                                        @if (is_null($user->avatar))
                                            <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-18 p-1">
                                                {{ \Illuminate\Support\Str::substr($user->name, 0, 1) . \Illuminate\Support\Str::substr($user->lastname, 0, 1) }}
                                            </span>
                                        @else
                                        <img src="{{ asset('/assets/images/users/avatar-2.jpg') }}"
                                             class="rounded-circle avatar-xs" alt="{{ $user->name . " " . $user->lastname }}">
                                        @endif
                                    </td>
                                    <td>
                                        <h5 class="font-size-14 m-0"><a href="" class="text-dark">{{ $user->name . " " . $user->lastname }}</a></h5>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Overview</h4>
                    @if( is_null($recipe->picture_path))
                        <img src="{{ asset('/assets/images/companies/img-1.png') }}" alt="" class="img-fluid w-100">
                        @else
                        <img src="{{ asset('storage/images/uploads/' . $recipe->client->slug . '/recipes/' . $recipe->picture_path) }}" alt="{{ $recipe->label }}" class="img-fluid w-100">
                        <h4 class="card-title mt-4">
                            <div class="text-center">
                                <a href="{{ asset('storage/images/uploads/' . $recipe->client->slug . '/recipes/' . $recipe->picture_path) }}" target="_blank" class="text-dark"><i class="bx bx-download h3 m-0"></i></a>
                            </div>
                        </h4>
                    @endif
                </div>
            </div>
        </div>
        <!-- end col -->

        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Commentaires</h4>

                    @if ( !is_null($recipe->comments) )
                    @foreach( $recipe->comments as $comment)
                        <div class="media mb-4">
                            <div class="me-3">
                                <img src="{{ isset($comment->user->avatar) ? asset('storage/images/uploads/' . $comment->user->client->slug . '/users/' . $comment->user->slug . '/picture/' . $comment->user->avatar) : asset('/assets/images/users/avatar-1.jpg') }}" alt="{{ $comment->user->name }}" class="img-thumbnail rounded-circle header-profile-client">
                            </div>
                            <div class="media-body">
                                <h5 class="font-size-13 mb-1">{!! substr($comment->description, 0, 40) !!}</h5>
                                    <p class="text-muted mb-1">{{ $comment->user->lastname . ' ' . $comment->user->name }}</p>
                            </div>
                            @if($comment->user_id === auth()->user()->id)
                                <div class="ms-3">
                                    <a href="#" class="text-muted font-size-16 edit-reply-link" data-bs-toggle="modal"
                                       data-bs-target=".edit-reply" data-comment-id="{{ $comment->id }}" data-comment = "{{ $comment->description }}">
                                        <i class="far fa-edit"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endforeach

                    @else
                        <div class="media-mb-4">
                            <div class="me-3">
                            </div>

                            <div class="media-body">
                                <h5 class="font-size-13 mb-1">Pas de commentaires pour le moment</h5>
                            </div>
                        </div>
                    @endif

                    <div class="text-center mt-4 pt-2">
                        <a href="#" class="btn btn-primary waves-effect waves-light btn-sm" data-bs-toggle="modal"
                           data-bs-target=".reply">Répondre</a>
                        @can('recipes.close.user')
                        <a href="" class="btn btn-primary waves-effect waves-light btn-sm" style="margin-left: 1em">Cloturer</a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->

    <!--  Reply -->
    <div class="modal fade reply" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Répondre</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('comments.store') }}" class="form-horizontal" method="POST" id="create_reply">
                        @csrf
                        <input type="hidden" value="{{ $recipe->id }}" id="comment_recipe_id" name="comment_recipe_id">
                        <input type="hidden" value="{{ auth()->user()->id }}" id="comment_user_id" name="comment_user_id">
                        <div class="mb-3">
                            <label for="page_label" class="form-label">Commentaire</label>
                            <textarea id="comment_description" name="comment_description"></textarea>
                        </div>

                        <div class="mt-3 d-grid">
                            <button class="btn btn-primary waves-effect waves-light UpdateProfile"
                                    type="submit">Créer</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!--  Edit Reply -->
    <div class="modal fade edit-reply" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Correction de ma réponse</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('comments.edit') }}" class="form-horizontal" method="POST" id="edit_reply">
                        @csrf
                        <input type="hidden" value="" id="comment_edit_recipe_id" name="comment_edit_recipe_id">
                        <div class="mb-3">
                            <label for="page_label" class="form-label">Commentaire</label>
                            <textarea id="edit_comment_description" name="edit_comment_description"></textarea>
                        </div>

                        <div class="mt-3 d-grid">
                            <button class="btn btn-primary waves-effect waves-light UpdateProfile"
                                    type="submit">Créer</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@endsection
@section('script')
    <!-- Summernote js -->
    <script src="{{ asset('/assets/libs/tinymce/tinymce.min.js') }}"></script>
    <script>
        tinymce.init({
            selector: "textarea#comment_description",
            height: 200,
            plugins: ["advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker", "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking", "save table contextmenu directionality emoticons template paste textcolor"],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
            style_formats: [{
                title: 'Bold text',
                inline: 'b'
            }, {
                title: 'Red text',
                inline: 'span',
                styles: {
                    color: '#ff0000'
                }
            }, {
                title: 'Red header',
                block: 'h1',
                styles: {
                    color: '#ff0000'
                }
            }, {
                title: 'Example 1',
                inline: 'span',
                classes: 'example1'
            }, {
                title: 'Example 2',
                inline: 'span',
                classes: 'example2'
            }, {
                title: 'Table styles'
            }, {
                title: 'Table row 1',
                selector: 'tr',
                classes: 'tablerow1'
            }]
        });
    </script>
    <script>
        tinymce.init({
            selector: "textarea#edit_comment_description",
            height: 200,
            plugins: ["advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker", "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking", "save table contextmenu directionality emoticons template paste textcolor"],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
            style_formats: [{
                title: 'Bold text',
                inline: 'b'
            }, {
                title: 'Red text',
                inline: 'span',
                styles: {
                    color: '#ff0000'
                }
            }, {
                title: 'Red header',
                block: 'h1',
                styles: {
                    color: '#ff0000'
                }
            }, {
                title: 'Example 1',
                inline: 'span',
                classes: 'example1'
            }, {
                title: 'Example 2',
                inline: 'span',
                classes: 'example2'
            }, {
                title: 'Table styles'
            }, {
                title: 'Table row 1',
                selector: 'tr',
                classes: 'tablerow1'
            }]
        });
    </script>

    <script>
        let editComment = document.querySelectorAll('.edit-reply-link');

        editComment.forEach((item) => {

            item.addEventListener('click', (event) => {
                let id = event.target.parentNode.getAttribute('data-comment-id')
                let comment = event.target.parentNode.getAttribute('data-comment')

                document.querySelector('#comment_edit_recipe_id').setAttribute('value', id);
                tinymce.get('edit_comment_description').setContent(comment);

            })
        })

    </script>
@endsection
