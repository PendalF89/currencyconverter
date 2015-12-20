jQuery(document).ready(function($){
    if(typeof currencyConverterColorSchemesSelectors !== 'undefined' ) {
        var selectorsAsString = currencyConverterColorSchemesSelectors.join();
        $(selectorsAsString).click(function(event){
            // TODO: Надо будет попытаться вынести кучу скриптов из класса с виджетов в отдельные файлы
        });
    }
});
