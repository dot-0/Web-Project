@extends('MasterLayout')
@section('content')
<div class="searchResBam">
    <div class="searchResTitle">
        Search Results...
    </div>
    <div class="searchResDiv">
        <div id="audioDiv">
            @for($i = 0 ; $i<sizeof($allSong) ; $i++)
            <div class="searchResult">
                <div class="songResultDiv" id="" onClick="window.open('/audio/{{$allSong[$i]->id}}','_blank');">
                    <img src="{{asset('').$allSong[$i]->poster}}">
                    <a>{{$allSong[$i]->title}}</a>
                    <div class="clearfix"></div>
                    <li>{{$artistArr[$i]}}</li>
                    <div class="clearfix"></div>
                    <li>
                        <img src="{{asset('images/starIcon.png')}}" class="ratingStar2">
                    </li>
                    <li>
                        <h3>{{$allSong[$i]->rating}}</h3>
                    </li>
                    <li>| &nbsp {{$allSong[$i]->users_listened}} views</li>
                </div>
            </div>
            @endfor
        </div>
        <div id="albumDiv">
            @foreach($allTag as $tag)
                <div class="searchResult">
                    <div class="artistResultDiv" id="" onclick="window.location = '/tag/{{$tag->id}}';">
                        <a>{{$tag->name}}</a>
                   </div>
                    <div class="artistTotalSong"><a style="text-decoration: none">{{sizeof($tag->audio_list)}}
                            @if(sizeof($tag->audio_list) < 2)
                                Song
                            @else
                                Songs
                            @endif
                        </a></div>
                </div>
            @endforeach
        </div>
        <div id="artistDiv">
            @foreach($allArtist as $artist)
            <div class="searchResult">
                <div class="artistResultDiv" id="" onclick="window.location = '/artist/{{$artist->id}}';">
                    <a>{{$artist->name}}</a>
                </div>
                 <div class="artistTotalSong"><a style="text-decoration: none" >{{sizeof($artist->audio_list)}}
                         @if(sizeof($artist->audio_list) < 2)
                             Song
                         @else
                             Songs
                         @endif
                     </a></div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="footerGap"></div>
</div>


<div class="searchResDan">
    <div class="filterBy">
        <h1>Filter By</h1>
    </div>
    <div class="filtersDiv">
        <div class="filters" id="audioFilter">
            <h1>Audios</h1>
        </div>
        <div class="filters" id="albumFilter">
            <h1>Genres</h1>
        </div>
        
        <div class="filters" id="artistFilter">
            <h1>Artists</h1>
        </div>
    </div>
</div>


<script type="text/javascript">
$(function() {

    $('#audioFilter').click(function(e) {
        $(this).css('background-color', '#023131');
        $("#albumFilter").css('background-color', '#232323');
        $("#artistFilter").css('background-color', '#232323');

        $("#audioDiv").delay(100).fadeIn(100);
        
        $("#artistDiv").fadeOut(100);
        $("#albumDiv").fadeOut(100);
        
        $('#albumFilter').removeClass('active');
        $('#artistFilter').removeClass('active');
        
        $(this).addClass('active');
        
        e.preventDefault();
    });

    $('#albumFilter').click(function(e) {
        $(this).css('background-color', '#023131');
        $("#audioFilter").css('background-color', '#232323');
        $("#artistFilter").css('background-color', '#232323');

        $("#albumDiv").delay(100).fadeIn(100);
        
        $("#audioDiv").fadeOut(100);
        $("#artistDiv").fadeOut(100);
        
        
      
        e.preventDefault();
    });

    $('#artistFilter').click(function(e) {
        $(this).css('background-color', '#023131');
        $("#albumFilter").css('background-color', '#232323');
        $("#audioFilter").css('background-color', '#232323');
        
        $("#artistDiv").delay(100).fadeIn(100);
        
        $("#audioDiv").fadeOut(100);
        $("#albumDiv").fadeOut(100);
        
        $('#albumFilter').removeClass('active');
        $('#audioFilter').removeClass('active');
        $(this).addClass('active');

        e.preventDefault();
    });
});
</script>

@endsection