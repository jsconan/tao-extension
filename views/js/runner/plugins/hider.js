define([
    'taoTests/runner/plugin'
], function (pluginFactory) {
    'use strict';

    return pluginFactory({
        name: 'hider',

        init() {
            const areaBroker = this.getAreaBroker();
            this.button = areaBroker.getToolbox().createEntry({
                control: 'hider',
                text: 'Hider',
                title: 'Hide the item',
                icon: 'eye-slash'
            });
            this.button.on('click', function (e) {
                e.preventDefault();
                areaBroker.getContentArea().toggle();
            });

            this.getTestRunner()
                .on('enabletools renderitem', () => this.enable())
                .on('disabletools unloaditem', () => this.disable());
        },

        destroy: function destroy() {
            if (this.button) {
                this.button.off('click');
            }
            this.button = null;
        },

        enable() {
            this.button.enable();
        },

        disable() {
            this.button.disable();
        }
    });
});