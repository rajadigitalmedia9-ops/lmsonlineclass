<div class="h-full flex space-x-6">
    <!-- Sidebar: Course Content -->
    <div class="w-80 bg-white border border-gray-200 rounded-2xl flex flex-col h-[calc(100vh-100px)] shadow-sm">
        <div class="p-5 border-b border-gray-100">
            <h2 class="text-lg font-bold text-gray-900 flex items-center">
                <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                Course Content
            </h2>
            <p class="text-sm text-gray-500 mt-1">{{ $videos->count() }} lessons</p>
        </div>
        
        <div class="flex-1 overflow-y-auto p-4 space-y-3">
            @forelse($videos as $index => $video)
                @php 
                    $isActive = $activeVideo && $activeVideo->id === $video->id; 
                @endphp
                <button wire:click="selectVideo({{ $video->id }})" class="w-full text-left p-4 rounded-xl border transition-all {{ $isActive ? 'bg-slate-900 text-white border-slate-900' : 'bg-white border-gray-100 text-gray-700 hover:border-gray-300 shadow-sm' }}">
                    <div class="flex items-start space-x-3">
                        <div class="mt-0.5 flex-shrink-0">
                            @if($isActive)
                                <div class="w-6 h-6 rounded-full bg-yellow-500 text-slate-900 flex items-center justify-center">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"></path></svg>
                                </div>
                            @else
                                <div class="w-6 h-6 rounded-full border-2 border-gray-300 flex items-center justify-center">
                                    <svg class="w-3 h-3 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                </div>
                            @endif
                        </div>
                        <div>
                            <p class="text-xs font-bold {{ $isActive ? 'text-yellow-500' : 'text-gray-900' }} uppercase mb-1">Lesson {{ $index + 1 }}</p>
                            <p class="text-sm font-semibold {{ $isActive ? 'text-white' : 'text-gray-700' }}">{{ $video->title }}</p>
                            <p class="text-xs {{ $isActive ? 'text-gray-400' : 'text-gray-500' }} mt-2 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $video->duration ?? 0 }} min
                            </p>
                        </div>
                    </div>
                </button>
            @empty
                <div class="text-center py-6 text-gray-500 text-sm">
                    No lessons uploaded yet.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Main Content: Player -->
    <div class="flex-1 flex flex-col h-[calc(100vh-100px)]">
        @if($activeLiveClass)
            <div class="mb-6">
                <h1 class="text-3xl font-extrabold text-[#1e293b]">{{ $activeLiveClass->title }}</h1>
            </div>
            <div class="flex-1 bg-black rounded-2xl overflow-hidden shadow-lg border border-slate-800 relative flex items-center justify-center">
                <!-- Placeholder for actual RTMP/OBS Player integration -->
                <div class="text-center text-white">
                    <svg class="w-16 h-16 text-yellow-500 mx-auto mb-4 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h2 class="text-2xl font-bold">Connecting to Live Stream...</h2>
                    <p class="text-gray-400 mt-2">Waiting for the instructor to start the broadcast via OBS.</p>
                </div>
                
                <!-- Overlay UI similar to Google Meet screenshot -->
                <div class="absolute top-4 right-4">
                    <button class="bg-blue-900 bg-opacity-80 hover:bg-opacity-100 text-white text-sm font-semibold px-4 py-2 rounded-lg flex items-center shadow-lg border border-white border-opacity-10 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        Video Completed
                    </button>
                </div>
            </div>
        @elseif($activeVideo)
            <div class="mb-6">
                <h1 class="text-3xl font-extrabold text-[#1e293b]">{{ $activeVideo->title }}</h1>
            </div>
            <div class="flex-1 bg-slate-900 rounded-2xl overflow-hidden shadow-lg border border-slate-800 relative">
                @if($activeVideo->video_path)
                    <video class="w-full h-full object-contain" controls controlsList="nodownload">
                        <source src="{{ asset('storage/' . $activeVideo->video_path) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-white">
                        <svg class="w-16 h-16 text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        <h2 class="text-xl font-medium text-gray-400">Video source not found</h2>
                    </div>
                @endif
                
                <div class="absolute top-4 right-4">
                    <button class="bg-blue-900 bg-opacity-80 hover:bg-opacity-100 text-white text-sm font-semibold px-4 py-2 rounded-lg flex items-center shadow-lg border border-white border-opacity-10 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        Video Completed
                    </button>
                </div>
            </div>
        @else
            <div class="flex-1 flex flex-col items-center justify-center text-gray-400 bg-white rounded-2xl border border-dashed border-gray-300">
                <svg class="w-20 h-20 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <h2 class="text-2xl font-bold text-gray-700">Select a Lesson</h2>
                <p class="text-sm mt-2">Choose a lesson from the course content sidebar to start watching.</p>
            </div>
        @endif
    </div>
</div>
