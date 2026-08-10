<div>
    <div class="mb-8 border-b border-gray-200 pb-4">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
    </div>

    <!-- Analytics Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-semibold flex items-center text-gray-800">
                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                Learning Analytics
            </h2>
            <span class="text-sm text-gray-500 font-medium">0% overall progress</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Lessons Done -->
            <div class="bg-slate-50 rounded-xl p-5 border border-slate-100 flex flex-col justify-between">
                <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <div>
                    <div class="text-3xl font-bold text-gray-900">{{ $lessonsDone }}</div>
                    <div class="text-sm text-gray-500 mt-1">Lessons Done</div>
                </div>
            </div>
            
            <!-- Certificates -->
            <div class="bg-slate-50 rounded-xl p-5 border border-slate-100 flex flex-col justify-between">
                <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                </div>
                <div>
                    <div class="text-3xl font-bold text-gray-900">{{ $certificates }}</div>
                    <div class="text-sm text-gray-500 mt-1">Certificates</div>
                </div>
            </div>

            <!-- Learning Hours -->
            <div class="bg-slate-50 rounded-xl p-5 border border-slate-100 flex flex-col justify-between">
                <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <div class="text-3xl font-bold text-gray-900">{{ $learningHours }}</div>
                    <div class="text-sm text-gray-500 mt-1">Learning Hours</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Grids -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Weekly Activity Chart Placeholder -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-6">Weekly Activity</h3>
            <div class="flex items-end h-48 space-x-4 border-b border-gray-100 pb-2">
                <div class="w-1/7 bg-blue-500 rounded-t-sm w-full h-1/4"></div>
                <div class="w-1/7 bg-blue-500 rounded-t-sm w-full h-full"></div>
                <div class="w-1/7 bg-blue-500 rounded-t-sm w-full h-3/4"></div>
                <div class="w-1/7 bg-blue-500 rounded-t-sm w-full h-1/6"></div>
                <div class="w-1/7 bg-blue-500 rounded-t-sm w-full h-2/3"></div>
                <div class="w-1/7 bg-blue-500 rounded-t-sm w-full h-5/6"></div>
                <div class="w-1/7 bg-blue-200 rounded-t-sm w-full h-1/12"></div>
            </div>
            <div class="flex justify-between mt-2 text-xs text-gray-400">
                <span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span><span>Sun</span>
            </div>
        </div>

        <!-- Focus Tracks -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Focus Tracks</h3>
            <div class="flex-1 border-2 border-dashed border-gray-200 rounded-xl flex flex-col items-center justify-center text-center p-6 text-gray-400">
                <svg class="w-10 h-10 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                <p class="text-sm">Start a course to see progress here.</p>
            </div>
        </div>
    </div>
</div>
