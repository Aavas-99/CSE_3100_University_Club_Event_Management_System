<div class="space-y-6">
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 bg-white p-4 rounded-2xl border border-slate-200">
        <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2">
            <i class="fas fa-calendar-alt text-kuet-500"></i> Events Directory
        </h2>
        
        <form action="{{ route('dashboard') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full md:w-auto">
            <input type="hidden" name="tab" value="events">
            <div class="relative flex-1 md:w-64">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search events..." class="w-full pl-10 pr-4 py-2 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:bg-white focus:border-kuet-500 focus:ring-1 focus:ring-kuet-500 transition-all">
            </div>
            
            <div class="relative">
                <select name="status" onchange="this.form.submit()" class="py-2 pl-4 pr-8 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:bg-white focus:border-kuet-500 focus:ring-1 focus:ring-kuet-500 transition-all appearance-none cursor-pointer">
                    <option value="">All Statuses</option>
                    <option value="Approved" {{ request('status') === 'Approved' ? 'selected' : '' }}>Approved</option>
                    <option value="Pending" {{ request('status') === 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Rejected" {{ request('status') === 'Rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
                <i class="fas fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
            </div>
            
            <div class="relative">
                <select name="club_id" onchange="this.form.submit()" class="py-2 pl-4 pr-8 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:bg-white focus:border-kuet-500 focus:ring-1 focus:ring-kuet-500 transition-all appearance-none cursor-pointer">
                    <option value="">All Clubs</option>
                    @foreach($filterClubs as $clubFilter)
                        <option value="{{ $clubFilter->id }}" {{ request('club_id') == $clubFilter->id ? 'selected' : '' }}>{{ $clubFilter->name }}</option>
                    @endforeach
                </select>
                <i class="fas fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
            </div>
            
            <div class="relative">
                <select name="type" onchange="this.form.submit()" class="py-2 pl-4 pr-8 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:bg-white focus:border-kuet-500 focus:ring-1 focus:ring-kuet-500 transition-all appearance-none cursor-pointer">
                    <option value="">All Types</option>
                    <option value="Workshop" {{ request('type') === 'Workshop' ? 'selected' : '' }}>Workshop</option>
                    <option value="Seminar" {{ request('type') === 'Seminar' ? 'selected' : '' }}>Seminar</option>
                    <option value="Competition" {{ request('type') === 'Competition' ? 'selected' : '' }}>Competition</option>
                    <option value="Festival" {{ request('type') === 'Festival' ? 'selected' : '' }}>Festival</option>
                    <option value="Meetup" {{ request('type') === 'Meetup' ? 'selected' : '' }}>Meetup</option>
                </select>
                <i class="fas fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
            </div>
            
            <div class="relative">
                <select name="sort" onchange="this.form.submit()" class="py-2 pl-4 pr-8 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:bg-white focus:border-kuet-500 focus:ring-1 focus:ring-kuet-500 transition-all appearance-none cursor-pointer">
                    <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Newest Created</option>
                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest Created</option>
                    <option value="date_asc" {{ request('sort') === 'date_asc' ? 'selected' : '' }}>Event Date (Soonest)</option>
                    <option value="date_desc" {{ request('sort') === 'date_desc' ? 'selected' : '' }}>Event Date (Latest)</option>
                </select>
                <i class="fas fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
            </div>
            <button type="submit" class="hidden"></button>
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs uppercase tracking-wider text-slate-500 font-semibold">
                        <th class="p-4">Event</th>
                        <th class="p-4">Club</th>
                        <th class="p-4">Date & Location</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($eventsList as $eventItem)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="p-4">
                                <div class="font-semibold text-slate-900">{{ $eventItem->title }}</div>
                                <div class="text-xs text-slate-500 mt-1">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-600">{{ $eventItem->event_type }}</span>
                                </div>
                            </td>
                            <td class="p-4">
                                <div class="text-slate-700 font-medium">{{ $eventItem->club->name ?? 'N/A' }}</div>
                            </td>
                            <td class="p-4">
                                <div class="text-slate-900"><i class="fas fa-calendar text-slate-400 mr-1"></i> {{ $eventItem->event_date->format('M d, Y') }}</div>
                                <div class="text-xs text-slate-500 mt-1"><i class="fas fa-map-marker-alt text-slate-400 mr-1"></i> {{ $eventItem->venue }}</div>
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-1 rounded-full text-xs font-bold uppercase tracking-wider
                                    {{ $eventItem->status === 'Approved' ? 'bg-emerald-50 text-emerald-700' :
                                       ($eventItem->status === 'Pending' ? 'bg-amber-50 text-amber-700' : 'bg-red-50 text-red-700') }}">
                                    {{ $eventItem->status }}
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                <a href="{{ route('events.show', $eventItem) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg border border-slate-200 text-slate-600 hover:text-kuet-600 hover:border-kuet-200 hover:bg-kuet-50 transition-colors text-xs font-semibold">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-500">
                                <i class="fas fa-search text-2xl mb-3 text-slate-300 block"></i>
                                No events found matching your criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($eventsList->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $eventsList->links() }}
            </div>
        @endif
    </div>
</div>
