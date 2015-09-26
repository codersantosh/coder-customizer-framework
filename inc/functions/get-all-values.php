<?php
if ( ! function_exists( 'coder_get_repeated_all_value' ) ) :
    /**
     * Function to get repeated value in array
     *
     * @access public
     * @since 1.1
     *
     * @param string $coder_customizer_name
     * @return array || other values
     *
     */
    function coder_get_repeated_all_value ( $coder_repeated_value_name ) {

        $coder_repeated_settings_controls = unserialize( coder_get_customizer_single_value('coder_repeated_settings_controls'));
        if(!isset($coder_repeated_settings_controls[$coder_repeated_value_name]) && null != $coder_repeated_settings_controls){
            return null;
        }
        $coder_selected_repeater = $coder_repeated_settings_controls[$coder_repeated_value_name];

        $repeated = $coder_selected_repeater['repeated'];

        if(!is_array($coder_selected_repeater)){
            return null;
        }
        $coder_repeated_saved_values_name = array_keys($coder_selected_repeater);
        unset($coder_repeated_saved_values_name[0]);
        $coder_get_customizer_all_values = coder_get_customizer_all_values();

        $coder_get_repeated_all_value = array();
        for ( $i = 1; $i <= $repeated; $i++ ){
            foreach($coder_repeated_saved_values_name as $coder_repeated_saved_value_name ){
                if( isset($coder_get_customizer_all_values[$coder_repeated_saved_value_name.'_'.$i]) )
                    $coder_get_repeated_all_value[$i][$coder_repeated_saved_value_name] = $coder_get_customizer_all_values[$coder_repeated_saved_value_name.'_'.$i];
            }
        }
        return $coder_get_repeated_all_value;
    }
endif;