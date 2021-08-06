<nav class="navbar navbar-expand-lg navbar-dark bg-work1 nav-mat fixed-top">
    <div class="container">
        <div class="row" style="width: 100%">
            <div class="col col-md-3">
                <a class="navbar-brand" href="{{URL::to('/')}}/">Kitappweb</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#bizimNav" aria-controls="bizimNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="col col-md-9">
                <div class="collapse navbar-collapse" id="bizimNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <input class="form-control me-2" type="search" placeholder="Ara" aria-label="Ara">
                    </ul>
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <a class="hlink" href="library"><i class="bi bi-book"></i> Kütüphane</a>
                    </ul>
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <a class="hlink" href="collections"><i class="bi bi-collection"></i> Koleksiyon</a>
                    </ul>
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <a class="hlink" href="discover"><i class="bi bi-search"></i> Keşfet</a>
                    </ul>
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <a class="hlink" href="wordbook"><i class="bi bi-alt"></i> Sözlük</a>
                    </ul>
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <a class="hlink" href="dissection"><i class="bi bi-bar-chart-steps"></i> Tartışmalar</a>
                    </ul>
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <a class="hlink" href="account"><i class="bi bi-person"></i> Hesap</a>
                    </ul>
                </div>
            </div>
        </div>
        @yield("nav")
    </div>
</nav>
