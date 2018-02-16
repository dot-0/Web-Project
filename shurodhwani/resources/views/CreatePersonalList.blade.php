@extends('MasterLayout')
@section('content')
<div class="container">
    <div class="registerArea">
        <div class="uploadAlbumDiv">
            <div class="uploadTitle">
                Create Playlist
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body" id="MakeAlbum">
                        {!! Form::open(
                        array(
                        'method'=>'POST',
                        'route' => 'customizedList.store',
                        'class' => 'form',
                        'novalidate' => 'novalidate',
                        'files' => true)) !!}
                        <div class="mediumGap"></div>
                        
                        <label class="col-md-4 control-label">Playlist Title</label>
                        <div class="col-md-6">
                            <input id="songTitle" type="text" class="songUploadDiv" name="albumTitle" required autofocus>
                            <div class="gap"></div>
                        </div>
                        <div class="clearfix"></div>
                        
                        
                        
                        <div class="makeAlbumAudioChoose">
                            <label class="col-md-4 control-label">Select Audio</label>
                            <select class="select2-selection--multiple" multiple="multiple" name="audio_list[]">
                                @foreach($audio_list as $audio)
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
                                <button type="submit" class="btn btn-primary">Create</button>
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