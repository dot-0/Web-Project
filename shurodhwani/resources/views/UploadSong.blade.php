@extends('MasterLayout')
@section('content')
<div class="container">
    <div class="registerArea">
        <div class="uploadAlbumDiv">
            <button id="uploadChoose" name="uploadChoose" class="uploadChooseButton" style="background-color: #023131">
            Upload Song
            </button>
            <button id="makeAlbumChoose" name="makeAlbumChoose" class="makeAlbumChooseButton">
            Make Album
            </button>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body" id="uploadSong">
                        {!! Form::open(
                        array(
                        'method'=>'POST',
                        'route' => 'audio.store',
                        'class' => 'form',
                        'novalidate' => 'novalidate',
                        'files' => true)) !!}
                        <div class="mediumGap"></div>
                        
                        <label class="col-md-4 control-label">Song Title</label>
                        <div class="col-md-6">
                            <input id="songTitle" type="text" class="songUploadDiv" name="songTitle" required autofocus>
                            <div class="gap"></div>
                        </div>
                        
                        <label class="col-md-4 control-label">Artist(s)</label>
                        <div class="col-md-6">
                            <input id="songArtist" type="text" class="songUploadDiv" name="songArtist" required autofocus>
                            
                            <div class="gap"></div>
                        </div>
                        <label class="col-md-4 control-label">Genre(s)</label>
                        <div class="col-md-6">
                            <input id="songGenre" type="text" class="songUploadDiv" name="songGenre" required autofocus>
                            <div class="mediumGap"></div>
                        </div>
                        <label class="col-md-4 control-label">Audio</label>
                        <div class="col-md-6">
                            <input id="audio" class="chooseAudio" type="file" name="audio" required autofocus>
                            <div class="mediumGap"></div>
                        </div>
                        <label class="col-md-4 control-label">Poster</label>
                        <div class="col-md-6">
                            <input id="songBack" class="chooseAudio" type="file" name="songBack" required autofocus>
                            <div class="mediumGap"></div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="songUploadButton">
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    
                    <div class="panel-body" id="MakeAlbum" style="display: none">
                        {!! Form::open(
                        array(
                        'method'=>'POST',
                        'route' => 'album.store',
                        'class' => 'form',
                        'novalidate' => 'novalidate',
                        'files' => true)) !!}
                        <div class="mediumGap"></div>
                        
                        <label class="col-md-4 control-label">Album Title</label>
                        <div class="col-md-6">
                            <input id="songTitle" type="text" class="songUploadDiv" name="albumTitle" required autofocus>
                            <div class="gap"></div>
                        </div>
                        <div class="clearfix"></div>



                        <div class="makeAlbumAudioChoose">
                        <label class="col-md-4 control-label">Select Audio(s)</label>
                          <select class="select2-selection--multiple" multiple="multiple" name="audio_list[]">
                              @foreach($uploadedSong as $audio)
                                <option value={{$audio->_id}}>{{$audio->title}}</option>
                              @endforeach
                          </select>
                        </div>

                        

                        <div class="mediumGap"></div>
                        <label class="col-md-4 control-label">Poster</label>
                        <div class="col-md-6">
                            <input id="songBack" class="chooseAudio" type="file" name="albumBack" required autofocus>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6">
                            <div class="songUploadButton">
                                <button type="submit" class="btn btn-primary">Upload</button>
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

<script type="text/javascript">

$(function() {
    $('#uploadChoose').click(function(e) {
        $(this).css('background-color', '#023131');
        $("#makeAlbumChoose").css('background-color', '#555');
        $("#uploadSong").delay(100).fadeIn(100);
        $("#MakeAlbum").fadeOut(100);
        $('#makeAlbumChoose').removeClass('active');
        $(this).addClass('active');
        e.preventDefault();
    });

    $('#makeAlbumChoose').click(function(e) {
        $(this).css('background-color', '#023131');
        $("#uploadChoose").css('background-color', '#555');
        $("#MakeAlbum").delay(100).fadeIn(100);
        $("#uploadSong").fadeOut(100);
        $('#uploadChoose').removeClass('active');
        $(this).addClass('active');
        e.preventDefault();
    });
});

</script>
@endsection