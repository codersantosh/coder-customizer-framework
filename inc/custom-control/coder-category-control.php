<?php
if ( ! class_exists( 'WP_Customize_Control' ) || class_exists( 'Coder_Customize_Category_Dropdown_Control' ))
    return NULL;

/**
 * Custom Control for category dropdown
 * @since 1.0.0
 *
 */
class Coder_Customize_Category_Dropdown_Control extends WP_Customize_Control {

    /**
     * Declare the control type.
     *
     * @access public
     * @var string
     */
    public $type = 'category_dropdown';

    /**
     * Function to  render the content on the theme customizer page
     *
     * @access public
     * @since 1.0.0
     *
     * @param null
     * @return void
     *
     */
    public function render_content() {
        $coder_customizer_name = 'coder_customizer_dropdown_categories_' . $this->id;;
        $coder_dropdown_categories = wp_dropdown_categories(
            array(
                'name'              => $coder_customizer_name,
                'echo'              => 0,
                'show_option_none'  =>__('Select','coder-customizer-framework'),
                'option_none_value' => '0',
                'selected'          => $this->value(),
            )
        );
        $coder_dropdown_final = str_replace( '<select', '<select ' . $this->get_link(), $coder_dropdown_categories );
        printf(
            '<label><span class="customize-control-title">%s</span> %s</label>',
            $this->label,
            $coder_dropdown_final
        );
    }
}
