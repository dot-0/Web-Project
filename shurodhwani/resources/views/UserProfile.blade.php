@extends('MasterLayout')
@section('content')
<div class="bamPash">
	
	<div class="proPicDiv">
		<img src="{{asset('').$user->profilePic}}" class="proPic">
		<div class="profileDetails">
			<h1>{{$user->name}}</h1>
			<div class="mediumGap"></div>
			<div class="profileListDiv">
				<div class="profileListTitle">
					<img src="{{asset('images/mailIcon.png')}}">
					&nbsp E-mail
				</div>
				<div class="profileListDescr">
					{{$user->email}}
				</div>
			</div>
			
			<div class="profileListDiv">
				<div class="gap2"></div>
				<div class="profileListTitle">
					<img src="{{asset('images/contribIcon.png')}}">
					&nbsp Contrib.
				</div>
				<div class="profileListDescr">
					{{$point}}
				</div>
			</div>
			
			<div class="profileListDiv">
				<div class="gap2"></div>
				<div class="profileListTitle">
					<img src="{{asset('images/joinedIcon.png')}}">
					&nbsp Joined
				</div>
				<div class="profileListDescr">
					{{$user->created_at}}
				</div>
			</div>

			<div class="profileListDiv">
				<div class="gap2"></div>
				<div class="profileListTitle">
					<img src="{{asset('images/aboutMeIcon.png')}}">
					&nbsp About Me
				</div>
				<div class="aboutMeDescr">
					{{$user->about_me}}
				</div>
			</div>
			
			
			<div class="gap2"></div>

			@if(Auth::check() == true && Auth::user()->_id == $user->_id)
			<div class="profileListDiv">
				<a href={{"/updateUserProfile/".$user->_id}} class="profileUpdateButton">Update</a>
			</div>
			@endif
		</div>
	</div>
	<div class="albums">
		<div class="tittle-head">
			<h3 class="tittle">Uploaded Songs</h3>
			<div class="clearfix"> </div>
		</div>
		@for($i=0; $i<sizeof($uploaded_song) && $i < 8; $i++)
			<div class="col-md-3 content-grid">
					<img src={{asset('').$uploaded_song[$i]->poster}} onClick="window.open('/audio/{{$uploaded_song[$i]->id}}','_blank');" >
					@if(Auth::check() == true && Auth::user()->_id == $user->_id)
					<div class="songUpdateButton" onclick="window.location = '/editSong/{{$uploaded_song[$i]->id}}';">
						<img src="{{asset('images/update.png')}}" title="Update">
					</div>
					@endif
				
				<a class="button play-icon popup-with-zoom-anim" href="/audio/{{$uploaded_song[$i]->id}}" target="_blank">
				@if(strlen($uploaded_song[$i]->title) > 15)
						{{substr($uploaded_song[$i]->title , 0 , 12)}}...
					@else
						{{$uploaded_song[$i]->title}}
					@endif
				</a>
			</div>
		@endfor
		<div class="clearfix"> </div>
		<a class="seeAll" href="/uploadedSongList/{{$user->_id}}">See All</a>
	</div>

	<div class="albums">
		<div class="tittle-head">
			<h3 class="tittle">Uploaded Albums</h3>
			<div class="clearfix"> </div>
		</div>
		@for($i=0; $i<sizeof($album_list) && $i < 8; $i++)
			<div class="col-md-3 content-grid">
				<img src={{asset('').$album_list[$i]->poster}} onClick="window.open('/album/{{$album_list[$i]->id}}','_blank');" >
				@if(Auth::check() == true && Auth::user()->_id == $user->_id)
					<div class="songUpdateButton" onclick="window.location = '/editAlbum/{{$album_list[$i]->id}}';">
						<img src="{{asset('images/update.png')}}" title="Update">
					</div>
				@endif

				<a class="button play-icon popup-with-zoom-anim" href="/album/{{$album_list[$i]->id}}" target="_blank">
					@if(strlen($album_list[$i]->title) > 15)
						{{substr($album_list[$i]->title , 0 , 12)}}...
					@else
						{{$album_list[$i]->title}}
					@endif
				</a>
			</div>
		@endfor
		<div class="clearfix"> </div>
		<a class="seeAll" href="/uploadedAlbumList/{{$user->_id}}">See All</a>
	</div>

	<div class="hugeGap"></div>
</div>
<div class="danPash">
	<div class="mediumGap"></div>
	<div class="recommendationDiv">
		<div class="suggestions">
			<li>Recently Played</li>
		</div>
		@for($i=0; $i<min(sizeof($recentList), 15); $i++)
		<div class="recommendSongDiv" onClick="window.open('/audio/{{$recentList[$i]->id}}','_blank');">
			<img src={{asset('').$recentList[$i]->poster}}>
			<div class="reducegap"></div>
			<h4 href="">{{$recentList[$i]->title}}</h4>
			<div class="reducegap"></div>
			<div class="clearfix"></div>
			<li>{{$artistArr[$i]}}</li>
			<div class="clearfix"></div>
			<li>
				<img src="{{asset('images/starIcon.png')}}" class="ratingStar2">
			</li>
			<li>
				<h3>{{$recentList[$i]->rating}}</h3>
			</li>
			<li>| &nbsp {{$recentList[$i]->users_listened}} views</li>
		</div>
		<div class="recommendGap"></div>
		@endfor
	</div>
</div>
@endsection