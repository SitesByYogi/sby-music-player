<?php
/*
Plugin Name: Music Player
Description: A simple WordPress plugin to play music files and external URLs.
Version: 1.0
Author: SitesByYogi
*/

// Enqueue necessary scripts and styles
function music_player_shortcode($atts) {
    $atts = shortcode_atts(
        array(
            'url' => '',      // URL of the music file or external URL
            'title' => '',    // Title of the music
            'artist' => '',   // Artist of the music
            'album' => '',    // Album of the music
            'autoplay' => 'false', // Autoplay the music
            'loop' => 'false', // Loop the music
            'image' => ''     // URL of the image
        ),
        $atts,
        'music_player'
    );

    // Output HTML for the player
    ob_start();
    ?>
    <div class="music-player">
        <?php if (!empty($atts['image'])) : ?>
            <img src="<?php echo esc_url($atts['image']); ?>" alt="Music Image">
        <?php endif; ?>
        <audio src="<?php echo esc_url($atts['url']); ?>" controls <?php echo ($atts['autoplay'] === 'true') ? 'autoplay' : ''; ?> <?php echo ($atts['loop'] === 'true') ? 'loop' : ''; ?>>
            Your browser does not support the audio element.
        </audio>
        <div class="music-info">
            <strong>Title:</strong> <?php echo esc_html($atts['title']); ?><br>
            <strong>Artist:</strong> <?php echo esc_html($atts['artist']); ?><br>
            <strong>Album:</strong> <?php echo esc_html($atts['album']); ?><br>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('music_player', 'music_player_shortcode');