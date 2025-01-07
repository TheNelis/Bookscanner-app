<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Boek info') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <a href="/scannen" class="underline">← Terug naar scannen</a>
                @if($book !== null)
                    <div class="book-details flex justify-items-center gap-5 mt-5">
                        @if(isset($book['image']['url']))
                            <img class="w-24" src="{{ $book['image']['url'] }}" alt="{{ $book['title'] }}">
                        @else
                            <img class="w-24" src="https://bookstoreromanceday.org/wp-content/uploads/2020/08/book-cover-placeholder.png" alt="{{ $book['title'] }}">
                        @endif
                        <div>
                            <p><strong>Titel: </strong>{{ $book['title'] }}</p>
                            <p><strong>Auteurs: </strong>
                                @foreach($book['cached_contributors'] as $contributor)
                                    <li>{{ $contributor['author']['name'] }}</li>
                                @endforeach
                            </p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('add.book') }}" class="mt-5">
                        @csrf
                        <input type="hidden" name="title" value="{{ $book['title'] }}">
                        <input type="hidden" name="authors" value="{{ isset($book['cached_contributors'][0]['author']['name']) ? $book['cached_contributors'][0]['author']['name'] : '' }}">
                        <input type="hidden" name="image" value="{{ $book['image']['url'] ?? '' }}">
                        
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Toevoegen aan lijst
                        </button>
                    </form>
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                @else
                    <div class="book-details gap-5 mt-5">
                        <p><strong class="text-lg">Boek niet gevonden in de database :'(</strong><br/>
                            Scan een ander boek of 
                            <a class="underline text-blue-600" href="https://hardcover.app/books/new" target="_blank">Voeg het boek toe</a>
                        </p>
                        <img class="mt-5" src="https://media0.giphy.com/media/v1.Y2lkPTc5MGI3NjExNnhwa3JtbXp5Y2lsY3ZoNzRmd2s4OG94NHVxbWJyNmswY2hpN2RjeSZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/3o6wrebnKWmvx4ZBio/giphy.webp" alt="">
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>