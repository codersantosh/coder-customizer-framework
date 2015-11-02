<?php
if ( ! function_exists( 'coder_sanitize_checkbox' ) ) :
    /**
     * Function to sanitize checkbox
     *
     * @access public
     * @since 1.1
     *
     * @param $coder_input
     * @return boolean
     *
     */
    function coder_sanitize_checkbox( $checked ) {
        // Boolean check.
        return ( ( isset( $checked ) && true == $checked ) ? true : false );
    }

endif;