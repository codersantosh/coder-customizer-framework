<?php
if ( ! function_exists( 'coder_sanitize_select' ) ) :
    /**
     * Function to sanitize select
     *
     * @access public
     * @since 1.1
     *
     * @param $coder_input
     * @param $coder_setting
     * @return string
     *
     */
    function coder_sanitize_select( $coder_input, $coder_setting ) {

        // Ensure input is a slug.
        $coder_input = sanitize_key( $coder_input );

        // Get list of choices from the control associated with the setting.
        $coder_choices = $coder_setting->manager->get_control( $coder_setting->id )->choices;

        // If the input is a valid key, return it; otherwise, return the default.
        return ( array_key_exists( $coder_input, $coder_choices ) ? $coder_input : $coder_setting->default );
    }

endif;