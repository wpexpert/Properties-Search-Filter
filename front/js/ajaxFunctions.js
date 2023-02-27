let currentDatatable;
let kotwAjaxFunctions = {

	functions: {
		getPostsJson : ( tableID, postsArgs, userID ) => {
			document.querySelector( '.lds-dual-ring' ).style.display = 'flex';
			let ajaxurl = KotwSearchsObject.ajaxurl;
			postsArgs = JSON.parse( postsArgs );
			let data = {
				action: 'kotw_get_posts_json_array',
				postsArgs : postsArgs,
				userID: userID
			};
			jQuery.post(
				ajaxurl,
				data,
				function ( response ) {
					console.log(data);
					//let postsArray = JSON.parse( response );
					//kotwAjaxFunctions.functions.getPostsRows( postsArray, tableID );
					//searchEvents.init();
                   document.querySelector(".search-footer #filter").click();
					console.clear();

				}
			);
		},

		getPostsRows : ( postsArray, tableID ) => {
			let table = document.querySelector( '#' + tableID );
			table.querySelector( 'tbody' ).innerHTML = '';
			postsArray.forEach( (row) => {
				let rowHtml = '<tr data-post-id = "' + row.post_id +'">' +
				              '<td class="post-title">' + row.post_title + '</td>'+
				              '<td class="date" data-order="'+kotwAjaxFunctions.functions.getOriginalDate(row.date)+'" data-date-formatted="'+row.date+'">' + row.date + '</td>'+
				              '<td class="deadline">' + row.deadline + '</td>'+
				              '<td class="favorite">' + row.favorite + '</td>'+
				              '</tr>';
				table.querySelector( 'tbody' ).innerHTML += rowHtml;
			} );

			jQuery.fn.dataTable.moment( 'MMMM dd, yyyy' );
			//jQuery.fn.dataTable.moment( 'MM/dd/yyyy' );
			if ( jQuery.fn.dataTable.isDataTable( '#' + tableID ) ) {
				currentDatatable.destroy();
				currentDatatable = jQuery( '#' + tableID ).DataTable(
					{
						"lengthMenu": [[50, 25, 100, 250,500, -1], [50, 25, 100, 250,1000, "All"]]
					}
				);
			}
			else {
				currentDatatable = jQuery( '#' + tableID ).DataTable(
					{
						"lengthMenu": [[50, 25, 100, 250,500, -1], [50, 25, 100, 250,500, "All"]]
					}
				);
			}



			document.querySelector( '.lds-dual-ring' ).style.display = 'none';
		},
		getOriginalDate : (formattedDate) => {
			let date = new Date (formattedDate);
			let fn = kotwAjaxFunctions.functions;
			return fn.addPrecedingZero(date.getMonth()+1) + '/' + fn.addPrecedingZero(date.getDate()) + '/' + date.getFullYear();
		},
		addPrecedingZero : (n) => {
			return (n < 10) ? ("0" + n) : n;
		}
	}
};