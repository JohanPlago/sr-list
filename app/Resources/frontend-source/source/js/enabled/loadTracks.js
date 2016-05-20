(function ($, srList) {
    /**
     * Add tracks to #jst-tracklist, fetched from the provided url
     * @param ajaxUrl
     */
    srList.loadTracks = function (ajaxUrl) {
        srList.loadTracksSpinner = new Spinner(getSpinnerOpts()).spin($('#jst-tracklist')[0]);

        $.getJSON(ajaxUrl)
            .success(populateTrackListContainer)
            .always(function() {srList.loadTracksSpinner.stop()});
    };

    /**
     * Add the tracks to display
     *
     * @param tracks
     */
    var populateTrackListContainer = function (tracks) {
        var $trackListContainer = $('#jst-tracklist');

        // Show that no tracklists are available if they are not
        if (tracks.length === 0) {
            $trackListContainer.html($('#jst-tracklist-empty').html());
            return;
        }

        // Template html
        var $trackListItemTemplate = $($('#jst-track-template').html());

        $.each(tracks, function(i, track) {
            $trackListItem = $trackListItemTemplate.clone();

            $trackListItem.find('.jst-track-name').html(track.name);
            $trackListItem.find('.jst-track-artists').html(getArtistNames(track.artists));

            if (typeof track.album !== 'undefined') {
                if (track.album.images.length > 1) {
                    $trackListItem.find('.jst-album-image').prop('src', track.album.images[1].url);
                }

                if (track.album.name.length > 0) {
                    $trackListItem.find('.jst-album-name').html(' - ' + track.album.name);
                } else {
                    $trackListItem.find('.jst-album-name').remove();
                }
            }

            if (typeof track.spotify_uri !== 'undefined') {
                $trackListItem.find('.jst-spotify-uri-a').prop('href', track.spotify_uri);
            } else {
                $trackListItem.find('.jst-spotify-uri').remove();
            }

            $trackListContainer.append($trackListItem);
        });
    };

    /**
     * Makes artists' names nice to print out
     *
     * @param artists Array of artists that have names
     * @returns {string}
     */
    var getArtistNames = function (artists) {
        var artistNames = '';

        for (var i = 0; i < artists.length; i ++) {
            artistNames += artists[i].name;

            if (i !== (artists.length-1)) {
                artistNames += ', ';
            }
        }

        return artistNames;
    };

    /**
     * Some settings for the "progress" spinner
     */
    var getSpinnerOpts = function() {
        return {
            lines: 13 // The number of lines to draw
            , length: 28 // The length of each line
            , width: 17 // The line thickness
            , radius: 36 // The radius of the inner circle
            , scale: 0.5 // Scales overall size of the spinner
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
            , top: '50%' // Top position relative to parent
            , left: '50%' // Left position relative to parent
            , shadow: false // Whether to render a shadow
            , hwaccel: false // Whether to use hardware acceleration
            , position: 'absolute' // Element positioning
        };
    };
})(jQuery, srList);