<?php
if ( ! function_exists( 'coder_sanitize_number_range' ) ) :
    /**
     * Function to sanitize number range
     *
     * @access public
     * @since 1.1
     *
     * @param $coder_input
     * @param $coder_setting
     * @return int || float || numeric value
     *
     */
    function coder_sanitize_number_range( $coder_input, $coder_setting ) {

        // Ensure input is an absolute integer.
        $coder_input = absint( $coder_input );

        // Get the input attributes associated with the setting.
        $atts = $coder_setting->manager->get_control( $coder_setting->id )->input_attrs;

        // Get minimum number in the range.
        $min = ( isset( $atts['min'] ) ? $atts['min'] : $coder_input );

        // Get maximum number in the range.
        $max = ( isset( $atts['max'] ) ? $atts['max'] : $coder_input );

        // Get step.
        $step = ( isset( $atts['step'] ) ? $atts['step'] : 1 );

        // If the number is within the valid range, return it; otherwise, return the default
        return ( $min <= $coder_input && $coder_input <= $max && is_int( $coder_input / $step ) ? $coder_input : $coder_setting->default );
    }

endif;