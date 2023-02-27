let ajaxurl = KotwSearchsObject.ajaxurl;

let loader = {
	element: document.querySelector( '.lds-dual-ring' ),
	show: () => {
		loader.element.style.display = 'flex';
	},
	hide: () => {
		loader.element.style.display = 'none';
	}
};

let userID = document.querySelector( 'input[name=user_id]' ).value;
let filterButton = document.querySelector( 'a#filter' );
let filterForm = document.querySelector( '#date-range form' );
let city_of_project = document.querySelector( '#city_of_project' );

/**
 * FUNCTIONS
 * @type {{favorites : searchEvents.favorites, reset : searchEvents.reset, showPostsPerPage : searchEvents.showPostsPerPage}}
 */
let searchEvents = {
	favorites: () => {

		// Non favorite this.
		document.querySelectorAll( 'a.favorite-this i.non-favorite' ).forEach( ( a ) => {

			a.addEventListener( 'click', function () {
				let postID = a.parentElement.getAttribute( 'post-id' );
				let userID = a.parentElement.getAttribute( 'user-id' );
				loader.show();
				console.log( 'favorite this' );
				jQuery.post(
					ajaxurl,
					{
						action: 'add_to_favorites',
						postID: postID,
						userID: userID
					},
					function ( response ) {
						console.log( response );
						loader.hide();
						a.classList.add( 'favorite' );
						if ( a.classList.contains( 'non-favorite' ) ) {
							a.classList.remove( 'non-favorite' );
						}
					}
				);
			} );
		} );

		// favorite this.
		document.querySelectorAll( 'a.favorite-this i.favorite' ).forEach( ( a ) => {

			a.addEventListener( 'click', function () {
				let postID = a.parentElement.getAttribute( 'post-id' );
				let userID = a.parentElement.getAttribute( 'user-id' );
				loader.show();
				jQuery.post(
					ajaxurl,
					{
						action: 'remove_from_favorites',
						postID: postID,
						userID: userID
					},
					function ( response ) {
						loader.hide();
						console.log( response );
						a.classList.add( 'non-favorite' );
						if ( a.classList.contains( 'favorite' ) ) {
							a.classList.remove( 'favorite' );
						}
					}
				);
			} );
		} );
	},
	showPostsPerPage: () => {
		// Show posts per page.
		document.querySelector( 'select[name=results-table_length]' ).addEventListener( 'change', function () {
			let perPage = document.querySelector( 'select[name=results-table_length]' ).value;
			//let perPage = 3000;
			loader.show();
			jQuery.post(
				ajaxurl,
				{
					action: 'kotw_get_posts_per_page',
					perPage: perPage
				},
				function ( response ) {
					loader.hide();
					//console.log( response );
					document.querySelector( '#results-wrapper tbody' ).innerHTML = response;
					searchEvents.init();
				}
			);
		} );
	},
	reset: () => {
		//let perPage = document.querySelector( 'select[name=results-table_length]' ).value;
		let perPage = 30;
		loader.show();
		jQuery.post(
			ajaxurl,
			{
				action: 'kotw_get_posts_per_page',
				perPage: perPage
			},
			function ( response ) {
				loader.hide();
				//console.log( response );
				document.querySelector( '#results-wrapper tbody' ).innerHTML = response;
				searchEvents.init();
			}
		);
	},
	applyFilter: () => {
	//	let perPage = document.querySelector( 'select[name=results-table_length]' ).value;
		let perPage = 5
		let checkbox = [];
		filterForm.querySelectorAll( 'input.csi_division' ).forEach( ( input ) => {
			if ( input.checked ) {
				checkbox.push( input.id );
			}
		} );
		
		loader.show();
		postings = document.getElementById("active_checkbox");
		if(postings.checked ==true)
		{
			activePosts = 'true';
		}
		else{
			activePosts = 'false';
		}
		console.log(checkbox);
		jQuery.post(
			ajaxurl,
			{
				action: 'kotw_get_posts_per_page_filtererd',
				perPage: perPage,
				from_date: filterForm.querySelector( '#from_date' ).value,
				to_date: filterForm.querySelector( '#to_date' ).value,
				city: filterForm.querySelector( '#city_of_project' ).value,
			//	csi_division: JSON.stringify( checkbox ),
				csi_division:  checkbox,
				search_input : document.querySelector("#search_input").value,
				active_postings : activePosts
			},
			function ( response ) {
				loader.hide();
				document.querySelector( '#results-wrapper tbody' ).innerHTML = response;
				searchEvents.init();
			}
		);
	},
	showMore: () => {

		document.querySelector( 'a#show-more' ).addEventListener( 'click', () => {
			let currentSelectValue = document.querySelector( 'select[name=results-table_length]' ).value;
			switch ( currentSelectValue ) {
				case '25' :
					document.querySelector( 'select[name=results-table_length]' ).value = '50';
					break;
				case '50' :
					document.querySelector( 'select[name=results-table_length]' ).value = '100';
					break;
				case '100' :
					document.querySelector( 'select[name=results-table_length]' ).value = '250';
					break;
				case '250' :
					document.querySelector( 'select[name=results-table_length]' ).value = '250';
					break;
				default:
					document.querySelector( 'select[name=results-table_length]' ).value = '250';
					break;
			}
			let perPage = document.querySelector( 'select[name=results-table_length]' ).value;
			//let perPage = 3000;
			loader.show();
			jQuery.post(
				ajaxurl,
				{
					action: 'kotw_get_posts_per_page',
					perPage: perPage
				},
				function ( response ) {
					loader.hide();
					//console.log( response );
					document.querySelector( '#results-wrapper tbody' ).innerHTML = response;
					searchEvents.init();
				}
			);

		} );
	},
	keyBoardEvents: () => {
		window.addEventListener( 'keydown', ( event ) => {
			if ( event.key === 'Enter' ) {
				console.log( 'enter is pressed' );
				searchEvents.applyFilter();
			}
		} );
	},
	
	init: () => {
		searchEvents.favorites();
		searchEvents.keyBoardEvents();
	//	searchEvents.onchangeDetection();
	}
};

//	document.querySelector("#city_of_project").addEventListener("change", searchEvents.applyFilter() ,false);


/**
 * EVENTS
 *
 * */
// Init.
searchEvents.init();


// Filteration functions.
filterButton.addEventListener( 'click', function () {
	
	searchEvents.applyFilter();
} ,false);

// Filteration functions.
city_of_project.addEventListener( 'change', function () {
	searchEvents.applyFilter();
} ,false);



// Search input.
let searchInput = document.querySelector( 'input#search_input' );
searchInput.addEventListener( 'keyup', function () {
	let value = searchInput.value;
	//currentDatatable.search( jQuery(this).val() ).draw();
    searchEvents.applyFilter();
} );

// Reset
document.querySelector( 'a#reset' ).addEventListener( 'click', function () {
	searchEvents.reset();
} );