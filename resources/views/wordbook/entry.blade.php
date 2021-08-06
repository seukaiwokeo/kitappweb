@php use App\Http\Controllers\ActionWordbookController; @endphp
@extends("layout.page")
@section("page_title", $entry->title . " | Sözlük")

@section("head")
    <style>
        .bg-work1 { padding-bottom: 0 !important; }
    </style>
@endsection

@section("scripts")
    <script>
        $(".s-trends").click(function() {
            $(".s-trends").removeClass("active");
            $(".trend-list").hide();
            $(this).addClass("active");
            $(".trend-list[data-id=" + $(this).data("id") + "]").show();
        });
    </script>
@endsection

@section("nav")
    @php $topTags = \App\Http\Controllers\ActionWordbookController::tagQuery(0, 20); @endphp
    @php $tags = \App\Http\Controllers\ActionWordbookController::tagQuery(); @endphp
    @if($tags != null)
        <div class="row" style="width: 100%; margin-top: 10px">
            <div class="col-md-12">
                <div class="collapse navbar-collapse" id="bizimNav2">
                    <ul class="navbar-nav col-md-1">
                        <div class="s-trends active" data-id="-1">#gündem</div>
                    </ul>
                    @foreach ($tags as $row)
                        <ul class="navbar-nav col-md-1">
                            <div class="s-trends" data-id="{{$row->id}}">#{{$row->title}}</div>
                        </ul>
                    @endforeach
                    @php $tagsOther = \App\Http\Controllers\ActionWordbookController::tagQuery(10); @endphp
                    @if($tagsOther != null)
                        <ul class="navbar-nav col-md-1">
                            <div class="dropdown">
                                <button class="s-trends-btn dropdown-toggle" type="button" id="other_trends" data-bs-toggle="dropdown" aria-expanded="false">
                                    diğerleri
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="other_trends">
                                    @foreach ($tagsOther as $row)
                                        <li><div class="dropdown-item s-trends" data-id="{{$row->id}}">{{$row->title}}</div></li>
                                    @endforeach
                                </ul>
                            </div>
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    @endif
@endsection

@section("body")
    <div class="row py-3 wordbook">
        <div class="col-md-3">
            <div class="list-group trend-list" data-id="-1">
                @php $trends = \App\Http\Controllers\ActionWordbookController::trends(); @endphp
                @if($trends != null)
                    @foreach ($trends as $row)
                        <div class="list-group-item row trends">
                            <div class="user-img col-md-2" style="background-image: url('{{URL::to('/')}}/images/avatar/{{$row->userAvatar}}')" onclick="window.location.replace('{{URL::to('/')}}/u/{{strtolower($row->userName)}}')"></div>
                            <div class="col-md-8">
                                <a href="{{URL::to('/')}}/wordbook/entry/{{$row->title_seo}}">{{$row->title}}</a>
                            </div>
                            <div class="col-md-2">
                                {{$row->totalCount}}
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            @if($topTags != null)
                @foreach ($topTags as $row)
                    <div class="list-group trend-list" data-id="{{$row->id}}" style="display: none">
                        @php $trends = \App\Http\Controllers\ActionWordbookController::trends($row->id); @endphp
                        @if($trends != null)
                            @foreach ($trends as $row)
                                <div class="list-group-item row trends">
                                    <div class="user-img col-md-2" style="background-image: url('{{URL::to('/')}}/images/avatar/{{$row->userAvatar}}')" onclick="window.location.replace('{{URL::to('/')}}/u/{{strtolower($row->userName)}}')"></div>
                                    <div class="col-md-8">
                                        <a href="{{URL::to('/')}}/wordbook/entry/{{$row->title_seo}}">{{$row->title}}</a>
                                    </div>
                                    <div class="col-md-2">
                                        {{$row->totalCount}}
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                @endforeach
            @endif

        </div>
        <div class="col-md-7">
            <div class="central-meta item" style="display: inline-block;">
                <div class="user-post">
                    <div class="friend-info">
                        <h3>{{$entry->title}}</h3>
                        <div class="post-meta">
                            <div class="description">
                                <p>
                                    {!! str_replace("\n", "<br/>", $entry->content) !!}
                                </p>
                            </div>
                        </div>
                        <hr>
                        <figure>
                            <div class="avatar" style="background-image: url('{{URL::to('/')}}/images/avatar/{{$entry->userAvatar}}')"></div>
                        </figure>
                        <div class="friend-name">
                            <ins><a href="{{URL::to('/')}}/u/{{strtolower($entry->userName)}}" title="">{{$entry->userUserName}}</a></ins>
                            <span>{{$entry->created_at}}</span>
                        </div>
                    </div>
                </div>
            </div>
            @php $replies = \App\Http\Controllers\ActionWordbookController::replies($entry->id); @endphp
            @if($replies != null)
                @foreach ($replies as $row)
                    <div class="central-meta item" style="display: inline-block;">
                        <div class="user-post">
                            <div class="friend-info">
                                <div class="post-meta">
                                    <div class="description">
                                        <p>
                                            {!! str_replace("\n", "<br/>", $row->content) !!}
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <figure>
                                    <div class="avatar" style="background-image: url('{{URL::to('/')}}/images/avatar/{{$row->userAvatar}}')"></div>
                                </figure>
                                <div class="friend-name">
                                    <ins><a href="{{URL::to('/')}}/u/{{strtolower($row->userName)}}" title="">{{$row->userUserName}}</a></ins>
                                    <span>{{$row->created_at}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="col-md-2">
            @php $rands = \App\Http\Controllers\ActionWordbookController::topAuthor(); @endphp
            @if($rands != null)
                <h4>En Çok Yazanlar</h4>
                <div class="list-group">
                    @foreach ($rands as $row)
                        <div class="list-group-item row">
                            <div class="user-img col-md-2" style="background-image: url('{{URL::to('/')}}/images/avatar/{{$row->avatar}}')" onclick="window.location.replace('{{URL::to('/')}}/u/{{strtolower($row->username)}}')"></div>
                            <div class="col-md-8">
                                <a href="{{URL::to('/')}}/u/{{strtolower($row->username)}}">{{$row->username}}</a>
                            </div>
                            <div class="col-md-1">
                                {{$row->TotalCount}}
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
