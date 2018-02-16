<!DOCTYPE html>
<html>
<head>
    <title>Laravel 5.5 Ajax Request example</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<body>

<div class="container">

    <h1>Users</h1>

    <div id="names">
    @foreach($users as $user)
        <div id={{$user->_id}}>
            {{$user->name}}
            <button class="button-delete" value="{{$user->_id}}">Delete</button>
        </div>
    @endforeach
    </div>

    <h1>Laravel 5.5 Ajax Request example</h1>
    <form >
        <div class="form-group">
            <label>Name:</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Name" required="">
        </div>
        <div class="form-group">
            <label>Password:</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Password" required="">
        </div>
        <div class="form-group">
            <strong>Email:</strong>
            <input type="email" id="email" name="email" class="form-control" placeholder="Email" required="">
        </div>
        <div class="form-group">
            <button class="btn btn-success btn-submit">Submit</button>
        </div>
    </form>
</div>

</body>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(".btn-submit").on('click' , function(e){
        e.preventDefault();
        var name = $("input[name=name]").val();
        var password = $("input[name=password]").val();
        var email = $("input[name=email]").val();
        $.ajax({
            type:'POST',
            url:'/ajaxRequest',
            data:{name:name, password:password, email:email},
            success:function(data){
                console.log("Success" , data);
                var opn = '<div id='+data.id+'>';
                var cls = '</div>';
                var btn = '<button class="button-delete" value='+data.id+'>Delete</button>';
                var add = opn+name+btn+cls;
                $('#names').append(add);
                $('#name').val("");
                $('#password').val("");
                $('#email').val("");

//                $('.button-delete').each(function () {
//                    console.log("button found =>" + $(this).val());
//                });
                //alert(data.success);

//                $(".button-delete").on('click' , function(e){
//                    e.preventDefault();
//                    var id = $(this).val();
//                    var url = 'ajaxTestDelete/'+id;
//                    console.log(id);
//                    $.ajax({
//                        type:'POST',
//                        url:url,
//                        success:function(data){
//                            console.log("Success" , data);
//                            $('#'+id).remove();
//                            //alert(data.success);
//                        },
//                        error: function (data) {
//                            console.log('Error:', data);
//                        }
//                    });
//                });
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
    $(document).on('click' , '.button-delete' , function(e){
        e.preventDefault();
        var id = $(this).val();
        var url = 'ajaxTestDelete/'+id;
        console.log(" => "+id);
        $.ajax({
            type:'POST',
            url:url,
            success:function(data){
                console.log("Success" , data);
                $('#'+id).remove();
                //alert(data.success);
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
</script>

</html>