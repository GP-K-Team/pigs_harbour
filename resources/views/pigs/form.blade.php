@extends('layouts.main', ['background' => 'texture-light'])

@php
  /** @var ?\App\Models\Pig $pig */
  $pig ??= null;
@endphp

@section('title')
    {{ isset($pig) ? $pig->name : 'Новая свинка' }}
@endsection

@section('content')
    <div class="content-container">
        <div class="form-container">
            <form class="form" action="{{ route('pigs.' . (is_null($pig) ? 'create' : 'update'), compact('pig')) }}" method="POST">
                <h2 class="form-title">
                    @if(isset($pig))
                        {{ $pig->name }}
                    @else
                        Новая свинка
                    @endif
                </h2>
                <div class="input-container">
                    <label class="input-label" for="name">Имя</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $pig?->name) }}" placeholder="Имя свинки">
                </div>

                <div class="input-container">
                    <label class="input-label" for="age">Возраст (текстом)</label>
                    <input type="text" name="age" id="age" value="{{ old('age', $pig?->age) }}" placeholder="Возраст свинки">
                </div>

                <div class="input-container">
                    <label class="input-label" for="slug_name">Транслит</label>
                    <input type="text" name="slug_name" id="slug_name" value="{{ old('slug_name', $pig?->slug_name) }}" placeholder="Транслит">
                </div>

                <div class="input-container has-textarea">
                    <label class="input-label" for="description">Подробное описание</label>
                    <textarea name="description" id="description" placeholder="Подробное описание">{{ trim( old('description', $pig?->description) ) }}</textarea>
                </div>

                <div class="input-container">
                    <fieldset>
                        <legend class="input-label">
                            Пол
                        </legend>
                        <div class="radio-group">
                            @foreach(\App\Enum\Sex::cases() as $sex)
                                <div class="radio-item">
                                    <input type="radio" name="sex" id="{{ $sex->value }}" value="{{ $sex->value }}" @checked($pig?->sex === $sex)>
                                    <label for="{{ $sex->value }}">{{ $sex->getLabel() }}</label>
                                </div>
                            @endforeach
                        </div>
                    </fieldset>
                </div>

                <div class="input-container">
                    <fieldset>
                        <legend class="input-label">
                            Принадлежность по шерсти
                        </legend>
                        <div class="radio-group">
                            @foreach(\App\Enum\Fur::cases() as $fur)
                                <div class="radio-item">
                                    <input type="radio" name="fur" id="{{ $fur->value }}" value="{{ $fur->value }}" @checked($pig?->fur === $fur)>
                                    <label for="{{ $fur->value }}">{{ $fur->getLabel() }}</label>
                                </div>
                            @endforeach
                        </div>
                    </fieldset>
                </div>
            </form>
        </div>
    </div>

    <style>
        .content-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 4rem 1rem 1rem;
            row-gap: 5rem;
        }

        .form {
            width: 60vw;
            height: 75vh;
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            place-content: flex-start;
            padding: 1rem;
            gap: 1rem;
            background-color: #ffffff;
            border: 1px solid var(--main_font);
            border-radius: 1rem;
        }

        .form-title {
            width: 100%;
            height: fit-content;
            flex-basis: 100%;
            margin: 0;
        }

        .input-container {
            display: flex;
            flex-direction: column;
            max-height: 90px;
            flex-basis: calc(50% - 1rem);
            gap: 0.25rem;
        }

        .input-container:is(:has(textarea), .has-textarea) {
            flex-basis: calc(100% - 1rem);
            max-height: unset;
        }

        .input-container label.input-label {
            white-space: nowrap;
            overflow-x: hidden;
            text-overflow: '...';
            font-size: 1rem;
            border-bottom: 1px solid var(--main_font);
        }

        .input-container :is(input, textarea, fieldset) {
            border: 2px solid var(--main_blue);
            border-radius: 0.5rem;
        }

        .input-container :is(input:not([type="radio"]), textarea):focus {
            outline: none;
            border-color: var(--main_pink);
        }

        .radio-group {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 1rem;
        }

        .radio-item {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 0.5rem;
        }

        input[type="text"], textarea {
            padding: 0.5rem;
            font-family: inherit;
            font-size: 1rem;
            background-color: transparent;
        }

        textarea {
            resize: vertical;
            min-height: 8rem;
            max-height: 20vh;
            overscroll-behavior: contain;
        }

        input[type="radio"] {
            width: 0.75rem;
            height: 0.75rem;
            margin: 0;

            appearance: none;
            border-radius: 50%;
            background: var(--light_blue);
            border: none;
            outline: 1px solid var(--main_font);
            outline-offset: 2px;
        }

        input[type="radio"]:checked {
            background: var(--main_pink);
        }
    </style>
@endsection
