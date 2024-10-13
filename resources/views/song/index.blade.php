<x-app-layout>
    <style>
        .button {
            font-size: 17px;
            border-radius: 12px;
            background: linear-gradient(180deg, rgb(56, 56, 56) 0%, rgb(36, 36, 36) 66%, rgb(41, 41, 41) 100%);
            color: rgb(218, 218, 218);
            border: none;
            padding: 2px;
            font-weight: 700;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .button span {
            border-radius: 10px;
            padding: 0.8em 1.3em;
            padding-right: 1.2em;
            text-shadow: 0px 0px 20px #4b4b4b;
            width: 100%;
            display: flex;
            align-items: center;
            gap: 12px;
            color: inherit;
            transition: all 0.3s;
            background-color: rgb(29, 29, 29);
            background-image: radial-gradient(at 95% 89%, rgb(15, 15, 15) 0px, transparent 50%), radial-gradient(at 0% 100%, rgb(17, 17, 17) 0px, transparent 50%), radial-gradient(at 0% 0%, rgb(29, 29, 29) 0px, transparent 50%);
        }

        .button:hover span {
            background-color: rgb(26, 25, 25);
        }

        .button-overlay {
            position: absolute;
            inset: 0;
            pointer-events: none;
            background: repeating-conic-gradient(rgb(48, 47, 47) 0.0000001%, rgb(51, 51, 51) 0.000104%) 60% 60%/600% 600%;
            filter: opacity(10%) contrast(105%);
            -webkit-filter: opacity(10%) contrast(105%);
        }

        .button svg {
            width: 15px;
            height: 15px;
        }

        /*------------------------------------------------------*/
        .container {
            padding: 20px;
            background-color: #f3f4f6;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 10px;
            padding: 10px;
        }

        .song-item {
            background-color: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.2);
            padding: 20px;
            text-align: left;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .song-item:hover {
            transform: translateY(-5px);
        }

        .tag {
            display: inline-block;
            background-color: #cbd5e0;
            color: #2d3748;
            border-radius: 20px;
            padding: 5px 10px;
            font-size: 12px;
            margin-right: 5px;
        }

        .action-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        .action-button {
            flex: 1;
            font-weight: bold;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            transition: background-color 0.3s;
            margin-right: 5px;
        }

        .view-button {
            background-color: #007bff;
            color: white;
        }

        .edit-button {
            background-color: #ffc107;
            color: white;
        }

        .delete-button {
            background-color: #dc3545;
            color: white;
        }

        .view-button:hover {
            background-color: #0056b3;
        }

        .edit-button:hover {
            background-color: #e0a800;
        }

        .delete-button:hover {
            background-color: #c82333;
        }

        .action-buttons .action-button:last-child {
            margin-right: 0;
        }

        @media (max-width: 300px) {
            .grid-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
    <div class="container">
        <div class="flex justify-end mb-4">
            <a href="{{ route('song.create') }}" class="button">
                <div class="button-overlay"></div>
                <span>Create Song <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 53 58" height="58"
                        width="53">
                        <path stroke-width="9" stroke="currentColor"
                            d="M44.25 36.3612L17.25 51.9497C11.5833 55.2213 4.5 51.1318 4.50001 44.5885L4.50001 13.4115C4.50001 6.86824 11.5833 2.77868 17.25 6.05033L44.25 21.6388C49.9167 24.9104 49.9167 33.0896 44.25 36.3612Z">
                        </path>
                    </svg></span>
            </a>
        </div>
        <div class="grid-container">
            @foreach ($songs as $song)
                <div class="song-item">
                    <div class="song-header">
                        <a class="hover:drop-shadow transform hover:bg-gray-200 font-bold text-xl mb-2"
                            href="{{ route('song.show', $song->id) }}">
                            {{ $song->title }}
                        </a>
                        <div class="tag-container">
                            <span class="tag">{{ $song->artist }}</span>
                            <span class="tag">{{ $song->genre }}</span>
                        </div>
                    </div>
                    <div class="action-buttons">
                        <a href="{{ route('song.show', $song->id) }}" class="action-button view-button">View</a>
                        <a href="{{ route('song.edit', $song->id) }}" class="action-button edit-button">Edit</a>
                        <form action="{{ route('song.destroy', $song->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-button delete-button">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
