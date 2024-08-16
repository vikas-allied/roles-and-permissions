<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Article / Edit') }}
            </h2>
            <a href="{{ route('articles.index') }}" class="bg-red-700 py-2 px-4 rounded-lg text-white">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('error'))
                        <p class="text-red-500 my-3" role="alert">{{ session('error') }}</p>
                    @endif
                    <form action="{{ route('articles.update', ['article' => $article->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div>
                        <label for="">Title<span class="text-red-500">*</span></label>
                            <div class="my-3">
                                <input type="text" name="title" id="title" value="{{ old('title', $article->title) }}" class="w-1/2 border-gray-300 rounded-lg shadow-sm" placeholder="Enter Title">
                            </div>
                            @error('title')
                            <p class="text-red-500 my-1">{{ $message }}</p>
                            @enderror

                            <label for="">Content</label>
                            <div class="my-3">
                            <textarea name="text" id="text" rows="10" cols="30" class="w-1/2 border-gray-300 rounded-lg shadow-sm">{{ old('text', $article->text) }}</textarea>
                            </div>

                            <label for="">Author<span class="text-red-500">*</span></label>
                            <div class="my-3">
                                <input type="text" name="author" id="author" value="{{ old('author', $article->author) }}" class="w-1/2 border-gray-300 rounded-lg shadow-sm" placeholder="Enter Author Name">
                            </div>
                            @error('author')
                            <p class="text-red-500 my-1">{{ $message }}</p>
                            @enderror
                            <button class="text-white bg-slate-600 hover:bg-slate-500 px-5 py-2 rounded-lg mt-2">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
