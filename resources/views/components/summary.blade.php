@php
    use App\Models\Pig;
    use App\Models\City;
    use Illuminate\Support\Collection;

    /** @var Collection|iterable<Pig> $pigs */
    /** @var Collection|iterable<City> $cities */
@endphp

<div class="summary_wrapper">
    <ul class="summary_list">
        <li>
            <div class="summary_block">
                <p class="summary_number">
                    {{ $cities->count() }}
                </p>
                <p>
                    {{ trans_choice('город|города|городов', $cities->count()) }}
                </p>
            </div>
        </li>
        <li>
            <div class="summary_block">
                <p class="summary_number">
                    15+
                </p>
                <p>
                    волонтеров
                </p>
            </div>
        </li>
        <li>
            <div class="summary_block">
                <p class="summary_number">
                    {{ $pigs->count() > 50 ? $pigs->count() : '50' }}+
                </p>
                <p>
                    счастливых свинок
                </p>
            </div>
        </li>
    </ul>
</div>

<style>
    .summary_wrapper {
        padding: 20px 40px;
        border-top: 10px solid var(--pale_orange);
        background-image: url("/images/bright_dark.png");
        background-size: contain;
    }

    .summary_list {
        margin: auto;
        width: 50%;
        display: flex;
        row-gap: 20px;
        column-gap: 20px;
        justify-content: space-between;

        @media (max-width: 1000px) {
            width: 80%;
        }

        @media (max-width: 768px) {
            width: 100%;
            flex-direction: column;
        }
    }

    .summary_block {
        display: flex;
        flex-direction: column;
        row-gap: 5px;
        justify-content: center;
        align-items: center;
        font-size: 15px;
    }

    .summary_block p {
        margin: 0;
    }

    .summary_number {
        font-family: '315karusel', sans-serif;
        font-size: 30px;
        color: var(--main_pink);
        font-weight: bold;
    }
</style>
