var $input = $('.field-mcc, .field-keywords').tagify({
    outputDelimiter: ', ',
    originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join(', ')
}).on('add', function (e, tagName) {

}).on("invalid", function (e, tagName) {
    console.log('JQEURY EVENT: ', "invalid", e, ' ', tagName);
});
var jqTagify = $input.data('tagify');