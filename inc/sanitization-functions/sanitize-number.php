<?php
if ( ! function_exists( 'coder_sanitize_number' ) ) :
    /**
     * Function to sanitize number
     *
     * @access public
     * @since 1.1
     *
     * @param $coder_input
     * @param $coder_setting
     * @return int || float || numeric value
     *
     */
    function coder_sanitize_number ( $coder_input, $coder_setting ) {
        $coder_sanitize_text = sanitize_text_field( $coder_input );

        // If the input is an number, return it; otherwise, return the default
        return ( is_numeric( $coder_sanitize_text ) ? $coder_sanitize_text : $coder_setting->default );
    }

endif;