

// var filterDateFromTo = new Lightpick({
//     field: document.getElementById('filter_transaction_dateFrom'),
//     secondField: document.getElementById('filter_transaction_dateTo'),
//     singleDate: false,
//     onSelect: function(start, end){
//         var str = '';
//         str += start ? start.format('Do MMMM YYYY') + ' to ' : '';
//         str += end ? end.format('Do MMMM YYYY') : '...';
//     }
// });

new Litepicker({
    element: document.getElementById('filter_transaction_dateFrom'),
    elementEnd: document.getElementById('filter_transaction_dateTo'),
    singleMode: false,
    allowRepick: true,
    format: 'DD MMM YYYY',
    lang: 'ru-RU',
    tooltipText: {"one":"день", "few":"дня", "many":"дней"}
})