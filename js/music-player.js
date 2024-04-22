jQuery(document).ready(function ($) {
    // Add custom functionality here

    // Example: Toggle play/pause button text
    $('.music-player audio').on('play', function () {
        $('.play-pause-btn').text('Pause');
    });

    $('.music-player audio').on('pause', function () {
        $('.play-pause-btn').text('Play');
    });

    // Example: Custom play/pause button functionality
    $('.play-pause-btn').on('click', function () {
        var audio = $('.music-player audio').get(0);
        if (audio.paused) {
            audio.play();
        } else {
            audio.pause();
        }
    });
});

jQuery(document).ready(function ($) {
    // Keep track of the currently playing audio element
    var currentAudio = null;

    // Add click event handler to each audio player
    $('.music-player audio').each(function () {
        $(this).on('play', function () {
            // Pause the previously playing audio
            if (currentAudio && !currentAudio.paused && currentAudio !== this) {
                currentAudio.pause();
                currentAudio.currentTime = 0; // Restart the previous audio
            }
            // Set the currently playing audio
            currentAudio = this;
        });
    });
});