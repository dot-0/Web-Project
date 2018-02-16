@extends('MasterLayout')
@section('content')
<div class="playerContainer">
	<div class="MP_title">
		Uploaded Songs by <a href="/user/{{$user->id}}"> {{$user->name}}</a>
	</div>
	<div class="mediumGap"></div>
	<div class="MP_Container">
		<div class="albums">
			@for($i=0; $i<sizeof($audio_list); $i++)
			<div class="col-md-3 content-grid">
				
					<img src={{asset('').$audio_list[$i]->poster}} onClick="window.open('/audio/{{$audio_list[$i]->id}}','_blank');" >
					@if(Auth::check() == true && Auth::user()->_id == $user->_id)
					<div class="songUpdateButton" onclick="window.location = '/editSong/{{$audio_list[$i]->id}}';">
						<img src="{{asset('images/update.png')}}" title="Update">
					</div>
					@endif
				
				<a class="button play-icon popup-with-zoom-anim" href="/audio/{{$audio_list[$i]->id}}" target="_blank">
					@if(strlen($audio_list[$i]->title) > 15)
						{{substr($audio_list[$i]->title , 0 , 12)}}...
					@else
						{{$audio_list[$i]->title}}
					@endif
				</a>
			</div>
			@endfor
			<div class="clearfix"> </div>
		</div>
		{{ $audio_list->links() }}
	</div>
</div>
@endsection