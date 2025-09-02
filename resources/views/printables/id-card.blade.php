<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student ID Card</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-md mx-auto">
        <!-- ID Card Container -->
        <div class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-xl shadow-2xl overflow-hidden border-4 border-white">
            <!-- Header Section -->
            <div class="bg-white p-4 relative">
                <!-- School Logo and Name -->
                <div class="flex items-center justify-between">
                    <!-- School Logo (Left) -->
                    <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center">
                        <svg class="w-10 h-10 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                        </svg>
                    </div>

                    <!-- School Name (Right) -->
                    <div class="text-right">
                        <h2 class="text-lg font-bold text-gray-800">Royal Grammar School</h2>
                        <p class="text-sm text-gray-600">Excellence in Education</p>
                    </div>
                </div>

                <!-- Card Title -->
                <div class="text-center mt-4">
                    <h1 class="text-2xl font-bold text-blue-800 tracking-wide">STUDENT ID CARD</h1>
                    <div class="w-24 h-1 bg-blue-600 mx-auto mt-2"></div>
                </div>
            </div>

            <!-- Main Content Section -->
            <div class="p-6 text-white">
                <!-- Student Photo -->
                <div class="flex justify-center mb-6">
                    <div class="w-32 h-32 bg-gray-300 rounded-full border-4 border-white shadow-lg flex items-center justify-center overflow-hidden">
                        <svg class="w-20 h-20 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>

                <!-- Student Information -->
                <div class="space-y-4">
                    <!-- Name Section -->
                    <div class="bg-white/20 rounded-lg p-4 backdrop-blur-sm">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wide text-blue-200 mb-1">First Name</label>
                                <p class="text-lg font-bold">{{ $student->first_name ?? 'John' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wide text-blue-200 mb-1">Last Name</label>
                                <p class="text-lg font-bold">{{ $student->last_name ?? 'Doe' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Grade/Education Level -->
                    <div class="bg-white/20 rounded-lg p-4 backdrop-blur-sm">
                        <label class="block text-xs font-semibold uppercase tracking-wide text-blue-200 mb-1">Grade/Level</label>
                        <p class="text-lg font-bold">{{ $student->grade ?? $student->education_level ?? 'Grade 10' }}</p>
                    </div>

                    <!-- Student ID -->
                    <div class="bg-white/20 rounded-lg p-4 backdrop-blur-sm">
                        <label class="block text-xs font-semibold uppercase tracking-wide text-blue-200 mb-1">Student ID</label>
                        <p class="text-lg font-bold font-mono">{{ $student->student_id ?? 'RGS2024001' }}</p>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-6 pt-4 border-t border-white/30">
                    <div class="flex justify-between items-center text-sm">
                        <div>
                            <p class="text-blue-200">Valid Until:</p>
                            <p class="font-semibold">{{ date('Y-m-d', strtotime('+1 year')) }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-blue-200">Academic Year:</p>
                            <p class="font-semibold">{{ date('Y') }}-{{ date('Y') + 1 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Accent -->
            <div class="h-2 bg-gradient-to-r from-yellow-400 to-yellow-600"></div>
        </div>
    </div>
</body>
</html>
