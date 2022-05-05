/**
 * NkDialog
 * jQuery dialog plugin
 * 
 * @version 1.1.0
 * @author Krescentmoon
 * @license under the MIT License
 */

// the semi-colon before the function invocation is a safety net against concatenated 
// scripts and/or other plugins that are not closed properly
;(function ($, window, document, undefined) {

    /**
     * Creates a dialog.
     * @public
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    var NkDialog = function(element, options) {
        
        this.element = element;
        this.$element = $(element);
        this.options = options;
        this.metadata = this.$element.data('nkdialog');
        this.init(this.element, this.options);

    };

    /**
     * Default options for the dialog.
     * @public
     */
    NkDialog.defaults = {

        // Dialog popup content id
        ids : {
            container : 'nkdialog-container', // (string)
            wrapper   : 'nkdialog-wrapper',   // (string)
            section   : 'nkdialog-section',   // (string)
            wrap      : 'nkdialog-wrap',      // (string)
            header    : 'nkdialog-header',    // (string)
            title     : 'nkdialog-title',     // (string)
            content   : 'nkdialog-content',   // (string)
            footer    : 'nkdialog-footer',    // (string)
            close     : 'nkdialog-close',     // (string)
            bg        : 'nkdialog-bg'         // (string)
        },

        classes : {
            skin   : 'origin',          // (string)
            opened : 'nkdialog-opened', // (string) add class in the body tag
            fixed  : 'nkdialog-fixed'   // (string) sameAs
        },

        // display and hidden content
        display : {
            header  : true, // (boolean)
            content : true, // (boolean)
            footer  : true  // (boolean)
        },

        // get data from the element
        data : {
            header   : '',                  // (string)
            content  : '',                  // (string)
            footer   : '',                  // (string)
            close    : '<span>close</span>' // (string)
        },

        // parse html from the target element
        target : {
            header   : '.nkdialog-header',   // (string)
            content  : '.nkdialog-content',  // (string)
            footer   : '.nkdialog-footer',   // (string)
            close    : '.nkdialog-close'     // (string)
        },

        // get load content from the url
        ajax : {
            url      : false,               // (boolean|string)
            target   : '#nkdialog-content', // (string)
            response : false,               // (boolean) output console
            status   : false,               // (boolean) sameAs
            xhr      : false                // (boolean) sameAs
        },

        // background
        bg : {
            disabled  : false,            // (boolean)
            color    : 'rgba(0,0,0,0.7)', // (string)
            image    : '',                // (string)
            style    : ''                 // (string)
        },

        // close button
        close : {
            offset : 'inner' // (string) 'inner' or 'outer'
        },

        // scroll event
        scroll : {
            fixed : true // (boolean)
        },
        
        // animation
        animate : {
            effect   : '', // (string) '', 'fade'
            duration : 250 // (number)
        },

        // dialog size
        size : {
            maxWidth   : '640px', // (string) px, rem, vw, vh
            maxHeight  : '50vh',  // (string) px, rem, vw, vh
            fullSize   : false,   // (boolean) overwrite maxWidth and maxHeight
            fullWidth  : false,   // (boolean) overwrite maxWidth
            fullHeight : false    // (boolean) overwrite maxHeight
        },

        // active event
        onoff : {
            delegate          : 'a',   // (string) '' or tag, id and class name is possible
            preventDefault    : false, // (boolean)
            click             : true,  // (boolean)
            destroy           : false, // (boolean)
            resize            : true,  // (boolean)
            resized           : false, // (boolean)
            orientationchange : false  // (boolean)
        },
        
        // callback
        on : {
            initialize           : null, // (function) e, el, opts
            initialized          : null, // (function) e, el, opts
            resize               : null, // (function) e, el, opts
            resized              : null, // (function) e, el, opts
            orientationchange    : null, // (function) e, el, opts
            destroy              : null, // (function) e, el, opts
            open                 : null, // (function) e, el, opts
            openAnimate          : null, // (function) e, el, opts
            openStepAnimate      : null, // (function) e, el, opts
            openProgressAnimate  : null, // (function) e, el, opts
            openCompleteAnimate  : null, // (function) e, el, opts
            openStartAnimate     : null, // (function) e, el, opts
            openDoneAnimate      : null, // (function) e, el, opts
            openFailAnimate      : null, // (function) e, el, opts
            openAlwaysAnimate    : null, // (function) e, el, opts
            close                : null, // (function) e, el, opts
            closeAnimate         : null, // (function) e, el, opts
            closeStepAnimate     : null, // (function) e, el, opts
            closeProgressAnimate : null, // (function) e, el, opts
            closeCompleteAnimate : null, // (function) e, el, opts
            closeStartAnimate    : null, // (function) e, el, opts
            closeDoneAnimate     : null, // (function) e, el, opts
            closeFailAnimate     : null, // (function) e, el, opts
            closeAlwaysAnimate   : null  // (function) e, el, opts
        }
    };

    NkDialog.prototype = {
        defaults: NkDialog.defaults,
        init: function(element, options) {

            this._core = NkDialog.prototype;
            this.settings = $.extend(true, {}, this.defaults, this.options, this.metadata);

            this.onInit(element, this.settings);
            this.doInit(element, this.settings);

            return this;
        }
    };

    /**
     * Execute initialize onInit method
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.doInit = function(element, settings) {
        this.doInitialize(element, settings);
        this.doInitialized(element, settings);
        this.doInitDestroy(element, settings);
    }

    /**
     * Attach initialize event handler
     * @public
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.onInit = function(element, settings) {
        var core = this._core;

        $(element).on('initialize.NkDialog', {element:element, settings:settings}, function(e, el, opts) {
            core.onInitialize(e, el, opts);
        })
        .on('initialized.NkDialog', {element:element, settings:settings}, function(e, el, opts) {
            core.onInitialized(e, el, opts);
        })
        .on('destroy.NkDialog', {element:element, settings:settings}, function(e, el, opts) {
            core.onDestroy(el, opts);
        });
    }






    /**
     * Execute initialize event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.doInitialize = function(element, settings) {
        $(element).trigger('initialize.NkDialog', [element, settings]);
    }

    /**
     * Attach initialize event handler
     * @public
     * @param {object} [event]
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.onInitialize = function(e, el, opts) {

        this.doOpen(el, opts);
        this.doInitializeDestroy(el, opts);

        if ( typeof opts.on.initialize == 'function' ) {
            opts.on.initialize(e, el, opts);
        }

    }

    /**
     * Remove initialize event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.offInitialize = function(element, settings) {
        $(element).off('initialize.NkDialog');
    }






    /**
     * Execute initialized event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.doInitialized = function(element, settings) {
        $(element).trigger('initialized.NkDialog', [element, settings]);
    }

    /**
     * Attach initialized event handler
     * @public
     * @param {object} [event]
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.onInitialized = function(e, el, opts) {
        if ( typeof opts.on.initialized == 'function' ) {
            opts.on.initialized(e, el, opts);
        }
    }

    /**
     * Remove initialized event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.offInitialized = function(element, settings) {
        $(element).off('initialized.NkDialog');
    }





    /**
     * Execute destory event handler when the object key is true
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.doInitDestroy = function(element, settings) {
        if ( isObjKey(settings, 'destroy.NkDialog') ) { 
            this.onDestroy(element, settings);
        } else {
            this.offDestroy(element, settings);
        }
    }

    /**
     * Execute destory event handler when the onoff option is true
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.doInitializeDestroy = function(element, settings) {
        if ( settings.onoff.destroy ) { 
            this.onDestroy(element, settings);
        } else {
            this.offDestroy(element, settings);
        }
    }

    /**
     * Execute destory event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.doDestroy = function(element, settings) {
        $(element).trigger('destroy.NkDialog', [element, settings]);
    }

    /**
     * Attach destory event handler
     * @public
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.onDestroy = function(element, settings) {

        this.offOpenDestroy(element, settings);
        this.offCloseDestroy(element, settings);

        this.offResizeAndOrientationchange(element, settings);
        this.offInitialize(element, settings);
        this.offInitialized(element, settings);
        this.offDestroy(element, settings);

        this.removeDialogElement(element, settings);

        if ( typeof settings.on.destroy == 'function' ) {
            settings.on.destroy(e, element, settings);
        }

    }

    /**
     * Remove destory event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.offDestroy = function(element, settings) {
        $(element).off('destroy.NkDialog');
    }





    /**
     * Execute open event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.doOpen = function(element, settings) {
        if ( settings.onoff.click ) { 
            this.onOpen(element, settings);
        } else {
            this.offOpen(element, settings);
            $(element).addClass('disabled');
        }
    }

    /**
     * Attach open event handler
     * @public
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.onOpen = function(element, settings) {
        var core = this;

        $(element).on('click.NkDialog.open', {element:element, settings:settings}, function(e, el, opts){
            e = e || window.event;

            var el = e.data.element, opts = e.data.settings;

            if ( opts.onoff.delegate == '' || opts.onoff.preventDefault ) {
                e.preventDefault();
            } else {
                e.stopPropagation();
                if ( $(e.target).is(opts.onoff.delegate) ) {
                    return;
                }                    
            }

            core.createDialogElement(el, opts);
            core.addBodyClass(el, opts);
            core.opSize(el, opts);
            
            core.onOpenAnimation(el, opts);
            core.doOpenAnimation(el, opts);
            core.offOpenAnimation(el, opts);

            core.onResizeAndOrientationchange(el, opts);
            core.doResizeAndOrientationchange(el, opts);

            core.doClose(el, opts);

            if ( typeof opts.on.open === 'function' ) {
                opts.on.open(e, el, opts);
            }

        });

    }

    /**
     * Remove open event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.offOpen = function(element, settings) {
        $(element).off('click.NkDialog.open');
    }

    /**
     * Remove open event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.offOpenDestroy = function(element, settings) {
        this.offOpenAnimation(element, settings);
        this.offOpen(element, settings);
    }





    /**
     * Add body class
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.addBodyClass = function(element, settings) {
        if ( settings.scroll.fixed ) {
            $('body').addClass(settings.classes.fixed);
        }
        $('body').addClass(settings.classes.opened);
    }

    /**
     * Remove body class
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.removeBodyClass = function(element, settings) {
        if ( settings.scroll.fixed ) {
            $('body').removeClass(settings.classes.fixed);
        }
        $('body').removeClass(settings.classes.opened);
    }





    /**
     * Execute openAnimation
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.doOpenAnimation = function(element, settings) {
        this.doOpenAnimate(element, settings);
        this.doOpenStepAnimate(element, settings);
        this.doOpenProgressAnimate(element, settings);
        this.doOpenCompleteAnimate(element, settings);
        this.doOpenStartAnimate(element, settings);
        this.doOpenDoneAnimate(element, settings);
        this.doOpenFailAnimate(element, settings);
        this.doOpenAlwaysAnimate(element, settings);
    }

    /**
     * Attach openAnimation
     * @public
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.onOpenAnimation = function(element, settings) {
        this.onOpenAnimate(element, settings);
        this.onOpenStepAnimate(element, settings);
        this.onOpenProgressAnimate(element, settings);
        this.onOpenCompleteAnimate(element, settings);
        this.onOpenStartAnimate(element, settings);
        this.onOpenDoneAnimate(element, settings);
        this.onOpenFailAnimate(element, settings);
        this.onOpenAlwaysAnimate(element, settings);
    }

    /**
     * Remove openAnimation
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.offOpenAnimation = function(element, settings) {
        this.offOpenAnimate(element, settings);
        this.offOpenStepAnimate(element, settings);
        this.offOpenProgressAnimate(element, settings);
        this.offOpenCompleteAnimate(element, settings);
        this.offOpenStartAnimate(element, settings);
        this.offOpenDoneAnimate(element, settings);
        this.offOpenFailAnimate(element, settings);
        this.offOpenAlwaysAnimate(element, settings);
    }





    /**
     * Execute openAnimate event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.doOpenAnimate = function(element, settings) {
        $(element).trigger('openAnimate.NkDialog', [element, settings]);
    }

    /**
     * Attach openAnimate event handler
     * @public
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.onOpenAnimate = function(element, settings) {
        var core = this;

        $(element).on('openAnimate.NkDialog', {element:element, settings:settings}, function(e, el, opts) {
            var ids = getObjValById(opts.ids);
            
            switch(opts.animate.effect) {
                case '':
                    $(ids.container).css({'opacity':'1','visibility':'visible'});
                    break;
                case 'fade':
                    $(ids.container).css({'opacity':'0','visibility':'hidden'})
                    .stop().animate({ opacity: 1 }, {
                        duration: opts.animate.duration,
                        start: function() {
                            core.doOpenStartAnimate(el, opts);
                        },
                        step: function() {
                            core.doOpenStepAnimate(el, opts);
                        },
                        progress: function() {
                            core.doOpenProgressAnimate(el, opts);
                        },
                        done: function() {
                            core.doOpenDoneAnimate(el, opts);
                        },
                        complete: function() {
                            core.doOpenCompleteAnimate(el, opts);
                        },
                        fail: function() {
                            core.doOpenFailAnimate(el, opts);
                        },
                        always: function() {
                            core.doOpenAlwaysAnimate(el, opts);
                        }
                    });
                    break;
            }
            
            if ( typeof opts.on.openAnimate === 'function' ) {
                opts.on.openAnimate(e, el, opts);
            }

        });

    }

    /**
     * Remove openAnimate event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.offOpenAnimate = function(element, settings) {
        $(element).off('openAnimate.NkDialog');
    }






    /**
     * Execute openStartAnimate event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.doOpenStartAnimate = function(element, settings) {
        $(element).trigger('openStartAnimate.NkDialog', [element, settings]);
    }

    /**
     * Attach openStartAnimate event handler
     * @public
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.onOpenStartAnimate = function(element, settings) {
        $(element).on('openStartAnimate.NkDialog', {element:element, settings:settings}, function(e, el, opts) {
            var ids = getObjValById(opts.ids);
            switch(opts.animate.effect) {
                case 'fade':
                    $(ids.container).css({'visibility':'visible'});
                    break;
            }
            if ( typeof opts.on.openStartAnimate === 'function' ) {
                opts.on.openStartAnimate(e, el, opts);
            }
        });
    }

    /**
     * Remove openStartAnimate event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.offOpenStartAnimate = function(element, settings) {
        $(element).off('openStartAnimate.NkDialog');
    }






    /**
     * Execute openStepAnimate event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.doOpenStepAnimate = function(element, settings) {
        $(element).trigger('openStepAnimate.NkDialog', [element, settings]);
    }

    /**
     * Attach openStepAnimate event handler
     * @public
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.onOpenStepAnimate = function(element, settings) {
        $(element).on('openStepAnimate.NkDialog', {element:element, settings:settings}, function(e, el, opts) {
            if ( typeof opts.on.openStepAnimate === 'function' ) {
                opts.on.openStepAnimate(e, el, opts);
            }
        });
    }

    /**
     * Remove openStepAnimate event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.offOpenStepAnimate = function(element, settings) {
        $(element).off('openStepAnimate.NkDialog');
    }





    /**
     * Execute openProgressAnimate event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.doOpenProgressAnimate = function(element, settings) {
        $(element).trigger('openProgressAnimate.NkDialog', [element, settings]);
    }

    /**
     * Attach openProgressAnimate event handler
     * @public
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.onOpenProgressAnimate = function(element, settings) {
        $(element).on('openProgressAnimate.NkDialog', {element:element, settings:settings}, function(e, el, opts) {
            if ( typeof opts.on.openProgressAnimate === 'function' ) {
                opts.on.openProgressAnimate(e, el, opts);
            }
        });
    }

    /**
     * Remove openProgressAnimate event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.offOpenProgressAnimate = function(element, settings) {
        $(element).off('openProgressAnimate.NkDialog');
    }






    /**
     * Execute openDoneAnimate event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.doOpenDoneAnimate = function(element, settings) {
        $(element).trigger('openDoneAnimate.NkDialog', [element, settings]);
    }

    /**
     * Attach openDoneAnimate event handler
     * @public
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.onOpenDoneAnimate = function(element, settings) {
        $(element).on('openDoneAnimate.NkDialog', {element:element, settings:settings}, function(e, el, opts) {
            if ( typeof opts.on.openDoneAnimate === 'function' ) {
                opts.on.openDoneAnimate(e, el, opts);
            }
        });
    }

    /**
     * Remove openDoneAnimate event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.offOpenDoneAnimate = function(element, settings) {
        $(element).off('openDoneAnimate.NkDialog');
    }






    /**
     * Execute openCompleteAnimate event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.doOpenCompleteAnimate = function(element, settings) {
        $(element).trigger('openCompleteAnimate.NkDialog', [element, settings]);
    }

    /**
     * Attach openCompleteAnimate event handler
     * @public
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.onOpenCompleteAnimate = function(element, settings) {
        $(element).on('openCompleteAnimate.NkDialog', {element:element, settings:settings}, function(e, el, opts) {
            if ( typeof opts.on.openCompleteAnimate === 'function' ) {
                opts.on.openCompleteAnimate(e, el, opts);
            }
        });
    }

    /**
     * Remove openCompleteAnimate event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.offOpenCompleteAnimate = function(element, settings) {
        $(element).off('openCompleteAnimate.NkDialog');
    }





    /**
     * Execute openFailAnimate event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.doOpenFailAnimate = function(element, settings) {
        $(element).trigger('openFailAnimate.NkDialog', [element, settings]);
    }

    /**
     * Attach openFailAnimate event handler
     * @public
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.onOpenFailAnimate = function(element, settings) {
        $(element).on('openFailAnimate.NkDialog', {element:element, settings:settings}, function(e, el, opts) {
            if ( typeof opts.on.openFailAnimate === 'function' ) {
                opts.on.openFailAnimate(e, el, opts);
            }
        });
    }

    /**
     * Remove openFailAnimate event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.offOpenFailAnimate = function(element, settings) {
        $(element).off('openFailAnimate.NkDialog');
    }





    /**
     * Execute openAlwaysAnimate event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.doOpenAlwaysAnimate = function(element, settings) {
        $(element).trigger('openAlwaysAnimate.NkDialog', [element, settings]);
    }

    /**
     * Attach openAlwaysAnimate event handler
     * @public
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.onOpenAlwaysAnimate = function(element, settings) {
        $(element).on('openAlwaysAnimate.NkDialog', {element:element, settings:settings}, function(e, el, opts) {
            if ( typeof opts.on.openAlwaysAnimate === 'function' ) {
                opts.on.openAlwaysAnimate(e, el, opts);
            }
        });
    }

    /**
     * Remove openAlwaysAnimate event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.offOpenAlwaysAnimate = function(element, settings) {
        $(element).off('openAlwaysAnimate.NkDialog');
    }





    /**
     * Execute close event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.doClose = function(element, settings) {
        this.onClose(element, settings);
    }

    /**
     * Attach close event handler
     * @public
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.onClose = function(element, settings) {
        var core = this,
            ids = getObjValById(settings.ids),
            target = [ids.bg, ids.close].join();

        $(target).on('click.NkDialog.close', {element:element, settings:settings}, function(e){
            e = e || window.e;
            e.preventDefault();

            var el = e.data.element, opts = e.data.settings;

            core.onCloseAnimation(el, opts);
            core.doCloseAnimation(el, opts);
            core.offCloseAnimation(el, opts);

            core.offResizeAndOrientationchange(el, opts);
            core.removeBodyClass(el, opts);

            if ( typeof opts.on.close === 'function' ) {
                opts.on.close(e, el, opts);
            }
        });
    }

    /**
     * Remove close event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.offClose = function(element, settings) {
        $(element).off('click.NkDialog.close');
    }

    /**
     * Remove close event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.offCloseDestroy = function(element, settings) {
        this.offCloseAnimation(element, settings);
        this.offResizeAndOrientationchange(element, settings);
        this.offClose(element, settings);
        this.removeBodyClass(element, settings);
    }



    /**
     * Execute closeAnimation
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.doCloseAnimation = function(element, settings) {
        this.doCloseAnimate(element, settings);
        this.doCloseStartAnimate(element, settings);
        this.doCloseStepAnimate(element, settings);
        this.doCloseProgressAnimate(element, settings);
        this.doCloseDoneAnimate(element, settings);
        this.doCloseCompleteAnimate(element, settings);
        this.doCloseFailAnimate(element, settings);        
        this.doCloseAlwaysAnimate(element, settings);
    }

    /**
     * Attach closeAnimation
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.onCloseAnimation = function(element, settings) {
        this.onCloseAnimate(element, settings);
        this.onCloseStartAnimate(element, settings);
        this.onCloseStepAnimate(element, settings);
        this.onCloseProgressAnimate(element, settings);
        this.onCloseDoneAnimate(element, settings);
        this.onCloseCompleteAnimate(element, settings);
        this.onCloseFailAnimate(element, settings);        
        this.onCloseAlwaysAnimate(element, settings);
    }

    /**
     * Remove closeAnimation
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.offCloseAnimation = function(element, settings) {
        this.offCloseAnimate(element, settings);
        this.offCloseStartAnimate(element, settings);
        this.offCloseStepAnimate(element, settings);
        this.offCloseProgressAnimate(element, settings);
        this.offCloseDoneAnimate(element, settings);
        this.offCloseCompleteAnimate(element, settings);
        this.offCloseFailAnimate(element, settings);
        this.offCloseAlwaysAnimate(element, settings);
    }





    /**
     * Execute closeAnimate event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.doCloseAnimate = function(element, settings) {
        $(element).trigger('closeAnimate.NkDialog', [element, settings]);
    }

    /**
     * Attach closeAnimate event handler
     * @public
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.onCloseAnimate = function(element, settings) {
        var core = this;
        $(element).on('closeAnimate.NkDialog', {element:element, settings:settings}, function(e, el, opts) {
            var ids = getObjValById(opts.ids);
            switch(opts.animate.effect) {
                case '':
                    $(ids.container).css({'opacity':'0','visibility':'hidden'});
                    core.removeDialogElement(el, opts);
                    break;
                case 'fade':
                    $(ids.container)
                    .css({'opacity':'1','visibility':'visible'})
                    .stop().animate({ opacity: 0 }, {
                        duration: opts.animate.duration,
                        start: function() {
                            core.doCloseStartAnimate(el, opts);
                            // console.log('start');
                        },
                        step: function() {
                            core.doCloseStepAnimate(el, opts);
                            // console.log('step');
                        },
                        progress: function() {
                            core.doCloseProgressAnimate(el, opts);
                            // console.log('progress');
                        },
                        done: function() {
                            core.doCloseDoneAnimate(el, opts);
                            // console.log('done');
                        },
                        complete: function() {
                            core.doCloseCompleteAnimate(el, opts);
                            // console.log('complete');
                        },
                        fail: function() {
                            core.doCloseFailAnimate(el, opts);
                            // console.log('fail');
                        },
                        always: function() {
                            core.doCloseAlwaysAnimate(el, opts);
                            // console.log('always');
                        }
                    });
                    break;
            }
            if ( typeof opts.on.closeAnimate === 'function' ) {
                opts.on.closeAnimate(e, el, opts);
            }
        });
    }

    /**
     * Remove closeAnimate event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.offCloseAnimate = function(element, settings) {
        $(element).off('closeAnimate.NkDialog');
    }






    /**
     * Execute closeStartAnimate event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.doCloseStartAnimate = function(element, settings) {
        $(element).trigger('closeStartAnimate.NkDialog', [element, settings]);
    }

    /**
     * Attach closeStartAnimate event handler
     * @public
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.onCloseStartAnimate = function(element, settings) {
        $(element).on('closeStartAnimate.NkDialog', {element:element, settings:settings}, function(e, el, opts) {
            if ( typeof opts.on.closeStartAnimate === 'function' ) {
                opts.on.closeStartAnimate(e, el, opts);
            }
        });
    }

    /**
     * Remove closeStartAnimate event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.offCloseStartAnimate = function(element, settings) {
        $(element).off('closeStartAnimate.NkDialog');
    }





    /**
     * Execute closeStepAnimate event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.doCloseStepAnimate = function(element, settings) {
        $(element).trigger('closeStepAnimate.NkDialog', [element, settings]);
    }

    /**
     * Attach closeStepAnimate event handler
     * @public
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.onCloseStepAnimate = function(element, settings) {
        $(element).on('closeStepAnimate.NkDialog', {element:element, settings:settings}, function(e, el, opts) {
            if ( typeof opts.on.closeStepAnimate === 'function' ) {
                opts.on.closeStepAnimate(e, el, opts);
            }
        });
    }

    /**
     * Remove closeStepAnimate event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.offCloseStepAnimate = function(element, settings) {
        $(element).off('closeStepAnimate.NkDialog');
    }






    /**
     * Execute closeProgressAnimate event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.doCloseProgressAnimate = function(element, settings) {
        $(element).trigger('closeProgressAnimate.NkDialog', [element, settings]);
    }

    /**
     * Attach closeProgressAnimate event handler
     * @public
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.onCloseProgressAnimate = function(element, settings) {
        $(element).on('closeProgressAnimate.NkDialog', {element:element, settings:settings}, function(e, el, opts) {
            if ( typeof opts.on.closeProgressAnimate === 'function' ) {
                opts.on.closeProgressAnimate(e, el, opts);
            }
        });
    }

    /**
     * Remove closeProgressAnimate event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.offCloseProgressAnimate = function(element, settings) {
        $(element).off('closeProgressAnimate.NkDialog');
    }





    /**
     * Execute closeDoneAnimate event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.doCloseDoneAnimate = function(element, settings) {
        $(element).trigger('closeDoneAnimate.NkDialog', [element, settings]);
    }

    /**
     * Attach closeDoneAnimate event handler
     * @public
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.onCloseDoneAnimate = function(element, settings) {
        $(element).on('closeDoneAnimate.NkDialog', {element:element, settings:settings}, function(e, el, opts) {
            if ( typeof opts.on.closeDoneAnimate === 'function' ) {
                opts.on.closeDoneAnimate(e, el, opts);
            }
        });
    }

    /**
     * Remove closeDoneAnimate event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.offCloseDoneAnimate = function(element, settings) {
        $(element).off('closeDoneAnimate.NkDialog');
    }






    /**
     * Execute closeCompleteAnimate event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.doCloseCompleteAnimate = function(element, settings) {
        $(element).trigger('closeCompleteAnimate.NkDialog', [element, settings]);
    }

    /**
     * Attach closeCompleteAnimate event handler
     * @public
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.onCloseCompleteAnimate = function(element, settings) {
        $(element).on('closeCompleteAnimate.NkDialog', {element:element, settings:settings}, function(e, el, opts) {
            if ( typeof opts.on.closeCompleteAnimate === 'function' ) {
                opts.on.closeCompleteAnimate(e, el, opts);
            }
        });
    }

    /**
     * Remove closeCompleteAnimate event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.offCloseCompleteAnimate = function(element, settings) {
        $(element).off('closeCompleteAnimate.NkDialog');
    }






    /**
     * Execute closeFailAnimate event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.doCloseFailAnimate = function(element, settings) {
        $(element).trigger('closeFailAnimate.NkDialog', [element, settings]);
    }

    /**
     * Attach closeFailAnimate event handler
     * @public
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.onCloseFailAnimate = function(element, settings) {
        $(element).on('closeFailAnimate.NkDialog', {element:element, settings:settings}, function(e, el, opts) {
            if ( typeof opts.on.closeFailAnimate === 'function' ) {
                opts.on.closeFailAnimate(e, el, opts);
            }
        });
    }

    /**
     * Remove closeFailAnimate event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.offCloseFailAnimate = function(element, settings) {
        $(element).off('closeFailAnimate.NkDialog');
    }





    /**
     * Execute closeAlwaysAnimate event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.doCloseAlwaysAnimate = function(element, settings) {
        $(element).trigger('closeAlwaysAnimate.NkDialog', [element, settings]);
    }

    /**
     * Attach closeAlwaysAnimate event handler
     * @public
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.onCloseAlwaysAnimate = function(element, settings) {
        var core = this;
        $(element).on('closeAlwaysAnimate.NkDialog', {element:element, settings:settings}, function(e, el, opts) {
            var timer = null, delta = opts.animate.duration;
            var run = function() {
                // remove element always after finish animation
                core.removeDialogElement(el, opts);
            };
            clearTimeout(timer);
            timer = setTimeout(run, delta);
            if ( typeof opts.on.closeAlwaysAnimate === 'function' ) {
                opts.on.closeAlwaysAnimate(e, el, opts);
            }
        });
    }

    /**
     * Remove closeAlwaysAnimate event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.offCloseAlwaysAnimate = function(element, settings) {
        $(element).off('closeAlwaysAnimate.NkDialog');
    }






    /**
     * Execute resize and orientationchange event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.doResizeAndOrientationchange = function(element, settings) {
        if ( settings.onoff.orientationchange ) { 
            this.doOrientationchange(element, settings);
        } else if( settings.onoff.resized ) {
            this.doResized(element, settings);
        } else if( settings.onoff.resize ) {
            this.doResize(element, settings);
        }
    }

    /**
     * Attach resize and orientationchange event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.onResizeAndOrientationchange = function(element, settings) {
        this.onResize(element, settings);
        this.onResized(element, settings);
        this.onOrientationchange(element, settings);
    }

    /**
     * Remove resize and orientationchange event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.offResizeAndOrientationchange = function(element, settings) {
        this.offOrientationchange(element, settings);
        this.offResized(element, settings);
        this.offResize(element, settings);
    }





    /**
     * Execute resize event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.doResize = function(element, settings) {
        this.onResize(element, settings);
    }

    /**
     * Attach resize event handler
     * @public
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.onResize = function(element, settings) {
        var core = this, timer = null, delta = 0, el, opts;
        var run = function(e) {
            el = e.data.element, opts = e.data.settings;
            core.doSize(el, opts);
            if ( typeof opts.on.resize === 'function' ) {
                opts.on.resize(e, el, opts);
            }
        };
        $(window).on('resize.NkDialog', {element:element, settings:settings}, function(e) {
            clearTimeout(timer);
            timer = setTimeout(run(e), delta);
        });
    }

    /**
     * Remove resize event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.offResize = function(element, settings) {
        $(window).off('resize.NkDialog');
    }





    /**
     * Execute resized event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.doResized = function(element, settings) {
        this.onResized(element, settings);
    }

    /**
     * Attach resized event handler
     * @public
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.onResized = function(element, settings) {
        var core = this, timer = null, delta = 0, el, opts;
        var run = function(e) {
            el = e.data.element, opts = e.data.settings;
            core.doSize(el, opts);
            if ( typeof opts.on.resize === 'function' ) {
                opts.on.resize(e, el, opts);
            }
        };
        $(window).on('resize.NkDialog.resized', {element:element, settings:settings}, function(e) {
            clearTimeout(timer);
            timer = setTimeout(run(e), delta);
        });
    }

    /**
     * Remove resized event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.offResized = function(element, settings) {
        $(window).off('resize.NkDialog.resized');
    }





    /**
     * Execute orientationchange event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.doOrientationchange = function(element, settings) {
        this.onOrientationchange(element, settings);
    }

    /**
     * Attach orientationchange event handler
     * @public
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.onOrientationchange = function(element, settings) {
        var core = this, timer = null, delta = 0, el, opts;
        var run = function(e) {
            el = e.data.element, opts = e.data.settings;
            // Calcute dialog size
            core.doSize(el, opts);
            // Add callback method
            if ( typeof opts.on.resize === 'function' ) {
                opts.on.resize(e, el, opts);
            }
        };
        $(window).on('orientationchange.NkDialog', {element:element, settings:settings}, function(e) {
            clearTimeout(timer);
            timer = setTimeout(run(e), delta);
        });
    }

    /**
     * Remove orientationchange event handler
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.offOrientationchange = function(element, settings) {
        $(window).off('orientationchange.NkDialog');
    }





    /**
     * Execute opSize method
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.doSize = function(element, settings) {
        this.opSize(element, settings);
    }


    /**
     * Calculate dialog size
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.opSize = function(element, settings) {
        this.doFullSize(element, settings);
        this.doFullWidth(element, settings);
        this.doFullHeight(element, settings);
    }


    /**
     * Execute the opFullSize method when the fullSize option is true
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.doFullSize = function(element, settings) {
        if ( !settings.size.fullSize ) { return; }
        this.opFullSize(element, settings);
    }


    /**
     * Calculate dialog fullSize
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.opFullSize = function(element, settings) {
        this.opFullWidth(element, settings);
        this.opFullHeight(element, settings);
    }


    /**
     * Execute the opFullWidth method when the fullWidth option is true
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.doFullWidth = function(element, settings) {
        if ( !settings.size.fullWidth ) { return; }
        this.opFullWidth(element, settings);
    }


    /**
     * Calculate Dialog fullWidth
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.opFullWidth = function(element, settings) {
        var ids = getObjValById(settings.ids);
        $(ids.wrapper).css('maxWidth', $(window).width());
    }


    /**
     * Execute the opFullHeight method when the fullHeight option is true
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.doFullHeight = function(element, settings) {
        if ( !settings.size.fullHeight ) { return; }
        this.opFullHeight(element, settings);
    }


    /**
     * Calculate Dialog fullHeight
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.opFullHeight = function(element, settings) {
        var ids = getObjValById(settings.ids);
        $(ids.content).css('maxHeight', $(window).height()
            - parseInt($(ids.header).outerHeight())
            - parseInt($(ids.footer).outerHeight())
            - parseInt($(ids.wrapper).css('padding-top'))
            - parseInt($(ids.wrapper).css('padding-bottom'))
            - parseInt($(ids.section).css('padding-top'))
            - parseInt($(ids.section).css('padding-bottom'))
        );
    }





    /**
     * Create the dialog element
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.createDialogElement = function(element, settings) {
        var _classes = settings.classes,
            _close = settings.close,
            _bg = settings.bg,
            _size = settings.size,
            _display = settings.display,
            _ids = settings.ids,
            ids = getObjValById(_ids);

        var doc_class  = '';
            doc_class += 'class="';
                doc_class += (_classes.skin == '') ? '' : _classes.skin;
                doc_class += (_close.offset == 'outer') ? ' outer' : ' inner';
                doc_class += (_bg.disabled) ? ' bg-disabled' : '';
                doc_class += (_size.fullSize) ? ' full-size' : '';
                doc_class += (_size.fullWidth) ? ' full-width' : '';
                doc_class += (_size.fullHeight) ? ' full-height' : '';
            doc_class += '"';

        var max_w = '';
            max_w += 'style="';
                max_w += (_size.maxWidth == '') ? '' : 'max-width:'+ _size.maxWidth +';';
            max_w += '"';

        var html = '';
        html += '<div id="'+ _ids.container +'" '+ doc_class +'>';
            html += this.createDialogBg(element, settings);
            html += (settings.close.offset == 'outer') ? this.createDialogClose(element, settings) : '';
            html += '<div id="'+ _ids.wrapper +'" '+ max_w +'>';
                html += '<div id="'+ _ids.section +'">';
                    html += (_close.offset == 'inner') ? this.createDialogClose(element, settings) : '';
                    html += '<div id="'+ _ids.wrap +'">';
                        html += (_display.header) ? this.createDialogHeader(element, settings) : '';
                        html += (_display.content) ? this.createDialogContent(element, settings) : '';
                        html += (_display.footer) ? this.createDialogFooter(element, settings) : '';
                    html += '</div>'; // #wrap
                html += '</div>'; // #section
            html += '</div>'; // #wrapper
        html += '</div>'; // #container


        // Add element node before closing the body tag
        if ( !$(ids.container).length ) {
            $('body').append(html);
        } else {
            $(ids.container)[0].outerHtml = html;
        }

        // Load dialog ajax content
        this.loadDialogAjaxContent(element, settings);
    }

    /**
     * Remove the dialog element
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.removeDialogElement = function(element, settings) {
        var ids = getObjValById(settings.ids);
        $(ids.container).remove();
    }

    /**
     * Create the dialog header element
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.createDialogHeader = function(element, settings) {
        var _ids = settings.ids,
            _data = settings.data,
            $target = $(element).find(settings.target.header);

        var html = '';
        html += '<header id="'+ _ids.header +'">';
            html += '<h2 id="'+ _ids.title +'">';
                html += _data.header;
                html += (!!$target.length) ? $target.html() : '';
            html += '</h2>';
        html += '</header>';

        return html;
    }

    /**
     * Create the dialog content element
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.createDialogContent = function(element, settings) {
        var _data = settings.data,
            _ids = settings.ids,
            _size = settings.size,
            $target = $(element).find(settings.target.content);
        
        var max_h = '';
            max_h += 'style="';
                max_h += (_size.maxHeight == '') ? '' : 'max-height:'+ _size.maxHeight +';';
            max_h += '"';

        var html = '';
        html += '<div id="'+ _ids.content +'" '+ max_h +'>';
            html += _data.content;
            html += (!!$target.length) ? $target.html() : $(element).html();
        html += '</div>'; // #content

        return html;
    }

    /**
     * Create the dialog footer element
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.createDialogFooter = function(element, settings) {
        var _data = settings.data,
            _ids = settings.ids,
            $target = $(element).find(settings.target.footer);
        
        var html = '';
        html += '<footer id="'+ _ids.footer +'">';
            html += _data.footer;
            html += (!!$target.length) ? $target.html() : '';
        html += '</footer>';

        return html;
    }

    /**
     * Create the dialog close element
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.createDialogClose = function(element, settings) {
        var _data = settings.data,
            _ids = settings.ids,
            $target = $(element).find(settings.target.close);

        var html = '';
        html += '<div id="'+ _ids.close +'">';
            html += _data.close;
            html += (!!$target.length) ? $target.html() : '';
        html += '</div>';

        return html;
    }

    /**
     * Create the dialog bg element
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.createDialogBg = function(element, settings) {
        var _bg = settings.bg,
            _ids = settings.ids;

        var style  = '';
            style += 'style="';
                style += (_bg.color == '') ? '' : 'background-color:'+ _bg.color +';';
                style += (_bg.image == '') ? '' : 'background:'+ _bg.image +';';
                style += (_bg.image == '') ? '' : 'background-position:center;';
                style += (_bg.image == '') ? '' : 'background-repeat:no-repeat;';
                style += (_bg.image == '') ? '' : 'background-size:cover;';
                style += (_bg.style == '') ? '' : _bg.style;
                style += (_bg.disabled) ? 'background:transparent;' : '';
            style += '"';

        var html = '';
        html += '<div id="'+ _ids.bg +'" '+ style +'></div>';
        
        return html;
    }

    /**
     * Load the dialog ajax content
     * @protect
     * @param {HTMLElement|jQuery} [element]
     * @param {Object} [options]
     */
    NkDialog.prototype.loadDialogAjaxContent = function(element, settings) {
        if (!settings.ajax.url) { return; }

        var ajax = settings.ajax;
        var max_h = $(ajax.target).css('max-height');

        $(ajax.target).css({'max-height':'1px','opacity':'0'}).load(ajax.url, function(response, status, xhr) {
            if (ajax.response) { console.log(response); }
            if (ajax.status) { console.log(status); }
            if (ajax.xhr) { console.log(xhr); }
            $(ajax.target).stop().animate({opacity:1, 'max-height':max_h}, {
                duration: 300
            });
        });

    }





    /**
     * isObjKey
     * @private
     * @param  {Object}  obj
     * @param  {string}  str
     * @return {Boolean}
     */
    function isObjKey(obj, str) {
        if ( !getObjKeyByNumeric(obj) ) { return; }
        var keys = getObjKeyByNumeric(obj);
        var regex = new RegExp(str, 'gi');
        return (!!keys.match(regex)) ? true : false;
    }

    /**
     * getObjKeyByNumeric
     * @private
     * @param  {Object} obj
     * @return {boolean | string}
     */
    function getObjKeyByNumeric(obj) {
        var keys = '';
        $.each(obj,function(i,val){
            if ( /[(?:0-9)]/gi.test(i) ) {
                keys += val;
            }
        });
        return (!!keys.length) ? keys : false;
    }

    /**
     * getObjValById
     * @private
     * @param  {Object} obj
     * @return {Object}
     */
    function getObjValById(obj) {
        var ids = {};
        $.each(obj,function(i,val){
            ids[i] = '#' + val;
        });
        return ids;
    }

    /**
     * isScreen
     * @private
     * @param  {string} screen
     * @return {Boolean}
     */
    function isScreen(screen) {
        var max_w;
        switch( screen ) {
            case 'screen' : max_w = 1920; break;
            case 'tablet' : max_w = 1023; break;
            case 'mobile' : max_w = 767; break;
        }
        if( !!window.matchMedia || !!window.msMatchMedia ){
            return window.matchMedia('(max-width:'+ max_w +'px)').matches;
        } else {
            return ($(window).width() <= max_w) ? true : false;
        }
        return max_w;
    }

    /**
     * isBrowser
     * @private
     * @param  {string}  browser
     * @return {Boolean}
     */
    function isBrowser(browser){
        switch(browser) {
            case 'chrome':
                return /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
            case 'safari':
                return /Safari/.test(navigator.userAgent) && /Apple Computer/.test(navigator.vendor);
            case 'firefox':
                return /Firefox/.test(navigator.userAgent);
            case 'opera':
                return /opera/.test(navigator.userAgent);
            case 'ie':
                return ((navigator.appName == 'Microsoft Internet Explorer') || ((navigator.appName == 'Netscape') && (new RegExp("Trident/.*rv:([0-9]{1,}[\.0-9]{0,})").exec(navigator.userAgent) !== null)));
            case 'ie8':
                return /*@cc_on @if (@_jscript_version < 9) output = true; @else output = false; @end @*/;
            case 'ie9':
                return /*@cc_on @if (@_jscript_version < 10) output = true; @else output = false; @end @*/;
        }
    }

    /**
     * isDevice
     * @private
     * @param  {string}  device
     * @return {Boolean}
     */
    function isDevice(device){
        switch(device) {
            case 'mobile':
                return (/Android|iPhone|iPad|iPod|BlackBerry|Windows Phone/i).test(navigator.userAgent || navigator.vendor || window.opera);
            case 'ios':
                return !!navigator.userAgent && /iPad|iPhone|iPod/.test(navigator.userAgent);
            case 'android':
                return ((ua.indexOf('Android') != -1) && (ua.indexOf('Mobile') != -1) && (ua.indexOf('Chrome') == -1));
            case 'SAMSUNG':
                return /SAMSUNG/i.test(navigator.userAgent);
            case 'LG':
                return /LG/i.test(navigator.userAgent);
        }
    }

    // jQuery plugin implementation
    $.fn.NkDialog = function(options) {
        return this.each(function() {
            new NkDialog(this, options);
        });
    };

    window.NkDialog = NkDialog;
})(jQuery, window, document);