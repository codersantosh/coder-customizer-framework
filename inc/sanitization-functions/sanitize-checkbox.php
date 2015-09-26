<?php
if ( ! function_exists( 'coder_sanitize_checkbox' ) ) :
    /**
     * Function to sanitize checkbox
     *
     * @access public
     * @since 1.1
     *
     * @param $coder_input
     * @return int
     *
     */
    function coder_sanitize_checkbox ( $coder_input ) {
        return ( ( isset( $coder_input ) && 1 == $coder_input ) ? 1 : 0 );
    }

endif;