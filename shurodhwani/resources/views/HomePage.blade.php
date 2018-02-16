@extends('MasterLayout')
@section('content')
<div id="page-wrapper">
	<div class="inner-content">
		
		<div class="music-left">
			<div class="callbacks_container">
				<ul class="rslides callbacks callbacks1" id="slider4">
					@for($i=0; $i<4 && $i<sizeof($trending); $i++)
					<li>
						<div class="banner-info">
							<a class="trend" >TRENDING</a>
						</div>
						<div class="callbacks">
							<img src="{{asset('').$trending[$i]->poster}}"  alt="">
							<a style="font-size: 20px;" href="/audio/{{$trending[$i]->id}}">{{$trending[$i]->title}}</a>
						</div>
					</li>
					@endfor
				</ul>
			</div>
			<!--banner-->
			<script src="js/responsiveslides.min.js"></script>
			<script>
				// You can also use "$(window).load(function() {"
				$(function () {
				// Slideshow 4
				$("#slider4").responsiveSlides({
					auto: true,
					pager:true,
					nav:true,
					speed: 500,
					namespace: "callbacks",
					before: function () {
					$('.events').append("<li>before event fired.</li>");
					},
					after: function () {
					$('.events').append("<li>after event fired.</li>");
					}
				});
			
				});
			</script>
			<div class="clearfix"> </div>
			<!--//End-banner-->
			<!--albums-->
			<!-- pop-up-box -->
			<link href="css/popuo-box.css" rel="stylesheet" type="text/css" media="all">
			<script src="js/jquery.magnific-popup.js" type="text/javascript"></script>
			<script>
					$(document).ready(function() {
					$('.popup-with-zoom-anim').magnificPopup({
						type: 'inline',
						fixedContentPos: false,
						fixedBgPos: true,
						overflowY: 'auto',
						closeBtnInside: true,
						preloader: false,
						midClick: true,
						removalDelay: 300,
						mainClass: 'my-mfp-zoom-in'
					});
					});
			</script>
			<!--//pop-up-box -->
			<div class="albums">
				<div class="tittle-head">
					<h3 class="tittle">New Releases <span class="new">New</span></h3>
					<div class="clearfix"> </div>
				</div>

				@for($i=0; $i<min(sizeof($newReleases), 12); $i++)
				<div class="col-md-3 content-grid" onClick="window.open('audio/{{$newReleases[$i]->id}}','_blank');">
					<a class="play-icon popup-with-zoom-anim" href=""><img src="{{asset('').$newReleases[$i]->poster}}"></a>
					<a class="button play-icon popup-with-zoom-anim" href="">
					@if(strlen($newReleases[$i]->title) > 15)
						{{substr($newReleases[$i]->title , 0 , 12)}}...
					@else
						{{$newReleases[$i]->title}}
					@endif
					</a>
				</div>
				@endfor
				<div class="clearfix"> </div>
			</div>
		</div>
		
		<div class="music-right">
			<div class="recommendationDiv">
				<div class="suggestions">
					<li>Recommended</li>
				</div>
				@for($i=0; $i<min(sizeof($recommendedSong), 15); $i++)
				
				<div class="recommendSongDiv" id="songButton" onClick="window.open ('audio/{{$recommendedSong[$i]->id}}', '_blank');">
					<img src="{{asset('').$recommendedSong[$i]->poster}}">
					<div class="reducegap"></div>
					<h4 href="">{{$recommendedSong[$i]->title}}</h4>
					<div class="reducegap"></div>
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
			<link href="css/jplayer.blue.monday.min.css" rel="stylesheet" type="text/css">
			<script type="text/javascript" src="js/jquery.jplayer.min.js"></script>
			<script type="text/javascript" src="js/jplayer.playlist.min.js"></script>
			
		</div>
		<div class="clearfix"></div>
	</div>
</div>
@endsection