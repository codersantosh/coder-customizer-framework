<?php
/*
Plugin Name: Coder Customizer Framework
Plugin URI: http://codersantosh.com
Description: Use WordPress Customizer in easy and standard way to your theme.
Version: 2.3
Author: Santosh Kunwar (CoderSantosh)
Author URI: http://codersantosh.com
License: GPLv2 or later
Copyright: Santosh Kunwar (CoderSantosh)
*/

/*Make sure we don't expose any info if called directly*/
if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

if ( ! class_exists( 'Coder_Customizer_Framework' ) ){
    /**
     * Class for almost all types of customizer fields.
     *
     * @package Coder Customizer Framework
     * @since 1.0.0
     */
    class Coder_Customizer_Framework{
        /*Basic variables for class*/

        /**
         * Variable to hold this framework version
         *
         * @var string
         * @access protected
         * @since 1.0.0
         *
         */
        private  $coder_customizer_framework_version = '2.3';

        /**
         * Variable to hold this framework minimum wp version
         *
         * @var string
         * @access protected
         * @since 1.0.0
         *
         */
        protected $coder_customizer_framework_minimum_wp_version = '3.1';

        /**
         * Coder_Customizer_Framework Plugin instance.
         *
         * @see coder_get_instance()
         * @var object
         * @access protected
         * @since 1.0.0
         *
         */
        protected static $coder_instance = NULL;

        /**
         * Variable to hold this framework url
         *
         * @var string
         * @access protected
         * @since 1.0.0
         *
         */
        protected $coder_customizer_framework_url = '';

        /**
         * Variable to hold this framework path
         *
         * @var string
         * @access protected
         * @since 1.0.0
         *
         */
        protected $coder_customizer_framework_path = '';

        /**
         * Name use to save customizer value
         *
         * @var string
         * @access protected
         * @since 1.0.0
         *
         */
        protected $coder_customizer_name = 'coder_customizer';

        /**
         * Holds all basic control types that does not required class
         *
         * @var array
         * @access protected
         * @since 1.0.0
         *
         */
        protected $coder_basic_control_types =
            array(
                'text',
                'text_html',
                'textarea',
                'textarea_html',
                'checkbox',
                'number',
                'number_range',
                'radio',
                'range',
                'select',
                'url',
                'email',
                'password',
                'dropdown-pages',
            );

        /**
         * Holds all panels sections settings
         *
         * @var array
         * @access protected
         * @since 1.0.0
         *
         */
        protected $coder_panels_sections_settings = array();

        /**
         * Holds all panels
         *
         * @var array
         * @access protected
         * @since 1.0.0
         *
         */
        protected $coder_panels = array();

        /**
         * Holds all sections
         *
         * @var array
         * @access protected
         * @since 1.0.0
         *
         */
        protected $coder_sections = array();

        /**
         * Holds same fields repeated settings controls
         *
         * @var array
         * @access protected
         * @since 1.0.0
         *
         */
        public  $coder_repeated_settings_controls = array();

        /**
         * Holds all settings controls
         *
         * @var array
         * @access protected
         * @since 1.0.0
         *
         */
        protected $coder_settings_controls = array();

        /**
         * Holds all panel id to remove
         *
         * @var array
         * @access protected
         * @since 1.0.0
         *
         */
        protected $coder_remove_panels = array();

        /**
         * Holds all section id to remove
         *
         * @var array
         * @access protected
         * @since 1.0.0
         *
         */
        protected $coder_remove_sections = array();

        /**
         * Holds all settings control id to remove
         *
         * @var array
         * @access protected
         * @since 1.0.0
         *
         */
        protected $coder_remove_settings_controls = array();

        /**
         * Access this plugin’s working coder_instance
         *
         * @access public
         * @since 1.0.0
         * @return object of this class
         */
        public static function coder_get_instance() {
            NULL === self::$coder_instance and self::$coder_instance = new self;
            return self::$coder_instance;
        }

        /**
         * Used for regular plugin work.
         *
         * @access public
         * @since 1.0.0
         *
         * @return void
         *
         */
        public function coder_customizer_init($coder_panels_sections_settings = array()) {

            /*Basic variables initialization with filter*/
            if (defined('CODER_CUSTOMIZER_THEME') && CODER_CUSTOMIZER_THEME == 1 ) {
                $this->coder_customizer_framework_url = get_template_directory_uri().'/coder-customizer-framework/';
                $this->coder_customizer_framework_path = get_template_directory().'/coder-customizer-framework/';
            }
            elseif (defined('CODER_CUSTOMIZER_CHILD_THEME') && CODER_CUSTOMIZER_CHILD_THEME == 1) {
                $this->coder_customizer_framework_url = get_stylesheet_directory_uri().'/coder-customizer-framework/';
                $this->coder_customizer_framework_path = get_stylesheet_directory().'/coder-customizer-framework/';
            }
            else {
                $this->coder_customizer_framework_url = plugin_dir_url( __FILE__ ) ;
                $this->coder_customizer_framework_path = plugin_dir_path( __FILE__ );
            }
            $this->coder_customizer_framework_url = apply_filters( 'coder_customizer_framework_url', $this->coder_customizer_framework_url );
            $this->coder_customizer_framework_path = apply_filters( 'coder_customizer_framework_path', $this->coder_customizer_framework_path );

            /*Basic variables initialization with filter*/
            if(defined('CODER_CUSTOMIZER_NAME')){
                $this->coder_customizer_name = CODER_CUSTOMIZER_NAME;
            }


            $this->coder_basic_control_types = apply_filters( 'coder_basic_control_types', $this->coder_basic_control_types );

            $this->coder_panels_sections_settings = $coder_panels_sections_settings;
            $this->coder_panels_sections_settings = apply_filters( 'coder_panels_sections_settings', $this->coder_panels_sections_settings );

            /*Hook before any function of class start */
            do_action( 'coder_customizer_framework_before', $this->coder_panels_sections_settings );

            if(isset($this->coder_panels_sections_settings['panels']) && !empty($this->coder_panels_sections_settings['panels'])){
                $this->coder_panels = $this->coder_panels_sections_settings['panels'];
            }
            if(isset($this->coder_panels_sections_settings['sections']) && !empty($this->coder_panels_sections_settings['sections'])){
                $this->coder_sections = $this->coder_panels_sections_settings['sections'];
            }
            if(isset($this->coder_panels_sections_settings['repeated_settings_controls']) && !empty($this->coder_panels_sections_settings['repeated_settings_controls'])){
                $this->coder_repeated_settings_controls = $this->coder_panels_sections_settings['repeated_settings_controls'];
            }
            if(isset($this->coder_panels_sections_settings['settings_controls']) && !empty($this->coder_panels_sections_settings['settings_controls'])){
                $this->coder_settings_controls = $this->coder_panels_sections_settings['settings_controls'];
            }
            if(isset($this->coder_panels_sections_settings['remove_panels']) && !empty($this->coder_panels_sections_settings['remove_panels'])){
                $this->coder_remove_panels = $this->coder_panels_sections_settings['remove_panels'];
            }
            if(isset($this->coder_panels_sections_settings['remove_sections']) && !empty($this->coder_panels_sections_settings['remove_sections'])){
                $this->coder_remove_sections = $this->coder_panels_sections_settings['remove_sections'];
            }
            if(isset($this->coder_panels_sections_settings['remove_settings_controls']) && !empty($this->coder_panels_sections_settings['remove_settings_controls'])){
                $this->coder_remove_settings_controls = $this->coder_panels_sections_settings['remove_settings_controls'];
            }
            $this->coder_panels = apply_filters( 'coder_panels', $this->coder_panels );

            $this->coder_sections = apply_filters( 'coder_sections', $this->coder_sections );

            $this->coder_repeated_settings_controls = apply_filters( 'coder_repeated_settings_controls', $this->coder_repeated_settings_controls );

            $this->coder_settings_controls = apply_filters( 'coder_settings_controls', $this->coder_settings_controls );

            $this->coder_remove_panels = apply_filters( 'coder_remove_panels', $this->coder_remove_panels );

            $this->coder_remove_sections = apply_filters( 'coder_remove_sections', $this->coder_remove_sections );

            $this->coder_remove_settings_controls = apply_filters( 'coder_remove_settings_controls', $this->coder_remove_settings_controls );

            /*Set default values for panels*/
            if(!empty( $this->coder_panels ) ){
                foreach( $this->coder_panels as $coder_panel_id => $coder_panel ){
                    $this->coder_panels_default_values($coder_panel_id, $coder_panel);
                }
            }

            /*Set default values for sections*/
            if( !empty( $this->coder_sections ) ) {
                foreach( $this->coder_sections as $coder_section_id => $coder_section ){
                    $this->coder_sections_default_values($coder_section_id, $coder_section);
                }
            }

            /*Set default values for coder repeated settings controls*/
            if(!empty($this->coder_repeated_settings_controls)) {
                foreach( $this->coder_repeated_settings_controls as $coder_repeated_setting_control_id => $coder_repeated_setting_control ){
                    $this->coder_repeated_setting_control_default_values( $coder_repeated_setting_control_id, $coder_repeated_setting_control );
                }
            }

            /*Set default values for setting control*/
            if(!empty($this->coder_settings_controls)) {
                foreach( $this->coder_settings_controls as $coder_settings_control_id => $coder_setting_control ){
                    $this->coder_setting_control_default_values($coder_settings_control_id, $coder_setting_control);
                }
            }

            /*Enqueue necessary styles and scripts in  Theme Customizer.*/
            add_action('customize_controls_enqueue_scripts', array($this,'coder_customize_controls_enqueue_scripts'), 12 );

            /*Adding theme customization admin screen*/
            add_action( 'customize_register', array($this,'coder_customize_register'), 12 );

            /*Hook before any function of class end */
            do_action( 'coder_repeated_settings_controls', $this->coder_repeated_settings_controls );
            do_action( 'coder_customizer_framework_after', $this->coder_panels_sections_settings );
        }

        /**
         * Constructor. Intentionally left empty and public.
         *
         * @access public
         * @since 1.0.0
         *
         *
         */
        public function __construct( $coder_customizer_init = array()){
            if(!empty($coder_customizer_init)) {
                $this->coder_customizer_init( $coder_customizer_init );
            }
        }

        /**
         * Function to Set default values for panels
         *
         * @access public
         * @since 1.0.0
         *
         * @param string $coder_panel_id Id of panel
         * @param array $coder_panel Single panel
         * @return void
         *
         */
        public function coder_panels_default_values($coder_panel_id, $coder_panel) {
            $coder_panels_default_values =
                array(
                    'priority'       => 120,
                    'capability'     => 'edit_theme_options',
                    'theme_supports' => '',
                    'title'          => '',
                    'description'    => '',
                );
            $coder_panels_default_values = apply_filters( 'coder_panel_default_values', $coder_panels_default_values);

            $this->coder_panels[$coder_panel_id] =
                array_merge(
                    $coder_panels_default_values,
                    (array)$coder_panel
                );
        }

        /**
         * Function to Set default values for sections
         *
         * @access public
         * @since 1.0.0
         *
         * @param string $coder_section_id Id of section
         * @param array $coder_section Single section
         * @return void
         *
         */
        public function coder_sections_default_values($coder_section_id, $coder_section) {
            $coder_sections_default_values =
                array(
                    'priority'       => 120,
                    'capability'     => 'edit_theme_options',
                    'theme_supports' => '',
                    'title'          => '',
                    'description'    => '',
                    'panel'          => '',
                );
            $coder_sections_default_values = apply_filters( 'coder_sections_default_values', $coder_sections_default_values);

            $this->coder_sections[$coder_section_id] =
                array_merge(
                    $coder_sections_default_values,
                    (array)$coder_section
                );
        }
        /**
         * Function to Set default values for repeated setting controls
         *
         * @access public
         * @since 1.0.0
         *
         * @param string $coder_settings_control_id Id of repeated setting controls
         * @param array $coder_setting_control Single settings control
         * @return void
         *
         */
        public function coder_repeated_setting_control_default_values($coder_repeated_settings_control_id, $coder_repeated_setting_control) {
            if(!empty($coder_repeated_setting_control)) {
                $coder_priority_fixed = 0;
                $coder_repeated_priority = 1;
                $coder_repeated = $coder_repeated_setting_control['repeated'];
                unset($coder_repeated_setting_control['repeated']);
                for( $i=1; $i <= $coder_repeated ; $i++) {
                    foreach( $coder_repeated_setting_control as $coder_settings_control_id => $coder_setting_control ){
                        if( 0 == $coder_priority_fixed ) {
                            $coder_repeated_priority =  $coder_setting_control['control']['priority'];
                        }
                        else {
                            $coder_repeated_priority = $coder_repeated_priority++;

                        }
                        if(isset($coder_setting_control['control']['label'])){
                            $coder_setting_control['control']['label'] = sprintf($coder_setting_control['control']['label'], $i);
                        }
                        $coder_setting_control['control']['priority'] = $coder_repeated_priority;
                        $coder_settings_control_id = $coder_settings_control_id.'_'.$i;

                        $coder_settings_control_id = apply_filters( 'coder_repeated_setting_control_id', $coder_settings_control_id , $coder_setting_control);
                        $coder_setting_control = apply_filters( 'coder_repeated_setting_control', $coder_setting_control, $coder_settings_control_id );

                        $this->coder_settings_controls[$coder_settings_control_id] = $coder_setting_control;

                        $coder_priority_fixed++;
                    }

                }
            }
        }

        /**
         * Function to Set default values for setting controls
         *
         * @access public
         * @since 1.0.0
         *
         * @param string $coder_settings_control_id Id of settings control
         * @param array $coder_setting_control Single settings control
         * @return void
         *
         */
        public function coder_setting_control_default_values( $coder_settings_control_id, $coder_setting_control ) {

            $coder_setting_control_type = $coder_setting_control['control']['type'];
            if( 'text' == $coder_setting_control_type ){
                $coder_default_sanitize_callback = 'sanitize_text_field';
            }
            elseif( 'text_html' == $coder_setting_control_type ){
                $coder_default_sanitize_callback = 'wp_kses_post';
                $coder_setting_control['control']['type'] = 'text';
            }
            elseif( 'textarea' == $coder_setting_control_type ){
                $coder_default_sanitize_callback = 'esc_textarea';
            }
            elseif( 'textarea_html' == $coder_setting_control_type ){
                $coder_default_sanitize_callback = 'wp_kses_post';
                $coder_setting_control['control']['type'] = 'textarea';
            }
            elseif( 'textarea_css' == $coder_setting_control_type ){
                $coder_default_sanitize_callback = 'wp_strip_all_tags';
                $coder_setting_control['control']['type'] = 'textarea';
            }
            elseif( 'checkbox' == $coder_setting_control_type ){
                $coder_default_sanitize_callback = 'coder_sanitize_checkbox';
            }
            elseif( 'number' == $coder_setting_control_type ){
                $coder_default_sanitize_callback = 'coder_sanitize_number';
            }
            elseif( 'number_range' == $coder_setting_control_type ){
                $coder_default_sanitize_callback = 'coder_sanitize_number_range';
                $coder_setting_control['control']['type'] = 'number';
            }
            elseif( 'radio' == $coder_setting_control_type ){
                $coder_default_sanitize_callback = 'coder_sanitize_select';
            }
            elseif( 'range' == $coder_setting_control_type ){
                $coder_default_sanitize_callback = 'coder_sanitize_number_range';
            }
            elseif( 'select' == $coder_setting_control_type ){
                $coder_default_sanitize_callback = 'coder_sanitize_select';
            }
            elseif( 'url' == $coder_setting_control_type ){
                $coder_default_sanitize_callback = 'esc_url_raw';
            }
            elseif( 'email' == $coder_setting_control_type ){
                $coder_default_sanitize_callback = 'coder_sanitize_email';
            }
            elseif( 'password' == $coder_setting_control_type ){
                $coder_default_sanitize_callback = 'sanitize_text_field';/*wp_filter_nohtml_kses*/
            }
            elseif( 'dropdown-pages' == $coder_setting_control_type ){
                $coder_default_sanitize_callback = 'coder_sanitize_post';
            }
            /*WordPress class available*/
            elseif( 'color' == $coder_setting_control_type ){
                $coder_default_sanitize_callback = 'coder_sanitize_hex_color';
            }
            elseif( 'upload' == $coder_setting_control_type ){
                $coder_default_sanitize_callback = 'coder_sanitize_upload';
            }
            elseif( 'image' == $coder_setting_control_type ){
                $coder_default_sanitize_callback = 'coder_sanitize_image';
            }

            /*Coder custom control*/
            elseif( 'post_dropdown' == $coder_setting_control_type ){
                $coder_default_sanitize_callback = 'coder_sanitize_post';
            }
            elseif( 'category_dropdown' == $coder_setting_control_type ){
                $coder_default_sanitize_callback = 'absint';
            }
            elseif( 'radio_image' == $coder_setting_control_type ){
                $coder_default_sanitize_callback = 'sanitize_text_field';
            }
            elseif( 'tags_dropdown' == $coder_setting_control_type ){
                $coder_default_sanitize_callback = 'absint';
            }
            elseif( 'user_dropdown' == $coder_setting_control_type ){
                $coder_default_sanitize_callback = 'absint';
            }
            else{
                $coder_default_sanitize_callback = 'esc_attr';
            }
            $coder_setting_type = 'theme_mod';
            if (defined('CODER_CUSTOMIZER_OPTION_MODE') && CODER_CUSTOMIZER_OPTION_MODE == 1 ) {
                $coder_setting_type = 'option';
            }
            $coder_setting_default_values =
                array(
                    'type'                 => $coder_setting_type,
                    'capability'           => 'edit_theme_options',
                    'theme_supports'       => '',
                    'default'              => '',
                    'transport'            => 'refresh',
                    'sanitize_callback'    => $coder_default_sanitize_callback,
                    'sanitize_js_callback' => 'esc_attr',
                );
            $coder_control_default_values =
                array(
                    'label'                 => '',
                    'section'               => '',
                    'type'                  => '',
                    'priority'              => 12,
                    'description'           => '',
                    'active_callback'       => ''
                );
            $coder_setting_default_values = apply_filters( 'coder_setting_default_values', $coder_setting_default_values);
            $coder_control_default_values = apply_filters( 'coder_control_default_values', $coder_control_default_values);


            if(!isset($coder_setting_control['setting'])) {
                $coder_setting_control['setting'] = array();
            }
            if(!isset($coder_setting_control['control'])) {
                $coder_setting_control['control'] = array();
            }

            $this->coder_settings_controls[$coder_settings_control_id]['setting'] =
                array_merge(
                    $coder_setting_default_values,
                    (array)$coder_setting_control['setting']
                );
            $this->coder_settings_controls[$coder_settings_control_id]['control'] =
                array_merge(
                    $coder_control_default_values,
                    (array)$coder_setting_control['control']
                );
        }
        /**
         * Enqueue style and scripts at Theme Customizer
         *
         * @access public
         * @since 1.0.0
         *
         * @return void
         *
         */
        function coder_customize_controls_enqueue_scripts(){
            global $pagenow;
            if ( 'customize.php' == $pagenow ) {
                wp_register_style( 'coder-customizer-framework-style', $this->coder_customizer_framework_url . '/assets/css/coder-customizer-framework.css', false, $this->coder_customizer_framework_version );
                wp_enqueue_style( 'coder-customizer-framework-style' );
            }
        }

        /**
         * Function to register customizer
         *
         * @access public
         * @since 1.0.0
         *
         * @param object $coder_wp_customize
         * @return void
         *
         */
        public function coder_customize_register( $coder_wp_customize ){

            require_once trailingslashit( $this->coder_customizer_framework_path ) . 'inc/coder-customizer-custom-control.php';

            /*Again adding filter here*/
            $coder_panels = apply_filters( 'coder_register_customize_panel', $this->coder_panels );
            $coder_sections = apply_filters( 'coder_register_customize_sections', $this->coder_sections );
            $coder_settings_controls = apply_filters( 'coder_register_customize_settings_controls', $this->coder_settings_controls );
            $coder_customizer_name = $this->coder_customizer_name;
            $coder_basic_control_types = apply_filters( 'coder_register_customizer_basic_control_types', $this->coder_basic_control_types );
            $coder_remove_panels = apply_filters( 'coder_register_customize_remove_panel', $this->coder_remove_panels );
            $coder_remove_sections = apply_filters( 'coder_register_customize_remove_sections', $this->coder_remove_sections );
            $coder_remove_settings_controls = apply_filters( 'coder_register_customize_remove_settings_controls', $this->coder_remove_settings_controls );

            /*Adding Panels*/
            if ( ! empty( $coder_panels ) ) {
                foreach($coder_panels as $coder_panel_key =>  $coder_panel) {
                    $coder_wp_customize->add_panel( esc_attr( $coder_panel_key ), $coder_panel );
                }
            }

            /*Adding sections*/
            if ( ! empty( $coder_sections ) ) {
                foreach($coder_sections as $coder_section_key =>  $coder_section) {
                    $coder_wp_customize->add_section( esc_attr( $coder_section_key ), $coder_section );
                }
            }


            /*Adding settings controls*/
            if ( ! empty( $coder_settings_controls ) ) {
                foreach($coder_settings_controls as $coder_setting_control_key =>  $coder_settings_control) {
                    do_action('coder_add_setting_control',$coder_wp_customize,$coder_customizer_name, $coder_basic_control_types, $coder_setting_control_key, $coder_settings_control);
                }
            }
            /*Removing Panels*/
            if ( ! empty( $coder_remove_panels ) ) {
                foreach($coder_remove_panels as $coder_remove_panel) {
                    $coder_wp_customize->remove_panel( esc_attr( $coder_remove_panel ));
                }
            }

            /*Removing sections*/
            if ( ! empty( $coder_remove_sections ) ) {
                foreach($coder_remove_sections as $coder_remove_section) {
                    $coder_wp_customize->remove_section( esc_attr( $coder_remove_section ));
                }
            }
            /*Removing settings controls*/
            if ( ! empty( $coder_remove_settings_controls ) ) {
                foreach($coder_remove_settings_controls as $coder_remove_settings_control) {
                    $coder_wp_customize->remove_setting( esc_attr( $coder_remove_settings_control ));
                    $coder_wp_customize->remove_control( esc_attr( $coder_remove_settings_control ));
                }
            }
            /*update option to save repeated values
            * @since 1.1
            */
            if (defined('CODER_CUSTOMIZER_OPTION_MODE') && CODER_CUSTOMIZER_OPTION_MODE == 1 ) {
                $coder_customizer_values = get_option( $this->coder_customizer_name);
            }
            else{
                $coder_customizer_values = get_theme_mod( $this->coder_customizer_name);
            }
            $coder_customizer_values['coder_repeated_settings_controls'] = serialize( $this->coder_repeated_settings_controls );

            if (defined('CODER_CUSTOMIZER_OPTION_MODE') && CODER_CUSTOMIZER_OPTION_MODE == 1 ) {
                update_option( $this->coder_customizer_name, $coder_customizer_values );
            }
            else{
                set_theme_mod( $this->coder_customizer_name, $coder_customizer_values );
            }
        }/*END function coder_customize_register*/
    } /*END class Coder_Customizer_Framework*/

    /*Initialize class after theme setup*/
    add_action( 'after_setup_theme', array ( Coder_Customizer_Framework::coder_get_instance(), 'coder_customizer_init' ));
    /*include path for sanitization fields*/
    $coder_current_framework_base_path = plugin_dir_path( __FILE__ );
    require_once trailingslashit( $coder_current_framework_base_path ) . 'inc/coder-customizer-hooks.php';
    require_once trailingslashit( $coder_current_framework_base_path ) . 'inc/coder-sanitization-functions.php';
    require_once trailingslashit( $coder_current_framework_base_path ) . 'inc/coder-customizer-functions.php';
}/*END if(!class_exists('Coder_Customizer_Framework'))*/
