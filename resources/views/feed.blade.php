@php use App\Http\Controllers\ActionBookController; @endphp
@extends("layout.page")
@section("page_title", "Akış")

@section("head")
    <style>
        .list-group-item i { margin-right: 5px }
    </style>
@endsection

@section("body")
    <div class="row">
        <div class="col-md-3">
            <div class="col-md-12 py-3">
                <h3>Gezin</h3>
                <div class="list-group">
                    <div class="list-group-item">
                        <i class="bi bi-stars"></i> <a href="{{URL::to('/')}}/trends">Gündem</a>
                    </div>
                    <div class="list-group-item">
                        <i class="bi bi-pencil-fill"></i> <a href="{{URL::to('/')}}/authors">Yazarlar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-12 py-3">
                <h3>Ben</h3>
                <div class="list-group">
                    <div class="list-group-item">
                        <i class="bi bi-emoji-heart-eyes-fill"></i> <a href="{{URL::to('/')}}/user/forme">Bana Özel</a>
                    </div>
                    <div class="list-group-item">
                        <i class="bi bi-inbox-fill"></i> <a href="{{URL::to('/')}}/user/inbox">Gelen Kutusu</a>
                    </div>
                    <div class="list-group-item">
                        <i class="bi bi-check-all"></i> <a href="{{URL::to('/')}}/user/reads">Okuduklarım</a>
                    </div>
                    <div class="list-group-item">
                        <i class="bi bi-bookmark-heart-fill"></i> <a href="{{URL::to('/')}}/user/toreads">Okuyacaklarım</a>
                    </div>
                    <div class="list-group-item">
                        <i class="bi bi-heart-fill"></i> <a href="{{URL::to('/')}}/user/authors">Beğendiğim Yazarlar</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 py-4">
            <div class="central-meta">
                <div class="new-postbox">
                    <figure>
                        <img src="images/resources/admin2.jpg" alt="">
                    </figure>
                    <div class="newpst-input">
                        <form method="post">
                            <textarea rows="2" placeholder="write something"></textarea>
                            <div class="attachments">
                                <ul>
                                    <li>
                                        <i class="fa fa-music"></i>
                                        <label class="fileContainer">
                                            <input type="file">
                                        </label>
                                    </li>
                                    <li>
                                        <i class="fa fa-image"></i>
                                        <label class="fileContainer">
                                            <input type="file">
                                        </label>
                                    </li>
                                    <li>
                                        <i class="fa fa-video-camera"></i>
                                        <label class="fileContainer">
                                            <input type="file">
                                        </label>
                                    </li>
                                    <li>
                                        <i class="fa fa-camera"></i>
                                        <label class="fileContainer">
                                            <input type="file">
                                        </label>
                                    </li>
                                    <li>
                                        <button type="submit">Post</button>
                                    </li>
                                </ul>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="central-meta item" style="display: inline-block;">
                <div class="user-post">
                    <div class="friend-info">
                        <figure>
                            <img src="images/resources/friend-avatar10.jpg" alt="">
                        </figure>
                        <div class="friend-name">
                            <ins><a href="time-line.html" title="">Janice Griffith</a></ins>
                            <span>published: june,2 2018 19:PM</span>
                        </div>
                        <div class="post-meta">

                            <div class="we-video-info">
                                <ul>
                                    <li>
															<span class="views" data-toggle="tooltip" title="" data-original-title="views">
																<i class="fa fa-eye"></i>
																<ins>1.2k</ins>
															</span>
                                    </li>
                                    <li>
															<span class="comment" data-toggle="tooltip" title="" data-original-title="Comments">
																<i class="fa fa-comments-o"></i>
																<ins>52</ins>
															</span>
                                    </li>
                                    <li>
															<span class="like" data-toggle="tooltip" title="" data-original-title="like">
																<i class="ti-heart"></i>
																<ins>2.2k</ins>
															</span>
                                    </li>
                                    <li>
															<span class="dislike" data-toggle="tooltip" title="" data-original-title="dislike">
																<i class="ti-heart-broken"></i>
																<ins>200</ins>
															</span>
                                    </li>

                                </ul>
                            </div>
                            <div class="description">

                                <p>
                                    World's most beautiful car in Curabitur <a href="#" title="">#test drive booking !</a> the most beatuiful car available in america and the saudia arabia, you can book your test drive by our official website
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-3">

        </div>
    </div>
@endsection
