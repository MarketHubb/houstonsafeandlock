/* jQuery (Footer) */
(function ($) {

	function update_active_sort_badge(dataSortClean) {
		$('#sort-badges span').each(function () {
			$(this).addClass('d-none');
			
			if ($(this).hasClass(dataSortClean)) {
				$(this).removeClass('d-none');
			}
		});
	}

	function update_active_sort_class(order) {
		$('.grid-sort-order').each(function () {
			$(this).removeClass('active-sort-order');
		});

		let sortOrderItem = $('.grid-sort-order[data-type="' + order + '"]');

		if (sortOrderItem.length == 1) {
			sortOrderItem.addClass('active-sort-order');
		}
	}
	var containerEl = $('#safe-products');
	var defaultSort = "price:desc";
	var mixer = mixitup(containerEl, {
		load: {
			sort: defaultSort
		},
		selectors: {
			target: '.mix',
			control: '[data-mixitup-control]'
		},
		callbacks: {
			onMixClick: function (state, originalEvent) {
				let dataSort = originalEvent.srcElement.attributes[2].nodeValue;
				let dataSortClean = dataSort.substr(0, dataSort.indexOf(':'));

				if (dataSortClean.length > 0) {
					update_active_sort_badge(dataSortClean);
				}
				const targetClasses = Object.values(originalEvent.target.classList);

				// Update sort text
				let currentSortText = originalEvent.srcElement.text;
				let selectedSortText = originalEvent.srcElement.innerHTML
				let sortHtml = '<span class="text-secondary">Sort by: </span><span>' + selectedSortText + '</span></span>';
				// $('#sort-filter-nav li.nav-item.dropdown a.dropdown-toggle').text(currentSortText);
				$('#sort-filter-nav li.nav-item.dropdown a.dropdown-toggle').html(sortHtml);
				
				// Sorts
				$('.product-details-list li span.badge').each(function () {
					$(this).closest('li')
						.removeClass('current-sort');
					
					if (dataSortClean && $(this).hasClass(dataSortClean)) {
						$(this).closest('li')
							.addClass('current-sort');
					}
				});

				update_active_sort_class('desc');
			}
		}
	});

	$('.grid-sort-order').on('click', function () {
		let currentState = mixer.getState();
		let sortOrder = $(this).attr('data-type');
		let currentSortType = currentState.activeSort.attribute;

		update_active_sort_class(sortOrder);

		let newSort = currentSortType + ':' + sortOrder;
		mixer.sort(newSort);
	});

})( jQuery );