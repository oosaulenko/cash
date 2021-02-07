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
    maxDate: '2019-08-30',
})
    .on('selected', (date, date2) => {
        if (date) {
            document.getElementById('filter_transaction_timeFrom').value = date.format('YYYY-MM-DD');
        }
        if (date2) {
            document.getElementById('filter_transaction_timeTo').value = date2.format('YYYY-MM-DD');
        }
    })
    .setDateRange(document.getElementById('filter_transaction_timeFrom').value, document.getElementById('filter_transaction_timeTo').value)
;


var filterTransactionPriceRangeInput = document.getElementById('filter_transaction_priceRange');
var filterTransactionAmountTo = document.getElementById('filter_transaction_amountTo');
var filterTransactionAmountFrom = document.getElementById('filter_transaction_amountFrom');

noUiSlider.create(filterTransactionPriceRangeInput, {
    start: [filterTransactionAmountFrom.value, filterTransactionAmountTo.value],
    connect: true,
    range: {
        'min': -10000,
        'max': 10000
    }
})
    .on('update', function (values, handle) {
        var value = values[handle];

        if (handle) {
            filterTransactionAmountTo.value = value;
        } else {
            filterTransactionAmountFrom.value = value;
        }
    })
;

filterTransactionAmountFrom.addEventListener('change', function () {
    filterTransactionPriceRangeInput.noUiSlider.set([this.value, null]);
});

filterTransactionAmountTo.addEventListener('change', function () {
    filterTransactionPriceRangeInput.noUiSlider.set([null, this.value]);
});