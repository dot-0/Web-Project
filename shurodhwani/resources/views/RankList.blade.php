@extends('MasterLayout')
@section('content')
<div class="searchResBam">
    <div class="searchResTitle">
        
        @if(sizeof($ratingSorted)<100)
        {{sizeof($ratingSorted)}} Songs ( All)
        @else
        Top 100
        @endif
    </div>
    <div class="searchResDiv">
        <div id="rankDiv1">
            @for($i = 0 ; $i<min(sizeof($ratingSorted), 100) ; $i++)
            <div class="searchResult">
                <div class="songResultDiv" id="" onClick="window.open('/audio/{{$ratingSorted[$i]->id}}','_blank');">
                    <img src="{{asset('').$ratingSorted[$i]->poster}}">
                    <a>{{$ratingSorted[$i]->title}}</a>
                    <div class="clearfix"></div>
                    <li>{{$rating_artist_arr[$i]}}</li>
                    <div class="clearfix"></div>
                    <li>
                        <img src="{{asset('images/starIcon.png')}}" class="ratingStar2">
                    </li>
                    <li>
                        <h3>{{$ratingSorted[$i]->rating}}</h3>
                        <li>| &nbsp {{$ratingSorted[$i]->users_listened}} views</li>
                    </li>
                    <div class="albumTotalSong"><h5>{{$i + 1}}</h5></div>
                </div>
            </div>
            @endfor
        </div>

        <div id="rankDiv2" style="display: none">
            @for($i = 0 ; $i<min(sizeof($listenSorted), 100) ; $i++)
            <div class="searchResult">
                <div class="songResultDiv" id="" onClick="window.open('/audio/{{$listenSorted[$i]->id}}','_blank');">
                    <img src="{{asset('').$listenSorted[$i]->poster}}">
                    <a>{{$listenSorted[$i]->title}}</a>
                    <div class="clearfix"></div>
                    <li>{{$listen_artist_arr[$i]}}</li>
                    <div class="clearfix"></div>
                    <li>
                        <img src="{{asset('images/starIcon.png')}}" class="ratingStar2">
                    </li>
                    <li>
                        <h3>{{$listenSorted[$i]->rating}}</h3>
                        <li>| &nbsp {{$listenSorted[$i]->users_listened}} views</li>
                    </li>
                    <div class="albumTotalSong"><h5>{{$i + 1}}</h5></div>
                </div>
            </div>
            @endfor
        </div>
    </div>
    <div class="footerGap"></div>
</div>

<div class="searchResDan">
    <div class="filterBy">
        <h1>Sort By</h1>
    </div>
    <div class="filtersDiv">
        <div class="filters" id="ratingFilter">
            <h1>Rating</h1>
        </div>
        <div class="filters" id="viewsFilter">
            <h1>Views</h1>
        </div>

    </div>
</div>

<script type="text/javascript">
$(function() {

    $("#ratingFilter").css('background-color', '#023131');

    $('#ratingFilter').click(function(e) {
        $(this).css('background-color', '#023131');
        $("#viewsFilter").css('background-color', '#232323');
        
        $('#viewsFilter').removeClass('active');


        $("#rankDiv1").delay(100).fadeIn(100);
        
        $("#rankDiv2").fadeOut(100);
        
        $(this).addClass('active');
        
        e.preventDefault();
    });

    $('#viewsFilter').click(function(e) {
        $(this).css('background-color', '#023131');
        $("#ratingFilter").css('background-color', '#232323');
        
        $('#ratingFilter').removeClass('active');

        $("#rankDiv2").delay(100).fadeIn(100);
        
        $("#rankDiv1").fadeOut(100);
        
        
        $(this).addClass('active');
        
        e.preventDefault();
    });
});
</script>

@endsection