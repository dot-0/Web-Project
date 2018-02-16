@extends('MasterLayout')
@section('content')
<div class="container">
    <div class="registerArea">
        <div class="uploadAlbumDiv">
            <div class="songDeleteButton" onclick="window.location = '/deleteAudio/{{Request::segment(2)}}';"><img src="{{asset('images/delete.png')}}" title="Remove This Song"></div>
            <div class="uploadTitle">
                Update Audio Details
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body" id="uploadSong">
                        {!! Form::open(
                        array(
                        'method'=>'PUT',
                        'route' => ['audio.update' , Request::segment(2)],
                        'class' => 'form',
                        'novalidate' => 'novalidate',
                        'files' => true)) !!}
                        <div class="mediumGap"></div>
                        
                        <label class="col-md-4 control-label">Song Title</label>
                        <div class="col-md-6">
                            <input id="songTitle" type="text" class="songUploadDiv" name="songTitle" required autofocus value='<?php echo $song->title;?>' >
                            <div class="gap"></div>
                        </div>
                        
                        <label class="col-md-4 control-label">Artist(s)</label>
                        <div class="col-md-6">
                            <input id="songArtist" type="text" class="songUploadDiv" name="songArtist" required autofocus value='<?php echo $artist_arr;?>'>
                            
                            <div class="gap"></div>
                        </div>
                        <label class="col-md-4 control-label">Genre(s)</label>
                        <div class="col-md-6">
                            <input id="songGenre" type="text" class="songUploadDiv" name="songGenre" required autofocus value='<?php echo $tag_arr;?>'>
                            <div class="mediumGap"></div>
                        </div>
                        
                        <label class="col-md-4 control-label">Poster</label>
                        <div class="col-md-6">
                            <input id="songBack" class="chooseAudio" type="file" name="songBack" required autofocus>
                            <div class="ajaira">(Just leave it if you don't want to change)</div>
                            <div class="mediumGap"></div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="songUploadButton">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="footerGap"></div>
    </div>
</div>
</div>
@endsection