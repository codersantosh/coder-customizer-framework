<?php
if ( ! function_exists( 'coder_get_customizer_all_values' ) ) :
    /**
     * Function to get all value
     *
     * @access public
     * @since 1.0.0
     *
     * @param string $coder_customizer_name
     * @return array || other values
     *
     */
    function coder_get_customizer_all_values($coder_customizer_name = null){
        if( null == $coder_customizer_name ){
            $coder_customizer_name = 'coder_customizer';
        }
        if (defined('coder_customizer_option_mode') && coder_customizer_option_mode == 1 ) {
            $coder_customizer_values = get_option( $coder_customizer_name);
        }
        else{
            $coder_customizer_values = get_theme_mod( $coder_customizer_name );
        }

        return $coder_customizer_values;
    }
endif;