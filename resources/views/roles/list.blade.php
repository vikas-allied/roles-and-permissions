<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Roles / List') }}
            </h2>
            @can('create roles')
            <a href="{{ route('roles.create') }}" class="bg-slate-700 py-2 px-4 rounded-lg text-white">Create</a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>

            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr class="border-b">
                        <th class="px-6 py-3 text-left" width="60">#</th>
                        <th class="px-6 py-3 text-left">Name</th>
                        <th class="px-6 py-3 text-left">Permissions</th>
                        <th class="px-6 py-3 text-left" width="180">Created</th>
                        <th class="px-6 py-3 text-center" width="280">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @forelse($roles as $role)
                        <tr class="border-b">
                            <td class="px-6 py-3 text-left">{{ $loop->iteration }}</td>
                            <td class="px-6 py-3 text-left">{{ $role->name }}</td>
                            <td class="px-6 py-3 text-left">{{ $role->permissions->pluck('name')->implode(', ') }}</td>
                            <td class="px-6 py-3 text-left">{{ \Carbon\Carbon::parse($role->created_at)->format('d M, Y') }}</td>
                            <td class="px-6 py-3 text-center">
                                @can('edit roles')
                                <a href="{{ route('roles.edit', ['role' => $role->id]) }}" class="bg-slate-700 hover:bg-slate-600 py-2 px-4 rounded-lg text-white">Edit</a>
                                @endcan

                                @can('delete roles')
                                <a href="javascript:void(0)" onclick="deleteRole({{ $role->id }})" class="bg-red-600 hover:bg-red-500 py-2 px-4 rounded-lg text-white">Delete</a>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-3 text-center">No roles found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="my-2">
                {{ $roles->links() }}
            </div>
        </div>
    </div>

    <x-slot name="script">
    <script type="text/javascript">

    function deleteRole(id) {

        if (confirm('Are you sure you want to delete this role?')) {
            $.ajax({
                url: `{{ url('roles')}}/${id}`,
                type: 'delete',
                dataType: 'json',
                headers: {
                    'x-csrf-token': '{{ csrf_token() }}'
                },
                success: function (){
                    window.location.href = '{{ route("roles.index") }}'
                }
            })
        }
    }
    </script>
</x-slot>

</x-app-layout>


