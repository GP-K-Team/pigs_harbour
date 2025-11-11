import Zebra_DatePicker from 'zebra_datepicker';
import 'zebra_datepicker/dist/css/default/zebra_datepicker.min.css';
import '/resources/css/zebra.css';

window.Zebra_DatePicker = Zebra_DatePicker;

$('input.datepick').Zebra_DatePicker({
    default_position: 'icon_top_left',
    direction: -1,
    format: 'd M Y',
    lang_clear_date: 'Очистить',
    first_day_of_week: 0,
    weekend_days: [5, 6],
    days_abbr: ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'],
    months: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
    select_other_months: true,
    view: 'months',
    show_select_today: 'Сегодня',
    onSelect() {
        this.blur();
    },
});
