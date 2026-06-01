((api) => {
    api.controlConstructor['dimensions'] = api.Control.extend({
        ready() {
            const control = this;
            const container = control.container[0];
            const hiddenInput = container.querySelector(`input#blogus_dimensions_${control.id}`);

            // --- Unit → Max value map ---
            const unitMaxMap = {
                'px'  : 999,
                'em'  : 100,
                'rem' : 100,
                '%'   : 100,
                'vw'  : 200,
                'vh'  : 200,
            };

            /**
             * Update max attribute + clamp existing values for all inputs of a device.
             */
            function applyUnitMax( device, unit ) {
                const max = unitMaxMap[ unit ] !== undefined ? unitMaxMap[ unit ] : 999;
                container.querySelectorAll( `input[data-device="${device}"]` ).forEach( input => {
                    input.setAttribute( 'max', max );
                    if ( input.value !== '' && parseFloat( input.value ) > max ) {
                        input.value = String( max );
                    }
                } );
            }

            // --- Device Switching Management ---
            const deviceButtons = container.querySelectorAll('.switch-device');

            function switchDeviceUI( targetDevice ) {
                // Normalize — WP toolbar fires 'phone', our data uses 'mobile'
                const deviceMap = { phone: 'mobile', tablet: 'tablet', desktop: 'desktop' };
                targetDevice = deviceMap[ targetDevice ] || targetDevice;

                // Guard: only act on known devices
                if ( ! ['desktop', 'tablet', 'mobile'].includes( targetDevice ) ) return;

                // 1. Update button active states
                deviceButtons.forEach( btn => {
                    btn.classList.toggle( 'active', btn.dataset.device === targetDevice );
                });

                // 2. Toggle visibility on wrappers + unit selects
                container.querySelectorAll('.wrapper, .dimension-unit').forEach( el => {
                    el.classList.toggle( 'active-device', el.dataset.device === targetDevice );
                });

                // 3. Sync field values from stored JSON
                let currentData = {};
                try {
                    currentData = JSON.parse( hiddenInput.value );
                } catch (e) {
                    currentData = control.params.value || {};
                }

                const deviceValues = currentData[ targetDevice ] || { top: '', right: '', bottom: '', left: '', unit: 'px' };

                ['top', 'right', 'bottom', 'left'].forEach( side => {
                    const input = container.querySelector( `input[data-device="${targetDevice}"][data-side="${side}"]` );
                    if ( input ) input.value = deviceValues[ side ] !== undefined ? deviceValues[ side ] : '';
                });

                const unitSelect = container.querySelector( `.dimension-unit.unit-${targetDevice}` );
                if ( unitSelect ) unitSelect.value = deviceValues.unit || 'px';

                // 4. Apply correct max for active unit
                applyUnitMax( targetDevice, deviceValues.unit || 'px' );
            }

            // --- Our control button clicks ---
            deviceButtons.forEach( button => {
                button.addEventListener( 'click', (e) => {
                    e.preventDefault();
                    const device = button.dataset.device;

                    // Update our UI immediately
                    switchDeviceUI( device );

                    // Sync to WP preview frame — this also triggers the bottom toolbar to update
                    if ( api.previewedDevice ) {
                        api.previewedDevice.set( device );
                    }
                });
            });

            // --- Two-way sync with WP toolbar device buttons (bottom of customizer) ---
            // Use api.bind('ready') to guarantee previewedDevice exists before we bind to it.
            // This is the key fix: wp toolbar changes fire on previewedDevice,
            // but the value may not be available until after the customizer fully loads.
            function bindPreviewedDevice() {
                if ( ! api.previewedDevice ) return;

                // Listen to ANY device change — whether from our buttons or the WP toolbar
                api.previewedDevice.bind( function( newDevice ) {
                    switchDeviceUI( newDevice );
                });

                // Apply whatever device is currently active right now on load
                switchDeviceUI( api.previewedDevice.get() );
            }

            // Try immediately; if previewedDevice isn't ready yet, wait for 'ready'
            if ( api.previewedDevice ) {
                bindPreviewedDevice();
            } else {
                api.bind( 'ready', function() {
                    bindPreviewedDevice();
                });
            }

            // --- Change Value Listeners ---
            const inputs = container.querySelectorAll('.control input');
            inputs.forEach( input => {
                input.addEventListener( 'input', handleChange );
                input.addEventListener( 'change', handleChange );
            });

            const selects = container.querySelectorAll('.dimension-unit');
            selects.forEach( select => {
                select.addEventListener( 'change', function () {
                    const device = this.dataset.device;
                    const unit   = this.value;

                    // Update max + clamp values
                    applyUnitMax( device, unit );

                    // Re-persist clamped values before saving unit
                    ['top', 'right', 'bottom', 'left'].forEach( side => {
                        const input = container.querySelector( `input[data-device="${device}"][data-side="${side}"]` );
                        if ( input ) {
                            control.updateData({ device, side, value: input.value });
                        }
                    });

                    control.updateData({ device, side: 'unit', value: unit });
                });
            });

            function handleChange() {
                const input          = this;
                const device         = input.dataset.device;
                const side           = input.dataset.side;
                const max            = parseFloat( input.getAttribute('max') );
                let   val            = input.value;
                const closestControl = input.closest('.control');

                // Enforce max on manual input / paste
                if ( val !== '' && ! isNaN( max ) && parseFloat( val ) > max ) {
                    val = String( max );
                    input.value = val;
                }

                if ( closestControl.classList.contains('linked') ) {
                    closestControl.querySelectorAll('input').forEach( inp => inp.value = val );
                    control.updateData({ device, side: 'all', value: val });
                } else {
                    control.updateData({ device, side, value: val });
                }
            }

            // --- Link / Binding toggle ---
            container.querySelectorAll('.blogus-binding').forEach( btn => {
                btn.addEventListener( 'click', function (e) {
                    e.preventDefault();
                    const parentControl = this.closest('.control');
                    const device        = this.closest('.wrapper').dataset.device;

                    this.classList.toggle('active');
                    parentControl.classList.toggle('linked');

                    if ( this.classList.contains('active') ) {
                        const firstValue = parentControl.querySelector('input')?.value || '';
                        parentControl.querySelectorAll('input').forEach( input => input.value = firstValue );
                        control.updateData({ device, side: 'all', value: firstValue });
                    }
                });
            });

            // --- Reset to Default ---
            container.querySelector('.blogus-dimensions-reset').addEventListener( 'click', function (e) {
                e.preventDefault();
                control.resetToDefaults();
            });

            // --- Sync hidden input → WP setting ---
            hiddenInput.addEventListener( 'change', function () {
                try {
                    control.setting.set( JSON.parse( this.value ) );
                } catch (e) {
                    console.warn( 'Blogus Dimensions: failed to parse hidden input value', e );
                }
            });
        },

        /**
         * Update a specific side (or all sides) for a device in the stored JSON.
         */
        updateData({ device, side, value }) {
            const control     = this;
            const container   = control.container[0];
            const hiddenInput = container.querySelector(`input#blogus_dimensions_${control.id}`);

            let data = {};
            try {
                data = JSON.parse( hiddenInput.value );
            } catch (e) {
                data = {};
            }

            if ( ! data[ device ] ) {
                data[ device ] = { top: '', right: '', bottom: '', left: '', unit: 'px' };
            }

            if ( side === 'all' ) {
                ['top', 'right', 'bottom', 'left'].forEach( s => data[ device ][ s ] = value );
            } else {
                data[ device ][ side ] = value;
            }

            hiddenInput.value = JSON.stringify( data );
            hiddenInput.dispatchEvent( new Event('change') );
        },

        /**
         * Reset all devices to their registered defaults.
         */
        resetToDefaults() {
            const control     = this;
            const container   = control.container[0];
            const defaults    = control.params.default || {};
            const hiddenInput = container.querySelector(`input#blogus_dimensions_${control.id}`);

            hiddenInput.value = JSON.stringify( defaults );
            hiddenInput.dispatchEvent( new Event('change') );

            ['desktop', 'tablet', 'mobile'].forEach( device => {
                const deviceDefaults = defaults[ device ] || { top: '', right: '', bottom: '', left: '', unit: 'px' };

                const selectElement = container.querySelector( `.dimension-unit.unit-${device}` );
                if ( selectElement ) selectElement.value = deviceDefaults.unit || 'px';

                ['top', 'right', 'bottom', 'left'].forEach( side => {
                    const input = container.querySelector( `input[data-device="${device}"][data-side="${side}"]` );
                    if ( input ) input.value = deviceDefaults[ side ] !== undefined ? deviceDefaults[ side ] : '';
                });
            });
        }
    });
})(wp.customize);