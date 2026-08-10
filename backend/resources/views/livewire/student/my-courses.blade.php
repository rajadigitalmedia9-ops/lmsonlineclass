<div>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">My Courses</h1>
        <div class="h-1 w-10 bg-blue-600 mt-2 rounded-full"></div>
    </div>

    <!-- Top Right Pills (All Courses, Live, etc) -->
    <div class="flex justify-end mb-6">
        <div class="flex items-center space-x-2">
            <button class="bg-blue-500 text-white px-4 py-2 rounded-full text-sm font-medium flex items-center shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                All Courses
            </button>
            <button class="bg-transparent text-gray-600 hover:bg-gray-100 px-4 py-2 rounded-full text-sm font-medium flex items-center transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                Live
            </button>
            <button class="bg-transparent text-gray-600 hover:bg-gray-100 px-4 py-2 rounded-full text-sm font-medium flex items-center transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Pre-Recorded
            </button>
            <button class="bg-transparent text-gray-600 hover:bg-gray-100 px-4 py-2 rounded-full text-sm font-medium flex items-center transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                Bonus Videos
            </button>
        </div>
    </div>

    <!-- Search -->
    <div class="mb-6">
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input wire:model.live="search" type="text" class="block w-full pl-11 pr-4 py-3 border border-gray-200 rounded-2xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm shadow-sm" placeholder="Search courses...">
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="bg-gray-50 border border-gray-100 rounded-2xl p-1 mb-8 flex space-x-1">
        <button wire:click="$set('filter', 'all')" class="flex-1 py-2.5 text-sm font-medium rounded-xl {{ $filter === 'all' ? 'bg-white text-blue-600 shadow-sm border border-gray-100' : 'text-gray-500 hover:text-gray-700' }} transition">
            All Courses
        </button>
        <button wire:click="$set('filter', 'in_progress')" class="flex-1 py-2.5 text-sm font-medium rounded-xl {{ $filter === 'in_progress' ? 'bg-white text-blue-600 shadow-sm border border-gray-100' : 'text-gray-500 hover:text-gray-700' }} transition">
            In Progress
        </button>
        <button wire:click="$set('filter', 'completed')" class="flex-1 py-2.5 text-sm font-medium rounded-xl {{ $filter === 'completed' ? 'bg-white text-blue-600 shadow-sm border border-gray-100' : 'text-gray-500 hover:text-gray-700' }} transition">
            Completed
        </button>
        <button wire:click="$set('filter', 'not_started')" class="flex-1 py-2.5 text-sm font-medium rounded-xl {{ $filter === 'not_started' ? 'bg-white text-blue-600 shadow-sm border border-gray-100' : 'text-gray-500 hover:text-gray-700' }} transition">
            Not Started
        </button>
    </div>

    <!-- Course Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($enrollments as $enrollment)
            @php 
                $course = $enrollment->course; 
                $batchName = $enrollment->batch ? $enrollment->batch->name : 'No Batch Assigned';
            @endphp
            <a href="{{ route('student.course.player', $course->id) }}" class="block bg-white rounded-3xl shadow-sm hover:shadow-md transition-shadow border border-gray-100 overflow-hidden group">
                <!-- Course Thumbnail Area (Image with pill) -->
                <div class="h-48 bg-gray-900 relative">
                    <!-- Default gradient if no image, but ideally we show the course image -->
                    <div class="absolute inset-0 bg-gradient-to-r from-purple-900 to-indigo-900 flex items-center justify-center opacity-80 group-hover:opacity-100 transition-opacity">
                        <!-- Abstract pattern or text if no image -->
                        <h2 class="text-white text-3xl font-black text-center px-4">{{ strtoupper($course->name) }}</h2>
                    </div>
                    
                    <div class="absolute top-4 right-4">
                        <span class="bg-blue-600 text-white text-xs font-semibold px-3 py-1 rounded-full shadow-sm">In Progress</span>
                    </div>
                </div>
                
                <!-- Course Details Area -->
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-2 leading-snug">{{ $course->name }}</h3>
                    <p class="text-sm text-gray-500 line-clamp-2 mb-6">
                        {{ $course->description ?? 'AI-powered SaaS product development using full-stack technologies and agentic AI workflows. The session...' }}
                    </p>
                    
                    <!-- Progress Bar -->
                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-2">
                            <span class="text-gray-500">Course Progress</span>
                            <span class="text-blue-600">1%</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-1.5">
                            <div class="bg-blue-600 h-1.5 rounded-full" style="width: 1%"></div>
                        </div>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-full py-12 flex flex-col items-center justify-center text-gray-500 bg-white rounded-3xl border border-dashed border-gray-300">
                <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                <p class="text-lg font-medium text-gray-700">No courses assigned yet</p>
            </div>
        @endforelse
    </div>
</div>
