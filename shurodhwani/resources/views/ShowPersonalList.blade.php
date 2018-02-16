@extends('MasterLayout')
@section('content')
<div class="playerContainer">
	<div class="MP_title">
		My Playlists
	</div>
	<div class="createPlaylist" onclick="window.location = '/customizedList/create';">
		<img src={{asset('images/createPlaylist.png')}}>
		<h3>Create New</h3>
	</div>
	<div class="mediumGap"></div>
	<div class="MP_Container">
		<div class="albums">
			@for($i=0; $i<sizeof($album_list); $i++)
			<div class="col-md-3 content-grid">
				<a class="play-icon popup-with-zoom-anim" href="#small-dialog">
					<img src={{asset('').$album_list[$i]->poster}}  onclick="window.location = '/customizedList/{{$album_list[$i]->id}}';">
					<div class="songUpdateButton" onclick="window.location = '/editPersonalList/{{$album_list[$i]->id}}';"><img src="{{asset('images/update.png')}}" ></div>
				</a>
				<a class="button play-icon popup-with-zoom-anim" href="/customizedList/{{$album_list[$i]->id}}">
					@if(strlen($album_list[$i]->title) > 15)
						{{substr($album_list[$i]->title , 0 , 12)}}...
					@else
						{{$album_list[$i]->title}}
					@endif
				</a>
			</div>
			@endfor
			<div class="clearfix"> </div>
		</div>
	</div>
</div>
@endsection