<?php
if ( ! class_exists( 'WP_Customize_Control' ) || class_exists( 'Coder_Customize_Tags_Dropdown_Control' ))
    return NULL;

/**
 * Custom Control for tags dropdown
 * @since 1.0.0
 *
 */
class Coder_Customize_Tags_Dropdown_Control extends WP_Customize_Control {

    /**
     * Declare the control type.
     *
     * @access public
     * @var string
     */
    public $type = 'tags_dropdown';

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
        $coder_tags = get_tags();
        if(!empty($coder_tags))  {
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
                    foreach ( $coder_tags as $coder_post ) {
                        printf('<option value="%s" %s>%s</option>', $coder_tags->term_id, selected($this->value(), $coder_post->ID, false), $coder_tags->name);
                    }
                    ?>
                </select>
            </label>
        <?php
        }
    }
}
?>