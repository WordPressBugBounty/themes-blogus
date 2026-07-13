wp.customize.controlConstructor['blogus-range'] = wp.customize.Control.extend({

    ready: function () {

        'use strict';

        var control   = this;
        var container = control.container[0];

        if ( ! container ) {
            return;
        }

        // Everything below is scoped to THIS control instance only.
        // No global selectors, no shared state between controls.

        control.elements = {
            collector      : container.querySelector( '.range-collector' ),
            unitSelect     : container.querySelector( '.custom-range-unit-select' ),
            resetButton    : container.querySelector( '.range-reset-slider' ),
            deviceButtons  : container.querySelectorAll( '.responsive-switchers button' ),
            numberInputs   : container.querySelectorAll( '.range-slider-value' ),
            sliders        : container.querySelectorAll( '.range-slider__range' ),
            deviceWrappers : {
                desktop: container.querySelector( '.desktop-range' ),
                tablet : container.querySelector( '.tablet-range' ),
                mobile : container.querySelector( '.mobile-range' )
            }
        };

        // Whether this particular instance has responsive (media query) support.
        control.hasMediaQuery = !! container.querySelector( '.has-media-queries' );

        /**
         * Keep a range slider and its adjacent number input in sync.
         */
        control.syncRangeText = function ( slider, input, source ) {

            if ( ! slider || ! input ) {
                return;
            }

            if ( 'slider' === source ) {
                input.value = slider.value;
            } else {
                slider.value = input.value;
            }
        };

        /**
         * Collect the current value of every slider (+ unit, if present)
         * scoped to this control only.
         */
        control.getSliderValues = function () {

            var values = {};

            control.elements.sliders.forEach( function ( slider ) {
                values[ slider.dataset.query ] = slider.value;
            } );

            if ( control.elements.unitSelect ) {
                values.unit = control.elements.unitSelect.value;
            }

            return values;
        };

        /**
         * Recalculate the collector value from current UI state,
         * write it to the hidden input and push it to the Customizer setting.
         */
        control.updateValues = function () {

            var collector = control.elements.collector;

            if ( ! collector ) {
                return;
            }

            var oldValue = {};

            try {
                oldValue = JSON.parse( collector.value );
            } catch ( e ) {
                oldValue = {};
            }

            if ( ! oldValue || 'object' !== typeof oldValue ) {
                oldValue = {};
            }

            var values = Object.assign( {}, oldValue, control.getSliderValues() );

            var newValue;

            if ( control.hasMediaQuery || control.elements.unitSelect ) {
                newValue = JSON.stringify( values );
            } else {
                newValue = values.desktop;
            }

            collector.value = newValue;

            // Push the value to the Customizer setting (drives postMessage/refresh transport).
            control.setting.set( newValue );

            // Notify anything else listening on the collector (e.g. WP's own
            // data-customize-setting-link binding), harmless if nothing is bound.
            collector.dispatchEvent( new Event( 'change', { bubbles: true } ) );
        };

        /**
         * Slider -> number input, and push updated value.
         */
        control.bindSliderEvents = function () {

            control.elements.sliders.forEach( function ( slider ) {

                var input = slider.nextElementSibling;

                slider.addEventListener( 'input', function () {
                    control.syncRangeText( slider, input, 'slider' );
                    control.updateValues();
                } );
            } );
        };

        /**
         * Number input -> slider, and push updated value.
         */
        control.bindNumberEvents = function () {

            control.elements.numberInputs.forEach( function ( input ) {

                var slider = input.previousElementSibling;

                [ 'keyup', 'change' ].forEach( function ( evtName ) {
                    input.addEventListener( evtName, function () {
                        control.syncRangeText( slider, input, 'input' );
                        control.updateValues();
                    } );
                } );
            } );
        };

        /**
         * Unit selector change.
         */
        control.bindUnitEvents = function () {

            if ( ! control.elements.unitSelect ) {
                return;
            }

            control.elements.unitSelect.addEventListener( 'change', function () {
                control.updateValues();
            } );
        };

        /**
         * Reset button: restore every device's default value.
         */
        control.bindResetEvents = function () {

            if ( ! control.elements.resetButton ) {
                return;
            }

            control.elements.resetButton.addEventListener( 'click', function ( e ) {

                e.preventDefault();

                control.elements.sliders.forEach( function ( slider ) {

                    var input = slider.nextElementSibling;
                    var def   = slider.dataset.default;

                    slider.value = def;

                    if ( input ) {
                        input.value = def;
                    }
                } );

                control.updateValues();
            } );
        };

        /**
         * Update this control's own UI to reflect the given device:
         * active button state + which desktop/tablet/mobile row is visible.
         */
        control.switchDeviceUI = function ( device ) {

            if ( ! control.hasMediaQuery ) {
                return;
            }

            control.elements.deviceButtons.forEach( function ( button ) {
                button.classList.toggle( 'active', button.dataset.device === device );
            } );

            Object.keys( control.elements.deviceWrappers ).forEach( function ( key ) {

                var wrapper = control.elements.deviceWrappers[ key ];

                if ( wrapper ) {
                    wrapper.classList.toggle( 'active', key === device );
                }
            } );
        };

        /**
         * Clicking this control's own responsive icons:
         * update this control's UI AND drive the global previewed device,
         * which in turn syncs every other Range control on the page.
         */
        control.bindDeviceButtonEvents = function () {

            control.elements.deviceButtons.forEach( function ( button ) {

                button.addEventListener( 'click', function ( e ) {

                    e.preventDefault();

                    var device = button.dataset.device;

                    control.switchDeviceUI( device );

                    if ( wp.customize.previewedDevice ) {
                        wp.customize.previewedDevice.set( device );
                    } else {
                        control.switchDeviceUI( device );
                    }
                } );
            } );
        };

        /**
         * Two-way sync with wp.customize.previewedDevice:
         * - Apply the current previewed device immediately.
         * - React whenever it changes, whether triggered from this control,
         *   another Range control, or the WP footer device switcher.
         */
        control.bindPreviewedDevice = function () {

            if ( ! control.hasMediaQuery ) {
                return;
            }

            function bind() {

                if ( ! wp.customize.previewedDevice ) {
                    return;
                }

                control.switchDeviceUI( wp.customize.previewedDevice.get() );

                wp.customize.previewedDevice.bind( function ( device ) {

                    // WP sometimes reports "phone"
                    if ( device === 'phone' ) {
                        device = 'mobile';
                    }

                    control.switchDeviceUI( device );

                } );
            }

            if ( wp.customize.previewedDevice ) {
                bind();
            } else {
                wp.customize.bind( 'ready', bind );
            }

        };

        control.init = function () {
            control.bindSliderEvents();
            control.bindNumberEvents();
            control.bindUnitEvents();
            control.bindResetEvents();
            control.bindDeviceButtonEvents();
            control.bindPreviewedDevice();
        };

        control.init();
    }

});