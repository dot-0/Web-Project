@extends('MasterLayout')
@section('content')
<div class="playerContainer">
	<div class="MP_title">
		{{$playlist_title}}
	</div>
	<div class="mediumGap"></div>
	<div class="MP_Container">
		<div class="column add-bottom">
			<div id="mainwrap">
				<div id="nowPlay">
					<span class="left" id="npAction">Paused...</span>
					<span class="right" id="npTitle"></span>
				</div>
                <div id="audiowrap"><div class="MP_container_1">
                        <div>
                            <audio preload id="audio1" controls="controls">Your browser does not support HTML5 Audio!</audio>
                        </div>
                        <div id="tracks">
                            <a id="btnPrev" >
                                <img src="{{asset('images/prev.png')}}" class="backButton">
                            </a>
                            <a id="btnNext">
                                <img src="{{asset('images/next.png')}}" class="backButton">
                            </a>
                        </div>
                    </div>
                </div>
			<div id="plwrap">
				<ul id="plList">
                    @for($i = 0 ; $i < sizeof($title_arr) ; $i++)
                        <li>
                            <div class="plItem" id="{{$id_arr[$i]}}">
                                <div class="plNum">{{$i + 1}}.</div>
                                <div class="plTitle"><a href="/audio/{{$id_arr[$i]}}" target="_blank">{{$title_arr[$i]}}</a></div>
                            </div>
                        </li>
                    @endfor
				</ul>
			</div>
		</div>
	</div>
</div>
</div>
<script src={{asset('http://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js')}}></script>
<script src={{asset('http://api.html5media.info/1.1.8/html5media.min.js')}}></script>
<script type="text/javascript">

    var b = document.documentElement;
b.setAttribute('data-useragent', navigator.userAgent);
b.setAttribute('data-platform', navigator.platform);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

jQuery(function ($) {
    var supportsAudio = !!document.createElement('audio').canPlayType;
    var playlist = [];
    var title_arr = {!! json_encode($title_arr) !!};
    var id_arr = {!! json_encode($id_arr) !!};
    var path_arr = {!! json_encode($path_arr) !!};
    for(i = 0 ; i < title_arr.length ; i++) {
        var add = {
            "track": i,
            "name": title_arr[i],
            "file": path_arr[i]
        };
        console.log(add);
        playlist.push(add);
    }
    console.log("HI");
    if (supportsAudio) {
        var index = 0,
            playing = false,
            mediaPath = {!! json_encode(url('/')) !!} + '/',
            extension = '',
            tracks = playlist,
            trackCount = tracks.length,
            npAction = $('#npAction'),
            npTitle = $('#npTitle'),
            audio = $('#audio1').bind('play', function () {
                playing = true;
                npAction.text('Now Playing...');
            }).bind('pause', function () {
                playing = false;
                npAction.text('Paused...');
            }).bind('ended', function () {
                npAction.text('Paused...');
                if ((index + 1) < trackCount) {
                    index++;
                    loadTrack(index);
                    audio.play();
                } else {
                    audio.pause();
                    index = 0;
                    loadTrack(index);
                }
            }).get(0),
            btnPrev = $('#btnPrev').click(function () {
                if ((index - 1) > -1) {
                    index--;
                    loadTrack(index);
                    if (playing) {
                        audio.play();
                    }
                } else {
                    audio.pause();
                    index = 0;
                    loadTrack(index);
                }
            }),
            btnNext = $('#btnNext').click(function () {
                if ((index + 1) < trackCount) {
                    index++;
                    loadTrack(index);
                    if (playing) {
                        audio.play();
                    }
                } else {
                    audio.pause();
                    index = 0;
                    loadTrack(index);
                }
            }),
            li = $('#plList li').click(function () {
                var id = parseInt($(this).index());
                if (id !== index) {
                    playTrack(id);
                }
            }),
            loadTrack = function (id) {
                $('.plSel').removeClass('plSel');
                $('#plList li:eq(' + id + ')').addClass('plSel');
                npTitle.text(tracks[id].name);
                index = id;
                audio.src = mediaPath + tracks[id].file + extension;
                console.log('loaded' , audio.src);

                var iid = id_arr[id];
                var user_id = -1;
                var pre = {!! json_encode(url('/')) !!};
                var url = pre + '/api/updateHitNumber';
                @if (Auth::check())
                {
                    user_id = "{{ Auth::user()->id }}";
                }
                @endif
                console.log(iid,url,user_id);
                $.ajax({
                    type:'POST',
                    url:url,
                    data:{id:iid , user_id:user_id},
                    success:function(data){
                        console.log("SSuccess" , data);
                    },
                    error: function (data) {
                        console.log('EError:', data);
                    }
                });
            },
            playTrack = function (id) {
                loadTrack(id);
                audio.play();
            };
//        extension = audio.canPlayType('audio/mpeg') ? '.mp3' : audio.canPlayType('audio/ogg') ? '.ogg' : '';
        extension = '';
        loadTrack(index);
    }
});

    </script>

@endsection