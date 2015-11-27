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
    function coder_get_customizer_all_values( $coder_customizer_name_args = null ){
        if( $coder_customizer_name_args ){
            $coder_customizer_name = $coder_customizer_name_args;
        }
        elseif(defined('CODER_CUSTOMIZER_NAME')){
            $coder_customizer_name = CODER_CUSTOMIZER_NAME;
        }
        else{
            $coder_customizer_name = 'coder_customizer';
        }

        if (defined('CODER_CUSTOMIZER_OPTION_MODE') && CODER_CUSTOMIZER_OPTION_MODE == 1 ) {
            $coder_customizer_values = get_option( $coder_customizer_name);
        }
        else{
            $coder_customizer_values = get_theme_mod( $coder_customizer_name );
        }

        return $coder_customizer_values;
    }
endif;