<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Users / Edit') }}
            </h2>
            <a href="{{ route('users.index') }}" class="bg-red-700 py-2 px-4 rounded-lg text-white">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('error'))
                        <p class="text-red-500 my-3" role="alert">{{ session('error') }}</p>
                    @endif
                    <form action="{{ route('users.update', ['user' => $user->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="">Name</label>
                            <div class="my-3">
                                <input type="text" name="name" value="{{ old('name',$user->name) }}" class="w-1/2 border-gray-300 rounded-lg shadow-sm" placeholder="Enter Name">
                            </div>
                            @error('name')
                            <p class="text-red-500 my-1">{{ $message }}</p>
                            @enderror

                            <label for="">Email</label>
                            <div class="my-3">
                                <input type="email" name="email" value="{{ old('email',$user->email) }}" class="w-1/2 border-gray-300 rounded-lg shadow-sm" placeholder="Enter Name">
                            </div>
                            @error('email')
                            <p class="text-red-500 my-1">{{ $message }}</p>
                            @enderror

                            <div class="mb-3 grid grid-cols-4">
                                @if($roles->isNotEmpty())
                                    @foreach($roles as $role)
                                        <div class="mt-3">
                                            <input {{ $hasRoles->contains($role->id) ? 'checked' : '' }} type="checkbox" id="role-{{ $role->id }}" name="role[]" value="{{ $role->name }}" class="rounded">
                                            <label for="role-{{ $role->id }}">{{ $role->name }}</label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

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
