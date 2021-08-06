@php use App\Http\Controllers\ActionBookController; @endphp
@extends("layout.page")
@section("page_title", $author->name)
@php $books = ActionBookController::authorsBooks($author->id); @endphp

@section("head")
    @if($books != null)
        <style>
            .profile-cover:before {
                background-image: url('{{URL::to('/')}}/{{$books[0]->cover}}');
            }
        </style>

    @endif
@endsection

@section("body")
    <div class="row py-5 px-4">
        <div class="col-md-12 mx-auto">
            <div class="bg-white shadow rounded overflow-hidden overlay-parent">
                <div class="px-4 pt-0 profile-cover">
                    <div class="media align-items-end profile-head">
                        <div class="profile mr-3"><img src="{{URL::to('/')}}/{{$author->avatar}}" alt="{{$author->name}}" width="130" class="rounded mb-2 img-thumbnail"></div>
                        <div class="media-body mb-5">
                            <h4 class="mt-0 mb-0">{{$author->name}}</h4>
                            <p class="small mb-4"> <i class="fas fa-map-marker-alt mr-2"></i>{{$author->birth_date}} @if($author->location) - {{$author->location}} @endif</p>
                        </div>
                    </div>
                </div>
                <div class="bg-light p-4 d-flex justify-content-end text-center">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <h5 class="font-weight-bold mb-0 d-block">{{$author->read_count}}</h5><small class="text-muted"> <i class="bi bi-check2-all"></i></small>
                        </li>
                        <li class="list-inline-item">
                            <h5 class="font-weight-bold mb-0 d-block">{{$author->to_read_count}}</h5><small class="text-muted"> <i class="bi bi-bookmark-heart-fill"></i> </small>
                        </li>
                        <li class="list-inline-item">
                            <h5 class="font-weight-bold mb-0 d-block">{{$author->like}}</h5><small class="text-muted"> <i class="bi bi-heart-fill"></i></small>
                        </li>
                    </ul>
                </div>
                <div class="px-4 py-3">
                    <h5 class="mb-0">Hakkında</h5>
                    <div class="p-4 rounded shadow-sm bg-light">
                        <p class="font-italic mb-0">{{$author->about}}</p>
                    </div>
                </div>
                <div class="py-4 px-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="mb-0">Son kitaplar</h5><a href="{{URL::to('/')}}/author/{{$author->id}}/books" class="btn btn-primary">Hepsini göster</a>
                    </div>
                    <div class="row">
                        @if($books != null)
                            @foreach ($books as $book)
                                <div class="col-md-3" onclick="window.location.replace('{{URL::to('/')}}/book/{{$book->id}}')">
                                    <div class="card book" data-id="{{$book->id}}">
                                        <div class="cover card-img-top" id="e_cover" style="background-image: url({{URL::to('/')}}/{{$book->cover}})"></div>
                                        <div class="card-body">
                                            <h5 class="card-title" id="e_title">{{$book->title}}</h5>
                                            <div class="pages" id="e_pages">{{$book->page_count}} sayfa</div>
                                            <div class="summary" id="e_pages">{{substr($book->summary, 0, 50)}}...</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
