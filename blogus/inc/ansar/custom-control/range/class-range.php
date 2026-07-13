<?php    
if ( ! class_exists( 'WP_Customize_Control' ) ) {
    return;
}

class Blogus_Range_Control extends WP_Customize_Control {

    public $type = 'blogus-range';
    public $media_query = false;
    public $input_attr = array();
    public $size_unit = array(); 
    
    public function enqueue() {
        wp_enqueue_style('blogus-range-control', get_template_directory_uri().'/inc/ansar/custom-control/range/css/range.css','4.0.13', 'all');
        wp_enqueue_script( 'blogus-range-control', get_template_directory_uri().'/inc/ansar/custom-control/range/js/range.js', array('jquery', 'customize-base', 'jquery-ui-button', 'jquery-ui-sortable'), false, true );
    }
    
    public function __construct( $manager, $id, $args = array() ) {
        parent::__construct( $manager, $id, $args );

        if ( ! empty( $args['media_query'] ) ) {
            $this->media_query = (bool) $args['media_query'];
        }
        if ( ! empty( $args['input_attr'] ) ) {
            $this->input_attr = $args['input_attr'];
        }
        if ( ! empty( $args['size_unit'] ) ) {
            $this->size_unit = $args['size_unit'];
        }
    }
    public function json() {

		$json = parent::json();

		$defaults = array(
			'desktop' => '',
			'tablet'  => '',
			'mobile'  => '',
			'unit'    => '',
		);

		// Default values.
		$default = $this->setting->default;
		$decoded = json_decode( $default, true );

		if ( is_array( $decoded ) ) {
			$defaults = array_merge( $defaults, $decoded );
		} elseif ( '' !== $default ) {
			$defaults['desktop'] = $default;
		}

		// Fallback unit.
		if ( empty( $defaults['unit'] ) && ! empty( $this->size_unit ) ) {
			$defaults['unit'] = $this->size_unit[0];
		}

		// Current values start as defaults.
		$values = $defaults;

		$value = $this->value();
		$decoded = json_decode( $value, true );

		if ( is_array( $decoded ) ) {

			$values = array_merge(
				$values,
				array_filter(
					$decoded,
					function( $v ) {
						return '' !== $v;
					}
				)
			);

		} elseif ( '' !== $value ) {

			$values['desktop'] = $value;

		}

		$json['desktop_value'] = $values['desktop'];
		$json['tablet_value']  = $values['tablet'];
		$json['mobile_value']  = $values['mobile'];
		$json['unit']          = $values['unit'];

		$json['desktop_default'] = $defaults['desktop'];
		$json['tablet_default']  = $defaults['tablet'];
		$json['mobile_default']  = $defaults['mobile'];

		$json['media_query'] = $this->media_query;
		$json['size_unit']   = $this->size_unit;
		$json['link']        = $this->get_link();

		$json['min']  = isset( $this->input_attr['min'] ) ? $this->input_attr['min'] : 0;
		$json['max']  = isset( $this->input_attr['max'] ) ? $this->input_attr['max'] : 100;
		$json['step'] = isset( $this->input_attr['step'] ) ? $this->input_attr['step'] : 1;

		return $json;
	}

    public function is_json( $string ) {
        return is_string( $string ) && is_array( json_decode( $string, true ) ) ? true : false;
    }

    protected function content_template() {
    ?>
        <div class="custom-range-control">
        <# if ( data.label ) { #>
            <div class="custom-range-title-area">
                <span class="customize-control-title">
                    <span>{{{ data.label }}}</span>
                </span>
  				<# if ( data.media_query ) { #>
                    <ul class="responsive-switchers responsive-switchers-open">
                        <li class="desktop"><button type="button" class="preview-desktop active" data-device="desktop"><i class="dashicons dashicons-desktop"></i></button></li>
                        <li class="tablet"><button type="button" class="preview-tablet" data-device="tablet"><i class="dashicons dashicons-tablet"></i></button></li>
                        <li class="mobile"><button type="button" class="preview-mobile" data-device="mobile"><i class="dashicons dashicons-smartphone"></i></button></li>
                    </ul>
                <# } #>
                <# if ( data.size_unit && data.size_unit.length ) { #>
                    <select class="custom-range-unit-select">
                        <# _.each( data.size_unit, function( unit ) { #>
                            <option value="{{ unit }}" <# if ( data.unit === unit ) { #>selected<# } #>>{{{ unit }}}</option>
                        <# }); #>
                    </select>
                <# } #>
                <span class="range-reset-slider"><span class="dashicons dashicons-image-rotate"></span></span>

            </div>
        <# } #>

        <div class="range-slider <# if ( data.media_query ) { #>has-media-queries<# }#>">
            <div class="desktop-range active">
                <input type="range" class="range-slider__range" title="{{{data.label}}}" min="{{data.min}}" max="{{data.max}}" step="{{data.step}}" data-query="desktop" data-default="{{data.desktop_default}}" value="{{data.desktop_value}}">
                <input type="number" class="range-slider-value" title="{{{data.label}}}" min="{{data.min}}" max="{{data.max}}" step="{{data.step}}" value="{{data.desktop_value}}">
            </div>

            <# if ( data.media_query ) { #>
                <div class="tablet-range">
                    <input type="range" class="range-slider__range" title="{{{data.label}}}" min="{{data.min}}" max="{{data.max}}" step="{{data.step}}" data-query="tablet" data-default="{{data.tablet_default}}" value="{{data.tablet_value}}">
                    <input type="number" class="range-slider-value" title="{{{data.label}}}" min="{{data.min}}" max="{{data.max}}" step="{{data.step}}" value="{{data.tablet_value}}">
                </div>
                <div class="mobile-range">
                    <input type="range" class="range-slider__range" title="{{{data.label}}}" min="{{data.min}}" max="{{data.max}}" step="{{data.step}}" data-query="mobile" data-default="{{data.mobile_default}}" value="{{data.mobile_value}}">
                    <input type="number" class="range-slider-value" title="{{{data.label}}}" min="{{data.min}}" max="{{data.max}}" step="{{data.step}}" value="{{data.mobile_value}}">
                </div>
            <# } #>
            <input type="hidden" class="range-collector" value="{{ data.value }}" {{{ data.link }}} >
        </div>
        </div>
        <?php
    }
}