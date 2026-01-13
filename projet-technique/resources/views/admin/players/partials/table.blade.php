<table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-50">
        <tr>
            <th scope="col" class="px-6 py-3 text-start">
                <span class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Player
                </span>
            </th>
            <th scope="col" class="px-6 py-3 text-start">
                <span class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Score
                </span>
            </th>
            <th scope="col" class="px-6 py-3 text-start">
                <span class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Teams
                </span>
            </th>
            <th scope="col" class="px-6 py-3 text-end"></th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
        @forelse($players as $player)
            <tr class="bg-white hover:bg-gray-50 transition-colors">
                <td class="size-px whitespace-nowrap">
                    <div class="px-6 py-3">
                        <div class="flex items-center gap-x-3">
                            @if($player->image)
                                <img class="inline-block size-[38px] rounded-full object-cover ring-2 ring-white"
                                    src="{{ asset('storage/' . $player->image) }}" alt="{{ $player->name }}">
                            @else
                                <span
                                    class="inline-flex items-center justify-center size-[38px] rounded-full bg-slate-100 text-slate-500 font-semibold text-sm leading-none ring-2 ring-white">
                                    {{ substr($player->name, 0, 1) }}
                                </span>
                            @endif
                            <div class="grow">
                                <span
                                    class="block text-sm font-semibold text-gray-800">{{ $player->name }}</span>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="h-px w-72 whitespace-nowrap">
                    <div class="px-6 py-3">
                        <span
                            class="inline-flex items-center gap-x-1.5 py-1 px-3 rounded-full text-xs font-medium {{ $player->score >= 50 ? 'bg-indigo-100 text-indigo-800' : 'bg-slate-100 text-slate-800' }}">
                            {{ $player->score }}
                        </span>
                    </div>
                </td>
                <td class="h-px w-72 whitespace-nowrap">
                    <div class="px-6 py-3">
                        <div class="flex flex-wrap gap-1">
                            @forelse($player->teams as $team)
                                <span class="inline-flex items-center gap-x-1.5 py-0.5 px-2 rounded-lg text-[10px] font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                                    {{ $team->name }}
                                </span>
                            @empty
                                <span class="text-xs text-slate-400 italic">No teams assigned</span>
                            @endforelse
                        </div>
                    </div>
                </td>
                <td class="size-px whitespace-nowrap">
                    <div class="px-6 py-1.5">
                        <div class="flex justify-end items-center gap-2">
                            <a href="{{ url('admin/players/' . $player->id . '/edit') }}"
                                class="text-slate-500 hover:text-indigo-600 transition-colors" title="Edit">
                                <i data-lucide="pencil" class="w-4 h-4"></i>
                            </a>
                            <form action="{{ url('admin/players/' . $player->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this player?');"
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
                <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                    <div class="flex flex-col justify-center items-center">
                        <div
                            class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center mb-3">
                            <i data-lucide="users" class="w-6 h-6 text-slate-300"></i>
                        </div>
                        <p class="font-medium">No players found</p>
                        <p class="text-sm text-slate-400 mt-1">Get started by creating a new player.</p>
                    </div>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
<div class="px-6 py-4 grid gap-3 border-t border-gray-200" id="pagination-links">
    {{ $players->links() }}
</div>
