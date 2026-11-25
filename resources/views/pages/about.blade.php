@extends('layouts.app')

@section('title', 'About Emberwick Hearth Co.')

@section('content')
<section class="mx-auto max-w-6xl px-4 py-16">
    <p class="font-display text-5xl font-extrabold text-pine">Emberwick</p>
    <h1 class="mt-3 text-2xl font-semibold text-ink/80">A fireplace company built for Colorado living rooms</h1>
    <div class="mt-10 grid gap-10 md:grid-cols-2">
        <img src="https://images.unsplash.com/photo-1615874959471-d2fa0e57ae8a?auto=format&fit=crop&w=1400&q=80"
             alt="Stone fireplace with warm fire in a mountain-style home"
             class="h-80 w-full rounded-2xl object-cover">
        <div class="space-y-4 text-ink/80">
            <p>Emberwick started in Denver with a simple rule: never sell a firebox without owning the vent path. Our crews are residential specialists — gas inserts, wood fireplaces, electric accent walls, mantels, and stone surrounds.</p>
            <p>We document clearances, protect flooring, and leave jobsites swept. The ERP you see in /admin is the same system that schedules crews, tracks vent-kit inventory, and invoices on completion.</p>
            <p>Service area: Denver, Boulder, Aurora, Littleton, Lakewood, Highlands Ranch, Fort Collins, and nearby Front Range neighborhoods.</p>
        </div>
    </div>
</section>
@endsection
