<?php
if ( ! function_exists( 'coder_sanitize_email' ) ) :
    /**
     * Function to sanitize email
     *
     * @access public
     * @since 1.1
     *
     * @param $coder_input
     * @return int || float
     *
     */
    function coder_sanitize_email( $coder_email, $coder_setting ) {
        // Sanitize $coder_email as a hex value without the hash prefix.
        $coder_email = sanitize_email( $coder_email );

        // If $coder_email is a valid email, return it; otherwise, return the default.
        return ( ! null( $coder_email ) ? $coder_email : $coder_setting->default );
    }

endif;