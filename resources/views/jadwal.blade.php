@extends('layouts.app')

@section('title', 'Jadwal S2 Magister Manajemen Eksekutif')

@section('content')
    {{-- Stats Cards --}}
    @include('components.stats-cards')

    {{-- Filter Panel --}}
    @include('components.filter-panel')

    {{-- Schedule Table --}}
    @include('components.schedule-table')
@endsection
