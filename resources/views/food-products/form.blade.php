@extends('layouts.main', ['background' => 'texture-light'])

@php
    use App\Models\FoodProduct;
    use App\Models\Hashtag;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\Vite;

    /**
     * @var ?FoodProduct $foodProduct
     * @var Collection|iterable<Hashtag> $hashtags
     */
    $foodProduct ??= null;
@endphp

@section('title', $foodProduct?->title ?? 'Новый продукт')

@push('styles')
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/form.css') }}">
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/choices.css') }}">
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/rich-text-editor.css') }}">
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/article.css') }}">
@endpush

@push('js')
    @vite('resources/js/filepond.js')
    @vite('resources/js/article-choice.js')
    @vite('resources/js/form/rich-text-editor.js')
    @vite('resources/js/form/translit.js')
    @vite('resources/js/zebra.js')

    @if($foodProduct && $foodProduct->mainImage)
        <script type="module">
            window.preloadedFiles = @js([
                [
                    'source' => asset('/storage/' . $foodProduct->mainImage->link),
                    'options' => [
                        'metadata' => ['id' => $foodProduct->mainImage->id],
                        'type' => 'local',
                    ],
                ],
            ]);
        </script>
    @endif
@endpush

@section('content')
    <div class="content-container">
        <div class="form-container">
            <form class="form" name="food_product_form" id="food_product_form"
                  action="{{ route('products.' . (is_null($foodProduct) ? 'create' : 'update'), compact('foodProduct')) }}"
                  method="POST" enctype="multipart/form-data">
                <h2 class="form-title">
                    @if(isset($foodProduct))
                        {{ $foodProduct->title }}
                    @else
                        Новый продукт
                    @endif
                </h2>

                <div class="input-container">
                    <label class="input-label" for="title">Заголовок</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $foodProduct?->title) }}"
                           placeholder="Название продукта" data-translit-source>
                    <x-error-bag name="title"/>
                </div>

                <div class="input-container has-input-prefix">
                    <label class="input-label" for="slug_title">Транслит</label>
                    <input type="text" name="slug_title" id="slug_title" value="{{ old('slug_title', $foodProduct?->slug_title) }}"
                           placeholder="Транслит" data-input-prefix="/food/" data-translit-target>
                    <x-error-bag name="slug_title"/>
                </div>

                <div class="input-container has-textarea">
                    <label class="input-label" for="text">Текст продукта</label>
                    <button class="button" type="button" onclick="$('#editor_window').closest('.window-container').show()">
                        Открыть редактор
                    </button>
                    <x-error-bag name="text"/>
                </div>

                <div class="input-container has-input-prefix">
                    <label class="input-label" for="description">Краткое описание</label>
                    <input type="text" name="description" id="description"
                           value="{{ old('description', $foodProduct?->description) }}"
                           placeholder="Краткое описание">
                    <x-error-bag name="description"/>
                </div>

                <div class="input-container has-input-prefix">
                    <label class="input-label" for="synonyms">Синонимы</label>
                    <input type="text" name="synonyms" id="synonyms"
                           value="{{ old('synonyms', $foodProduct?->synonyms) }}"
                           placeholder="Синонимы">
                    <x-error-bag name="synonyms"/>
                </div>

                <div class="input-container has-input-prefix">
                    <label class="input-label" for="meta_title">Meta-заголовок</label>
                    <input type="text" name="meta_title" id="meta_title"
                           value="{{ old('meta_title', $foodProduct?->meta_title) }}"
                           placeholder="Meta-title">
                    <x-error-bag name="meta_title"/>
                </div>

                <div class="input-container has-input-prefix">
                    <label class="input-label" for="meta_description">Meta-описание</label>
                    <input type="text" name="meta_description" id="meta_description"
                           value="{{ old('meta_description', $foodProduct?->meta_description) }}"
                           placeholder="Meta-description">
                    <x-error-bag name="meta_description"/>
                </div>


                <div class="input-container">
                    <label class="input-label" for="hashtags">Категории</label>
                    <select name="hashtags[]" id="hashtags" multiple>
                        <option value="" disabled>Выберите категории</option>
                        @foreach($hashtags as $id => $tag)
                            <option value="{{ $tag }}" @selected(in_array($tag, old('hashtags', $foodProduct?->hashtags()->pluck('tag')->toArray() ?? [])))>
                                {{ $tag }}
                            </option>
                        @endforeach
                    </select>
                    <x-error-bag name="hashtags"/>
                </div>

                <div class="input-container has-dropzone">
                    <label class="input-label" for="cover">Обложка</label>
                    <div class="dropzone-container">
                        <div class="filepond" data-filepond-input-name="cover">

                        </div>
                    </div>
                    <x-error-bag name="cover"/>
                </div>

                <button class="button form-button" type="submit">Отправить</button>

                @csrf
            </form>
        </div>

        <div class="window-container">
            <div class="window" id="editor_window">
                <div class="window-title-container">
                    <h2 class="window-title">{{ $foodProduct?->title ?? 'Новый продукт' }}</h2>
                    <button class="window-close-button" type="button"></button>
                </div>

                <div class="editor-container">
                    <textarea class="rich-text-editor" name="text" id="text" form="food_product_form" placeholder="Можно ли морским свинкам огурцы?">
                        {{ trim( old('text', $foodProduct?->text) ) }}
                    </textarea>
                </div>
            </div>
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
            background-color: var(--light-blue);
            border-bottom-left-radius: 1rem;
            border-bottom-right-radius: 1rem;
        }

        .window-container {
            background-color: rgba(50, 50, 50, 0.9);
        }

        #editor_window {
            width: 75vw;
            height: 80vh;
            max-width: 90vw;
            max-height: 80vh;
        }

        .editor-container {
            min-height: 100%;
            height: 100%;
        }
    </style>
@endsection
