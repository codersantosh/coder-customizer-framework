<?php
if ( ! class_exists( 'WP_Customize_Control' ) || class_exists( 'Coder_Customize_Post_Dropdown_Control' ))
    return NULL;

/**
 * Custom Control for post dropdown
 * @since 1.0.0
 *
 */
class Coder_Customize_Post_Dropdown_Control extends WP_Customize_Control {
    /**
     * Declare the control type.
     *
     * @access public
     * @var string
     */
    public $type = 'post_dropdown';

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
        $coder_customizer_post_args = array(
            'posts_per_page'   => -1,
        );
        $coder_posts = get_posts( $coder_customizer_post_args );
        if(!empty($coder_posts))  {
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
                    foreach ( $coder_posts as $coder_post ) {
                        printf('<option value="%s" %s>%s</option>', $coder_post->ID, selected($this->value(), $coder_post->ID, false), $coder_post->post_title);
                    }
                    ?>
                </select>
            </label>
        <?php
        }
    }
}