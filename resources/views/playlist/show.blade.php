<x-app-layout>
    <div class="w-full rounded overflow-hidden shadow-lg p-4 bg-white mb-4">
            <div class="flex justify-between">
                <div>       
                    <a class="font-bold text-xl mb-2" href="{{ route('playlist.show', $playlist->id) }}">
                        {{ $playlist->name }}
                        <span class="inline-block shadow-lg bg-gray-400 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">{{ $playlist->tag }}</span>
</a>
                </div>
                <div>
                    <a href="{{ route('playlist.edit', $playlist->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded mr-2">
                        Edit
                    </a>
                    <form action="{{ route('playlist.destroy', $playlist->id) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
            <div class="px-6 pt-4 pb-2">
                <table class="w-full table-auto">
                    <tbody>
                         @foreach ($playlist->songs as $song)
                        <tr>
                            <td class= "border px-4 py02">{{ $song->title }}</td>
                            <td class= "border px-4 py02">{{ $song->artist }}</td>
                            <td class= "border px-4 py02">{{ $song->genre }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <form action="{{ route('playlist.addSong', $playlist->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="songs" class="block text-sm font-medium text-gray-700">Select Song</label>
                    <select id="songs" name="songs_id"> 
                        @foreach ($availableSongs  as $song)
                            <option value="{{$song->id}}">{{$song->title}}</option> 
                        @endforeach
                </select> 
                <button type="submit" id="addSong" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add Song</button>
            </div>
        </form>
</x-app-layout>
