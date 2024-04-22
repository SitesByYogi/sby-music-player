<?php
/*
Plugin Name: Music Player
Description: A simple WordPress plugin to play music files and external URLs.
Version: 1.0
Author: SitesByYogi
*/

// Enqueue necessary scripts and styles
function music_player_enqueue_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('music-player-script', plugins_url('/js/music-player.js', __FILE__), array('jquery'), '1.0', true);
    wp_enqueue_style('music-player-style', plugins_url('/css/music-player.css', __FILE__), array(), '1.0', 'all');
}
add_action('wp_enqueue_scripts', 'music_player_enqueue_scripts');

// Shortcode handler
function music_player_shortcode($atts) {
    $atts = shortcode_atts(
        array(
            'url' => '', // URL of the music file or external URL
            'autoplay' => 'false', // Autoplay the music
            'loop' => 'false', // Loop the music
        ),
        $atts,
        'music_player'
    );

    // Output HTML for the player
    ob_start();
    ?>
    <div class="music-player">
        <audio src="<?php echo esc_url($atts['url']); ?>" controls <?php echo ($atts['autoplay'] === 'true') ? 'autoplay' : ''; ?> <?php echo ($atts['loop'] === 'true') ? 'loop' : ''; ?>>
            Your browser does not support the audio element.
        </audio>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('music_player', 'music_player_shortcode');