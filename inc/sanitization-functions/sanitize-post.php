<?php
if ( ! function_exists( 'coder_sanitize_post' ) ) :
    /**
     * Function to sanitize post/page/post type
     *
     * @access public
     * @since 1.1
     *
     * @param int $coder_post_id
     * @param object $coder_setting
     * @return int || float
     *
     */
    function coder_sanitize_post( $coder_post_id, $coder_setting ) {
        // Ensure $coder_post_id is an absolute integer.
        $coder_post_id = absint( $coder_post_id );

        // If $coder_post_id is an ID of a published page, return it; otherwise, return the default.
        return ( 'publish' == get_post_status( $coder_post_id ) ? $coder_post_id : $coder_setting->default );
    }

endif;