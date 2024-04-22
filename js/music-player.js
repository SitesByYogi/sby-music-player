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