<?php
if ( ! class_exists( 'WP_Customize_Control' ) || class_exists( 'Coder_Customize_Html_Control' ))
    return NULL;

/**
 * Custom Control for html display
 * @since 1.0.0
 *
 */
class Coder_Customize_Message_Control extends WP_Customize_Control {

    /**
     * Declare the control type.
     *
     * @access public
     * @var string
     */
    public $type = 'message';

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
        if ( empty( $this->description ) ) {
            return;
        }
        ?>
        <div class="coder-customize-customize-message">
            <?php echo wp_kses_post( $this->description ); ?>
        </div> <!-- .coder-customize-customize-message -->
        <?php
    }
}
