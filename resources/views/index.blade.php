@extends('layouts.main')

@section('title')
    Сайт
@endsection

@section('content')
    @include('components.banner')
    @include('components.badge')
    @include('components.main_pigs')
    @include('components.steps')
    @include('components.summary')
@endsection

