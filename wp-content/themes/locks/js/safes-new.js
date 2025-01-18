(function ($) {

    var offsetSet = false;

    function set_sort_filter_sticky_offset() {
        if ($(window).width() <= 768) {
            let headerHeight = $('#masthead').height();
        } else {
            $('body').on('scroll', function() {
                let header = $('masthead');
                if (header.hasClass('is-scrolling')) {
                    let headerHeight = header.height();
                }
            });
        }

        if (headerHeight && headerHeight.length > 0) {
            offsetSet = true;
            console.table("headerHeight", headerHeight);
        }
    }

$(window).load(function () {
    $('#safe-grid-container').scroll(function() {
        let test = "test";
        console.table("test", test);
        console.table("offsetSet", offsetSet);
        if (!offsetSet) {
            
            set_sort_filter_sticky_offset();
        }
    });
});

    // region ## Global vars ##

    const reset = $('input[value="reset"]');
    var test = "1";

    function add_badges_to_safes(activeFilters) {
        if (activeFilters.length > 0) {
            let i = 0;

            while (i < activeFilters.length) {
                let filterType = activeFilters[i].split("--")[0];
                let filterContainer = $('#safe-filters .' + filterType);
                
                if (filterContainer.length === 1) {
                    let badgeIcon = decodeURIComponent(filterContainer.data('icon'));

                    if (badgeIcon.length > 0) {
                        let badgeSpan = '<span class="tw-badge"><img src="' + badgeIcon
                    }
                }

                i++;
            }
        }
    }

    // region ## Functions: Remove empty filters ##

    function remove_filter(availableFilters, filterContainer = null) {
        filterContainer = (filterContainer) || '#safe-filters';

        $(filterContainer + ' .form-check input:checkbox').each(function () {
            if ($(this).val() != 'reset' && !availableFilters.includes($(this).val())) {
                $(this).closest('.form-check').remove();
            }
        });

    }

    function remove_empty_safe_filters() {
        let allSafeFilterClasses = [];
        
        $('#safe-products .mix').each(function () {
            let safeClassNamesArray = safe_filter_class_names.call(this);

            for (let i = 0; i < safeClassNamesArray.length; i++) {
                if (!allSafeFilterClasses.includes(safeClassNamesArray[i])) {
                    allSafeFilterClasses.push(safeClassNamesArray[i]);
                }
            }
        });

        remove_filter(allSafeFilterClasses);
    }

    // endregion

    // region Update & reset filters
    function reset_all_filters(filterContainer) {
        filterContainer = (filterContainer) || '#safe-filters';
        console.table("filterContainer", filterContainer);

        $(filterContainer + ' .form-check input:checkbox').each(function () {
            $(this)
                .attr('disabled', false)
                .prop('checked', false);
        });

        $('#safe-products .mix').each(function () { 
            $(this).removeClass('d-none');
        });
    }

    function update_available_filters(remainingFilters, filterContainer) {
        filterContainer = (filterContainer) || '#safe-filters';

        $(filterContainer + ' .form-check input:checkbox').each(function () {
            if ($(this).val() != 'reset') {
                let availableFilter = remainingFilters.includes($(this).val());
                $(this).attr('disabled', !availableFilter);
            }
        });

    }

    // region Helper functions
    function safe_filter_class_names() {
        var classesArray = $(this).attr('class').split(/\s+/);

        var filteredClasses = classesArray.filter(function (className) {
            return className.includes('--');
        });

        return filteredClasses;
    }

    function check_safe_class_names_against_active_filters(activeFiltersArray, safeClassNamesArray) {
        return activeFiltersArray.every(filter => safeClassNamesArray.includes(filter));
    }
    // endregion 

    function removeDoubleDashAndAfter(arr) {
        return arr.map(item => {
            const index = item.indexOf('--');
            if (index !== -1) {
                return item.slice(0, index);
            }
            return item;
        });
    }

    function update_active_filter_badges(activeFiltersArray) {
        activeFiltersArray = removeDoubleDashAndAfter(activeFiltersArray);
        $('.badge-filter').addClass('d-none');

        let i = 1;
        for (const filterName of activeFiltersArray) {
            console.table("i", i);
            console.table("filterName", filterName);
            let filerBadge = $('.filter-badges').find('.' + filterName);
            filerBadge.removeClass('d-none');
            i++;
        }

        // $('#sort-badges span').each(function () {
        //     $(this).addClass('d-none');
            
        //     if ($(this).hasClass(dataSortClean)) {
        //         $(this).removeClass('d-none');
        //     }
        // });
    }

    function apply_filters_to_grid(activeFiltersArray, filterContainer) {

        if (activeFiltersArray.length === 0) {
            reset_all_filters();
        }

        let remainingFilters = [];
        
        $('#safe-products .mix').each(function () {
            $(this).removeClass('d-none');

            let safeClassNamesArray = safe_filter_class_names.call(this);
            let safeClassesMatchFilters = check_safe_class_names_against_active_filters(activeFiltersArray, safeClassNamesArray);
            
            if (!safeClassesMatchFilters) {
                $(this).addClass('d-none');
            } else {
                for (const className of safeClassNamesArray) {
                    if (!remainingFilters.includes(className)) {
                        remainingFilters.push(className);
                    }
                }
            }

        });

        update_active_filter_badges(activeFiltersArray);

        if (remainingFilters.length > 0) {
            update_available_filters(remainingFilters, filterContainer);
        }

        return remainingFilters;
    }

    function filter_reset() {
        $('#safe-filters div.form-check input:checkbox').each(function () {
            if ($(this) !== reset) {
                $(this).prop('checked', false);    
            }
            reset.prop('checked', true);
        });
    }
    
    function active_filters(filterContainer = null) {
        filterContainer = (filterContainer) || '#safe-filters';

        if (reset.is(':checked')) {
            filter_reset();
        } else {
            let activeClassList = '';
            let activeFilters = [];

            $(filterContainer + ' div.form-check input:checked').each(function () {
                activeFilters.push($(this).val());
                let separator = (activeClassList.length === 0) ? '' : ',';
                activeClassList += separator + '.' + $(this).val();
            });

            apply_filters_to_grid(activeFilters, filterContainer);
        }
    }

    // region ## Events ##

    // Filter
    $('#safe-filters .form-check input:checkbox').change(function () {
        if ($(this).val() === 'reset') {
            reset_all_filters();
        } else {
            active_filters();
        }
    });

    $('#modal-safe-filters .form-check input:checkbox').change(function () {
        if ($(this).val() === 'reset') {
            reset_all_filters();
        } else {
            let filterContainer = '#modal-safe-filters';
            active_filters(filterContainer);
        }
    });

    // Filter (mobile) 
    $('#modal-apply').on('click', function () {
        let filterContainer = '#modal-safe-filters';
        active_filters(filterContainer);
    });

    // endregion

    // region ## Instantiation ##

    // Default sort
    $('.nav-link.dropdown-toggle.filter-sort-type').text('Sort by: Price');
    $('#sort-badges span').each(function () {
        if ($(this).hasClass('price')) {
            $(this).removeClass('d-none');
        }
    });
    
    // Remove empty filters
    remove_empty_safe_filters();

    // endregion

    // region Mobile
    if ($(window).width() <= 768) {
        let filterContainer = $('#filters');
        let filterModalBody = $('body #modal-safe-filters .modal-body');

        filterModalBody.html(filterContainer);

        $('#modal-reset').on('click', function () {
            reset_all_filters('#modal-safe-filters');
            
        });
    }


    
})(jQuery);