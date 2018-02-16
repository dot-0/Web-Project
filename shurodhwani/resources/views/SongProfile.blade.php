@extends('MasterLayout')
@section('content')

<div class="bamPash">
    
    <div class="mediumGap"></div>
    <div class="songPosterDiv">
        <img src="{{asset('').$audio->poster}}">
        <li></li>

        @if(Auth::check())
        <div  class="addToFavIcon">
            <div class="click">
                <span class="fa fa-heart-o"></span>
                <div class="ring"></div>
                <div class="ring2"></div>
                <p class="info">Added to favourites!</p>
            </div>
        </div>
        @endif

        <div class="songProfileHeader">
            <h3>{{$audio->title}}</h3>

            @for($i=0; $i<sizeof($artist_id); $i++)
                <a href="/artist/{{$artist_id[$i]->_id}}">{{$artist_id[$i]->name}}</a>
            @endfor
            <div class="ratingDiv">
                <div class="ratingstardiv"><img src="{{asset('images/starIcon.png')}}"></div>
                <div class="ratingpointdiv"><h5 id="rating">{{$audio->rating}}</h5></div>
                
            </div>
            <h2>{{$audio->users_listened}} views</h2>
        </div>

        <div class="musicPlayerContainer">
            <div id="audiowrap">
                <div><audio preload id="audio1" controls="controls">Your browser does not support HTML5 Audio!</audio></div>
            </div>
        </div>
    </div>

    <div class="songDetailsDiv">

        <h3>
            Tags :
            @for($i=0; $i<sizeof($tag_id); $i++)
                <a href="/tag/{{$tag_id[$i]->_id}}">{{$tag_id[$i]->name}}</a>
            @endfor
        </h3>

        <div class="commentProPic">
            <img src="{{asset('').$user->profilePic}}">
        </div>
        <div class="commenter">
            <a href="/user/{{$user->id}}">{{$user->name}}</a>
            <h1>{{$user->created_at}}</h1>
        </div>
    </div>

    @if(Auth::check())
    <div class="rateDiv">
        <h1>Rate This</h1>
        <div class="ratingStars">
            <form id="ratingsForm">
                <div class="stars">
                    <input type="radio" name="star_1" class="star-1" id="star-1" />
                    <label class="star-1" for="star-1">1</label>
                    <input type="radio" name="star_2" class="star-2" id="star-2" />
                    <label class="star-2" for="star-2">2</label>
                    <input type="radio" name="star_3" class="star-3" id="star-3" />
                    <label class="star-3" for="star-3">3</label>
                    <input type="radio" name="star_4" class="star-4" id="star-4" />
                    <label class="star-4" for="star-4">4</label>
                    <input type="radio" name="star_5" class="star-5" id="star-5" />
                    <label class="star-5" for="star-5">5</label>
                    <input type="radio" name="star_6" class="star-6" id="star-6" />
                    <label class="star-6" for="star-6">6</label>
                    <input type="radio" name="star_7" class="star-7" id="star-7" />
                    <label class="star-7" for="star-7">7</label>
                    <input type="radio" name="star_8" class="star-8" id="star-8" />
                    <label class="star-8" for="star-8">8</label>
                    <input type="radio" name="star_9" class="star-9" id="star-9" />
                    <label class="star-9" for="star-9">9</label>
                    <input type="radio" name="star_10" class="star-10" id="star-10" />
                    <label class="star-10" for="star-10">10</label>
                    <span></span>
                </div>
            </form>
        </div>
    </div>
    @endif
    <div class="clearfix"></div>
    <div class="mediumGap"></div>


    <div class="audioProfileCommentDiv">
        @if(Auth::check())
        <h1>Leave a comment</h1>
            <textarea class="commentTextArea" id="comArea" name="comArea"></textarea>
            <div class="clearfix"></div>
            <div class="form-group">
                <button class="commentSubmit commentSubmit_Success" id="cmtSubmit">Submit</button>
            </div>
        @endif
        <h1>Comments...</h1>
        <div class="hr1"><hr></div>
            <div class="comments" id="allcomments">
                @include('paginateComments')
            </div>
            <div class="paginationFooter">
                <li class="prevPag" data-from="{{ $from - 1}}">Back</li>
                &nbsp &nbsp &nbsp
                <li><a id="pageNo" name="1">1</a></li>
                &nbsp &nbsp &nbsp
                <li class="nextPag" data-from="{{ $from + 1 }}">Next</li>
            </div>
    </div>
