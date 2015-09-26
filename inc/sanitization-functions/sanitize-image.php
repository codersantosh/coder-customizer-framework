<?php
if ( ! function_exists( 'coder_sanitize_image' ) ) :
    /**
     * Function to sanitize image
     *
     * @access public
     * @since 1.1
     *
     * @param $coder_image
     * @return string
     *
     */
    function coder_sanitize_image( $coder_image, $coder_setting ) {
        /*
         * Array of valid image file types.
         *
         * The array includes image mime types that are included in wp_get_mime_types()
         */
        $coder_mimes = array(
            'jpg|jpeg|jpe' => 'image/jpeg',
            'gif'          => 'image/gif',
            'png'          => 'image/png',
            'bmp'          => 'image/bmp',
            'tif|tiff'     => 'image/tiff',
            'ico'          => 'image/x-icon'
        );
        // Return an array with file extension and mime_type.
        $coder_file = wp_check_filetype( $coder_image, $coder_mimes );
        // If $coder_image has a valid mime_type, return it; otherwise, return the default.
        return ( $coder_file['ext'] ? $coder_image : $coder_setting->default );
    }

endif;