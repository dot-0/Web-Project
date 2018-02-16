<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Artist;
use App\Tag;
use App\Audio;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('audio_upload');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        echo "search show called with query ==> ".$request->searchTag.'<br>';
        $txt = $request->searchTag;
        $exp = '/.*'.$txt.'.*/i';
        echo $exp.'<br>';
        $allSong = Audio::where('title' , 'regexp' , $exp)->get();
        echo "<-------------SONG------------->".'<br>';
        foreach($allSong as $song) echo $song->title.'<br>';
        echo '<br>';

        $allArtist = Artist::where('name' , 'regexp' , $exp)->get();
        echo "<------------Artist------------>".'<br>';
        foreach($allArtist as $art) echo $art->name.'<br>';
        echo '<br>';

        $allTag = Tag::where('name' , 'regexp' , $exp)->get();
        echo "<-------------TAG-------------->".'<br>';
        foreach($allTag as $tag) echo $tag->name.'<br>';
    }

    public function showSearchResult(Request $request)
    {
        //echo "search show called with query ==> ".$request->id.'<br>';
        $txt = $request->id;
        $exp = '/.*'.$txt.'.*/i';
        //echo $exp.'<br>';
        $allSong = Audio::where('title' , 'regexp' , $exp)->orderBy('users_listened' , 'desc')->get();
        //echo "<-------------SONG------------->".'<br>';
        //foreach($allSong as $song) echo $song->title.'<br>';
        //echo '<br>';

        $allArtist = Artist::where('name' , 'regexp' , $exp)->get();
        //echo "<------------Artist------------>".'<br>';
        //foreach($allArtist as $art) echo $art->name.'<br>';
        //echo '<br>';

        $allTag = Tag::where('name' , 'regexp' , $exp)->get();
        //echo "<-------------TAG-------------->".'<br>';
        //foreach($allTag as $tag) echo $tag->name.'<br>';
        $artistArr = [];
        $limit = 50;
        for($i = 0 ; $i<sizeof($allSong) ; $i++) {
            $song = $allSong[$i];
            $art = "";
            for($j = 0 ; $j < sizeof($song->artist_arr) ; $j++){
                if(strlen($art) + strlen($song->artist_arr[$j]) > $limit){
                    for($k = 0 ; $k < strlen($song->artist_arr[$j]) ; $k++){
                        $art = $art.$song->artist_arr[$j][$k];
                        if(strlen($art) == $limit){
                            $art = $art." ....";
                            break;
                        }
                    }
                }
                else{
                    if($j > 0) $art = $art." ";
                    $art = $art.$song->artist_arr[$j];
                    if($j < sizeof($song->artist_arr) - 1) $art = $art.",";
                }
            }
            $artistArr = array_prepend($artistArr , $art);
            //for($j = 0 ; $j < sizeof($song->artist_arr) ; $j++) echo $song->artist_arr[$j].", ";
            //echo " :::==>".$song->title." ".$art."<br>";
        }
        $artistArr = array_reverse($artistArr);

        return view('SearchResult' , compact('allSong' , 'allArtist' , 'allTag' , 'artistArr'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($query)
    {
        //
        echo "search show called with query ==> ".$query;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
