<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 bg-white p-4 rounded-2xl border border-slate-200">
        <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2">
            <i class="fas fa-building text-kuet-500"></i> Clubs Directory
        </h2>
        
        <form action="{{ route('dashboard') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
            <input type="hidden" name="tab" value="clubs">
            <div class="relative flex-1 sm:w-64">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search clubs..." class="w-full pl-10 pr-4 py-2 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:bg-white focus:border-kuet-500 focus:ring-1 focus:ring-kuet-500 transition-all">
            </div>
            <select name="sort" onchange="this.form.submit()" class="py-2 pl-4 pr-8 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:bg-white focus:border-kuet-500 focus:ring-1 focus:ring-kuet-500 transition-all appearance-none cursor-pointer">
                <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Newest First</option>
                <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest First</option>
                <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
            </select>
            <button type="submit" class="hidden"></button>
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs uppercase tracking-wider text-slate-500 font-semibold">
                        <th class="p-4">Club Name</th>
                        <th class="p-4">Organizer</th>
                        <th class="p-4">Total Events</th>
                        <th class="p-4">Created Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($clubsList as $clubItem)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="p-4">
                                <div class="font-semibold text-slate-900">{{ $clubItem->name }}</div>
                                <div class="text-xs text-slate-500 truncate max-w-xs">{{ $clubItem->description }}</div>
                            </td>
                            <td class="p-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold">
                                        {{ strtoupper(substr($clubItem->organizer->name ?? '?', 0, 1)) }}
                                    </div>
                                    <span>{{ $clubItem->organizer->name ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-bold">{{ $clubItem->events_count }}</span>
                            </td>
                            <td class="p-4 text-slate-500 text-xs">
                                {{ $clubItem->created_at->format('M d, Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-slate-500">
                                <i class="fas fa-search text-2xl mb-3 text-slate-300 block"></i>
                                No clubs found matching your criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($clubsList->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $clubsList->links() }}
            </div>
        @endif
    </div>
</div>
