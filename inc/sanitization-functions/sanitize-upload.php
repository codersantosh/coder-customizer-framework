<?php
if ( ! function_exists( 'coder_sanitize_upload' ) ) :
    /**
     * Function to sanitize upload
     *
     * @access public
     * @since 1.1
     *
     * @param $coder_upload
     * @return string
     *
     */
    function coder_sanitize_upload( $coder_upload, $coder_setting ) {
        /*
         * Array of valid upload file types.
         *
         * The array includes upload mime types that are included in wp_get_mime_types()
         */
        $coder_mimes = wp_get_mime_types();
        // Return an array with file extension and mime_type.
        $coder_file = wp_check_filetype( $coder_upload, $coder_mimes );
        // If $coder_upload has a valid mime_type, return it; otherwise, return the default.
        return ( $coder_file['ext'] ? $coder_upload : $coder_setting->default );
    }

endif;