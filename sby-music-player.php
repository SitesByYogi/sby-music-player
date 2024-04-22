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

// Enqueue necessary scripts and styles
function music_player_shortcode($atts) {
    $atts = shortcode_atts(
        array(
            'url' => '',      // URL of the music file or external URL
            'autoplay' => 'false', // Autoplay the music
            'loop' => 'false', // Loop the music
            'image' => '',    // URL of the image (if needed)
        ),
        $atts,
        'music_player'
    );

    // Retrieve attachment ID from the media URL
    $attachment_id = attachment_url_to_postid($atts['url']);

    // Extract metadata, or default to empty strings
    $metadata = wp_get_attachment_metadata($attachment_id);
    $title = isset($metadata['title']) ? $metadata['title'] : get_the_title($attachment_id);
    $artist = isset($metadata['artist']) ? $metadata['artist'] : '';
    $album = isset($metadata['album']) ? $metadata['album'] : '';

    // Output HTML for the player
    ob_start();
    ?>
    <div class="music-player">
        
        <div class="music-info">
            <?php if (!empty($title)) : ?>
                <div class="music-info-item"><strong>Title:</strong> <?php echo esc_html($title); ?></div>
            <?php endif; ?>
            <?php if (!empty($artist)) : ?>
                <div class="music-info-item"><strong>Artist:</strong> <?php echo esc_html($artist); ?></div>
            <?php endif; ?>
            <?php if (!empty($album)) : ?>
                <div class="music-info-item"><strong>Album:</strong> <?php echo esc_html($album); ?></div>
                <div class="audio-div"><audio src="<?php echo esc_url($atts['url']); ?>" controls 
            <?php echo ($atts['autoplay'] === 'true') ? 'autoplay' : ''; ?> 
            <?php echo ($atts['loop'] === 'true') ? 'loop' : ''; ?>>
            Your browser does not support the audio element.
        </audio></div>
            <?php endif; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('music_player', 'music_player_shortcode');

// add shortcode for playlist 
function music_playlist_shortcode($atts) {
    $atts = shortcode_atts(
        array(
            'media_ids' => '', // A comma-separated list of media IDs
            'autoplay' => 'false', // Whether to autoplay the first track
            'loop' => 'false', // Whether to loop the entire playlist
        ),
        $atts,
        'music_playlist'
    );

    // Split media_ids into an array
    $media_ids = array_filter(array_map('trim', explode(',', $atts['media_ids'])));

    // Check if media_ids is not empty
    if (empty($media_ids)) {
        return '<p>No tracks available.</p>';
    }

    // Output HTML for the playlist
    ob_start();
    ?>
    <div class="music-playlist">
        <?php
        // Loop through each media ID and fetch metadata
        foreach ($media_ids as $media_id) {
            $attachment_url = wp_get_attachment_url($media_id);
            $metadata = wp_get_attachment_metadata($media_id);
            $title = isset($metadata['title']) ? $metadata['title'] : get_the_title($media_id);
            $artist = isset($metadata['artist']) ? $metadata['artist'] : '';

            // Display each track in the playlist
            ?>
            <div class="music-track">
                <audio src="<?php echo esc_url($attachment_url); ?>" controls <?php echo ($atts['autoplay'] === 'true' && $media_id === $media_ids[0]) ? 'autoplay' : ''; ?> <?php echo ($atts['loop'] === 'true') ? 'loop' : ''; ?>>
                    Your browser does not support the audio element.
                </audio>
                <div class="music-info">
                    <?php if (!empty($title)) : ?>
                        <div class="music-info-item"><strong>Title:</strong> <?php echo esc_html($title); ?></div>
                    <?php endif; ?>
                    <?php if (!empty($artist)) : ?>
                        <div class="music-info-item"><strong>Artist:</strong> <?php echo esc_html($artist); ?></div>
                    <?php endif; ?>
                    
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
    return ob_get_clean();
}

add_shortcode('music_playlist', 'music_playlist_shortcode');