</div>
<div class="danPash">
    <div class="mediumGap"></div>
    <div class="recommendationDiv">
        <div class="suggestions">
            <li>Suggestions</li>
        </div>
        @for($i=0; $i<15 && $i < sizeof($recommendedSong); $i++)
        <div class="recommendSongDiv" onclick="window.location = '/audio/{{$recommendedSong[$i]->id}}';">
            <img src="{{asset('').$recommendedSong[$i]->poster}}">
            <div class="reducegap"></div>
            <h4 href="">{{$recommendedSong[$i]->title}}</h4>
            <div class="reducegap"></div>
            <div class="clearfix"></div>
            <li>{{$artist_arr[$i]}}</li>
            <div class="clearfix"></div>
            <li>
                <img src="{{asset('images/starIcon.png')}}" class="ratingStar2">
            </li>
            <li>
                <h3>{{$recommendedSong[$i]->rating}}</h3>
                <li>| &nbsp {{$recommendedSong[$i]->users_listened}} views</li>
            </li>
        </div>
        <div class="recommendGap"></div>
        @endfor
    </div>
</div>

<script type="text/javascript">

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var pn=1;

    var iterator = 0;
    var paginateLimit = 7;
    var commentSize = {!! json_encode($commentSize) !!};
    $(document).ready(function() {

        if(iterator == 0) $('.prevPag').hide();
        else $('.prevPag').show();
        if(paginateLimit*(iterator+1) > commentSize) $('.nextPag').hide();
        else $('.nextPag').show();
        console.log(' =====> ' , commentSize);

        $(document).on('click', '.prevPag', function() {
            var id = {!! json_encode($id) !!};
            var pre = {!! json_encode(url('/')) !!};
            iterator = iterator - 1;
            from = paginateLimit*iterator;
            to = paginateLimit*(iterator+1);

            var data = {id:id , from: from , to: to};
            var url = pre + '/api/paginateComments';
            console.log(" ===> " , pre , from , to - 1);

            if(from > 0) $('.prevPag').show();
            else $('.prevPag').hide();
            if(to >= commentSize) $('.nextPag').hide();
            else $('.nextPag').show();

            $.ajax({
                // the route you're requesting should return view('page_details') with the required variables for that view
                type: 'post',
                url: url,
                data: data,
                success:function(data){
                    $('#allcomments').html(data);
                    
                    pn=pn-1;
                    $('#pageNo').html(pn);
            

                    console.log('Success pagination');
                },
                error: function (data) {
                    console.log('EError:', data);
                }
            })
        });
        $(document).on('click', '.nextPag', function() {
            var id = {!! json_encode($id) !!};
            var pre = {!! json_encode(url('/')) !!};
            iterator = iterator + 1;
            from = paginateLimit*iterator;
            to = paginateLimit*(iterator+1);

            var data = {id:id , from: from , to: to};
            var url = pre + '/api/paginateComments';
            console.log(" ===> " , pre , from , to - 1);

            if(from > 0) $('.prevPag').show();
            else $('.prevPag').hide();
            if(to >= commentSize) $('.nextPag').hide();
            else $('.nextPag').show();

            $.ajax({
                // the route you're requesting should return view('page_details') with the required variables for that view
                type: 'post',
                url: url,
                data: data,
                success:function(data){
                    $('#allcomments').html(data);
                    pn=pn+1;
                    $('#pageNo').html(pn);
                    console.log('Success pagination');
                },
                error: function (data) {
                    console.log('EError:', data);
                }
            })
        });
    });

    $("#cmtSubmit").on('click' , function(e){
        console.log("Hit");
        e.preventDefault();
        var content = $('#comArea').val();
        var user_id = -1;
            @if (Auth::check())
        {
            user_id = "{{ Auth::user()->id }}";
        }
                @endif
        var target_id = {!! json_encode($id) !!};
        var data = {comment:content, user_id:user_id, target_id:target_id};
        var pre = {!! json_encode(url('/')) !!};
        var url = pre+'/api/addComment';
        console.log(url , data);
        $.ajax({
            type:'POST',
            url:url,
            data:data,
            success:function(data){
                console.log("SSuccess" , data);
                var add;
                add = '<div class="singleComment">';
                add = add + '<div class="commentProPic" id="newComment">';
                add = add + '</div>';
                add = add + '<div class="commenter">';
                add = add + '<a href="/user/'+user_id+'">'+data.userName+'</a>';
                add = add + '<h1>' + data.tym.date + '</h1>';
                add = add + '</div>';
//
                //add = add + '<div class="voteDiv"><div class="panel2 panel2-default"> <div class="panel2-footer"> <i id="like1" class="glyphicon glyphicon-thumbs-up"></i> <div id="like1-bs3"></div> <i id="dislike1" class="glyphicon glyphicon-thumbs-down"></i> <div id="dislike1-bs3"></div> </div> </div> </div> <div class="clearfix"></div> <div class="hr2"><hr></div> <div class="commentText">';

                add = add + '<div class="voteDiv"> <div class="panel2 panel2-default"> <div class="panel2-footer">';
                var like_id = "like" + data.id + "-bs3";
                add = add + '<i id="like1" class="glyphicon glyphicon-thumbs-up" title='+data.id+'></i><div id=' + like_id +' class='+data.id+'> 0</div>';
                var dislike_id = "dislike" + data.id + "-bs3";
                add = add + '<i id="dislike1" class="glyphicon glyphicon-thumbs-down" title='+data.id+'></i><div id=' + dislike_id +' class='+data.id+'> 0</div>';

                add = add + '</div> </div> </div>';
                add = add + '<div class="clearfix"></div> <div class="hr2"><hr></div> <div class="commentText">';
                add = add + content;
                add = add + '</div>';
                add = add + '<div class="mediumGap"></div>';
                //$('.commenter').html("Hello" + $('.commenter').html());
                //console.log(" ====> " , $('.commenter').html());
//                $('#allcomments').html(add + $('#allcomments').html());

                console.log(data.proPic);
                var img = $("<img />").attr('src', '/'+data.proPic);
                $('#allcomments').prepend(add);
                $('#newComment').prepend(img);

                $('#comArea').val("");

            },
            error: function (data) {
                console.log('EError:', data);
            }
        });
    });

    $(".addToFavIcon").on('click' , function(e){
        console.log("Hit Fav Icon");
        e.preventDefault();
        var user_id = -1;
            @if (Auth::check())
        {
            user_id = "{{ Auth::user()->id }}";
        }
                @endif
        var target_id = {!! json_encode($id) !!};
        var data = {user_id:user_id, target_id:target_id};
        var pre = {!! json_encode(url('/')) !!};
        var url = pre+'/api/addToFav';
        console.log(url , data);
        $.ajax({
            type:'POST',
            url:url,
            data:data,
            success:function(data){
                console.log("Success" , data);
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });

    function updateRating(val){
        console.log("Hit star " , val);
        var user_id = -1;
            @if (Auth::check())
        {
            user_id = "{{ Auth::user()->id }}";
        }
                @endif
        var target_id = {!! json_encode($id) !!};
        var data = {user_id:user_id, target_id:target_id , given_rating: val};
        var pre = {!! json_encode(url('/')) !!};
        var url = pre+'/api/updateRating';
        console.log(url , data);
        $.ajax({
            type:'POST',
            url:url,
            data:data,
            success:function(data){
                console.log("Success" , data);
                var add = '<h5 id="rating">' + data.new_rating + '</h5>';
                $('#rating').replaceWith(add);
                $("#star-1").prop( "checked", false);
                $("#star-2").prop( "checked", false);
                $("#star-3").prop( "checked", false);
                $("#star-4").prop( "checked", false);
                $("#star-5").prop( "checked", false);
                $("#star-6").prop( "checked", false);
                $("#star-7").prop( "checked", false);
                $("#star-8").prop( "checked", false);
                $("#star-9").prop( "checked", false);
                $("#star-10").prop( "checked", false);
                $("#star-"+val).prop( "checked", true);
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    }

    var rate = {!! json_encode($rating) !!};
    rate = Math.round(rate);

    console.log(rate);

    $("#star-"+rate).prop( "checked", true);

    $("input[name='star_1']").on('click' , function(e){
        e.preventDefault();
        updateRating(1);
    });

    $("input[name='star_2']").on('click' , function(e){
        e.preventDefault();
        updateRating(2);
    });

    $("input[name='star_3']").on('click' , function(e){
        e.preventDefault();
        updateRating(3);
    });

    $("input[name='star_4']").on('click' , function(e){
        e.preventDefault();
        updateRating(4);
    });

    $("input[name='star_5']").on('click' , function(e){
        e.preventDefault();
        updateRating(5);
    });

    $("input[name='star_6']").on('click' , function(e){
        e.preventDefault();
        updateRating(6);
    });

    $("input[name='star_7']").on('click' , function(e){
        e.preventDefault();
        updateRating(7);
    });

    $("input[name='star_8']").on('click' , function(e){
        e.preventDefault();
        updateRating(8);
    });

    $("input[name='star_9']").on('click' , function(e){
        e.preventDefault();
        updateRating(9);
    });

    $("input[name='star_10']").on('click' , function(e){
        e.preventDefault();
        updateRating(10);
    });

    var b = document.documentElement;
    b.setAttribute('data-useragent', navigator.userAgent);
    b.setAttribute('data-platform', navigator.platform);

    jQuery(function ($) {
        var supportsAudio = !!document.createElement('audio').canPlayType;
        var title = {!! json_encode($title) !!}
        var file_path = {!! json_encode($path) !!}

        var add = {
                    "track": 1,
                    "name": title,
                    "file": "/"+file_path
                };
        console.log(add);
        var playlist = [add];

        if (supportsAudio) {
            var index = 0,
                    playing = true,
                    mediaPath = '',
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
                    },
                    playTrack = function (id) {
                        loadTrack(id);
                        audio.play();
                    };
            extension = '';
            loadTrack(index);
            audio.play();
        }
    });

    $(document).ready(function() {
        $(document).on('click' , '.glyphicon-thumbs-up' , function(e){
            e.preventDefault();
        //$('i.glyphicon-thumbs-up').click(function(){
            console.log("liked comment");
            var user_id = -1;
                @if (Auth::check())
            {
                user_id = "{{ Auth::user()->id }}";
            }
                    @endif

            var it = $(this).attr('title');
            console.log(it,data);

            var target_id = it;
            var pre = {!! json_encode(url('/')) !!};
            var url = pre+'/api/upComment';
            var data = {user_id:user_id, target_id:target_id};
            console.log(url , data);
            $.ajax({
                type:'POST',
                url:url,
                data:data,
                success:function(data){
                    var $this = $(this),
                            c = $this.data('count');
                    if (!c) c = 0;
                    c = data.up;
                    $this.data('count',c);
                    var iid = "like"+it;
                    $('#'+iid+'-bs3').html(c);
                    console.log('#'+iid+'-bs3');
                    console.log("Success" , data);
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });
        $(document).on('click' , '.glyphicon-thumbs-down' , function(e){
            e.preventDefault();
        //$('i.glyphicon-thumbs-down').click(function(){
            console.log("disliked comment");
            var user_id = -1;
                @if (Auth::check())
            {
                user_id = "{{ Auth::user()->id }}";
            }
                    @endif

            var it = $(this).attr('title');
            console.log(it,data);

            var target_id = it;
            var pre = {!! json_encode(url('/')) !!};
            var url = pre+'/api/downComment';
            var data = {user_id:user_id, target_id:target_id};
            console.log(url , data);
            $.ajax({
                type:'POST',
                url:url,
                data:data,
                success:function(data){
                    var $this = $(this),
                            c = $this.data('count');
                    if (!c) c = 0;
                    c = data.down;
                    $this.data('count',c);
                    var iid = "dislike"+it;
                    $('#'+iid+'-bs3').html(c);
                    console.log('#'+iid+'-bs3');
                    console.log("Success" , data);
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });
        $(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });
    });



    @if($fav == 1)
    $('.click').addClass('active');
    $('.click').addClass('active-2');
    setTimeout(function() {
        $('.click span').addClass('fa-heart');
        $('.click span').removeClass('fa-heart-o')
    }, 150);
    setTimeout(function() {
        $('.click').addClass('active-3')
    }, 150);

    @endif

    $('.click').click(function() {
        if ($('.click span').hasClass("fa-heart")) {
            $('.click').removeClass('active');
            setTimeout(function() {
                $('.click').removeClass('active-2')
            }, 30);
            $('.click').removeClass('active-3');
            setTimeout(function() {
                $('.click span').removeClass('fa-heart');
                $('.click span').addClass('fa-heart-o')
            }, 15)
        } else {
            $('.click').addClass('active');
            $('.click').addClass('active-2');
            setTimeout(function() {
                $('.click span').addClass('fa-heart');
                $('.click span').removeClass('fa-heart-o')
            }, 150);
            setTimeout(function() {
                $('.click').addClass('active-3')
            }, 150);
            $('.info').addClass('info-tog');
            setTimeout(function(){
                $('.info').removeClass('info-tog')
            },1000)
        }
    });

</script>

@endsection