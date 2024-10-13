<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Playlist;
use App\Models\Song;

class SongController extends Controller
{
    
    public function index()
    {
        $songs = Song::all();
        return view('song.index', ['songs'=>$songs]);
    }

    public function create()
    {
       return view('song.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'artist' => 'required',
            'genre' => 'required'
        ]);

        Song::create([
            'title' => $request->input('title'),
            'artist' => $request->input('artist'),
            'genre' => $request->input('genre')
        ]);

        return redirect('/song');
    }
    public function show(Song $song)
    {
        $allPlaylists=Playlist::all();
       return view('song.show', ['song' => $song, 'allPlaylists'=>$allPlaylists]);
    }
    public function edit($id)
    {
        $song = Song::findOrFail($id);

        return view('song.edit', ['song' => $song]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'artist' => 'required',
            'genre' => 'required'
        ]);

            Song::where('id', $id)
                ->update([
                    'title' => $request->input('title'),
                    'artist' => $request->input('artist'),
                    'genre' => $request->input('genre')
        ]);

    return redirect('/song');
    }

    public function destroy($id)
    {
        $song = Song::where('id', $id);

        $song->delete();

        return redirect('/song');
    }

    public function addPlaylist(Request $request, Song $song)
    {
        if ($song->playlists->contains($request['playlist'])) {
            return redirect()->back()->with('error', 'This song already exists in the playlist');
        }

        $song->playlists()->attach($request['playlist']);
        return redirect('/song/' . $song->id)->with('success', 'Song is added to the playlist!');
    }
    public function removePlaylist(Request $request, Song $song)
    {
        
        $song->playlists()->detach($request['playlist']);
        return redirect('/song/' . $song->id)->with('success', 'This song has been removed grom the playlist!');

    }
}