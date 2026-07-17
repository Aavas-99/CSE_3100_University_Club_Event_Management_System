<div class="space-y-6">
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 bg-white p-4 rounded-2xl border border-slate-200">
        <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2">
            <i class="fas fa-user-graduate text-kuet-500"></i> Students Directory
        </h2>
        
        <form action="{{ route('dashboard') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full md:w-auto">
            <input type="hidden" name="tab" value="students">
            <div class="relative flex-1 md:w-64">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search students..." class="w-full pl-10 pr-4 py-2 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:bg-white focus:border-kuet-500 focus:ring-1 focus:ring-kuet-500 transition-all">
            </div>
            
            <div class="relative">
                <select name="department" onchange="this.form.submit()" class="py-2 pl-4 pr-8 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:bg-white focus:border-kuet-500 focus:ring-1 focus:ring-kuet-500 transition-all appearance-none cursor-pointer">
                    <option value="">All Departments</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept }}" {{ request('department') === $dept ? 'selected' : '' }}>{{ $dept }}</option>
                    @endforeach
                </select>
                <i class="fas fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
            </div>
            
            <div class="relative">
                <select name="sort" onchange="this.form.submit()" class="py-2 pl-4 pr-8 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:bg-white focus:border-kuet-500 focus:ring-1 focus:ring-kuet-500 transition-all appearance-none cursor-pointer">
                    <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Newest</option>
                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest</option>
                    <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                    <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
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
                        <th class="p-4">Student</th>
                        <th class="p-4">Student ID</th>
                        <th class="p-4">Department</th>
                        <th class="p-4">Joined</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($studentsList as $studentItem)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                        {{ strtoupper(substr($studentItem->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-slate-900">{{ $studentItem->name }}</div>
                                        <div class="text-xs text-slate-500">{{ $studentItem->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 font-mono text-slate-600">
                                {{ $studentItem->student_id ?? 'N/A' }}
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-1 rounded-md bg-slate-100 text-slate-700 text-xs font-bold">
                                    {{ $studentItem->department ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="p-4 text-slate-500 text-xs">
                                {{ $studentItem->created_at->format('M d, Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-slate-500">
                                <i class="fas fa-search text-2xl mb-3 text-slate-300 block"></i>
                                No students found matching your criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($studentsList->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $studentsList->links() }}
            </div>
        @endif
    </div>
</div>
