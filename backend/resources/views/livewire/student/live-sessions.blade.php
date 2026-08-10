<div>
    <div class="mb-8 border-b border-gray-200 pb-4">
        <h1 class="text-3xl font-bold text-gray-900 flex items-center">
            <span class="w-8 h-8 rounded-lg bg-red-100 text-red-500 flex items-center justify-center mr-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </span>
            Your Live Rooms
        </h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($liveClasses as $class)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col hover:shadow-md transition">
                <!-- Header part -->
                <div class="bg-blue-500 p-6 text-white relative">
                    <span class="inline-block bg-blue-400 text-xs font-bold px-2 py-1 rounded-md mb-3">
                        Active Batch
                    </span>
                    <h2 class="text-xl font-bold leading-snug">{{ strtoupper($class->course->name ?? 'UNKNOWN COURSE') }} ({{ $class->batch->name ?? 'Batch' }})</h2>
                    <p class="text-blue-100 text-sm mt-1">Live Interactive Session: {{ $class->title }}</p>
                </div>
                
                <!-- Body part -->
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div class="space-y-4 mb-6">
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <div>
                                <p class="text-xs font-bold text-gray-900 uppercase">Schedule</p>
                                <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($class->scheduled_at)->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div>
                                <p class="text-xs font-bold text-gray-900 uppercase">Status</p>
                                @if($class->status == 'active')
                                    <p class="text-sm text-green-600 font-bold flex items-center">
                                        <span class="w-2 h-2 rounded-full bg-green-500 mr-2 animate-pulse"></span>
                                        Available Now
                                    </p>
                                @else
                                    <p class="text-sm text-yellow-600 font-medium">
                                        Scheduled
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    @if($class->status == 'active')
                        <a href="{{ route('student.course.player', ['id' => $class->course_id, 'live' => $class->id]) }}" class="w-full block text-center py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition">
                            Join Room
                        </a>
                    @else
                        <button disabled class="w-full block text-center py-3 bg-gray-100 text-gray-400 rounded-xl font-bold cursor-not-allowed">
                            Link Not Available
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 flex flex-col items-center justify-center text-gray-500 bg-white rounded-2xl border border-dashed border-gray-300">
                <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-lg font-medium text-gray-700">No active live sessions</p>
                <p class="text-sm mt-1">There are no live rooms scheduled for your enrolled courses right now.</p>
            </div>
        @endforelse
    </div>
</div>
