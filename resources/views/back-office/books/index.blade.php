<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if (session()->has('message'))
    <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ session()->get('message') }}
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-5">{{ __("Liste des livres") }}</h1>
                    <div class="mb-2">
                        <form action="{{route('books.index')}}" method="post">
                            @csrf
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" value="{{request()->title}}">
                            <label for="author">Author</label>
                            <input type="text" name="author" id="author" value="{{request()->author}}">
                            <button type="submit">Rechercher</button>
                        </form>
                    </div>

                    <table class="styled-table">
                        <thead>
                            <tr>
                                <th>title</th>
                                <th>author</th>
                                <th>copies</th>
                                <th>Emprunt</th>
                                <th>Rendre</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($books as $book)
                            <tr>
                                <td>{{$book->title}}</td>
                                <td>{{$book->author}}</td>
                                <td>{{$book->available_copies}}</td>
                                <td>
                                    @if ($book->available_copies != 0 )
                                    <form action="{{route('books.emprunt.store')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="copie" id="copie" value="1">
                                        <input type="hidden" name="book_id" id="book_id" value="{{$book->id}}">
                                        <button type="submit">Emprunter</button>
                                    </form>
                                    @else
                                    Indisponible
                                    @endif
                                </td>
                                <td>
                                    <form action="{{route('books.retour.store')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="copie" id="copie" value="1">
                                        <input type="hidden" name="book_id" id="book_id" value="{{$book->id}}">
                                        <button type="submit">Rendu</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>