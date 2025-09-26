<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-6">Welcome to Tinkering LMS</h1>
                    
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

                        <!-- Module Progress Bars -->
                        @if(count($moduleProgress) > 0)
                            <div class="mb-6 module-progress-section">
                                <div class="flex items-center mb-6">
                                    <h3 class="text-xl font-bold text-gray-800 flex items-center">
                                        <span class="mr-3 text-2xl">📊</span>
                                        Learning Progress by Module
                                    </h3>
                                </div>
                            
                            @foreach($moduleProgress as $progress)
                                <div class="mb-6 p-6 module-progress-card">
                                    <div class="flex items-center justify-between mb-5">
                                        <div class="flex items-center">
                                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-4 shadow-lg">
                                                <span class="text-white font-bold text-lg">
                                                    {{ strtoupper(substr($progress['module_name'], 0, 2)) }}
                                                </span>
                                            </div>
                                            <div>
                                                <h4 class="text-xl font-bold text-gray-800 mb-1">{{ $progress['module_name'] }}</h4>
                                                @if($progress['all_completed'])
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800 border border-green-200">
                                                        ✅ Complete
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-3xl font-bold text-blue-600 mb-1">{{ $progress['progress_percent'] }}%</div>
                                            <div class="text-sm text-gray-600 font-medium">
                                                {{ $progress['completed_activities'] }} of {{ $progress['total_activities'] }} activities
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Individual Module Progress Bar -->
                                    <div class="w-full progress-bar-container">
                                        @php
                                            $progressWidth = $progress['progress_percent'] ?? 0;
                                            $progressWidth = max(0, min(100, $progressWidth)); // Ensure between 0-100
                                        @endphp
                                        
                                        <!-- Progress bar with enhanced styling -->
                                        <div class="progress-bar-fill" 
                                             style="width: {{ $progressWidth }}%; min-width: {{ $progressWidth > 0 ? '12px' : '0px' }};">
                                            <!-- Progress percentage overlay -->
                                            <div class="absolute inset-0 flex items-center justify-center">
                                                <span class="progress-text">
                                                    {{ $progressWidth }}%
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            @endforeach
                            
                            <!-- Overall Completion Status -->
                            @php
                                $allModulesCompleted = collect($moduleProgress)->every(function($progress) {
                                    return $progress['all_completed'];
                                });
                            @endphp
                            
                            @if($allModulesCompleted && count($moduleProgress) > 0)
                                <div class="flex items-center justify-center bg-gradient-to-r from-green-100 to-emerald-100 border-2 border-green-400 rounded-xl p-6 shadow-lg">
                                    <div class="text-center">
                                        <div class="text-6xl mb-3 animate-bounce">🎉</div>
                                        <div class="text-2xl font-bold text-green-800 mb-2">Congratulations!</div>
                                        <div class="text-green-700 font-medium">You have completed all activities in all your unlocked modules!</div>
                                        <div class="mt-3 inline-block bg-green-200 text-green-800 px-4 py-2 rounded-full text-sm font-semibold">
                                            🏆 Achievement Unlocked!
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="text-center text-gray-600 text-sm bg-gray-50 rounded-lg p-3">
                                    <span class="inline-block mr-2">🚀</span>
                                    Keep going! Complete all activities in each module to unlock your achievement badges.
                                </div>
                            @endif
                        </div>
                    @endif


                </div>
            </div>
        </div>
    </div>


        <style>
            /* Enhanced progress bar styling for better visibility */
            .progress-bar-container {
                background: linear-gradient(to bottom, #ffffff 0%, #f1f5f9 100%);
                border: 2px solid #e2e8f0;
                border-radius: 12px;
                box-shadow: 
                    inset 0 2px 4px rgba(0,0,0,0.1),
                    0 1px 3px rgba(0,0,0,0.1);
                position: relative;
                overflow: hidden;
            }
            
            .progress-bar-fill {
                background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 50%, #1e40af 100%);
                border-radius: 10px;
                box-shadow: 
                    inset 0 2px 4px rgba(255,255,255,0.3),
                    0 2px 8px rgba(59, 130, 246, 0.3),
                    0 0 0 1px rgba(255,255,255,0.2);
                position: relative;
                overflow: hidden;
                transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            }
            
            .progress-bar-fill::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, 
                    transparent 0%, 
                    rgba(255,255,255,0.6) 50%, 
                    transparent 100%);
                animation: shimmer 3s infinite;
                border-radius: 10px;
            }
            
            .progress-bar-fill::after {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(180deg, 
                    rgba(255,255,255,0.2) 0%, 
                    transparent 50%, 
                    rgba(0,0,0,0.1) 100%);
                border-radius: 10px;
            }
            
            @keyframes shimmer {
                0% { left: -100%; }
                100% { left: 100%; }
            }
            
            .progress-text {
                text-shadow: 
                    0 1px 2px rgba(0,0,0,0.8),
                    0 0 4px rgba(0,0,0,0.3);
                font-weight: 800;
                letter-spacing: 0.5px;
                font-size: 0.875rem;
                z-index: 10;
                position: relative;
            }
            
            /* Enhanced module card styling */
            .module-progress-card {
                background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
                border: 2px solid #e2e8f0;
                border-radius: 16px;
                box-shadow: 
                    0 4px 6px rgba(0,0,0,0.05),
                    0 1px 3px rgba(0,0,0,0.1);
                transition: all 0.3s ease;
            }
            
            .module-progress-card:hover {
                transform: translateY(-2px);
                box-shadow: 
                    0 8px 15px rgba(0,0,0,0.1),
                    0 4px 6px rgba(0,0,0,0.05);
                border-color: #3b82f6;
            }
            
            /* Progress bar height adjustment */
            .progress-bar-container {
                height: 12px;
                margin-top: 8px;
            }
            
            .progress-bar-fill {
                height: 100%;
            }
            
            /* Additional enhancements for better visibility */
            .progress-bar-container:hover {
                border-color: #3b82f6;
                box-shadow: 
                    inset 0 2px 4px rgba(0,0,0,0.1),
                    0 1px 3px rgba(0,0,0,0.1),
                    0 0 0 3px rgba(59, 130, 246, 0.1);
            }
            
            /* Make progress text more visible */
            .progress-text {
                font-size: 0.75rem;
                font-weight: 900;
                text-transform: uppercase;
                letter-spacing: 1px;
            }
            
            /* Enhanced module progress section */
            .module-progress-section {
                background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
                border: 2px solid #e2e8f0;
                border-radius: 20px;
                padding: 24px;
                box-shadow: 
                    0 4px 6px rgba(0,0,0,0.05),
                    0 1px 3px rgba(0,0,0,0.1);
            }
        </style>

        <script>
            console.log('Dashboard JavaScript loaded');
        </script>
</x-app-layout>
