<?php

namespace App\Http\Controllers;


use App\Models\Album;
use App\Http\Requests\AlbumFormRequest;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class AlbumController extends Controller
{

    protected $artists = [];

    function __construct()
    {
        $this->artists = $this->getArtistsList();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $albums = Album::query()
        ->orderBy('artist','asc')
        ->orderBy('year','asc')->get();

        $message = $request->session()->get('message');


        return view('albums.index',compact('albums', 'message'))
                ->with('i', (request()->input('page', 1) - 1) * 5);;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $artists = $this->artists;

        return view('albums.create',compact('artists'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AlbumFormRequest $request)
    {
        $artistName = $this->searchArray($request->artist, $this->artists);

        $album = Album::create([
            'artist_id'  => $request->artist,
            'artist'     => $artistName,
            'album_name' => $request->albumName,
            'year'       => $request->year
        ]);

        $request->session()->flash('message',"Album {$album->album_name} created with success.");

        return redirect()->route('albums.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function show(Album $album)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function edit(Album $album)
    {
        $artists = $this->artists;

        return view('albums.edit', compact('album','artists'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function update(AlbumFormRequest $request, Album $album)
    {


        $artistName = $this->searchArray($request->artist, $this->artists);

        $album->update([
            'artist_id'  => $request->artist,
            'artist'     => $artistName,
            'album_name' => $request->albumName,
            'year'       => $request->year]);

        $request->session()->flash('message',"Album {$album->album_name} update with success.");

        return redirect()->route('albums.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Album $album)
    {

        $album->delete();

        $request->session()->flash('message',"Album deleted with success.");

        return redirect()->route('albums.index');
    }

    public static function getArtistsList()
    {
        $client = new Client();
        $url = "https://moat.ai/api/task/";

        $params = [
            //If you have any Params Pass here
        ];

        $headers = [
            'Basic' => 'ZGV2ZWxvcGVyOlpHVjJaV3h2Y0dWeQ=='
        ];

        $response = $client->request('GET', $url, [
            // 'json' => $params,
            'headers' => $headers,
            'verify'  => false,
        ]);

        $artistsList = json_decode($response->getBody(),true);


        return $artistsList;
    }

    public static function searchArray($search,array $array){
        try{
            foreach ($array as $key[0] => $value) {
                //array_push($valnewarray,array_column($value, 'id'));
                if($value['0']['id'] == $search)
                    $val = $value['0']['name'];
            }

            return $val;

        }catch (Exception $e) {
            return false;
        }
    }

}
