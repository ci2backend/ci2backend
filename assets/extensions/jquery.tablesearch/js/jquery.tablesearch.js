/**
 **options to have following keys:
 **searchText: this should hold the value of search text
 **searchPlaceHolder: this should hold the value of search input box placeholder
 **/
(function($) {
    $.fn.tableSearch = function(options) {
        if (!$(this).is('table')) {
            return;
        }
        var tableObj = $(this),
            searchText = (options.searchText) ? options.searchText : 'Search: ',
            searchPlaceHolder = (options.searchPlaceHolder) ? options.searchPlaceHolder : '',
            divObj = (options.divObj) ? $(options.divObj).append(searchText) : $('<div style="float:right;">' + searchText + '</div>'),
            inputClass = (options.inputClass) ? options.inputClass : '',
            inputObj = $('<input type="text" placeholder="' + searchPlaceHolder + '" class="' + inputClass + '" />'),
            caseSensitive = (options.caseSensitive === true) ? true : false,
            searchFieldVal = '',
            pattern = '';
        inputObj.off('keyup').on('keyup', function() {
            searchFieldVal = $(this).val();
            pattern = (caseSensitive) ? RegExp(searchFieldVal) : RegExp(searchFieldVal, 'i');
            tableObj.find('tbody tr').hide().each(function() {
                var currentRow = $(this);
                currentRow.find('td').each(function() {
                    if (pattern.test($(this).html())) {
                        currentRow.show();
                        return false;
                    }
                });
            });
        });
        if (typeof options.container != "undefined" && $(options.container)) {
        	$(options.container).append(divObj.append(inputObj));
        }
        else {
        	tableObj.before(divObj.append(inputObj));
        }
        return tableObj;
    }
}(jQuery));
