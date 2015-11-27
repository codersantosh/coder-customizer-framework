<?php
if ( ! function_exists( 'coder_get_customizer_single_value' ) ) :
    /**
     * Function to get single value
     *
     * @access public
     * @since 1.0.0
     *
     * @param string $coder_single_value_name
     * @return array || other values
     *
     */
    function coder_get_customizer_single_value ( $coder_single_value_name ){
        $coder_customizer_values = coder_get_customizer_all_values();
        if(!isset($coder_customizer_values[$coder_single_value_name])){
            return null;
        }
        return $coder_customizer_values[$coder_single_value_name];
    }
endif;