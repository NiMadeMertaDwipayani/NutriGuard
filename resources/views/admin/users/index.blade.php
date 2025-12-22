<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">{{ __('Manajemen Pengguna') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-700">
                
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-100">Daftar Pengguna</h3>
                    <a href="{{ route('admin.users.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded shadow-lg transition">
                        + Tambah User
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-emerald-900/50 border border-emerald-500 text-emerald-200 px-4 py-3 rounded relative mb-4">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="bg-red-900/50 border border-red-500 text-red-200 px-4 py-3 rounded relative mb-4">{{ session('error') }}</div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-gray-800 text-gray-300">
                        <thead>
                            <tr class="bg-gray-700 text-gray-200 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Nama</th>
                                <th class="py-3 px-6 text-left">Email</th>
                                <th class="py-3 px-6 text-center">Role</th>
                                <th class="py-3 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm font-light">
                            @foreach ($users as $user)
                                <tr class="border-b border-gray-700 hover:bg-gray-700 transition">
                                    <td class="py-3 px-6 font-bold text-white">{{ $user->name }}</td>
                                    <td class="py-3 px-6">{{ $user->email }}</td>
                                    <td class="py-3 px-6 text-center">
                                        <span class="{{ $user->role === 'admin' ? 'bg-purple-600 text-white' : 'bg-gray-600 text-gray-200' }} py-1 px-3 rounded text-xs uppercase font-bold">
                                            {{ $user->role }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="flex item-center justify-center gap-2">
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-400 hover:text-blue-300">Edit</a>
                                            <span class="text-gray-600">|</span>
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin hapus user ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-300">Hapus</button>
                                            </form>
                                        </div>
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

