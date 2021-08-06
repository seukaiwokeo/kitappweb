@php use App\Http\Controllers\ActionBookController; @endphp
@extends("layout.page")
@section("page_title", "Kütüphane")

@section("body")
    <div class="row" id="book_list">
        @php $books = ActionBookController::bookQuery(null, 20, $author->id); @endphp
        @if($books != null)
            <h3>{{$author->name}} Kitapları</h3>
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
@endsection
