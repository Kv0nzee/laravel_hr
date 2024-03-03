<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <title>{{$title}}</title>
</head>
<body>
    <x-navbar/>
    <div class=" py-8 px-10 ">
        {{$slot}}
    </div>
</body>
</html>