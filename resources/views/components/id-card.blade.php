<div class="print-card ">
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg overflow-hidden border-2 border-white print:rounded-none">
        <!-- Header Section -->
        <div class="bg-white p-1.5">
            <div class="flex items-center">
                <!-- School Logo (Left) -->
                <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center shrink-0">
                    <svg class="w-14 h-14 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                    </svg>
                </div>

                <div class="text-center w-full">
                    <h2 class="text-xl font-bold text-gray-800">Royal Grammar School Aarazi</h2>

                    <h1 class="text-sm font-bold text-blue-800 tracking-wide">STUDENT ID CARD</h1>
                    <div class="w-16 h-0.5 bg-blue-600 mx-auto mt-1"></div>
                </div>
            </div>
        </div>
        <!-- Main Content Section -->
        <div class="p-2 text-white flex-1 flex">
            <div class="flex  space-x-3 w-full">
                <!-- Student Photo (Left) -->
                <div class="flex-shrink-0">
                    <div class="w-20 h-20 bg-gray-300 rounded-lg border-2 border-white flex items-center justify-center overflow-hidden">
                        <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                <!-- Student Information -->
                <div class="flex-1 space-y-2">
                    <!-- Name -->
                    <div class="bg-white/20 rounded py-1 px-2  backdrop-blur-sm">
                        <label class="text-xs font-semibold uppercase text-blue-200">
                            Name:
                        </label>
                        <span class="text-sm font-bold ml-2">
                            {{ $student->name }}
                        </span>
                    </div>
                    <!-- Student ID -->
                    <div class="bg-white/20 rounded py-1 px-2  backdrop-blur-sm">
                        <label class="text-xs font-semibold uppercase text-blue-200">
                            ID:
                        </label>
                        <span class="text-sm font-bold font-mono ml-2">
                            {{ $student->registery_number }}
                        </span>
                    </div>
                    <!-- Class -->
                    <div class="bg-white/20 rounded py-1 px-2  backdrop-blur-sm">
                        <label class="text-xs font-semibold uppercase text-blue-200">
                            Class:
                        </label>
                        <span class="text-sm font-bold ml-2">
                            {{ $student->educationLevel->name }}
                        </span>
                    </div>
                    <!-- Valid Until (smaller at bottom) -->
                    <div class="flex items-center justify-between mt-2">
                        <p class="text-xs text-blue-200">
                            Valid From:
                            <span class="font-semibold">
                                {{ date('m/Y', strtotime($student->admission_date)) }}
                            </span>
                        </p>
                        <p class="text-xs text-blue-200">
                            Valid Until:
                            <span class="font-semibold">
                                {{ date('m/Y', strtotime('+1 year')) }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bottom Accent -->
        <div class="h-1 bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600"></div>
    </div>
</div>
