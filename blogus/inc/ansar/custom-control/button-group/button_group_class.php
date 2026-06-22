<?php
/**
 * Customizer Segmented Multi-Choice Button Group Control for Blogus theme.
 */

if ( ! class_exists( 'Blogus_Button_Group_Control' ) ) {
    class Blogus_Button_Group_Control extends WP_Customize_Control {
        /**
         * Control type identifier.
         */
        public $type = 'blogus-button-group';

        /**
         * Enqueue independent style and interaction controllers.
         */
        public function enqueue() {
            wp_enqueue_style(
                'blogus-btn-group-css',
                get_theme_file_uri( '/inc/ansar/custom-control/button-group/css/button-group.css' ),
                array(),
                '1.0.0'
            );

            wp_enqueue_script(
                'blogus-btn-group-js',
                get_theme_file_uri( '/inc/ansar/custom-control/button-group/js/button-group.js' ),
                array( 'jquery', 'customize-controls' ),
                '1.0.0',
                true
            );
        }

        /**
         * Pass down the complex choices architecture into JSON for JS templating.
         */
        public function to_json() {
            parent::to_json();

            $this->json['id']      = $this->id; // <-- add this
            $this->json['choices'] = $this->choices;
            $this->json['link']    = $this->get_link();

            $value = $this->value();
            if ( is_string( $value ) ) {
                $value = $value !== '' ? array_map( 'trim', explode( ',', $value ) ) : array();
            }
            $this->json['value'] = ! empty( $value ) && is_array( $value ) ? $value : array();
        }

        /**
         * Dynamic Underscore JS markup interface generation.
         */
        protected function content_template() {
            ?>
            <# if ( ! data.choices ) { return; } #>
            
            <span class="customize-control-title">{{ data.label }}</span>
            <# if ( data.description ) { #>
                <span class="description customize-control-description">{{ data.description }}</span>
            <# } #>

            <!-- Hidden input maintaining primary array syncing -->
            <input type="hidden" {{{ data.link }}} value="{{ data.value.join(',') }}" />

            <div class="blogus-btn-group">
                <# _.each( data.choices, function( optionData, choiceKey ) { #>
                    <# 
                    var isChecked = _.contains( data.value, choiceKey ) ? 'checked=\"checked\"' : ''; 
                    var labelText = optionData.title ? optionData.title : choiceKey;
                    var iconClass = optionData.icon ? optionData.icon : '';
                    #>
                    <div class="blogus-btn-item">
                        <input type="checkbox" id="blogus-btn-{{ data.id }}-{{ choiceKey }}" value="{{ choiceKey }}" {{{ isChecked }}} class="blogus-group-checkbox" />
                        <label class="blogus-btn-label" for="blogus-btn-{{ data.id }}-{{ choiceKey }}">
                            <# if ( iconClass ) { #>
                                <span class="custom-icon {{ iconClass }}" title="{{ labelText }}"></span>
                            <# } else { #>
                                <span>{{ labelText }}</span>
                             <# } #>
                        </label>
                    </div>
                <# } ); #>
            </div>
            <?php
        }
    }
}