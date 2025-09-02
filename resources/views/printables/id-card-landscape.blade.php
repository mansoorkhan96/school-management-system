<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student ID Card - Landscape</title>
    @vite('resources/css/app.css')
    <style>
        @media print {
            body { margin: 0; padding: 0; background: white !important; }
            .print-card {
                /* width: 3.375in !important; */
                /* height: 2.125in !important; */
                margin: 0 !important;
                box-shadow: none !important;
                border: 1px solid #ccc !important;
            }
            .no-print { display: none !important; }
        }
        /* .print-card {
            width: 3.375in;
            height: 2.125in;
            margin: 0 auto;
        } */
    </style>
</head>
<body class="p-8">
    <div class="grid grid-cols-2 gap-x-2 gap-y-5">
        <x-id-card :student="$student" />
        <x-id-card :student="$student" />
        <x-id-card :student="$student" />
        <x-id-card :student="$student" />
        <x-id-card :student="$student" />
        <x-id-card :student="$student" />
        <x-id-card :student="$student" />
        <x-id-card :student="$student" />
    </div>
</body>
</html>
