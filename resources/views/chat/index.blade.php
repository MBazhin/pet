@php use App\Http\Resources\Chat\UserResource;@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Чат</title>

    @vite(['resources/css/Chat/app.css', 'resources/js/Chat/app.js'])
</head>
<body>
    <div
        id="app"
        data-auth="{{ UserResource::make(auth()->user())->toJson() }}"
    ></div>
</body>
</html>
