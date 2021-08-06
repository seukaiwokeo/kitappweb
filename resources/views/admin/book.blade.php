<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Yönetim Paneli</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link id="bsdp-css" href="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker3.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/work.css">
</head>
<body>
<div class="modal fade" id="editBookM" tabindex="-1" aria-labelledby="editBookMl" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBookMl">Düzenle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card book">
                            <div class="cover card-img-top" id="preview_cover_m" style="background-image: url(https://images-na.ssl-images-amazon.com/images/I/51uLvJlKpNL._SY291_BO1,204,203,200_QL40_FMwebp_.jpg)"></div>
                            <div class="card-body">
                                <h5 class="card-title" id="preview_title_m">The Hobbit</h5>
                                <div class="author"  id="preview_author_m">J. R. R. Tolkien</div>
                                <div class="pages"  id="preview_pages_m">300 sayfa</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row" id="book_add_m">
                            <form id="saving_book" class="needs-validation" novalidate>
                                <div class="mb-3 row">
                                    <label for="title_m" class="col-sm-2 col-form-label">Başlık</label>
                                    <div class="col-sm-4">
                                        <input type="text" required class="form-control" id="title_m">
                                    </div>
                                    <label for="cover_file_m" class="col-sm-2 col-form-label">Kitap kapağı</label>
                                    <div class="col-sm-4">
                                        <input class="form-control" type="file" id="cover_file_m">
                                        <input class="form-control" id="cover_m" name="cover_m" type="text" hidden>
                                    </div>
                                </div>
                                <div class="mb-4 row">
                                    <label for="summary_m" class="col-sm-2 col-form-label">Özet</label>
                                    <div class="col">
                                        <textarea class="form-control" required id="summary_m" rows="4"></textarea>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="author_m" class="col-sm-2 col-form-label">Yazar</label>
                                    <div class="col-sm-4">
                                        <input type="text" required class="form-control" id="author_m">
                                    </div>
                                    <label for="page_count_m" class="col-sm-2 col-form-label">Sayfa sayısı</label>
                                    <div class="col-sm-4">
                                        <input class="form-control" required type="number" id="page_count_m">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="publishing_date_m" class="col-sm-2 col-form-label">Yayım Tarihi</label>
                                    <div class="col-sm-4">
                                        <div class="input-group date">
                                            <input type="text" required id="publishing_date_m" name="publishing_date_m" class="form-control">
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <label for="maket_link_m" class="col-sm-2 col-form-label">Market Linki</label>
                                    <div class="col-sm-4">
                                        <input class="form-control" type="text" id="maket_link_m">
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <label for="market_price_m" class="col-sm-2 col-form-label">Market Fiyatı</label>
                                    <div class="col">
                                        <input type="text" class="form-control" id="market_price_m">
                                    </div>
                                </div>
                                <div class="mb-1 row" style="margin-top: 20px">
                                    <div class="d-grid gap-1">
                                        <button class="btn btn-primary" type="submit">Kaydet</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                <button type="button" class="btn btn-danger" onclick="removeBook()" data-bs-dismiss="modal">Sil</button>
            </div>
        </div>
    </div>
</div>
<nav class="navbar navbar-expand-lg navbar-dark bg-work1 nav-mat">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Yönetim Paneli</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#bizimNav" aria-controls="bizimNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="bizimNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Kitaplar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Kullanıcılar</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<main class="container py-3">
    <div class="row">
        <div class="col-md-3" style="padding-left: 0">
            <div class="card book">
                <div class="cover card-img-top" id="preview_cover" style="background-image: url(https://images-na.ssl-images-amazon.com/images/I/51uLvJlKpNL._SY291_BO1,204,203,200_QL40_FMwebp_.jpg)"></div>
                <div class="card-body">
                    <h5 class="card-title" id="preview_title">The Hobbit</h5>
                    <div class="author"  id="preview_author">J. R. R. Tolkien</div>
                    <div class="pages"  id="preview_pages">300 sayfa</div>
                </div>
            </div>
        </div>
        <div class="col-md-9" >
            <div class="row" id="book_add">
                <div class="card mb-3 addb">
                    <div class="card-header">
                        <div class="row flex-between-end">
                            <div class="col-auto flex-lg-grow-1 flex-lg-basis-0 align-self-center">
                                <h5 class="mb-0">Kitap Ekle</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-light">
                        <form id="adding_book" class="needs-validation" novalidate>
                            <div class="mb-3 row">
                                <label for="title" class="col-sm-2 col-form-label">Başlık</label>
                                <div class="col-sm-4">
                                    <input type="text" required class="form-control" id="title">
                                </div>
                                <label for="cover" class="col-sm-2 col-form-label">Kitap kapağı</label>
                                <div class="col-sm-4">
                                    <input class="form-control" required type="file" id="cover">
                                    <input class="form-control" id="cover_url" name="cover_url" type="text" hidden>
                                </div>
                            </div>
                            <div class="mb-4 row">
                                <label for="summary" class="col-sm-2 col-form-label">Özet</label>
                                <div class="col">
                                    <textarea class="form-control" required id="summary" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="author" class="col-sm-2 col-form-label">Yazar</label>
                                <div class="col-sm-4">
                                    <input type="text" required class="form-control" id="author">
                                </div>
                                <label for="page_count" class="col-sm-2 col-form-label">Sayfa sayısı</label>
                                <div class="col-sm-4">
                                    <input class="form-control" required type="number" id="page_count">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="publishing_date" class="col-sm-2 col-form-label">Yayım Tarihi</label>
                                <div class="col-sm-4">
                                    <div class="input-group date">
                                        <input type="text" required id="publishing_date" name="publishing_date" class="form-control">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </div>
                                <label for="maket_link" class="col-sm-2 col-form-label">Market Linki</label>
                                <div class="col-sm-4">
                                    <input class="form-control" type="text" id="maket_link">
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label for="market_price" class="col-sm-2 col-form-label">Market Fiyatı</label>
                                <div class="col">
                                    <input type="text" class="form-control" id="market_price">
                                </div>
                            </div>
                            <div class="mb-1 row" style="margin-top: 20px">
                                <div class="d-grid gap-1">
                                    <button class="btn btn-primary" type="submit">Ekle</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <h3 style="margin-top: 10px">Son Eklenenler</h3>
        <div class="d-flex" style="margin-bottom: 10px">
            <input class="form-control me-2" type="search" placeholder="Ara" aria-label="Ara">
            <button class="btn btn-primary" onClick="getBooks($(this).prev().val())">Ara</button>
        </div>
        <div class="row" id="book_list">
        </div>
    </div>
    <footer class="pt-4 my-md-5 pt-md-5 border-top">
        <div class="row">
            <div class="col-12 col-md">
                <small class="d-block mb-3 text-muted">Bullvio Technology © 2021-2022</small>
            </div>
        </div>
    </footer>
</main>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>
<script src="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/locales/bootstrap-datepicker.tr.min.js" charset="UTF-8"></script>
<script src="assets/js/notify.min.js"></script>
<script src="assets/js/work.js"></script>
</body>
</html>
