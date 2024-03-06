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
	
	
	// var containerEl = document.querySelector('.product-list-container');
	var containerEl = document.querySelector('#safe-products');
	var mixer = mixitup(containerEl, {
		load: {
			sort: 'price:desc'
		},
		selectors: {
			target: '.mix',
			control: '[data-mixitup-control]'
		},
		callbacks: {
			onMixClick: function (state, originalEvent) {
				// console.table("originalEvent", originalEvent);
				let dataSort = originalEvent.srcElement.attributes[2].nodeValue;
				let dataSortClean = dataSort.substr(0, dataSort.indexOf(':'));

				if (dataSortClean.length > 0) {
					update_active_sort_badge(dataSortClean);
				}
				const targetClasses = Object.values(originalEvent.target.classList);

				// Update sort text
				let currentSortText = originalEvent.srcElement.text;
				$('#sort-filter-nav li.nav-item.dropdown a.dropdown-toggle').text('Sort By: ' + currentSortText);

				if (Object.values(targetClasses).indexOf('filter-link') > -1) {
					$('#sort-filter-nav li.nav-item').not('.dropdown').each(function () {
						$(this).removeClass('active-filter');
					});
					$(this).closest('li.nav-item').not('.dropdown').addClass('active-filter');
				   	
				} 
				if (Object.values(targetClasses).indexOf('dropdown-item') > -1) {
					// console.log("targetClasses", targetClasses);
					$('li.dropdown .dropdown-menu a.dropdown-item').each(function () {
						$(this).removeClass('active-filter');
					});
					$(this).addClass('active-filter');
				}

				// Filters
				// if (originalEvent.srcElement.hasClass('filter-link')) {
				// 	$('#sort-filter-nav li.nav-item').not('.dropdown').each(function() {
				// 		$(this).removeClass('active-filter');
				// 	});
				// 	$(this).closest('li.nav-item').addClass('active-filter');
				// }
				
				
				// Sorts
				$('.product-details-list li span.badge').each(function () {
					$(this).closest('li')
						.removeClass('current-sort');
					
					if (dataSortClean && $(this).hasClass(dataSortClean)) {
						$(this).closest('li')
							.addClass('current-sort');
					}
					
				});
			}
		}
	});
	
	
	
	// $('.sort-select').on('change', function(){
	// 	let selected = $(this).val()
	// 	mixer.filter('.' + selected);
	// });

	// var mixer = mixitup('.products');

	// var mixer = mixitup(containerEl, {
	// 	"animation": {
	// 		"duration": 0,
	// 		"nudge": false,
	// 		"reverseOut": false,
	// 		"effects": ""
	// 	}
	// });

})(jQuery);