let KotwSearchsAdmin = {
    authorsPostType : {
        elements: {},
        variables: {},
        events : () => {
            // Disable the original post title input field.
            //document.querySelector( 'input[name=post_title]' ).setAttribute( 'disabled', true );

            // Update the original post title input field on first and/or last name input fields change.
            document.querySelectorAll( 'input.name_field' ).forEach( ( input ) => {
                input.addEventListener( 'keyup', () => {
                    let firstName = document.querySelector( 'input.name_field.first' ).value;
                    let lastName  = document.querySelector( 'input.name_field.last' ).value;

                    document.querySelector( 'input[name=post_title]' ).value = firstName + ' ' + lastName;
                } );
            } );


            // Show selection for user when "Link to existing user is checked".
            let checkBox = document.querySelector( '#KotwSearchs_is_linked_to_user' );
            checkBox.addEventListener( 'click', () => {
                if( true === checkBox.checked ) {
                    document.querySelector( '#select-user-wordpress' ).style.display = 'block';
                } else {
                    document.querySelector( '#select-user-wordpress' ).style.display = 'none';
                }
            } );

            let inputUser    = document.querySelector( 'input[name=KotwSearchs_wordpress_user_id]' );
            let selectUser   = document.querySelector( 'select[name=KotwSearchs_wordpress_user]' );
            let ajaxResultsDiv = document.querySelector( 'div.ajax-results' );

            // Select value of select box.
            selectUser.value = inputUser.value;
            selectUser.addEventListener( 'change', () => {
                inputUser.value = selectUser.value;
            } );



            // Get Ajax results for users.
            inputUser.addEventListener( 'keyup', () => {
                let id = inputUser.value;
                jQuery.post(
                    ajaxurl,
                    {
                        action : 'mazen_get_wordpress_users',
                        id     : id
                    },
                    ( response ) => {
                        console.log( response );
                        ajaxResultsDiv.style.display = "flex";
                        ajaxResultsDiv.innerHTML = response;
                        ajaxResultsDiv.querySelectorAll( 'li' ).forEach( ( li ) => {
                            li.addEventListener( 'click', () => {
                                inputUser.value  = id;
                                selectUser.value = id;
                                ajaxResultsDiv.style.display = 'none';
                            } );
                        } );
                    }
                );
            } );

        },
        functions : {
        },
        init : () => {
            KotwSearchsAdmin.authorsPostType.events();
            console.log( 'mazen authors admin' );
        }
    },
    galleryUploader : {
        settings : {
            uploaderTitle : 'Select or upload image',
            uploaderButton : 'Set image(s)',
            multiple : true,
            modal : false,
        },
        functions : {
        },
        events : () => {
            let plugin = KotwSearchsAdmin.galleryUploader;
            // Click on add image button
            let addImagesBtn = document.querySelector( 'a.add-images' );
            addImagesBtn.addEventListener( 'click', () => {
                let settings = plugin.settings;
                let custom_uploader = wp.media({
                    title: settings.uploaderTitle,
                    button: {
                        text: settings.uploaderButton
                    },
                    multiple: settings.multiple
                })
                    .on('select', function() {
                        let imagesArray          = custom_uploader.state().get('selection').toJSON();
                        let imagesGalleryWrapper = document.querySelector( '.images-gallery' );
                        let imagesListInput      = document.querySelector( 'input[name=KotwSearchs_author_gallery]' );
                        let html    = '';
                        let idArray = [];
                        imagesArray.forEach( ( img ) => {
                            html    += '<img data-id = "' + img.id + '" src = "' + img.url + '"/>';
                            idArray.push( img.id );
                        } );
                        imagesGalleryWrapper.innerHTML = html;
                        imagesListInput.value = idArray.join( ',' );

                        if( settings.modal ) {
                            jQuery('.modal').css( 'overflowY', 'auto');
                        }
                    })
                    .open();
            } );

            // Click on reset image button
            let resetImagesBtn = document.querySelector( 'a.reset-images' );
            resetImagesBtn.addEventListener( 'click', () => {
                let imagesGalleryWrapper = document.querySelector( '.images-gallery' );
                let imagesListInput      = document.querySelector( 'input[name=KotwSearchs_author_gallery]' );

                imagesGalleryWrapper.innerHTML = '';
                imagesListInput.value = '';

            } );



        },
        init : () => {
            KotwSearchsAdmin.galleryUploader.events();
        }
    }

};

window.addEventListener('DOMContentLoaded', (event) => {
    if( 'authors' === KotwSearchsObject.post_type ) {
        KotwSearchsAdmin.authorsPostType.init();
        KotwSearchsAdmin.galleryUploader.init();
    }
});
