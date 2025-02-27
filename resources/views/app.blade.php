<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quotation System</title>
    @vite(['resources/css/app.css', 'resources/js/src/app.js'])
</head>
<body>
<div id="app" class="flex flex-col min-h-full min-w-full"></div>
</body>
</html>
