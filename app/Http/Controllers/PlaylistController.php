<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Playlist;
use App\Models\Song;

class PlaylistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $playlists = Playlist::all();
        return view('playlist.index', compact('playlists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $songs = Song::all(); 

        return view('playlist.show', ['songs' => $songs]);
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(Playlist $playlist)
    {
        $availableSongs = Song::whereDoesntHave('playlists', function($query) use ($playlist) {
            $query->where('playlist_id', $playlist->id);
        })->get();
    
        return view('playlist.show', [
            'playlist' => $playlist,
            'availableSongs' => $availableSongs, // Pass the available songs to the view
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
    // Retrieve the playlist by its ID
    $playlist = Playlist::findOrFail($id);
    
    // Pass the playlist to the view
    return view('playlist.edit', ['playlist' => $playlist]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    // Validate the request data
    $request->validate([
        'name' => 'required',
        'tag' => 'required'
    ]);

    // Find the playlist and update its attributes
    $playlist = Playlist::findOrFail($id);
    $playlist->update([
        'name' => $request->input('name'),
        'tag' => $request->input('tag'),
    ]);

    // Redirect back to the playlists index page
    return redirect()->route('playlist.index')->with('success', 'Playlist updated successfully!');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        $playlist = Playlist::where('id', $id);

        $playlist->delete();

        return redirect('/playlist')->with('success', 'Playlist deleted successfully!');
    }

    
    public function addSong(Request $request, Playlist $playlist)
    {
        $request->validate([
            'song_id' => 'required|exists:songs,id',
        ]);
    
        $playlist->songs()->attach($request->input('song_id'));
        return redirect()->route('playlist.show', $playlist->id)->with('success', 'Song added to playlist!');
    }
}