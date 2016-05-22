(function ($) {
    $(function () {
        $('.js-create-playlist-trigger').on('click', createPlaylist);
    });

    function createPlaylist(e) {
        e.preventDefault();

        var ajaxUrl = $(this).data('target-url'),
            $playlistTriggerer = $(this);

        $.ajax(ajaxUrl, {
            method: 'POST',
            beforeSend: function () {
                $('.js-create-playlist-status-error').addClass('hidden');
                $('.js-create-playlist-status-success').addClass('hidden');
                $playlistTriggerer.addClass('hidden');
            },
            error: function (response) {
                try {
                    updateStatusWithError($.parseJSON(response.responseText).error_message);
                } catch (e) {
                    updateStatusWithError('Fel i kommunikation med servern. Vi vet tyvärr inget mer.');
                }
            },
            success: createdPlaylist
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
})
(jQuery, srList);