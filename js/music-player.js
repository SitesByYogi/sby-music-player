jQuery(document).ready(function ($) {
    var currentAudio = null; // Keep track of the currently playing audio element

    // Play/pause control for each audio player
    $('.music-player audio').each(function () {
        $(this).on('play', function () {
            // If there is an active audio and it's not the current one, pause it
            if (currentAudio && currentAudio !== this) {
                currentAudio.pause();
                currentAudio.currentTime = 0; // Reset to start
            }
            currentAudio = this; // Update current audio
        });

        $(this).on('pause', function () {
            if (currentAudio === this) {
                currentAudio = null; // Clear the current audio when it's paused
            }
        });
    });

    // Handle play/pause with custom buttons (if required)
    $('.play-pause-btn').on('click', function () {
        var audio = $(this).siblings('audio').get(0);
        if (audio.paused) {
            // Pause any other playing audio and reset it
            if (currentAudio && currentAudio !== audio) {
                currentAudio.pause();
                currentAudio.currentTime = 0;
            }
            audio.play(); // Play the clicked audio
            currentAudio = audio;
        } else {
            audio.pause(); // Pause the clicked audio
        }
    });
});

jQuery(document).ready(function ($) {
    var currentAudio = null; // Track the current playing audio

    // Pause other audio when a new one plays
    $('.music-playlist audio').on('play', function () {
        var newAudio = this;
        if (currentAudio && currentAudio !== newAudio) {
            currentAudio.pause();
            currentAudio.currentTime = 0; // Reset the previous track
        }
        currentAudio = newAudio; // Update current audio
    });

    $('.music-playlist audio').on('pause', function () {
        if (currentAudio === this) {
            currentAudio = null; // Clear the current audio when it's paused
        }
    });
});

