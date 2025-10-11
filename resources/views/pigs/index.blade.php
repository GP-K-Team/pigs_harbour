@extends('layouts.main', ['background' => 'texture-light'])

@section('title')
    Свинки
@endsection

@php
/** @var \Illuminate\Support\Collection|iterable<\App\Models\Pig> $pigs */
@endphp

@section('content')
    <div class="list-container">
        <ul class="list">
            @foreach($pigs as $pig)
                <li class="list-item">
                    <p>{{ $pig->name }}</p>
                </li>
            @endforeach
        </ul>
    </div>

    <style>
        .list-container {
            padding: 1rem;
        }

        .list {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            padding: 1rem;
            max-width: 250px;
            background-color: #E2F4F4;
            border-radius: 1rem;
        }
    </style>
@endsection
