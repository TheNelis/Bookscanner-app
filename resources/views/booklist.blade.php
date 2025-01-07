<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Boekenlijst') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="flex-column max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if($books->count() > 0)
                @foreach($books as $book)
                    <div class="book-details flex justify-between items-center gap-5 mt-5 bg-white p-4 rounded-lg shadow">
                        <div class="flex items-center gap-5">
                            @if($book->image)
                                <img src="{{ $book->image }}" alt="{{ $book->title }}" class="w-24">
                            @else
                                <img src="https://bookstoreromanceday.org/wp-content/uploads/2020/08/book-cover-placeholder.png" alt="Cover placeholder" class="w-24">
                            @endif
                            <div>
                                <p><strong>Titel: </strong>{{ $book->title }}</p>
                                <p><strong>Auteurs: </strong>@if($book->authors) {{ $book->authors }} @endif</p>
                            </div>
                        </div>
                        
                        <form action="{{ route('booklist.destroy', $book->id) }}" method="POST" class="ml-auto">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Verwijder
                            </button>
                        </form>
                    </div>
                @endforeach
            @else
                <p class="text-center">Je boekenlijst is leeg. Scan een boek om toe te voegen!</p>
            @endif
            {{ $books->links() }}
        </div>
    </div>
</x-app-layout>