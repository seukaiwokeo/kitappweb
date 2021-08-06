@php use App\Http\Controllers\ActionBookController; @endphp
@extends("layout.page")
@section("page_title", "Kütüphane")

@section("body")
    <div class="row">
        <div class="col-md-3">
            @php $authors = \App\Http\Controllers\ActionAuthorController::randomAuthors(); @endphp
            @if($authors != null)
                <div class="col-md-12 py-3">
                    <h3>Yazarlar</h3>
                    <div class="list-group">
                        @foreach ($authors as $author)
                            <div class="list-group-item row" style="padding: 5px">
                                <div class="book-img col-md-3" style="background-image: url('{{URL::to('/')}}/{{$author->avatar}}')" onclick="window.location.replace('{{URL::to('/')}}/author/{{$author->id}}')"></div>
                                <div class="col-md-9 brf">
                                    <a href="{{URL::to('/')}}/author/{{$author->id}}">{{$author->name}}</a>
                                    <br />
                                    {{substr($author->location, 0, 15)}}...
                                    <br />
                                    Beğeni: {{$author->like}}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            @php $rands = ActionBookController::randomBooks(); @endphp
            @if($rands != null)
                <div class="col-md-12 py-3">
                    <h3>Ne Okumalı?</h3>
                    <div class="list-group">
                        @foreach ($rands as $book)
                            <div class="list-group-item row" style="padding: 5px">
                                <div class="book-img col-md-3" style="background-image: url('{{URL::to('/')}}/{{$book->cover}}')" onclick="window.location.replace('{{URL::to('/')}}/book/{{$book->id}}')"></div>
                                <div class="col-md-9 brf">
                                    <a href="{{URL::to('/')}}/book/{{$book->id}}">{{$book->title}}</a>
                                    <div class="pages" id="e_pages">{{$book->page_count}} sayfa</div>
                                    <a href="{{URL::to('/')}}/author/{{$book->authorId}}">
                                        <img width="16" src="{{URL::to('/')}}/{{$book->authorAvatar}}"> {{$book->authorName}}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        <div class="col-md-9 py-3" id="book_list">
            <div class="row">
                @php $book = ActionBookController::latestBook(); @endphp
                @if($book != null)
                    <h3>Son Çıkan</h3>
                    <div class="col-md-12" onclick="window.location.replace('{{URL::to('/')}}/book/{{$book->id}}')">
                        <div class="row book latest" data-id="{{$book->id}}">
                            <div class="col-md-4 cover" id="e_cover" style="height: 400px; background-image: url({{URL::to('/')}}/{{$book->cover}})"></div>
                            <div class="col-md-7 card-body">
                                <h5 class="card-title" id="e_title">{{$book->title}}</h5>
                                <div class="author" id="e_author">
                                    <a href="{{URL::to('/')}}/author/{{$book->authorId}}">
                                        <i class="bi bi-pencil"></i>
                                        <img width="16" src="{{URL::to('/')}}/{{$book->authorAvatar}}"> {{$book->authorName}}
                                    </a>
                                </div>
                                <div class="pages" id="e_pages">{{$book->page_count}} sayfa</div>
                                <div class="summary" id="e_pages">{{substr($book->summary, 0, 800)}}...</div>
                            </div>
                        </div>
                    </div>
                @endif
                @php $books = ActionBookController::bookQuery(); @endphp
                @if($books != null)
                    <h3>Gündem</h3>
                    @foreach ($books as $book)
                        <div class="col-md-3" onclick="window.location.replace('{{URL::to('/')}}/book/{{$book->id}}')">
                            <div class="card book" data-id="{{$book->id}}">
                                <div class="cover card-img-top" id="e_cover" style="background-image: url({{URL::to('/')}}/{{$book->cover}})"></div>
                                <div class="card-body">
                                    <h5 class="card-title" id="e_title">{{$book->title}}</h5>
                                    <div class="author" id="e_author">
                                        <a href="{{URL::to('/')}}/author/{{$book->authorId}}">
                                            <i class="bi bi-pencil"></i>
                                            <img width="16" src="{{URL::to('/')}}/{{$book->authorAvatar}}"> {{$book->authorName}}
                                        </a>
                                    </div>
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

@endsection
