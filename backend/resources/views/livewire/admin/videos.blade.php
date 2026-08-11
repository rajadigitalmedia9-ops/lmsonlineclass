<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Manage Offline Videos</h2>
        <button wire:click="create" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
            Upload Video
        </button>
    </div>

    <!-- Videos Table -->
    <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Video Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($videos as $video)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $video->title }}</div>
                        <div class="text-xs text-gray-500">{{ $video->is_free ? 'Free' : 'Premium' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ optional($video->course)->name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ optional($video->subject)->name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Published</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                        <button wire:click="delete({{ $video->id }})" wire:confirm="Are you sure you want to delete this video?" class="text-gray-600 hover:text-red-900">Delete</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No videos uploaded yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal Form -->
    @if($showModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-800 bg-opacity-75">
        <div class="relative p-4 w-full max-w-lg max-h-full">
            <div class="relative bg-white rounded-lg shadow">
                <form wire:submit.prevent="save" 
                      x-data="{ isUploading: false, progress: 0, uploadError: false, get isProcessing() { return this.isUploading && this.progress === 100; } }">
                    <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">
                            Upload Video
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Video Title</label>
                                <input type="text" wire:model="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
                                @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Course</label>
                                <select wire:model="course_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
                                    <option value="">Select Course</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                                    @endforeach
                                </select>
                                @error('course_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Subject</label>
                                <select wire:model="subject_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
                                    <option value="">Select Subject</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                                @error('subject_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            
                            <!-- Upload Type Selector -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Video Source</label>
                                <div class="flex items-center space-x-4">
                                    <label class="inline-flex items-center">
                                        <input type="radio" wire:model.live="upload_type" value="file" class="form-radio text-blue-600 focus:ring-blue-500">
                                        <span class="ml-2 text-sm text-gray-700">Upload File (Render)</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" wire:model.live="upload_type" value="url" class="form-radio text-blue-600 focus:ring-blue-500">
                                        <span class="ml-2 text-sm text-gray-700">External URL (Free/Cloud)</span>
                                    </label>
                                </div>
                            </div>

                            <!-- External URL Input -->
                            @if($upload_type === 'url')
                            <div>
                                <label class="block text-sm font-medium text-gray-700">External Video URL (e.g., Google Drive, S3, Cloudflare R2)</label>
                                <input type="url" wire:model="video_url" placeholder="https://..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
                                <p class="text-xs text-gray-500 mt-1">Paste the direct link to the MP4 file or embed URL.</p>
                                @error('video_url') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            @endif
                            
                            <!-- File Upload Input -->
                            @if($upload_type === 'file')
                            <div x-on:livewire-upload-start="isUploading = true; uploadError = false"
                                 x-on:livewire-upload-finish="isUploading = false; progress = 100"
                                 x-on:livewire-upload-error="isUploading = false; uploadError = true"
                                 x-on:livewire-upload-progress="progress = $event.detail.progress">
                                
                                <label class="block text-sm font-medium text-gray-700">Video File (MP4, max 50MB for testing)</label>
                                <input type="file" wire:model="video_file" class="mt-1 block w-full sm:text-sm">
                                
                                <!-- Progress Bar -->
                                <div x-show="isUploading" class="mt-3">
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" x-bind:style="`width: ${progress}%`"></div>
                                    </div>
                                    <p class="text-blue-600 text-xs mt-1 font-semibold" x-text="isProcessing ? 'Processing on server, please wait...' : `Uploading... ${progress}%`"></p>
                                </div>
                                
                                <!-- Success Message -->
                                <div x-show="!isUploading && progress === 100 && !uploadError" class="mt-2 text-green-600 text-xs font-semibold flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    File uploaded to temporary storage! Click 'Upload & Save' to finalize.
                                </div>

                                <!-- Error Message -->
                                <div x-show="uploadError" class="mt-2 text-red-600 text-xs font-semibold">
                                    Upload failed. Please check the file size limits or network connection.
                                </div>

                                @error('video_file') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-lg">
                        <button type="submit" 
                                x-bind:disabled="isUploading || (@js($upload_type) === 'file' && !@js($video_file) && progress === 0)"
                                x-bind:class="{ 'opacity-50 cursor-not-allowed': isUploading || (@js($upload_type) === 'file' && !@js($video_file) && progress === 0) }"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                            <span wire:loading.remove wire:target="save">Upload & Save</span>
                            <span wire:loading wire:target="save">Saving...</span>
                        </button>
                        <button type="button" wire:click="$set('showModal', false)" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
