@extends('layouts.main', ['background' => 'texture-light'])

@php
    use App\Enum\Fur;
    use App\Enum\Sex;
    use App\Models\Article;
    use App\Models\Hashtag;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\Vite;

    /**
     * @var ?Article $article
     * @var Collection|iterable<Hashtag> $hashtags
     */
    $article ??= null;
@endphp

@section('title')
    {{ isset($article) ? $article->title : 'Новая статья' }}
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/form.css') }}">
@endpush

@push('js')
    <script type="module" src="{{ Vite::asset('resources/js/select-input.js') }}"></script>
    <script type="module" src="{{ Vite::asset('resources/js/filepond.js') }}"></script>
    <script type="module" src="{{ Vite::asset('resources/js/page/translit.js') }}"></script>

    @if($article)
        <script type="module">
            window.preloadedFiles = @js([
                [
                    'source' => asset('/storage/' . $article->mainImage->link),
                    'options' => [
                        'metadata' => ['id' => $article->mainImage->id],
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
            <form class="form"
                  action="{{ route('blog.' . (is_null($article) ? 'create' : 'update'), compact('article')) }}"
                  method="POST" enctype="multipart/form-data">
                <h2 class="form-title">
                    @if(isset($article))
                        {{ $article->title }}
                    @else
                        Новая статья
                    @endif
                </h2>

                <div class="input-container">
                    <label class="input-label" for="title">Заголовок</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $article?->title) }}"
                           placeholder="Заголовок статьи" data-translit-source>
                    <x-error-bag name="title"/>
                </div>

                <div class="input-container has-input-prefix">
                    <label class="input-label" for="slug_title">Транслит</label>
                    <input type="text" name="slug_title" id="slug_title" value="{{ old('slug_title', $article?->slug_title) }}"
                           placeholder="Транслит" data-input-prefix="/blog/" data-translit-target>
                    <x-error-bag name="slug_title"/>
                </div>

                <div class="input-container has-textarea">
                    <label class="input-label" for="text">Текст статьи</label>
                    <textarea name="text" id="text"
                              placeholder="Текст статьи">{{ trim( old('text', $article?->text) ) }}</textarea>
                    <x-error-bag name="text"/>
                </div>

                <div class="input-container has-input-prefix">
                    <label class="input-label" for="description">Краткое описание</label>
                    <input type="text" name="description" id="description"
                           value="{{ old('description', $article?->description) }}"
                           placeholder="Краткое описание">
                    <x-error-bag name="description"/>
                </div>

                <div class="input-container has-input-prefix">
                    <label class="input-label" for="origin_link">Ссылка на источник</label>
                    <input type="text" name="origin_link" id="origin_link"
                           value="{{ old('origin_link', $article?->origin_link) }}"
                           placeholder="Краткое описание">
                    <x-error-bag name="origin_link"/>
                </div>

                <div class="input-container has-input-prefix">
                    <label class="input-label" for="meta_title">Meta-заголовок</label>
                    <input type="text" name="meta_title" id="meta_title"
                           value="{{ old('meta_title', $article?->meta_title) }}"
                           placeholder="Meta-title">
                    <x-error-bag name="meta_title"/>
                </div>

                <div class="input-container has-input-prefix">
                    <label class="input-label" for="meta_description">Meta-описание</label>
                    <input type="text" name="meta_description" id="meta_description"
                           value="{{ old('meta_description', $article?->meta_description) }}"
                           placeholder="Meta-description">
                    <x-error-bag name="meta_description"/>
                </div>

                <div class="input-container has-select">
                    <label class="input-label" for="hashtags">Категории</label>
                    <select name="hashtags" id="hashtags" multiple>
                        <option value="" disabled>Выберите категории</option>
                        @foreach($hashtags as $id => $tag)
                            <option value="{{ $id }}">
                                {{ $tag }}
                            </option>
                        @endforeach
                    </select>
                    <x-error-bag name="hashtags"/>
                </div>

                {{--                <div class="input-container has-select">--}}
                {{--                    <label class="input-label" for="companion">Отдаётся вместе</label>--}}
                {{--                    <select name="companion" id="companion" data-search="true">--}}
                {{--                        <option value="" @selected(empty($pig) && empty($pig->companion_pig_id))>Без напарника</option>--}}
                {{--                        @foreach($companionCandidates as $candidate)--}}
                {{--                            <option--}}
                {{--                                value="{{ $candidate->id }}" @selected(isset($pig) && ($pig->companion || $pig->companionOf) && ($pig->companion?->id ?? $pig->companionOf->id) === $candidate->id)>--}}
                {{--                                {{ $candidate->name }}--}}
                {{--                            </option>--}}
                {{--                        @endforeach--}}
                {{--                    </select>--}}
                {{--                    <x-error-bag name="companion"/>--}}
                {{--                </div>--}}

                <div class="input-container has-dropzone">
                    <label class="input-label" for="cover">Обложка</label>
                    <div class="dropzone-container">
                        <div class="filepond" data-filepond-input-name="cover">

                        </div>
                    </div>
                    <x-error-bag name="cover"/>
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
    </style>
@endsection
