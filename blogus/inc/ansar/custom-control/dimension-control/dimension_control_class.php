<?php 
class Dimension_Custom_Control extends WP_Customize_Control {

    /**
     * Control's Type.
     *
     * @var string
     */
    public $type = 'dimensions';

    /**
     * Size Unit for Dimension.
     *
     * @var array
     */
    public $size_unit = array();

    /**
     * Refresh the parameters passed to the JavaScript via JSON.
     *
     * @see WP_Customize_Control::to_json()
     */
    public function to_json() {
        parent::to_json();

        $default_value = ( isset( $this->default ) ) ? $this->default : array();
        if ( is_object( $this->setting ) ) {
            $default_value = $this->setting->default;
        }

        // Structure setup fallbacks
        $saved_value = $this->value();
        if ( ! is_array( $saved_value ) ) {
            $saved_value = json_decode( $saved_value, true );
        }
		
        // Base structural guarantee
        $base_defaults = array(
            'desktop' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '', 'unit' => 'px' ),
            'tablet'  => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '', 'unit' => 'px' ),
            'mobile'  => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '', 'unit' => 'px' ),
        );

        $this->json['default']   = wp_parse_args( (array) $default_value, $base_defaults );
        $this->json['value']     = wp_parse_args( (array) $saved_value, $base_defaults );
        $this->json['size_unit'] = $this->size_unit;
        $this->json['link']      = $this->get_link();
        $this->json['choices']   = $this->choices;
        $this->json['id']        = $this->id;
        $this->json['sides']     = array(
            'top'    => __( 'Top', 'blogus' ),
            'right'  => __( 'Right', 'blogus' ),
            'bottom' => __( 'Bottom', 'blogus' ),
            'left'   => __( 'Left', 'blogus' ),
        );
    }

    public function enqueue() {
        wp_enqueue_style('dimension-control-css', get_template_directory_uri().'/inc/ansar/custom-control/dimension-control/css/dimension.css', array(), '4.0.13', 'all');
        wp_enqueue_script( 'dimension-control-js', get_template_directory_uri().'/inc/ansar/custom-control/dimension-control/js/dimension.js', array('jquery', 'customize-controls'), false, true );
    }

    /**
     * Renders the Underscore template for this control.
     */
    protected function content_template() {
        ?>
        <div class="blogus-dimension-wrapper responsive-control customize-control-responsive-wrapper">
            <input type="hidden" value='{{{ "object" === typeof data.value ? JSON.stringify( data.value ) : data.value }}}' id="blogus_dimensions_{{{ data.id }}}" name="blogus_dimensions_{{{ data.id }}}">
            
            <# if ( data.label ) { #>
            <div class="dimension-label-unit-wrapper">
                <div class="label-switcher-wrapper">
                    <span class="customize-control-title">{{{ data.label }}}</span>
                    <div class="responsive-switchers">
                        <button type="button" class="switch-device active" data-device="desktop" title="<?php esc_attr_e('Desktop', 'blogus'); ?>">
                            <span class="dashicons dashicons-desktop"></span>
                        </button>
                        <button type="button" class="switch-device" data-device="tablet" title="<?php esc_attr_e('Tablet', 'blogus'); ?>">
                            <span class="dashicons dashicons-tablet"></span>
                        </button>
                        <button type="button" class="switch-device" data-device="mobile" title="<?php esc_attr_e('Mobile', 'blogus'); ?>">
                            <span class="dashicons dashicons-smartphone"></span>
                        </button>
                    </div>
                </div>
                
                <div class="unit-wrapper">
                    <div class="input-wrapper">
                        <# _.each(['desktop', 'tablet', 'mobile'], function(device) { #>
                            <select class="dimension-unit unit-{{{ device }}} {{{ device === 'desktop' ? 'active-device' : '' }}}" data-device="{{{ device }}}" name="unit" data-type="unit">
                                <# _.each( data.size_unit, function( size_unit ) { #>
                                <option value="{{ size_unit }}" {{{ data.value[device] && data.value[device].unit == size_unit ? 'selected' : '' }}}>{{{ size_unit }}}</option>
                                <# } ); #>
                            </select>
                        <# }); #>
                        <div class="blogus-dimensions-reset">
                            <span class="dashicons dashicons-image-rotate" title="<?php esc_attr_e( 'Back to default', 'blogus' ); ?>"></span>
                        </div>
                    </div>
                </div>
            </div>
            <# } #>
            
            <# if ( data.description ) { #>
                <span class="description customize-control-description">{{{ data.description }}}</span>
            <# } #>

            <# _.each(['desktop', 'tablet', 'mobile'], function(device) { #>
                <div class="wrapper wrapper-{{{ device }}} {{{ device === 'desktop' ? 'active-device' : '' }}}" data-device="{{{ device }}}">
                    <div class="control">
                        <# _.each( data.sides, function( label, key ) { #>
                            <label for="{{ data.id }}_{{ device }}_{{ key }}" class="{{ key }}">
                                <input type="number"
                                       id="{{ data.id }}_{{ device }}_{{ key }}"
                                       data-side="{{{ key }}}"
                                       data-device="{{{ device }}}"
                                       value="{{{ data.value[device] && data.value[device][key] !== undefined ? data.value[device][key] : '' }}}">
                                <h5>{{{ label }}}</h5>
                            </label>
                        <# } ) #>
                        <button class="blogus-binding">
                            <svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 24 24">
                                <path d="M12 22a5 5 0 0 1-5-5v-2.5a.83.83 0 0 1 .83-.83.84.84 0 0 1 .84.83V17a3.33 3.33 0 0 0 6.66 0v-2.5a.84.84 0 0 1 .84-.83.83.83 0 0 1 .83.83V17a5 5 0 0 1-5 5Zm4.17-11.67a.84.84 0 0 1-.84-.83V7a3.33 3.33 0 0 0-6.66 0v2.5a.84.84 0 0 1-.84.83A.83.83 0 0 1 7 9.5V7a5 5 0 0 1 10 0v2.5a.83.83 0 0 1-.83.83Zm-3.34 5V8.67a.83.83 0 1 0-1.66 0v6.66a.83.83 0 1 0 1.66 0Z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            <# }); #>
        </div>
        <?php
    }

    protected function render_content() {}
}