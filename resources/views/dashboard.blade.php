@extends('layouts.dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

     <!-- Card: Welcome -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold">Welcome</h2>
            <p class="mt-2">Halo, <span class="font-bold">{{ auth()->user()->name }}</span>! 🎉</p>
        </div>

        <!-- Card: Jumlah User -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold">Total Users</h2>
            <p class="text-3xl font-bold mt-2">{{ \App\Models\User::count() }}</p>
        </div>

        <!-- Card: Jumlah Post -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold">Total Posts</h2>
            <p class="text-3xl font-bold mt-2">{{ \App\Models\Post::count() }}</p>
        </div>

        <!-- Card: Jumlah Product -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold">Total Products</h2>
            <p class="text-3xl font-bold mt-2">{{ \App\Models\Product::count() }}</p>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        console.log("Dashboard loaded");
    </script>
@endpush
