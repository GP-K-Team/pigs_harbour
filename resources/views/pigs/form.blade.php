@extends('layouts.main', ['background' => 'texture-light'])

@php
    use Illuminate\Support\Facades\Vite;

    /**
     * @var ?\App\Models\Pig $pig
     * @var \Illuminate\Support\Collection|iterable<\App\Models\City> $cities
     * @var \Illuminate\Support\Collection|iterable<\App\Models\Pig> $companionCandidates
     */
    $pig ??= null;
@endphp

@section('title')
    {{ isset($pig) ? $pig->name : 'Новая свинка' }}
@endsection

@push('js')
    <script type="module" src="{{ Vite::asset('resources/js/select-input.js') }}"></script>
    <script type="module" src="{{ Vite::asset('resources/js/filepond.js') }}"></script>
    <script type="module" src="{{ Vite::asset('resources/js/zebra.js') }}"></script>
    <script type="module" src="{{ Vite::asset('resources/js/page/translit.js') }}"></script>
@endpush

@section('content')
    <div class="content-container">
        <div class="form-container">
            <form class="form" action="{{ route('pigs.' . (is_null($pig) ? 'create' : 'update'), compact('pig')) }}"
                  method="POST" enctype="multipart/form-data">
                <h2 class="form-title">
                    @if(isset($pig))
                        {{ $pig->name }}
                    @else
                        Новая свинка
                    @endif
                </h2>

                <div class="input-container">
                    <label class="input-label" for="name">Имя</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $pig?->name) }}"
                           placeholder="Имя свинки" data-translit-source>
                    <x-error-bag name="name"/>
                </div>

                <div class="input-container">
                    <label class="input-label" for="age">Возраст (текстом)</label>
                    <input type="text" name="age" id="age" value="{{ old('age', $pig?->age) }}"
                           placeholder="Возраст свинки">
                    <x-error-bag name="age"/>
                </div>

                <div class="input-container">
                    <label class="input-label" for="slug_name">Транслит</label>
                    <input type="text" name="slug_name" id="slug_name" value="{{ old('slug_name', $pig?->slug_name) }}"
                           placeholder="Транслит" data-translit-target>
                    <x-error-bag name="slug_name"/>
                </div>

                <div class="input-container">
                    <label class="input-label" for="birthday">Дата рождения (для фильтра)</label>
                    <input class="datepick" type="text" name="birthday" id="birthday"
                           value="{{ old('birthday', $pig?->birthday) }}"
                           placeholder="Дата рождения">
                    <x-error-bag name="birthday"/>
                </div>

                <div class="input-container has-radio">
                    <fieldset>
                        <legend class="input-label">
                            Ищет дом
                        </legend>
                        <div class="radio-group">
                            <div class="radio-item">
                                <input type="radio" name="is_active" id="1"
                                       value="{{ true }}" @checked(empty($pig) || $pig->is_active)>
                                <label for="1">Да</label>
                            </div>
                            <div class="radio-item">
                                <input type="radio" name="is_active" id="0"
                                       value="{{ false }}" @checked(isset($pig) && !$pig->is_active)>
                                <label for="0">Нет</label>
                            </div>
                        </div>
                    </fieldset>
                    <x-error-bag name="is_active"/>
                </div>

                <div class="input-container has-textarea">
                    <label class="input-label" for="description">Подробное описание</label>
                    <textarea name="description" id="description"
                              placeholder="Подробное описание">{{ trim( old('description', $pig?->description) ) }}</textarea>
                    <x-error-bag name="description"/>
                </div>

                <div class="input-container">
                    <fieldset>
                        <legend class="input-label">
                            Пол
                        </legend>
                        <div class="radio-group">
                            @foreach(\App\Enum\Sex::cases() as $sex)
                                <div class="radio-item">
                                    <input type="radio" name="sex" id="{{ $sex->value }}"
                                           value="{{ $sex->value }}" @checked($pig?->sex === $sex)>
                                    <label for="{{ $sex->value }}">{{ $sex->getLabel() }}</label>
                                </div>
                            @endforeach
                        </div>
                    </fieldset>
                    <x-error-bag name="sex"/>
                </div>

                <div class="input-container">
                    <fieldset>
                        <legend class="input-label">
                            Шерсть
                        </legend>
                        <div class="radio-group">
                            @foreach(\App\Enum\Fur::cases() as $fur)
                                <div class="radio-item">
                                    <input type="radio" name="fur" id="{{ $fur->value }}"
                                           value="{{ $fur->value }}" @checked($pig?->fur === $fur)>
                                    <label for="{{ $fur->value }}">{{ $fur->label() }}</label>
                                </div>
                            @endforeach
                        </div>
                    </fieldset>
                    <x-error-bag name="fur"/>
                </div>

                <div class="input-container has-select">
                    <label class="input-label" for="city">Город</label>
                    <select name="city" id="city">
                        <option value="" disabled>Выберите город</option>
                        @foreach($cities as $id => $city)
                            <option value="12" @selected($id === $pig?->city_id)>
                                {{ $city }}
                            </option>
                        @endforeach
                    </select>
                    <x-error-bag name="city"/>
                </div>

                <div class="input-container has-select">
                    <label class="input-label" for="companion">Отдаётся вместе</label>
                    <select name="companion" id="companion" data-search="true">
                        <option value="" @selected(empty($pig) && empty($pig->companion_pig_id))>Без напарника</option>
                        @foreach($companionCandidates as $candidate)
                            <option
                                value="{{ $candidate->id }}" @selected(isset($pig) && ($pig->companion || $pig->companionOf) && ($pig->companion?->id ?? $pig->companionOf->id) === $candidate->id)>
                                {{ $candidate->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-error-bag name="companion"/>
                </div>

                <div class="input-container has-dropzone">
                    <label class="input-label" for="images">Фото</label>
                    <div class="dropzone-container">
                        <div class="filepond">

                        </div>
                    </div>
                    <x-error-bag name="files"/>
                </div>

                <div class="form-button">
                    <button type="submit">Отправить</button>
                </div>

                @csrf
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

        .form-container {
            max-width: 750px;
        }

        .form {
            max-width: 75vw;
            min-height: 90vh;
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
            max-width: 100%;
            max-height: 100px;
            flex-direction: column;
            flex-basis: calc(50% - 1rem);
            gap: 0.25rem;
        }

        .input-container:is(:has(textarea), .has-textarea) {
            flex-basis: calc(100% - 1rem);
            max-height: unset;
        }

        .input-container:is(:has(.filepond), .has-dropzone) {
            flex-basis: calc(100% - 1rem);
            max-height: unset;
        }

        .input-container:is(:has(input[type="radio"]), .has-radio) {
            flex-basis: calc(100% - 1rem);
            max-height: unset;
        }

        .input-container:is(:has(select), .has-select) {
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
            margin: 0;
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
            flex-wrap: wrap;
            align-items: center;
            gap: 1rem;
        }

        .radio-item {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 0.5rem;
        }

        .filepond {
            width: 100%;
            height: 10rem;
            padding: 0.25rem;
            background-color: var(--light_blue);
            border-bottom-left-radius: 1rem;
            border-bottom-right-radius: 1rem;
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

        input[type="file"] {
            display: none;
        }

        .select-input .select-input__dropdown {
            width: 100%;
            max-height: 10rem;
            border: 1px solid var(--main_font);
            border-radius: 0.5rem;
            overflow-y: scroll;
            scrollbar-width: thin;
            scrollbar-color: var(--main_pink) var(--light_blue);
        }

        #companion + .select-input .select-input__option:not(:disabled) {
            display: flex;
            flex-direction: row;
            align-items: center;
        }

        #companion + .select-input .select-input__option:not(.select-input__option--value, :first-child)::before {
            content: "";
            width: 4rem;
            height: 4rem;
            display: inline-flex;
            background-image: url('/public/images/texture-light.png');
        }

        .form-button {
            width: 100%;
            display: flex;
            flex-direction: column;
        }

        .form-button > button {
            width: max-content;
            align-self: flex-end;
            margin-right: 1rem;
            border: none;
            padding: 0.75rem 1rem;
            font-family: inherit;
            font-size: 1rem;
            font-weight: 800;
            color: var(--main_font);
            background: var(--main_pink);
            border-radius: 0.5rem;
        }

        span.input-error {
            color: var(--holiday-red);
        }
    </style>
@endsection
