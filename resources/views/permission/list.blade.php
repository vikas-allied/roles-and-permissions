<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Permissions / List') }}
            </h2>
            <a href="{{ route('permissions.create') }}" class="bg-slate-700 py-2 px-4 rounded-lg text-white">Create</a>
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
                        <th class="px-6 py-3 text-left" width="180">Created</th>
                        <th class="px-6 py-3 text-center" width="280">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @forelse($permissions as $permission)
                        <tr class="border-b">
                            <td class="px-6 py-3 text-left">{{ $loop->iteration }}</td>
                            <td class="px-6 py-3 text-left">{{ $permission->name }}</td>
                            <td class="px-6 py-3 text-left">{{ \Carbon\Carbon::parse($permission->created_at)->format('d M, Y') }}</td>
                            <td class="px-6 py-3 text-center">
                                <a href="{{ route('permissions.edit', ['permission' => $permission->id]) }}" class="bg-slate-700 hover:bg-slate-600 py-2 px-4 rounded-lg text-white">Edit</a>
                                <a href="javascript:void(0)" onclick="deletePermission({{ $permission->id }})" class="bg-red-600 hover:bg-red-500 py-2 px-4 rounded-lg text-white">Delete</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-3 text-center">No permissions found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="my-2">
                {{ $permissions->links() }}
            </div>
        </div>
    </div>

    <x-slot name="script">
    <script type="text/javascript">

    function deletePermission(id) {
           
        if (confirm('Are you sure you want to delete this permission?')) {
            $.ajax({
                url: `{{ url('permissions')}}/${id}`,
                type: 'delete',
                data: {id:id},
                dataType: 'json',
                headers: {
                    'x-csrf-token': '{{ csrf_token() }}'
                },
                success: function (){
                    window.location.href = '{{ route("permissions.index") }}'
                }
            })
        }
    }

        // function deletePermission(id) {
        //     console.log('here');
        //     if (confirm('Are you sure you want to delete this permission?')) {
        //         fetch(`{{ url('permissions') }}/${id}`, {
        //             method: 'DELETE',
        //             headers: {
        //                 'Content-Type': 'application/json',
        //                 'X-CSRF-TOKEN': '{{ csrf_token() }}'
        //             }
        //         })
        //         .then(response => response.json())
        //         .then(data => {
        //             console.log(data);
        //             if (data.status) {
        //                 alert('Permission deleted successfully.');
        //                 location.reload();
        //             } else {
        //                 alert('Failed to delete permission.');
        //             }
        //         })
        //         .catch(error => {
        //             console.error('Error:', error);
        //             alert('An error occurred while deleting the permission.');
        //         });
        //     }
        // }
    </script>
</x-slot>

</x-app-layout>


