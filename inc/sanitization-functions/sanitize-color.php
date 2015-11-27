<?php
if ( ! function_exists( 'coder_sanitize_hex_color' ) ) :
    /**
     * Function to sanitize hex color
     *
     * @access public
     * @since 1.1
     *
     * @param $coder_input
     * @return int || float
     *
     */
    function coder_sanitize_hex_color( $coder_hex_color, $coder_setting ) {
        // Sanitize $coder_hex_color as a hex value without the hash prefix.
        $coder_hex_color = sanitize_hex_color( $coder_hex_color );

        // If $coder_hex_color is a valid hex value, return it; otherwise, return the default.
        return ( null != $coder_hex_color ? $coder_hex_color : $coder_setting->default );
    }

endif;