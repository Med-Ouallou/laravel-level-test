@extends('layouts.admin')

@section('title', 'Manage Teams')
@section('header', 'Team Management')

@section('content')
    <div class="flex flex-col">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-800">
                            All Teams
                        </h2>
                        <!-- Add button could go here if route existed -->
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-start">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                                        Team Name
                                    </span>
                                </th>
                                <th scope="col" class="px-6 py-3 text-start">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                                        Players
                                    </span>
                                </th>
                                <th scope="col" class="px-6 py-3 text-end"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($teams as $team)
                                <tr class="bg-white hover:bg-gray-50 transition-colors">
                                    <td class="size-px whitespace-nowrap">
                                        <div class="px-6 py-3">
                                            <div class="flex items-center gap-x-3">
                                                <div class="grow">
                                                    <span
                                                        class="block text-sm font-semibold text-gray-800">{{ $team->name }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="h-px w-72 whitespace-nowrap">
                                        <div class="px-6 py-3">
                                            <div class="flex items-center gap-1">
                                                <i data-lucide="users" class="w-3 h-3 text-slate-400"></i>
                                                <span
                                                    class="text-sm text-gray-600">{{ $team->players ? $team->players->count() : 0 }}
                                                    Players</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="size-px whitespace-nowrap">
                                        <div class="px-6 py-1.5">
                                            <div class="flex justify-end items-center gap-2">
                                                <a href="{{ route('admin.teams.edit', $team->id) }}"
                                                    class="text-slate-500 hover:text-indigo-600 transition-colors" title="Edit">
                                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                                </a>
                                                <!-- Assuming destroy route follows standard resource naming if it existed, but utilizing existing code structure -->
                                                <form action="{{ route('admin.teams.destroy', $team->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this team?');"
                                                    class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-slate-500 hover:text-red-600 transition-colors"
                                                        title="Delete">
                                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-10 text-center text-gray-500">
                                        <div class="flex flex-col justify-center items-center">
                                            <div
                                                class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center mb-3">
                                                <i data-lucide="flag" class="w-6 h-6 text-slate-300"></i>
                                            </div>
                                            <p class="font-medium">No teams found</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="px-6 py-4 grid gap-3 border-t border-gray-200">
                        {{ $teams->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection