<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $activity->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Activity Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h1 class="text-3xl font-bold mb-2">{{ $activity->title }}</h1>
                            <p class="text-gray-600 text-lg">{{ $activity->objective }}</p>
                        </div>
                        <div class="text-right">
                            <div class="bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full mb-2">
                                Progress: {{ number_format($progress->progress_percent, 1) }}%
                            </div>
                            <div class="w-32 bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $progress->progress_percent }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Concept Focus -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold mb-4 text-blue-800">🎯 Concept Focus</h3>
                            <p class="text-gray-700 leading-relaxed">{{ $activity->concept_focus }}</p>
                        </div>
                    </div>

                    <!-- Materials Needed -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold mb-4 text-green-800">🛠️ Materials Needed</h3>
                            <ul class="space-y-2">
                                @foreach($activity->materials_needed as $material)
                                    <li class="flex items-center">
                                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $material }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Instructions -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold mb-4 text-purple-800">📋 Instructions</h3>
                            <div class="prose max-w-none">
                                {!! nl2br(e($activity->instructions)) !!}
                            </div>
                        </div>
                    </div>

                    <!-- Circuit Diagram -->
                    @if($activity->circuit_diagram)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-xl font-semibold mb-4 text-orange-800">🔌 Circuit Diagram</h3>
                                <div class="text-center">
                                    <img src="{{ Storage::url($activity->circuit_diagram) }}" 
                                         alt="Circuit Diagram" 
                                         class="max-w-full h-auto rounded-lg shadow-md hover:shadow-lg transition-shadow cursor-pointer"
                                         onclick="openImageModal(this.src)">
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Explanation -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold mb-4 text-indigo-800">💡 Explanation</h3>
                            <div class="prose max-w-none">
                                {!! nl2br(e($activity->explanation)) !!}
                            </div>
                        </div>
                    </div>

                    <!-- Video -->
                    @if($activity->video_link)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-xl font-semibold mb-4 text-red-800">🎥 Video Tutorial</h3>
                                <div class="aspect-w-16 aspect-h-9">
                                    <iframe src="{{ $activity->video_link }}" 
                                            class="w-full h-64 rounded-lg" 
                                            frameborder="0" 
                                            allowfullscreen>
                                    </iframe>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar - Checklist -->
                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg sticky top-6">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold mb-4 text-gray-800">✅ Activity Checklist</h3>
                            
                            @if($activity->checklists->count() > 0)
                                <div class="space-y-3">
                                    @foreach($activity->checklists as $checklist)
                                        <div class="flex items-center p-3 border-2 border-gray-200 rounded-lg hover:bg-gray-50 transition-colors hover:border-blue-300">
                                            <input type="checkbox" 
                                                   id="checklist_{{ $checklist->id }}"
                                                   class="w-5 h-5 text-blue-600 bg-gray-100 border-2 border-gray-300 rounded focus:ring-blue-500 focus:ring-2"
                                                   {{ in_array($checklist->id, $progress->completed_checklist_items ?? []) ? 'checked' : '' }}
                                                   data-checklist-id="{{ $checklist->id }}">
                                            <label for="checklist_{{ $checklist->id }}" 
                                                   class="ml-3 text-sm font-medium text-gray-700 cursor-pointer flex-1">
                                                {{ $checklist->item }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                                    <div class="flex justify-between text-sm mb-3">
                                        <span class="text-blue-700">Completed:</span>
                                        <span class="font-semibold text-blue-800" id="completed-count">
                                            {{ count($progress->completed_checklist_items ?? []) }} / {{ $activity->checklists->count() }}
                                        </span>
                                    </div>
                                    <button onclick="saveChecklistProgress()" 
                                            class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                                        💾 Save Progress
                                    </button>
                                </div>
                            @else
                                <p class="text-gray-500 text-sm">No checklist items for this activity.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <div class="mt-8 flex justify-between">
                <a href="{{ route('modules.show', $module) }}" 
                   class="inline-flex items-center text-blue-600 hover:text-blue-800 bg-blue-50 px-4 py-2 rounded-lg hover:bg-blue-100 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Module
                </a>
                
                <a href="{{ route('dashboard') }}" 
                   class="inline-flex items-center text-gray-600 hover:text-gray-800 bg-gray-50 px-4 py-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative max-w-4xl max-h-full">
                <button onclick="closeImageModal()" 
                        class="absolute top-4 right-4 text-white hover:text-gray-300 text-2xl font-bold">
                    ×
                </button>
                <img id="modalImage" src="" alt="Circuit Diagram" class="max-w-full max-h-full rounded-lg">
            </div>
        </div>
    </div>

    <script>
        console.log('Activity page JavaScript loaded');
        
        function saveChecklistProgress() {
            console.log('Saving checklist progress...');
            
            // Get all checked items
            const checkedItems = [];
            document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                if (checkbox.checked) {
                    checkedItems.push(checkbox.dataset.checklistId);
                }
            });
            
            console.log('Checked items:', checkedItems);
            console.log('Activity ID: {{ $activity->id }}');
            console.log('Request URL: /activities/{{ $activity->id }}/save-progress');
            
            // Show loading state
            const saveButton = document.querySelector('button[onclick="saveChecklistProgress()"]');
            const originalText = saveButton.textContent;
            saveButton.textContent = '⏳ Saving...';
            saveButton.disabled = true;
            
            // Create form data
            const formData = new FormData();
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            console.log('CSRF Token:', csrfToken);
            formData.append('_token', csrfToken);
            formData.append('completed_items', JSON.stringify(checkedItems));
            
            // Send AJAX request
            const url = `/activities/{{ $activity->slug }}/save-progress`;
            console.log('Sending request to:', url);
            console.log('Form data entries:');
            for (let [key, value] of formData.entries()) {
                console.log(key, ':', value);
            }
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);
                if (!response.ok) {
                    // Try to get error details
                    return response.text().then(text => {
                        console.error('Error response:', text);
                        throw new Error(`HTTP error! status: ${response.status}, body: ${text}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('Progress saved successfully:', data);
                
                // Check if data has the expected structure
                if (!data || typeof data !== 'object') {
                    console.error('Invalid response data:', data);
                    throw new Error('Invalid response format');
                }
                
                // Update progress bar
                const progressBar = document.querySelector('.bg-blue-600');
                const progressText = document.querySelector('.bg-blue-100');
                if (progressBar) {
                    progressBar.style.width = data.progress_percent + '%';
                }
                if (progressText) {
                    progressText.textContent = `Progress: ${data.progress_percent}%`;
                }
                
                // Update completed count
                const completedCount = document.getElementById('completed-count');
                if (completedCount) {
                    completedCount.textContent = `${data.completed_count} / ${data.total_count}`;
                }
                
                // Show success message
                showNotification(`Progress saved: ${data.progress_percent}%`, 'success');
                
                // Reset button
                saveButton.textContent = originalText;
                saveButton.disabled = false;
            })
            .catch(error => {
                console.error('Error saving progress:', error);
                console.error('Error details:', error.message);
                console.error('Error stack:', error.stack);
                showNotification('Error saving progress: ' + error.message, 'error');
                
                // Reset button
                saveButton.textContent = originalText;
                saveButton.disabled = false;
            });
        }

        function openImageModal(src) {
            document.getElementById('modalImage').src = src;
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }

        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg text-white z-50 ${
                type === 'success' ? 'bg-green-500' :
                type === 'error' ? 'bg-red-500' :
                'bg-blue-500'
            }`;
            notification.textContent = message;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // Close image modal when clicking outside
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageModal();
            }
        });
    </script>
</x-app-layout>
