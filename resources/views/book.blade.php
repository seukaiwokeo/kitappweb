@php use App\Http\Controllers\ActionBookController; @endphp
@extends("layout.page")
@section("page_title", $book->title)

@section("body")
    <div class="row">
        <div class="col-md-12">
            <div class="row book page" data-id="{{$book->id}}">
                <div class="overlay" style="background-image: url({{URL::to('/')}}/{{$book->cover}})"></div>
                <div class="col-md-3 cover" id="e_cover" style="height: 400px; background-image: url({{URL::to('/')}}/{{$book->cover}})"></div>
                <div class="col-md-8 card-body">
                    <h5 class="card-title" id="e_title">{{$book->title}}</h5>
                    <div class="summary" id="e_pages">{{$book->summary}}</div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card book page">
                <div class="card-body">
                    <ul class="nav">
                        <li class="nav-item">
                            <a href="{{URL::to('/')}}/author/{{$book->authorId}}">
                                <span class="book-detail-item">
                                    <i class="bi bi-pencil"></i>
                                    <img width="16" src="{{URL::to('/')}}/{{$book->authorAvatar}}"> {{$book->authorName}}
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <span class="book-detail-item"><i class="bi bi-paperclip"></i> {{$book->page_count}} sayfa</span>
                        </li>
                        <li class="nav-item">
                            <span class="book-detail-item"><i class="bi bi-heart-fill"></i>
                                @if ($book->unlike_count > 0)
                                    {{$book->like_count * 100 / ($book->like_count + $book->unlike_count)}}%
                                @else
                                -
                                @endif
                            </span>
                        </li>
                        <li class="nav-item">
                            <span class="book-detail-item"><i class="bi bi-check2-all"></i> {{$book->read_count}}</span>
                        </li>
                        <li class="nav-item">
                            <span class="book-detail-item"><i class="bi bi-bookmark-heart-fill"></i> {{$book->to_read_count}}</span>
                        </li>
                        <li class="nav-item">
                            <span class="book-detail-item"><i class="bi bi-eye-fill"></i> {{$book->views}}</span>
                        </li>
                        <li class="nav-item">
                            <span class="book-detail-item"><i class="bi bi-calendar"></i> {{$book->publishing_date}}</span>
                        </li>
                        @if($book->market_link)
                        <li class="nav-item">
                            <span class="book-detail-item"><i class="bi bi-bag"></i> {{$book->market_link}}</span>
                        </li>
                        @endif
                        @if($book->market_price)
                            <li class="nav-item">
                                <span class="book-detail-item"><i class="bi bi-tag"></i> {{number_format($book->market_price, 2)}}₺</span>
                            </li>
                        @endif
                    </ul>
                </div>

            </div>
            <div class="col-md-12">
                <div class="float-right">
                    <button class="btn btn-primary"><i class="bi bi-bookmark-heart-fill"></i> Okuyacağım</button>
                    <button class="btn btn-secondary"><i class="bi bi-check2-all"></i> Okudum</button>
                </div>
            </div>
            <div class="clearfix"></div>
            @php $books = ActionBookController::similarBooks($book->id); @endphp
            @if($books != null)
            <h3>Benzerleri</h3>
            <div class="col-md-12">
                <div class="owl-carousel">
                        @foreach ($books as $book)
                            <div class="col-md-12" onclick="window.location.replace('{{URL::to('/')}}/book/{{$book->id}}')">
                                <div class="card book" data-id="{{$book->id}}">
                                    <div class="cover card-img-top" id="e_cover" style="background-image: url({{URL::to('/')}}/{{$book->cover}})"></div>
                                    <div class="card-body">
                                        <h5 class="card-title" id="e_title">{{$book->title}}</h5>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection

@section("head")
    <link rel="stylesheet" href="{{URL::to('/')}}/assets/css/owl/owl.carousel.min.css">
@endsection

@section("scripts")
    <script src="{{URL::to('/')}}/assets/js/owl/owl.carousel.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.owl-carousel').owlCarousel({
                items:4,
                lazyLoad:true,
                loop:true,
                margin:10,
                autoplay:true,
                responsive : {
                    0 : {
                        items : 1
                    },
                    480 : {
                        items : 2
                    },
                    768 : {
                        items : 3
                    },
                    1024 : {
                        items : 4
                    }
                }
            });
        });
    </script>
@endsection
