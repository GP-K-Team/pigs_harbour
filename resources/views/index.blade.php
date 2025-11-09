@extends('layouts.main')

@php
    use App\Models\Pig;
    use App\Models\City;
    use App\Helpers\FileHelper;
    use App\Helpers\LinguisticsHelper;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\Vite;

    /** @var Collection|iterable<Pig> $pigs */
    /** @var Collection|iterable<City> $cities */
@endphp

@push('js')
    <script type="module" src="{{ Vite::asset('resources/js/splide.js') }}"></script>
@endpush

@section('title')
    Главная
@endsection

@section('content')
    @include('components.banner')
    @include('components.badge')
    @include('components.main_pigs')
    @include('components.steps')
    @include('components.summary')
@endsection

