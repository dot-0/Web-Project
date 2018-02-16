@extends('MasterLayout')
@section('content')
<div class="playerContainer">
	<div class="MP_title">
		{{sizeof($albums)}} Albums
	</div>
	<div class="mediumGap"></div>
	<div class="MP_Container">
		<div class="recommendationDiv">
				@for($i=0; $i<sizeof($albums); $i++)
					<div class="recommendSongDiv" id="songButton" onclick="window.location = '/album/{{$albums[$i]->id}}';">
						<img src="{{asset('').$albums[$i]->poster}}">
						<div class="reducegap"></div>
						<h4>{{$albums[$i]->title}}</h4>
						<div class="reducegap"></div>
						<li>Created By : <a href="/user/{{$addedBy[$i]->_id}}">{{$addedBy[$i]->name}}</a></li>
						<div class="clearfix"></div>
						<li>{{$albums[$i]->created_at}}</li>
						<div class="albumTotalSong"><h5>{{sizeof($albums[$i]->audio_list)}} 
						@if(sizeof($albums[$i]->audio_list) < 2)
                        Song
                        @else 
                        Songs
                        @endif
						</h5></div>
					</div>
					<div class="recommendGap"></div>
				@endfor
		</div>
		{{ $albums->links() }}
	</div>
</div>
</div>
@endsection