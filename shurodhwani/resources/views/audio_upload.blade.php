{!! Form::open(
    array(
        'method'=>'POST',
        'route' => 'search.store',
        'class' => 'form',
        'novalidate' => 'novalidate',
        'files' => true)) !!}


<label class="col-md-4 control-label">Search Keyword</label>
<div class="col-md-6">
    <input id="searchTag" type="text" class="songUploadDiv" name="searchTag" required autofocus>

    <div class="gap"></div>
</div>

<button type="submit">Search</button>

{!! Form::close() !!}