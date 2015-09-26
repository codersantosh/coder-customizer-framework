<?php
if ( ! class_exists( 'WP_Customize_Control' ) || class_exists( 'Coder_Customize_Radio_Image_Control' ))
    return NULL;

/**
 * Custom Control radio image
 * @since 1.0.0
 *
 */
class Coder_Customize_Radio_Image_Control extends WP_Customize_Control {

    /**
     * Declare the control type.
     *
     * @access public
     * @var string
     */
    public $type = 'radio_image';

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
        if ( empty( $this->choices ) ) {
            return;
        }

        $coder_customizer_name = 'coder_customizer_radio_image' . $this->id;;
        ?>
        <label>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <?php if ( ! empty( $this->description ) ) : ?>
                <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
            <?php endif; ?>
            <?php
            foreach ( $this->choices as $value => $label ) :
                printf('<label><input class="coder-radio-image" type="radio"  name="%s" value="%s" %s %s>', esc_attr( $coder_customizer_name ), esc_attr( $value ), $this->get_link(), checked( $this->value(), $value, 0 ));
                printf('<span><img src="%s" alt="%s" /></span></label>', esc_url($label), esc_attr( $value ));
                ?>
            <?php
            endforeach;
            ?>
        </label>
    <?php
    }
}