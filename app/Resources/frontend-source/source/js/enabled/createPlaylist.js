(function ($, srList) {
    $(function () {
        $('.js-create-playlist-trigger').on('click', createPlaylist);
    });


    function createPlaylist(e) {
        e.preventDefault();

        srList.createPlaylistSpinner = new Spinner(getSpinnerOpts());

        var ajaxUrl = $(this).data('target-url'),
            $playlistTriggerer = $(this);

        $.ajax(ajaxUrl, {
            method: 'POST',
            beforeSend: function () {
                $('.js-create-playlist-status-error').addClass('hidden');
                $('.js-create-playlist-status-success').addClass('hidden');
                $playlistTriggerer.addClass('hidden');
                srList.createPlaylistSpinner.spin($('.js-create-playlist')[0]);
            },
        })
            .done(createdPlaylist)
            .fail(function (response) {
                try {
                    updateStatusWithError($.parseJSON(response.responseText).error_message);
                } catch (e) {
                    updateStatusWithError('Fel i kommunikation med servern. Vi vet tyvärr inget mer.');
                }
            })
            .always(function() {
                srList.createPlaylistSpinner.stop();
            });
    }

    function updateStatusWithError(errorMessage) {
        $('.js-create-playlist-status-error')
            .removeClass('hidden')
            .text(errorMessage);
        $('.js-create-playlist-trigger').removeClass('hidden');
    }

    function createdPlaylist(response, status, statusObject) {
        if (response !== 'ok' && statusObject.status !== 201) {
            updateStatusWithError('Någet gick fel. Vi vet tyvärr inget mer.');
            return;
        }

        $('.js-create-playlist-status-success')
            .removeClass('hidden');
        $('.js-create-playlist-status-error').addClass('hidden');
        $('.js-create-playlist-trigger').addClass('hidden');
    }


    /**
     * Some settings for the "progress" spinner
     */
    function getSpinnerOpts() {
        return {
            lines: 13 // The number of lines to draw
            , length: 28 // The length of each line
            , width: 17 // The line thickness
            , radius: 36 // The radius of the inner circle
            , scale: 0.25 // Scales overall size of the spinner
            , corners: 1 // Corner roundness (0..1)
            , color: '#000' // #rgb or #rrggbb or array of colors
            , opacity: 0.25 // Opacity of the lines
            , rotate: 0 // The rotation offset
            , direction: 1 // 1: clockwise, -1: counterclockwise
            , speed: 1 // Rounds per second
            , trail: 81 // Afterglow percentage
            , fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
            , zIndex: 2e9 // The z-index (defaults to 2000000000)
            , className: 'spinner' // The CSS class to assign to the spinner
            , top: '0' // Top position relative to parent
            , left: '24px' // Left position relative to parent
            , shadow: false // Whether to render a shadow
            , hwaccel: false // Whether to use hardware acceleration
            , position: 'relative' // Element positioning
        };
    };
})
(jQuery, srList);