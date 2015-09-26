<?php
if ( ! class_exists( 'WP_Customize_Control' ) || class_exists( 'Coder_Customize_User_Dropdown_Control' ))
    return NULL;

/**
 * Custom Control for user dropdown
 * @since 1.0.0
 *
 */
class Coder_Customize_User_Dropdown_Control extends WP_Customize_Control {

    /**
     * Declare the control type.
     *
     * @access public
     * @var string
     */
    public $type = 'user_dropdown';

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
        $coder_users = get_users();
        if(!empty($coder_users))  {
            ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <select <?php $this->link(); ?>>
                    <?php
                    $coder_default_value = $this->value();
                    if( -1 == $coder_default_value || empty($coder_default_value)){
                        $coder_default_selected = 1;
                    }
                    else{
                        $coder_default_selected = 0;
                    }
                    printf('<option value="-1" %s>%s</option>',selected($coder_default_selected, 1, false),__('Select','coder-customizer-framework'));
                    foreach ( $coder_users as $coder_user ) {
                        printf('<option value="%s" %s>%s</option>', $coder_user->data->ID, selected($this->value(),  $coder_user->data->ID, false), $coder_user->data->display_name);
                    }
                    ?>
                </select>
            </label>
        <?php
        }
    }
}