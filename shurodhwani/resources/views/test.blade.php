<style type="text/css">
  

@import url(//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css);
$primary_color: #3C2053;
$player_color: #402457;
$font_color: #9073A9;

body {
  font-family: 'Josefin Sans', sans-serif !important;
  margin: 5rem 0 5rem 0;
  background: $primary_color;
  font-family: tahoma;

  .music_player {
    position: relative;
    margin: 0 auto;
    background: $player_color;
    height: 15rem;
    width: 40rem;
    -webkit-box-shadow: 10px 0px 20px -6px  rgba(0, 0, 0, 0.75);
    -moz-box-shadow: 10px 7px 20px -6px rgba(0, 0, 0, 0.75);
    box-shadow: 10px 0px 20px -6px rgba(0, 0, 0, 0.75);

    .artist_img {
      img {
        height: 14rem;
      }

    }

    .time_slider {
      background: #301643;
      height: 2.5rem;
      width: 18.7rem;
      position: absolute;
      bottom: 0;

      span {
        position: absolute;
        font-size: 12px;
        top: 0.75rem;
      }

      .runing_time {
        left: 1rem;
        color: #FECF7D;
      }

      .song_long {
        right: 1rem;
        color: #775B8E;
      }

    }

    .controllers {
      background: #260F39;
      height: 2.5rem;
      width: 21.4rem;
      position: absolute;
      right: 0;
      bottom: 0;
      font-family: FontAwesome;
      text-align: center;
      color: #83649F;

      i {
        position: relative;
        bottom: -0.7rem;
        padding: 0 15px 0 15px;
      }

    }

    .now_playing {
      top: 0;
      right: 0;
      height: 2.5rem;
      width: 21.4rem;
      position: absolute;
      background: #260F39;
      text-align: center;
      color: $font_color;

      i.fa-heart {
        top: 0.5rem;
        right: 4rem;
        position: absolute;
      }

      i.fa-refresh {
        top: 0.5rem;
        left: 4rem;
        position: absolute;
      }

      p {
        text-transform: uppercase;
        font-size: 12px;
      }

    }

  }

  .music_info {
    top: 2rem;
    right: 0;
    position: absolute;
    width: 21rem;

    h2 {
      color: #fff;
      text-align: center;
      font-size: 20px;
      text-transform: uppercase;
    }

    p {
      text-align: center;
    }

    .date {
      color: #A384BD;
      font-weight: bold;
      font-size: 13px;
      margin-top: -0.8em;
    }

    .song_title {
      color: #E7DF70;
    }

  }

}

input[type=range] {
  -webkit-appearance: none;
  border: 1px solid white;
  border-radius: 2px;
  width: 12rem;
  top: 1rem;
  left: 0;
  right: 0;
  margin: auto;
  position: absolute;
}

input[type=range]::-webkit-slider-runnable-track {
  width: 300px;
  height: 5px;
  background: #8664A1;
  border: none;
  border-radius: 3px;
}

input[type=range]::-webkit-slider-thumb {
  -webkit-appearance: none;
  border: 3px solid #fff;
  height: 16px;
  width: 16px;
  border-radius: 50%;
  background: #9200FF;
  margin-top: -4px;
}

input[type=range]:focus {
  outline: none;
}

input[type=range]:focus::-webkit-slider-runnable-track {
  background: #8664A1;
}

input[type=range]::-moz-range-track {
  width: 300px;
  height: 5px;
  background: #8664A1;
  border: none;
  border-radius: 3px;
}

input[type=range]::-moz-range-thumb {
  -webkit-appearance: none;
  border: 3px solid #fff;
  height: 16px;
  width: 16px;
  border-radius: 50%;
  background: #9200FF;
  margin-top: -4px;
}

input[type=range]:-moz-focusring {
  outline: 1px solid white;
  outline-offset: -1px;
}

input[type=range]::-ms-track {
  width: 300px;
  height: 5px;
  background: transparent;
  border-color: transparent;
  border-width: 6px 0;
  color: transparent;
}

input[type=range]::-ms-fill-lower {
  background: #777;
  border-radius: 10px;
}

input[type=range]::-ms-fill-upper {
  background: #ddd;
  border-radius: 10px;
}

input[type=range]::-ms-thumb {
  border: none;
  height: 16px;
  width: 16px;
  border-radius: 50%;
  background: goldenrod;
}

input[type=range]:focus::-ms-fill-lower {
  background: #888;
}

input[type=range]:focus::-ms-fill-upper {
  background: #ccc;
}

fieldset {
  margin: auto;
  left: 0;
  right: 0;
  position: absolute;
  width: 9rem;
}

/****** Style Star Rating Widget *****/
.rating {
  border: none;
  float: left;
}

.rating > input {
  display: none;
}

.rating > label:before {
  margin: 5px;
  font-size: 1.25em;
  font-family: FontAwesome;
  display: inline-block;
  content: "\f005";
}

.rating > .half:before {
  content: "\f089";
  position: absolute;
}

.rating > label {
  color: #ddd;
  float: right;
}

.rating > input:checked ~ label,

/* show gold star when clicked */
.rating:not(:checked) > label:hover, /* hover current star */
.rating:not(:checked) > label:hover ~ label {
  color: #FFD700;
}

.rating > input:checked + label:hover, .rating > input:checked ~ label:hover, .rating > label:hover ~ input:checked ~ label, .rating > input:checked ~ label:hover ~ label {
  color: #FFED85;
}

i {
  cursor: pointer;
}

i:hover {
  color: #FEC35E;
}

.song_list {
  background: #402457;
  position: absloute;
  margin: 0 auto;
  width: 40rem;
  height: 5rem;
  font-size: 20px;
  color: #fff;
  overflow-y: scroll;
  -webkit-box-shadow: 10px 7px 20px -6px rgba(0, 0, 0, 0.75);
  -moz-box-shadow: 10px 7px 20px -6px rgba(0, 0, 0, 0.75);
  box-shadow: 10px 7px 20px -6px rgba(0, 0, 0, 0.75);

  .title {
    width: 48%;
    text-align: center;
    float: left;
    padding: 2px 0 2px 0;
  }

}

.dark {
  background: #260F39;
}
  
</style>


<link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">

<div class="music_player">
  <div class="artist_img">
  <img src="http://pichoster.net/images/2016/12/02/adele.jpg">
  </div>
  <div class="time_slider">
    <span class="runing_time">0:00</span>
    <input type="range" value="0">
    <span class="song_long">0:00</span>
  </div>
  <div class="now_playing">
    <i class="fa fa-refresh" aria-hidden="true"></i>

    <p> now playing </p>
    <i class="fa fa-heart" aria-hidden="true"></i>
  </div>
  <div class="music_info">
    <h2>adele</h2>
    <p class="date">12 - 2016</p>
    <p class="song_title">Rolling in the deep</p>
    <fieldset class="rating">
    <input type="radio" id="star5" name="rating" value="5" /><label class ="full" for="star5" title="Awesome - 5 stars"></label>
    <input type="radio" id="star4half" name="rating" value="4 and a half" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
    <input type="radio" id="star4" name="rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
    <input type="radio" id="star3half" name="rating" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
    <input type="radio" id="star3" name="rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
    <input type="radio" id="star2half" name="rating" value="2 and a half" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
    <input type="radio" id="star2" name="rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
    <input type="radio" id="star1half" name="rating" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
    <input type="radio" id="star1" name="rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
    <input type="radio" id="starhalf" name="rating" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
</fieldset>
  </div>
  <div class="controllers">
    <i class="fa fa-play" aria-hidden="true"></i>
  </div>
</div> 

<script type="text/javascript">
  

var audio = new Audio('http://www.tegos.ru/new/mp3_full/Adele_-_Rolling_In_The_Deep.mp3');
var audioTotalTime = 0;
$('body').on('click','.fa-play',function(e){
  audio.play();
  audioTotalTime = audio.duration / 60;
  $(this).addClass('fa-pause')
  $(this).removeClass('fa-play');
  $('.song_long').text(Math.round(audioTotalTime * 100) / 100);
  updateCurrentTime();
});

$('body').on('click','input[type=range]',function(){
  audio.pause();
  audio.currentTime = audioTotalTime * $(this).val();
   audio.play();
});

$('body').on('click','.fa-pause',function(){
  audio.pause();
  $(this).addClass('fa-play')
  $(this).removeClass('fa-pause');
});

$('body').on('click','.fa-music',function(){
  $('.song_list').slideToggle();
});

function updateCurrentTime(){
  setInterval(function(){
    var time = audio.currentTime;
    var minutes = Math.floor(time / 60);   
    var seconds = Math.floor(time);
    seconds = (seconds - (minutes * 60 )) < 10 ? ('0' + (seconds - (minutes * 60 ))) : (seconds - (minutes * 60 )); 
    var currentTime = minutes + ':' + seconds;
    $('.runing_time').text(currentTime);
    $("input[type=range]").val(time/audioTotalTime )
  },1000)
 
}

</script>>