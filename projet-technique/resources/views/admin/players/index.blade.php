@extends('layouts.admin')

@section('title', 'Manage Players')
@section('header', 'Player Management')

@section('content')
<div class="flex flex-col">
    <div class="-m-1.5 overflow-x-auto">
        <div class="p-1.5 min-w-full inline-block align-middle">
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">
                        All Students
                    </h2>
                    <div>
                        <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-indigo-600 text-white hover:bg-indigo-700 disabled:opacity-50 disabled:pointer-events-none" href="{{ url('admin/players/create') }}">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                            Add New Student
                        </a>
                    </div>
                </div>

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-start">
                                <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                                        Student
                                    </span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-start">
                                <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                                        Score
                                    </span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-start">
                                <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                                        Teams
                                    </span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-end"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($players as $player)
                            <tr class="bg-white hover:bg-gray-50">
                                <td class="size-px whitespace-nowrap">
                                    <div class="px-6 py-3">
                                        <div class="flex items-center gap-x-3">
                                            @if($player->image)
                                                <img class="inline-block size-[38px] rounded-full object-cover" src="{{ $player->image }}" alt="{{ $player->name }}">
                                            @else
                                                <span class="inline-flex items-center justify-center size-[38px] rounded-full bg-indigo-100 text-indigo-500 font-semibold text-sm leading-none">
                                                    {{ substr($player->name, 0, 1) }}
                                                </span>
                                            @endif
                                            <div class="grow">
                                                <span class="block text-sm font-semibold text-gray-800">{{ $player->name }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="h-px w-72 whitespace-nowrap">
                                    <div class="px-6 py-3">
                                        <span class="inline-flex items-center gap-x-1.5 py-1 px-3 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                            {{ $player->score }}
                                        </span>
                                    </div>
                                </td>
                                <td class="h-px w-72 whitespace-nowrap">
                                    <div class="px-6 py-3">
                                        <span class="text-sm text-gray-500">{{ $player->teams->count() }} Teams</span>
                                    </div>
                                </td>
                                <td class="size-px whitespace-nowrap">
                                    <div class="px-6 py-1.5">
                                        <div class="hs-dropdown relative inline-block [--placement:bottom-right]">
                                            <button id="hs-table-dropdown-{{ $player->id }}" type="button" class="hs-dropdown-toggle py-1.5 px-2 inline-flex justify-center items-center gap-2 rounded-lg text-gray-700 align-middle disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm">
                                                <i data-lucide="more-vertical" class="w-4 h-4"></i>
                                            </button>
                                            <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden divide-y divide-gray-200 min-w-40 z-10 bg-white shadow-2xl rounded-lg p-2 mt-2" aria-labelledby="hs-table-dropdown-{{ $player->id }}">
                                                <div class="py-2 first:pt-0 last:pb-0">
                                                    <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100" href="{{ url('admin/players/' . $player->id . '/edit') }}">
                                                        <i data-lucide="pencil" class="w-4 h-4 text-gray-500"></i>
                                                        Edit
                                                    </a>
                                                    
                                                     <form action="{{ url('admin/players/' . $player->id) }}" method="POST" class="w-full" onsubmit="return confirm('Are you sure?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="w-full flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-red-600 hover:bg-gray-100 focus:outline-none focus:bg-gray-100">
                                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                    <div class="flex flex-col justify-center items-center">
                                       <i data-lucide="meh" class="w-10 h-10 text-gray-300 mb-2"></i>
                                       <p>No students found.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-4 grid gap-3 border-t border-gray-200">
                    {{ $players->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
