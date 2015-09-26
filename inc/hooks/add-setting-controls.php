<?php
/*I have added it through action so that it is flexible to the developer to adapt change*/
add_action('coder_add_setting_control','coder_add_setting_control_callback', 12, 5);

if ( ! function_exists( 'coder_add_setting_control_callback' ) ) :
    /**
     * Function to add customizer setting and controls
     *
     * @access public
     * @since 1.0.0
     *
     * @param object $coder_wp_customize
     * @param string $coder_customizer_name common name for all setting and controls
     * @param array $coder_basic_control_types
     * @param string $coder_setting_control_key
     * @param array $coder_settings_control
     * @return void
     *
     */
    function coder_add_setting_control_callback($coder_wp_customize, $coder_customizer_name, $coder_basic_control_types, $coder_setting_control_key, $coder_settings_control){
        $coder_wp_customize->add_setting( esc_attr( $coder_customizer_name.'['.$coder_setting_control_key.']' ), $coder_settings_control['setting']);

        $coder_control_field_type = $coder_settings_control['control']['type'];

        /*check if basic control types*/
        if ( in_array( $coder_control_field_type, $coder_basic_control_types ) ) {
            $coder_wp_customize->add_control( esc_attr( $coder_customizer_name.'['.$coder_setting_control_key.']' ), $coder_settings_control['control']);
        }
        else {
            /*Check for default WP_Customize_Custom_Control defined*/
            $coder_Explode_Customize_Custom_Control_class_name = explode('_', strtolower( $coder_control_field_type ));
            $coder_Ucfirst_Customize_Custom_Control_class_name_array = array_map('ucfirst', $coder_Explode_Customize_Custom_Control_class_name);
            $coder_Implode_Customize_Custom_Control_class_name = implode('_', $coder_Ucfirst_Customize_Custom_Control_class_name_array);

            $coder_New_Customize_Custom_Control_class_name = 'WP_Customize_'.$coder_Implode_Customize_Custom_Control_class_name.'_Control';
            $coder_customizer_class_exist = false;
            if ( class_exists( $coder_New_Customize_Custom_Control_class_name ) ) {
                $coder_customizer_class_exist = true;
            }
            else{
                $coder_New_Customize_Custom_Control_class_name = 'Coder_Customize_'.$coder_Implode_Customize_Custom_Control_class_name.'_Control';
                if ( class_exists( $coder_New_Customize_Custom_Control_class_name ) ) {
                    $coder_customizer_class_exist = true;
                }
            }
            if($coder_customizer_class_exist){
                $coder_wp_customize->add_control(
                    new $coder_New_Customize_Custom_Control_class_name(
                        $coder_wp_customize,
                        esc_attr( $coder_customizer_name.'['.$coder_setting_control_key.']'),
                        $coder_settings_control['control']
                    )
                );
            }
            else {
                ?>
                <script>
                    console.log('<?php echo  $coder_New_Customize_Custom_Control_class_name. "not found. Please create it."?>');
                </script>
            <?php
            }

        }
    }
endif;