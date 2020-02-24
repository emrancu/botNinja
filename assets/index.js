
(function($) {

    let url = window.location.href;
    let currentURL = 'admin.php'+url.split('admin.php')[1] ;

    let currentNAV = $('ul#adminmenu li.toplevel_page_BotNinja a[href="' + currentURL + '"]');

    $(currentNAV).closest('li').addClass('current')
    $('ul#adminmenu li.toplevel_page_BotNinja li').click(function(){
        $("ul#adminmenu li.toplevel_page_BotNinja li").removeClass('current') ;
        $(this).addClass('current')
    })

})( jQuery );

function getRequest(url, loading = false, rootUrl = false, csrf = false) {
    return new Promise((resolve, reject) => {
        if (loading) {
            store.state.dataLoading = true;
            var loader= webToast.loading({
                status:'Loading...',
                message:'Please Wait a moment',
                line: true
            });
        }

        let baseURL = '' ;
        if(rootUrl){
              baseURL = secureAjaxData.root + 'botNinja/v1/' ;
        }

        let options = {
            method: 'get',
        };

        if(csrf){
            options.headers = new Headers({'X-WP-Nonce': secureAjaxData.security})
        }

        fetch(baseURL+url, options).then(function (response) {
            if (loading) {
                store.state.dataLoading = false;
                loader.fadeOut().remove()
            }

            if (response.status === 200) {

                resolve(response.json());

            } else {

                resolve(false);

            }

        });
    });
}

function postRequestOutside(url, loading = false) {
    return new Promise((resolve, reject) => {
        if (loading) {
            store.state.dataLoading = true
            var loader= webToast.loading({
                status:'Loading...',
                message:'Please Wait a moment',
                line: true
            });
        }
        const options = {
           // headers: new Headers({'X-WP-Nonce': secureAjaxData.security}),
            method: 'post',

        };

        fetch(  url, options)
            .then((response) => {

                if (response.status === 200) {
                    resolve(response.json());
                } else {
                    resolve(false);
                }

                if (loading) {
                    store.state.dataLoading = false;
                    loader.fadeOut().remove()
                }

            });

    });
}

function postRequest(url, data, loading = false) {
    return new Promise((resolve, reject) => {
        if (loading) {
            store.state.dataLoading = true;
            var loader= webToast.loading({
                status:'Loading...',
                message:'Please Wait a moment',
                line: true
            });
        }
        const options = {
            headers: {
                'X-WP-Nonce': secureAjaxData.security,
            },
            method: 'post',
            body: JSON.stringify(data)
        };

        fetch(secureAjaxData.root + 'botNinja/v1/' + url, options)
            .then((response) => {
                if (response.status === 200) {
                    resolve( response.json() );
                } else {
                    resolve(false);
                    webToast.Danger({
                        status:'Sorry !',
                        message:  response.length ? response.message : "Something went wrong",
                    })
                }

                if (loading) {
                    store.state.dataLoading = false;
                    loader.fadeOut().remove()
                }

            });

    });
}

