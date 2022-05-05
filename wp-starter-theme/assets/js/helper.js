/*!
 *
 * PathInfo
 * getPath(path)
 * getDirpath(path)
 * getDirname(path)
 * getFilename(path)
 * getFilenameWithExtension(path)
 * getFileExtension(path)
 *
 * 
 * Detect
 * isScreen(screen)
 * isBrowser(browser)
 * isDevice(device)
 *
 * 
 * Utility
 * isObjKey(obj)
 * getObjKeyByNumeric(obj)
 * getObjVal(obj, prefix, suffix)
 * equalizeHeights()
 */
// the semi-colon before the function invocation is a safety net against concatenated 
// scripts and/or other plugins that are not closed properly
;(function ($, window, document, undefined) {
    Nk = window.Nk || {};
    Nk.help = window.Nk.help || {};

    /**
     * Get location path
     * @private
     * @param  {string} [path]
     * @return {string}
     */
    Nk.help.getPath = function(path) {
        return (!!path) ? path : window.location.pathname;;
    }

    /**
     * Get directory path
     * @private
     * @param  {string} [path]
     * @return {string}
     */
    Nk.help.getDirpath = function(path) {
        return this.getPath(path).replace(/[^\\\/]*$/, '');
    }

    /**
     * Get directory name
     * @private
     * @param  {string} [path]
     * @return {string}
     */
    Nk.help.getDirname = function(path) {
        return this.getPath(path).replace(/[\\\/][^\\\/]*$/, '').split('/').pop();
    }

    /**
     * Get file name
     * @private
     * @param  {string} [path]
     * @return {string}
     */
    Nk.help.getFilename = function(path) {
        return this.getPath(path).replace(/^.*[\\\/]/, '').split('.').shift();
    }

    /**
     * Get file name with extension
     * @private
     * @param  {string} [path]
     * @return {string}
     */
    Nk.help.getFilenameWithExtension = function(path) {
        return this.getPath(path).replace(/^.*[\\\/]/, '');
    }

    /**
     * Get file extension
     * @private
     * @param  {string} [path]
     * @return {string}
     */
    Nk.help.getFileExtension = function(path) {
        return this.getPath(path).split('.').pop();
    }






    /**
     * isScreen
     * @private
     * @param  {string} [screen]
     * @return {Boolean}
     */
    Nk.help.isScreen = function(screen) {
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
     * @param  {string} [browser]
     * @return {Boolean}
     */
    Nk.help.isBrowser = function(browser){
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
     * @param  {string} [device]
     * @return {Boolean}
     */
    Nk.help.isDevice = function(device){
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






    /**
     * is Object Key
     * @private
     * @param  {Object}  [obj]
     * @param  {string}  [str]
     * @return {Boolean}
     */
    Nk.help.isObjKey = function(obj, str) {
        if ( !this.getObjKeyByNumeric(obj) ) { return; }
        var keys = this.getObjKeyByNumeric(obj);
        var regex = new RegExp(str, 'gi');
        return (!!keys.match(regex)) ? true : false;
    }


    /**
     * Get Object Key
     * @private
     * @param  {Object} [obj]
     * @return {boolean | string}
     */
    Nk.help.getObjKeyByNumeric = function(obj) {
        var keys = '';
        $.each(obj,function(i,val){
            if ( /[(?:0-9)]/gi.test(i) ) {
                keys += val;
            }
        });
        return (!!keys.length) ? keys : false;
    }
    

    /**
     * Get Object Value
     * @private
     * @param  {Object} [obj]
     * @param  {String} [prefix]
     * @param  {String} [suffix]
     * @return {Object}
     */
    Nk.help.getObjVal = function(obj, prefix, suffix) {
        var ids = {};
        $.each(obj,function(i,val){
            ids[i] = suffix + val + suffix;
        });
        return ids;
    }

    /**
     * Equalize element heights
     * @public
     * @return {number}
     */
    Nk.help.equalizeHeights = function() {
        var maxHeight = this.map(function(i, e) {
            return $(e).height();
        }).get();
        return this.height( Math.max.apply(this, maxHeight) );
    };

})(jQuery, window, document);