@extends('MasterLayout')
@section('content')
<div class="container">
    <div class="registerArea">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Update Info</div>
                    <div class="panel-body">
                        {!! Form::open(
                        array(
                        'method'=>'POST',
                        'action'=>'UserController@saveEdited',
                        'class' => 'form',
                        'novalidate' => 'novalidate',
                        'files' => true)) !!}
                        <div class="mediumGap"></div>

                        <label class="col-md-4 control-label">Name</label>
                        <div class="col-md-6">
                            <input id="name" type="text" class="songUploadDiv" name="name" value="<?=$user->name?>">
                            <div class="gap"></div>
                        </div>

                        <label class="col-md-4 control-label">About Me</label>
                        <div class="col-md-6">
                            <textarea id="aboutMe" class="songUploadDiv" name="aboutMe">{{$user->about_me}}</textarea>
                            <div class="gap"></div>
                        </div>
                        <label class="col-md-4 control-label">Profile Picture</label>
                        <div class="col-md-6">
                            <input id="proPic" class="chooseAudio" type="file" name="proPic">
                            <div class="ajaira">(Just leave it if you don't want to change)</div>
                            <div class="mediumGap"></div>
                        </div>

                        <div class="col-md-6">
                            <div class="songUploadButton">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                        <input type="text" name="id" value={{$user->_id}} style="display: none">
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection