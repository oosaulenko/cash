import moment from "moment";
import noUiSlider from 'nouislider';

new Litepicker({
    element: document.getElementById('filter_transaction_dateFrom'),
    elementEnd: document.getElementById('filter_transaction_dateTo'),
    singleMode: false,
    allowRepick: true,
    format: 'DD MMM YYYY',
    lang: 'ru-RU',
    tooltipText: {
        "one": "день",
        "few": "дня",
        "many": "дней"
    },
    minDate: '2015-01-01',
    maxDate: '2019-06-30',
})
    .on('selected', (date, date2) => {
        document.getElementById('filter_transaction_timeFrom').value = date.format('YYYY-MM-DD');
        document.getElementById('filter_transaction_timeTo').value = date2.format('YYYY-MM-DD');
        console.log(date.format('YYYY-MM-DD'));
        console.log(date2.format('YYYY-MM-DD'));
    })
    .setDateRange(document.getElementById('filter_transaction_timeFrom').value, document.getElementById('filter_transaction_timeTo').value)
;



var filterTransactionPriceRangeInput = document.getElementById('filter_transaction_priceRange');
noUiSlider.create(filterTransactionPriceRangeInput, {
    start: [20, 80],
    connect: true,
    range: {
        'min': 0,
        'max': 100
    }
})
    .on('start', function () {
        //
    })
;