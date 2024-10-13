<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Playlist;
use App\Models\Song;

class PlaylistController extends Controller
{
    public function index()
    {
        $playlists = Playlist::all();
        return view('playlist.index', ['playlists'=>$playlists]);
    }

    public function create()
    {
        return view('playlist.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'tag' => 'required'
        ]);

        Playlist::create([
            'name' => $request->input('name'),
            'tag' => $request->input('tag')
        ]);

        return redirect('/playlist')->with('success', 'Playlist created successfully!');
    }

    public function show(Playlist $playlist)
    {
        $allSongs = Song::all();
        return view('playlist.show',['playlist'=>$playlist, 'allSongs'=>$allSongs]);
    }

    public function edit($id)
    {
    $playlist = Playlist::findOrFail($id);
    
    return view('playlist.edit', ['playlist' => $playlist]);
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required',
        'tag' => 'required',
    ]);

    $playlist = Playlist::findOrFail($id);
    $playlist->update([
        'name' => $request->input('name'),
        'tag' => $request->input('tag'),
    ]);


    return redirect()->route('playlist.index')->with('success', 'Playlist updated successfully!');
}

    public function destroy($id) 
    {
        $playlist = Playlist::where('id', $id);
        $playlist->delete();
        return redirect('/playlist')->with('success', 'Playlist deleted successfully!');
    }

    public function addSong(Request $request, Playlist $playlist) {
        if ($playlist->songs->contains($request['song'])) {
            return redirect()->back()->with('error', 'Song is already in the playlist.');
        }

        $playlist->songs()->attach($request['song']);
        return redirect('/playlist/' . $playlist->id)->with('success', 'Song added successfully!');
    }

    public function removeSong(Request $request, Playlist $playlist)
    {
        
        $playlist->songs()->detach($request['song']);
        return redirect('/playlist/' . $playlist->id)->with('success', 'Song has been removed!');

    }

}