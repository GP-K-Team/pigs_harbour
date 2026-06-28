@extends('layouts.main', ['background' => 'texture-light'])

@php
    use App\Models\Article;
    use App\Models\FoodProduct;
    use App\Models\SearchQuery;
    use Illuminate\Contracts\Pagination\LengthAwarePaginator;

    /** @var LengthAwarePaginator|iterable<SearchQuery> $searchQueries */
    /** @var string $type */
@endphp

@section('title', 'Поисковые запросы')

@section('content')
    <div class="search-queries-container">
        <h1 class="search-queries-title">Поисковые запросы</h1>

        <div class="tabs">
            <a href="{{ route('search-queries.index', ['type' => Article::searchType()]) }}">
                <div @class(['tab', 'tab-active' => $type === Article::searchType()])>
                    Статьи
                </div>
            </a>
            <a href="{{ route('search-queries.index', ['type' => FoodProduct::searchType()]) }}">
                <div @class(['tab', 'tab-active' => $type === FoodProduct::searchType()])>
                    Рацион
                </div>
            </a>
        </div>

        @if($searchQueries->isEmpty())
            <h3>Нет запросов</h3>
        @else
            <div class="search-queries-table-wrapper">
                <table class="search-queries-table">
                    <thead>
                        <tr>
                            <th>Запрос</th>
                            <th>Кол-во</th>
                            <th>Успешен</th>
                            <th>Обновлён</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($searchQueries as $searchQuery)
                            <tr @class(['row-failed' => $searchQuery->failed])>
                                <td>{{ $searchQuery->search_text }}</td>
                                <td>{{ $searchQuery->search_count }}</td>
                                <td>{{ $searchQuery->failed ? 'Нет' : 'Да' }}</td>
                                <td>{{ $searchQuery->updated_at->format('d.m.Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($searchQueries->hasPages())
                <div class="pagination-wrapper">
                    <ul class="pagination-list">
                        @if($searchQueries->onFirstPage())
                            <li class="disabled">←</li>
                        @else
                            <a href="{{ $searchQueries->previousPageUrl() }}">
                                <li>←</li>
                            </a>
                        @endif

                        <li class="item-active">
                            {{ $searchQueries->currentPage() }} / {{ $searchQueries->lastPage() }}
                        </li>

                        @if($searchQueries->hasMorePages())
                            <a href="{{ $searchQueries->nextPageUrl() }}">
                                <li>→</li>
                            </a>
                        @else
                            <li class="disabled">→</li>
                        @endif
                    </ul>
                </div>
            @endif
        @endif
    </div>

    <style>
        .search-queries-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem 1rem 40px;
            row-gap: 2rem;
        }

        .search-queries-title {
            font-size: 2.5rem;
            text-align: center;
        }

        h3 {
            font-size: 2rem;
        }

        .tabs {
            display: flex;
            column-gap: 20px;
        }

        .tab {
            padding: 10px 30px;
            border-radius: 10px;
            font-size: 1.5rem;
            cursor: pointer;
            background-color: white;
            box-shadow: 0 4px 4px 0 var(--shadow-drop);
        }

        .tab:hover {
            opacity: 0.7;
        }

        .tab-active {
            color: white;
            background-color: var(--main-pink);
            font-weight: bold;
        }

        .search-queries-table-wrapper {
            width: 90vw;
            max-width: 1080px;
            overflow-x: auto;
            border-radius: 1rem;
            box-shadow: 0 4px 4px 0 var(--shadow-drop);
        }

        .search-queries-table {
            width: 100%;
            min-width: 620px;
            border-collapse: collapse;
            background-color: white;
        }

        .search-queries-table th,
        .search-queries-table td {
            padding: 12px 20px;
            font-size: 1.1rem;
            text-align: left;
            border-bottom: 1px solid var(--light-blue);
        }

        .search-queries-table th {
            background-color: var(--light-blue);
            font-weight: bold;
        }

        .search-queries-table tr:last-child td {
            border-bottom: 0;
        }

        .search-queries-table tr.row-failed td {
            color: var(--holiday-red, #c0392b);
        }

        .pagination-list {
            display: flex;
            column-gap: 20px;
            align-items: center;
        }

        .pagination-list li {
            padding: 10px 20px;
            font-size: 1.25rem;
            cursor: pointer;
            border-radius: 50%;
        }

        .pagination-list li.disabled {
            opacity: 0.4;
            cursor: default;
        }

        .pagination-list .item-active {
            background-color: var(--light-blue);
            border-radius: 10px;
        }

        @media (max-width: 768px) {
            .tabs {
                column-gap: 10px;
            }

            .tab {
                padding: 8px 18px;
                font-size: 1.2rem;
            }

            .search-queries-table th,
            .search-queries-table td {
                padding: 8px 10px;
                font-size: 0.9rem;
            }
        }
    </style>
@endsection
