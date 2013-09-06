/**
 * A super-simple DOM helper lib.
 *
 * @author Mike Botsko
 *
 * Contains methods useful for this project, built to mimic
 * jQuery - developers who are familiar with jQuery will
 * have no trouble adapting to this.
 *
 * Works with all browser versions of the past few years.
 */
simpleDOM = function( selector ){

    var _raw_selector = selector

    var _matches = [];
    if( typeof selector === "object" ){
        _matches = [selector];
    }
    if( typeof selector === "string" ){
        _matches = document.querySelectorAll(_raw_selector);
    }

    return {


        /**
         * Adds a new CSS class to each element
         *
         * @param className
         * @returns simpleDOM
         */
        addClass: function( className ){
            for( var n = 0, l = _matches.length; n < l; n++ ){
                _matches[n].className += " " + className;
            }
            return this;
        },


        /**
         * Removes a CSS class name from an element
         * @param className
         * @returns simpleDOM
         */
        removeClass: function( className ){
            var regex = new RegExp('(?:^|\\s)'+className+'(?!\\S)');
            for( var n = 0, l = _matches.length; n < l; n++ ){
                _matches[n].className = _matches[n].className.replace( regex , '' );
            }
            return this;
        },

        /**
         * Determine if an element has a CSS class name.
         *
         * @todo Only works for the first element matched by
         * the selector. Will not currently work on subsequent
         * elements
         *
         * @param className
         * @returns boolean
         */
        hasClass: function( className ){
            var regex = new RegExp('(?:^|\\s)'+className+'(?!\\S)');
            if( _matches.length >= 1 ){
                return this.get(0).className.match( regex );
            }
            return false;
        },


        /**
         * Binds eventHandler of eventType to all elements
         * matching selector.
         *
         * @param eventType
         * @param eventHandler
         * @returns simpleDOM
         */
        bind: function( eventType, eventHandler ){

            for( var n = 0, l = _matches.length; n < l; n++ ){
                var eventElem = _matches[n];
                if(eventElem.addEventListener){
                    eventElem.addEventListener(eventType, eventHandler, false);
                } else {
                    eventElem.attachEvent('on'+eventType, eventHandler);
                }
            }
            return this;
        },


        /**
         * Unbinds an event from all elements matching selector.
         *
         * @param eventType
         * @param eventHandler
         * @returns {*}
         */
        unbind: function( eventType, eventHandler ){

            for( var n = 0, l = _matches.length; n < l; n++ ){
                var eventElem = _matches[n];
                if(eventElem.removeEventListener){
                    eventElem.removeEventListener(eventType, eventHandler, false);
                } else {
                    eventElem.detachEvent('on'+eventType, eventHandler);
                }
            }
            return this;
        },


        /**
         * Set css attribute values
         *
         * @param att
         * @param val
         * @returns simpleDOM
         */
        css: function( att, val ){
            for( var n = 0, l = _matches.length; n < l; n++ ){
                _matches[n].style[att] = val;
            }
            return this;
        },

        getCss: function(attr){
            return this.get(0).style[attr];
        },

        /**
         * Get the inner HTML of an object
         * @returns innerHTML
         */
        html: function(){
            return this.get(0).innerHTML;
        },

        setHtml: function(html){
            for( var n = 0, l = _matches.length; n < l; n++){
                _matches[n].innerHTML = html;
            }
        },


        /**
         * Short-cut for hiding an element
         *
         * @returns simpleDOM
         */
        hide: function(){
            this.css('display', 'none');
            return this;
        },


        /**
         * Short-cut for showing a hidden element
         *
         * @returns simpleDOM
         */
        show: function(){
            this.css('display', 'block');
            return this;
        },


        /**
         * Add a new HTML attribute attr with value val
         *
         * @param attr
         * @param val
         * @returns simpleDOM
         */
        addAttr: function( attr, val ){
            for( var n = 0, l = _matches.length; n < l; n++ ){
                var newAttr = document.createAttribute(attr);
                newAttr.value = val;
                _matches[n].setAttributeNode(newAttr)
            }
            return this;
        },


        /**
         * Returns the current value of an HTML attribute
         *
         * @param attr
         * @returns {string}
         */
        attr: function( attr ){
            return this.get(0).getAttribute(attr);
        },


        /**
         * Removes an HTML attribute
         * @param attr
         * @returns simpleDOM
         */
        removeAttr: function( attr ){
            for( var n = 0, l = _matches.length; n < l; n++ ){
                _matches[n].removeAttribute(attr)
            }
            return this;
        },


        /**
         * Returns the direct element
         * @param k
         * @returns {*}
         */
        get: function(k){
            return _matches[k];
        },

        val: function(){
            return this.get(0).value;
        },

        setVal: function(value){
            for( var n = 0, l = _matches.length; n < l; n++){
                _matches[n].value = value;
            }
            return this;
        },

        each: function(func){
            for( var n = 0, l = _matches.length; n < l; n++ ){
                func(_matches[n]);
            }
            return this;
        },

        remove: function(){
            for (var n = 0, l = _matches.length; n < l; n++){
                _matches[n].parentNode.removeChild(_matches[n]);
            }
            return this;
        },
        after: function(html){
            var element = document.createElement('div');
            element.innerHTML = html;
            for(var n = 0, l = _matches.length; n < l; n++){
                var parent = _matches[n].parentNode;
                if (parent.lastChild == _matches[n]) {
                    parent.appendChild(element.firstChild);
                } else {
                    parent.insertBefore(element.firstChild, _matches[n].nextSibling);
                }
            }
            return this;
        },

        append: function(html){
            // This is sort of hacky. not sure how else to do this.
            var element = document.createElement('div');
            element.innerHTML = html;
            for(var n = 0, l = _matches.length; n < l; n++){
                _matches[n].appendChild(element.firstChild);
            }
            return this;
        }
    }
};

//TODO .after(), .remove()

// function stopPropagation( e ){
//     if (!e) var e = window.event;
//     e.cancelBubble = true;
//     if (e.stopPropagation) e.stopPropagation();
// }