@for($i=0; $i<sizeof($comments); $i++)
    <div class="singleComment">
        <div class="commentProPic">
            <img src={{asset('').$commenter[$i]->profilePic}}>
        </div>
        <div class="commenter">
            <a href="/user/{{$commenter[$i]->_id}}">{{$commenter[$i]->name}}</a>
            <h1>{{$comments[$i]->created_at}}</h1>
        </div>

        <div class="voteDiv">
            <div class="panel2 panel2-default">
                <div class="panel2-footer">

                    <i id="like1" class="glyphicon glyphicon-thumbs-up" title={{$comments[$i]->id}}></i><div id="{{"like".$comments[$i]->id."-bs3"}}" class="{{$comments[$i]->_id}}">{{$comments[$i]->up}}</div>
                    <i id="dislike1" class="glyphicon glyphicon-thumbs-down" title={{$comments[$i]->id}}></i> <div id="{{"dislike".$comments[$i]->id."-bs3"}}" class="{{$comments[$i]->_id}}">{{$comments[$i]->down}}</div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="hr2"><hr></div>

        <div class="commentText">
            {{$comments[$i]->content}}
        </div>
        <div class="mediumGap"></div>
    </div>
@endfor