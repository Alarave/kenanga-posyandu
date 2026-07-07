@extends('layouts.public-layout')

@section('title', 'Beranda - Posyandu Kenanga')

@section('content')
<div class="max-w-7xl mx-auto px-6 md:px-12 py-20">
    <h1 class="text-4xl font-bold mb-8">Test Home Page</h1>
    
    <div class="bg-white rounded-lg p-6 mb-8">
        <h2 class="text-2xl font-bold mb-4">Schedules Count: {{ $schedules->count() }}</h2>
        <h2 class="text-2xl font-bold mb-4">Articles Count: {{ $articles->count() }}</h2>
    </div>
</div>
@endsection
