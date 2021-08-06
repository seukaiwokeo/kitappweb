@php use App\Http\Controllers\ActionBookController; @endphp
@extends("layout.page")
@section("page_title", "Giriş")

@section("head")
    <link rel="stylesheet" href="{{URL::to('/')}}/assets/css/login.css">
    <style>
        .cover {
            height: 100px }
        @media (max-width: 991.98px) {
            .cover {
                height: 584px } }
    </style>
@endsection

@section("body")
    <div class="row justify-content-center" style="margin-top: 2rem">
        <div class="col-md-10 text-center">
            <h4><q>Artık kozmik düşünmeye başlıyoruz. Sempati
                    hislerimiz bilinmeyen uzaklıklara kadar yayılıyor.</q> - Nikola Tesla</h4>
        </div>
        <div class="col-md-12 col-lg-10 py-3">
            <div class="wrap d-md-flex">
                <div class="text-wrap p-4 p-lg-5 text-center d-flex align-items-center order-md-last">
                    <div class="text w-100">
                        <h2>Merhaba</h2>
                        <p>Kütüphane kartın yok mu?</p>
                        <a href="register" class="btn btn-dark">Kayıt Ol</a>
                    </div>
                </div>
                <div class="login-wrap p-4 p-lg-5">
                    <div class="d-flex">
                        <div class="w-100">
                            <h3 class="mb-4">Kapı</h3>
                        </div>
                    </div>
                    <form method="POST" class="signin-form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="form-group mb-3">
                            <label class="label" for="uid">Kullanıcı Adı veya E-Posta</label>
                            <input type="text" id="uid" name="uid" class="form-control" required="">
                        </div>
                        <div class="form-group mb-3">
                            <label class="label" for="password">Şifre</label>
                            <input type="password" id="password" name="password" class="form-control" required="">
                        </div>
                        <div class="form-group d-md-flex py-2">
                            <div class="w-50 text-left">
                                <label class="checkbox-wrap checkbox-primary mb-0">Beni Unutma
                                    <input type="checkbox" name="remember" checked="">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="w-50 text-md-right">
                                <a href="#">Şifremi Unuttum!</a>
                            </div>
                        </div>
                        <div class="form-group py-2">
                            <button type="submit" class="btn btn-primary submit px-3" style="width: 100%">Geçiş Yap</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center py-3">
        <div class="col-md-12 col-lg-10">
            <div class="row">
                @php $books = ActionBookController::bookQuery(); @endphp
                @if($books != null)
                    @foreach ($books as $book)
                        <div class="col-md-1">
                            <a href="{{URL::to('/')}}/book/{{$book->id}}">
                                <div class="card book" data-id="{{$book->id}}">
                                    <div class="cover card-img-top" id="e_cover" style="background-image: url({{URL::to('/')}}/{{$book->cover}})"></div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection
