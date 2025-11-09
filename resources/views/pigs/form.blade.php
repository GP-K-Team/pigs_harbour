@extends('layouts.main', ['background' => 'texture-light'])

@php
    use App\Enum\Fur;
    use App\Enum\Sex;
    use App\Models\Pig;
    use App\Models\City;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\Vite;

    /**
     * @var ?Pig $pig
     * @var Collection|iterable<City> $cities
     * @var Collection|iterable<Pig> $companionCandidates
     */
    $pig ??= null;
@endphp

@section('title')
    {{ isset($pig) ? $pig->name : 'Новая свинка' }}
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/form.css') }}">
@endpush

<script>
    window.preloadedFiles = @json(
        $pig?->images->map(fn($file) => [
            'source' => asset('/storage/' . $file->link),
            'options' => [
                'type' => 'local',
                 'metadata' => [
                    'id' => $file->id
                ]
            ]
        ])
    );
</script>

@push('js')
    <script type="module" src="{{ Vite::asset('resources/js/select-input.js') }}"></script>
    <script type="module" src="{{ Vite::asset('resources/js/filepond.js') }}"></script>
    <script type="module" src="{{ Vite::asset('resources/js/zebra.js') }}"></script>
    <script type="module" src="{{ Vite::asset('resources/js/page/translit.js') }}"></script>
@endpush

<meta name="csrf-token" content="{{ csrf_token() }}">

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

                <div class="input-container has-input-prefix">
                    <label class="input-label" for="slug_name">Транслит</label>
                    <input type="text" name="slug_name" id="slug_name" value="{{ old('slug_name', $pig?->slug_name) }}"
                           placeholder="Транслит" data-input-prefix="/catalog/" data-translit-target>
                    <x-error-bag name="slug_name"/>
                </div>

                <div class="input-container">
                    <label class="input-label" for="birthday">Дата рождения (для фильтра)</label>
                    <input class="datepick" type="text" name="birthday" id="birthday"
                           value="{{ old('birthday', Str::headline($pig?->birthday->translatedFormat('d M Y'))) }}"
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
                                       value="{{ true }}" checked>
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
                            @foreach(Sex::cases() as $sex)
                                <div class="radio-item">
                                    <input type="radio" name="sex" id="{{ $sex->value }}"
                                           value="{{ $sex->value }}" @checked($pig?->sex === $sex || old('sex') === $sex->value)>
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
                            @foreach(Fur::cases() as $fur)
                                <div class="radio-item">
                                    <input type="radio" name="fur" id="{{ $fur->value }}"
                                           value="{{ $fur->value }}" @checked($pig?->fur === $fur || old('fur') === $fur->value)>
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
                            <option value="{{ $id }}" @selected($id === $pig?->city_id)>
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

        .filepond {
            width: 100%;
            height: 10rem;
            padding: 0.25rem;
            background-color: var(--light_blue);
            border-bottom-left-radius: 1rem;
            border-bottom-right-radius: 1rem;
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
    </style>
@endsection
