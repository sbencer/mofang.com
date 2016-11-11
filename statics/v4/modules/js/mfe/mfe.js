define('mfe',[], function(require, exports, module){

    var mfe = {};

    mfe.exists = function (target) {
        return (undefined !== target);
    };

    var exists = mfe.exists;

    //*@public
    /**
        Looks for last occurrence of a string _(needle)_ inside an array or string
        _(haystack)_. An IE8-safe fallback for the default _lastIndexOf()_ method.
    */
    mfe.lastIndexOf = function (needle, haystack, index) {
        if (haystack.lastIndexOf) {
            return haystack.lastIndexOf(needle, index || haystack.length);
        }
        // in IE8 there is no lastIndexOf for arrays or strings but we
        // treat them slightly differently, this is written for minimal-
        // code as a slight tradeoff in performance but should rarely be
        // hit as it is
        var string = ("string" === typeof haystack);
        var rev = (string? haystack.split(""): haystack).reverse();
        var cap = rev.length-1;
        var len = haystack.length;
        var idx;
        // if it is a string we need to make it a string again for
        // the indexOf method
        if (string) {
            rev = rev.join("");
        }
        idx = mfe.indexOf(needle, rev, len - (index || len));
        // put the array back the way it was
        if (!string) {
            rev.reverse();
        }
        return -1 === idx? idx: (cap - idx);
    };
    var lastIndexOf = mfe.lastIndexOf;


    var uidCounter = 0;

    //*@public
    /**
        Creates a unique identifier (with an optional prefix) and returns
        the identifier as a string.
    */
    mfe.uid = function (prefix) {
        return String((prefix? prefix: "") + uidCounter++);
    };



    //* @public
    //* Returns a random integer between 0 and a specified upper boundary;
    //* i.e., 0 <= return value < _inBound_.
    //
    //      var randomLetter = String.fromCharCode(mfe.irand(26) + 97);
    //
    mfe.irand = function(inBound) {
        return Math.floor(Math.random() * inBound);
    };

    //* Returns _inString_ with the first letter capitalized.
    mfe.cap = function(inString) {
        return inString.slice(0, 1).toUpperCase() + inString.slice(1);
    };

    //* Returns _inString_ with the first letter lower-cased.
    mfe.uncap = function(inString) {
        return inString.slice(0, 1).toLowerCase() + inString.slice(1);
    };

    mfe.format = function(inVarArgs) {
        var pattern = /\%./g;
        var arg = 0, template = inVarArgs, args = arguments;
        var replacer = function(inCode) {
            return args[++arg];
        };
        return template.replace(pattern, replacer);
    };

    var toString = Object.prototype.toString;

    //* Returns true if the argument is a string.
    mfe.isString = function(it) {
        return toString.call(it) === "[object String]";
    };

    //* Returns true if the argument is a function.
    mfe.isFunction = function(it) {
        return toString.call(it) === "[object Function]";
    };

    //* Returns true if the argument is an array.
    mfe.isArray = Array.isArray || function(it) {
        return toString.call(it) === "[object Array]";
    };

    //* Returns true if the argument is an object.
    mfe.isObject = Object.isObject || function (it) {
        // explicit null/undefined check for IE8 compatibility
        return (it != null) && (toString.call(it) === "[object Object]");
    };

    //* Returns true if the argument is true.
    mfe.isTrue = function(it) {
        return !(it === "false" || it === false || it === 0 || it === null || it === undefined);
    };

    //*@public
    /**
        Returns the index of any entry in _array_ whose _callback_ returns
        a truthy value. Accepts an optional _context_ for the _callback_. Each
        _callback_ will receive three parameters, the _value_ at _index_, and an
        immutable copy of the original array. If no callback returns true, or
        _array_ is not an Array, this method returns false.
    */
    mfe.find = function (array, callback, context) {
        var $source = mfe.isArray(array) && array;
        var $ctx = context || mfe.global;
        var $fn = callback;
        var idx = 0, len, $copy, ret;
        if ($source && $fn && mfe.isFunction($fn)) {
            $copy = mfe.clone($source);
            len = $source.length;
            for (; idx < len; ++idx) {
                ret = $fn.call($ctx, $source[idx], idx, $copy);
                if (!! ret) {
                    return idx;
                }
            }
        }
        return false;
    };

    //* Returns the index of the element in _inArray_ that is equivalent
    //* (==) to _inElement_, or -1 if no such element is found.
    mfe.indexOf = function(inElement, inArray, fromIndex) {
        if (inArray.indexOf) {
            return inArray.indexOf(inElement, fromIndex);
        }

        if (fromIndex) {
            if (fromIndex < 0) {
                fromIndex = 0;
            }

            if (fromIndex > inArray.length) {
                return -1;
            }
        }

        for (var i=fromIndex || 0, l=inArray.length, e; (e=inArray[i]) || (i<l); i++) {
            if (e == inElement) {
                return i;
            }
        }
        return -1;
    };

    //* Removes the first element in the passed-in array that is equivalent
    //* (==) to _inElement_.
    mfe.remove = function(inElement, inArray) {
        var i = mfe.indexOf(inElement, inArray);
        if (i >= 0) {
            inArray.splice(i, 1);
        }
    };

    /**
        Invokes _inFunc_ on each element of _inArray_.
        If _inContext_ is specified, _inFunc_ is called with _inContext_ as _this_.
    */
    mfe.forEach = function(inArray, inFunc, inContext) {
        if (inArray) {
            var c = inContext || this;
            if (mfe.isArray(inArray) && inArray.forEach) {
                inArray.forEach(inFunc, c);
            } else {
                var a = Object(inArray);
                var al = a.length >>> 0;
                for (var i = 0; i < al; i++) {
                    if (i in a) {
                        inFunc.call(c, a[i], i, a);
                    }
                }
            }
        }
    };

    /**
        Invokes _inFunc_ on each element of _inArray_, and returns the results as an Array.
        If _inContext_ is specified, _inFunc_ is called with _inContext_ as _this_.
    */
    mfe.map = function(inArray, inFunc, inContext) {
        var c = inContext || this;
        if (mfe.isArray(inArray) && inArray.map) {
            return inArray.map(inFunc, c);
        } else {
            var results = [];
            var add = function(e, i, a) {
                results.push(inFunc.call(c, e, i, a));
            };
            mfe.forEach(inArray, add, c);
            return results;
        }
    };

    //*@public
    /**
        Concatenates a variable number of arrays, removing any duplicate
        entries.
    */
    mfe.merge = function (/* _arrays_ */) {
        var $m = Array.prototype.concat.apply([], arguments);
        var $s = [];
        for (var $i=0, v$; (v$=$m[$i]); ++$i) {
            if (!~mfe.indexOf(v$, $s)) {
                $s.push(v$);
            }
        }
        return $s;
    };
    var merge = mfe.merge;

    //*@public
    /**
        Returns an array of the values of all properties in an object.
    */
    mfe.values = function (o) {
        if (o) {
            var $r = [];
            for (var $k in o) {
                if (o.hasOwnProperty($k)) {
                    $r.push(o[$k]);
                }
            }
            return $r;
        }
    };

    //*@public
    /**
        Takes a variable number of arrays and returns an array of
        values that are unique across all of the arrays. Note that
        this is not a particularly cheap method and should never be
        called recursively.

        TODO: test in IE8
        TODO: figure out why the one-hit reversal wasn't working
    */
    mfe.union = function (/* _arrays_ */) {
        // create one large array of all of the arrays passed to
        // the method for comparison
        var values = Array.prototype.concat.apply([], arguments);
        // the array of seen values
        var seen = [];
        // the array of values actually to be returned
        var ret = [];
        var idx = 0;
        var len = values.length;
        var value;
        for (; idx < len; ++idx) {
            value = values[idx];
            // if we haven't seen this value before go ahead and
            // push it to the seen array
            if (!~mfe.indexOf(value, seen)) {
                seen.push(value);
                // here we check against the entirety of any other values
                // in the values array starting from the end
                if (idx === lastIndexOf(value, values)) {
                    // if this turned out to be true then it is a unique entry
                    // so go ahead and push it to our union array
                    ret.push(value);
                }
            }
        }
        // we should have a flattened/unique array now, return it
        return ret;
    };
    var union = mfe.union;
    //*@public
    /**
        Returns the unique values found in one or more arrays.
    */
    mfe.unique = union;
    var unique = mfe.unique;

    //*@public
    /**
        Reduces one or more arrays, removing any duplicate entries
        across them.
    */
    mfe.reduce = merge;

    //*@public
    /**
        Convenience method that takes an array of properties and an object
        as parameters. Returns a new object with just those properties named
        in the array that are found to exist on the base object. If the third
        parameter is true, falsy values will be ignored.
    */
    mfe.only = function (properties, object, ignore) {
        var ret = {};
        var idx = 0;
        var len;
        var property;
        // sanity check the properties array
        if (!exists(properties) || !(properties instanceof Array)) {
            return ret;
        }
        // sanity check the object
        if (!exists(object) || "object" !== typeof object) {
            return ret;
        }
        // reduce the properties array to just unique entries
        properties = unique(properties);
        // iterate over the properties given and if the property exists on
        // the object copy its value to the return array
        for (len = properties.length; idx < len; ++idx) {
            property = properties[idx];
            if (property in object) {
                if (true === ignore && !object[property]) {
                    continue;
                }
                ret[property] = object[property];
            }
        }
        // return the array of values we found for the given properties
        return ret;
    };

    //*@public
    /**
        Convenience method that takes two objects as parameters. For each key
        from the first object, if the key also exists in the second object, a
        mapping of the key from the first object to the key from the second
        object is added to a result object, which is eventually returned. In
        other words, the returned object maps the named properties of the
        first object to the named properties of the second object. The optional
        third parameter is a boolean designating whether to pass unknown key/value
        pairs through to the new object. If true, those keys will exist on the
        returned object.
    */
    mfe.remap = function (map, obj, pass) {
        var $key, $val, $ret = pass? mfe.clone(obj): {};
        for ($key in map) {
            $val = map[$key];
            if ($key in obj) {
                $ret[$val] = obj.get? obj.get($key): obj[$key];
            }
        }
        return $ret;
    };

    //*@public
    /**
        Convenience method that takes an array of properties and an object
        as parameters. Returns a new object with all of the keys in the
        object except those specified in the _properties_ array. The values
        are shallow copies.
    */
    mfe.except = function (properties, object) {
        // the new object to return with just the requested keys
        var ret = {};
        var keep;
        var idx = 0;
        var len;
        var key;
        // sanity check the properties array
        if (!exists(properties) || !(properties instanceof Array)) {
            return ret;
        }
        // sanity check the object
        if (!exists(object) || "object" !== typeof object) {
            return ret;
        }
        // we want to only use the union of the properties and the
        // available keys on the object
        keep = union(properties, keys(object));
        // for every property in the keep array now copy that to the new
        // hash
        for (len = keep.length; idx < len; ++idx) {
            key = keep[idx];
            // if the key was specified in the properties array but does not
            // exist in the object ignore it
            if (!(key in object)) {
                continue;
            }
            ret[key] = object[key];
        }
        // return the new hash
        return ret;
    };

    //*@public
    /**
        Helper method that accepts an array of objects and returns
        a hash of those objects indexed by the specified property. If a filter
        is provided, it should accept four parameters: the key, the value
        (object), the current mutable map reference, and an immutable
        copy of the original array of objects for comparison.
    */
    mfe.indexBy = function (property, array, filter) {
        // the return value - indexed map from the given array
        var map = {};
        var value;
        var len;
        var idx = 0;
        // sanity check for the array with an efficient native array check
        if (!exists(array) || !(array instanceof Array)) {
            return map;
        }
        // sanity check the property as a string
        if (!exists(property) || "string" !== typeof property) {
            return map;
        }
        // the immutable copy of the array
        var copy = mfe.clone(array);
        // test to see if filter actually exsits
        filter = exists(filter) && "function" === typeof filter? filter: undefined;
        for (len = array.length; idx < len; ++idx) {
            // grab the value from the array
            value = array[idx];
            // make sure that it exists and has the requested property at all
            if (exists(value) && exists(value[property])) {
                if (filter) {
                    // if there was a filter use it - it is responsible for
                    // updating the map accordingly
                    filter(property, value, map, copy);
                } else {
                    // use the default behavior - check to see if the key
                    // already exists on the map it will be overwritten
                    map[value[property]] = value;
                }
            }
        }
        // go ahead and return our modified map
        return map;
    };

    //*@public
    /**
        Expects as parameters a string, _property_, and an array of objects
        that may have the named property. Returns an array of all the values
        of the named property in the objects in the array.
    */
    mfe.pluck = function (property, array) {
        var ret = [];
        var idx = 0;
        var len;
        // if we don't have a property to look for or an array of
        // objects to search through we have to return an empty array
        if (!(exists(property) && exists(array))) {
            return ret;
        }
        // if it isn't actually an array, return an empty array
        if (!(array instanceof Array)) {
            return ret;
        }
        // if property isn't a string, then return an empty array
        if ("string" !== typeof property) {
            return ret;
        }
        // now that sanity is established to some extent, let's get
        // to work
        for (len = array.length; idx < len; ++idx) {
            // if the object in the array is actually undefined, skip
            if (!exists(array[idx])) {
                continue;
            }
            // if it was found, then check to see if the property
            // exists on it
            if (exists(array[idx][property])) {
                ret.push(array[idx][property]);
            }
        }
        // return whatever we found, if anything
        return ret;
    };

    /**
        Creates a new array with all elements of _inArray_ that pass the test
        defined by _inFunc_. If _inContext_ is specified, _inFunc_ is called
        with _inContext_ as _this_.
    */
    mfe.filter = function(inArray, inFunc, inContext) {
        var c = inContext || this;
        if (mfe.isArray(inArray) && inArray.filter) {
            return inArray.filter(inFunc, c);
        } else {
            var results = [];
            var f = function(e, i, a) {
                var eo = e;
                if (inFunc.call(c, e, i, a)) {
                    results.push(eo);
                }
            };
            mfe.forEach(inArray, f, c);
            return results;
        }
    };

    /**
        Returns an array of all own enumerable properties found on _inObject_.
    */
    mfe.keys = Object.keys || function(inObject) {
        var results = [];
        var hop = Object.prototype.hasOwnProperty;
        for (var prop in inObject) {
            if (hop.call(inObject, prop)) {
                results.push(prop);
            }
        }
        // *sigh* IE 8
        if (!({toString: null}).propertyIsEnumerable("toString")) {
            var dontEnums = [
                'toString',
                'toLocaleString',
                'valueOf',
                'hasOwnProperty',
                'isPrototypeOf',
                'propertyIsEnumerable',
                'constructor'
            ];
            for (var i = 0, p; (p = dontEnums[i]); i++) {
                if (hop.call(inObject, p)) {
                    results.push(p);
                }
            }
        }
        return results;
    };
    var keys = mfe.keys;

    /**
        Clones an existing Array, or converts an array-like object into an Array.

        If _inOffset_ is non-zero, the cloning starts from that index in the source Array.
        The clone may be appended to an existing Array by passing the existing Array as _inStartWith_.

        Array-like objects have _length_ properties, and support square-bracket notation ([]).
        Often, array-like objects do not support Array methods, such as _push_ or _concat_, and
        so must be converted to Arrays before use.

        The special _arguments_ variable is an example of an array-like object.
    */
    mfe.cloneArray = function(inArrayLike, inOffset, inStartWith) {
        var arr = inStartWith || [];
        for(var i = inOffset || 0, l = inArrayLike.length; i<l; i++){
            arr.push(inArrayLike[i]);
        }
        return arr;
    };
    mfe.toArray = mfe.cloneArray;

    /**
        Shallow-clones an object or an array.
    */
    mfe.clone = function(obj) {
        return mfe.isArray(obj) ? mfe.cloneArray(obj) : mfe.mixin({}, obj);
    };

    //* @protected
    var empty = {};

    //* @public
    /**
        Will take a variety of options to ultimately mix a set of properties
        from objects into single object. All configurations accept a boolean as
        the final parameter to indicate whether or not to ignore _truthy_/_existing_
        values on any _objects_ prior.

        If _target_ exists and is an object, it will be the base for all properties
        and the returned value. If the parameter is used but is _falsy_, a new
        object will be created and returned. If no such parameter exists, the first
        parameter must be an array of objects and a new object will be created as
        the _target_.

        The _source_ parameter may be an object or an array of objects. If no
        _target_ parameter is provided, _source_ must be an array of objects.

        The _options_ parameter allows you to set the _ignore_ and/or _exists_ flags
        such that if _ignore_ is true, it will not override any truthy values in the
        target, and if _exists_ is true, it will only use truthy values from any of
        the sources. You may optionally add a _filter_ method-option that returns a
        true or false value to indicate whether the value should be used. It receives
        parameters in this order: _property_, _source value_, _source values_,
        _target_, _options_. Note that modifying the target in the filter method can
        have unexpected results.

        Setting _options_ to true will set all options to true.
    */
    mfe.mixin = function(target, source, options) {
        // the return object/target
        var t;
        // the source or sources to use
        var s;
        var o, i, n, s$;
        if (mfe.isArray(target)) {
            t = {};
            s = target;
            if (source && mfe.isObject(source)) {
                o = source;
            }
        } else {
            t = target || {};
            s = source;
            o = options;
        }
        if (!mfe.isObject(o)) {
            o = {};
        }
        if (true === options) {
            o.ignore = true;
            o.exists = true;
        }
        // here we handle the array of sources
        if (mfe.isArray(s)) {
            for (i=0; (s$=s[i]); ++i) {
                mfe.mixin(t, s$, o);
            }
        } else {
        // otherwise we execute singularly
            for (n in s) {
                s$ = s[n];
                if (empty[n] !== s$) {
                    if ((!o.exists || s$) && (!o.ignore || !t[n]) && (o.filter && mfe.isFunction(o.filter)? o.filter(n, s$, s, t, o): true)) {
                        t[n] = s$;
                    }
                }
            }
        }
        return t;
    };

    //* @public
    /**
        Returns a function closure that will call (and return the value of)
        function _method_, with _scope_ as _this_.

        _method_ may be a function or the string name of a function-valued
        property on _scope_.

        Arguments to the closure are passed into the bound function.

            // a function that binds this to this.foo
            var fn = mfe.bind(this, "foo");
            // the value of this.foo(3)
            var value = fn(3);

        Optionally, any number of arguments may be prefixed to the bound function.

            // a function that binds this to this.bar, with arguments ("hello", 42)
            var fn = mfe.bind(this, "bar", "hello", 42);
            // the value of this.bar("hello", 42, "goodbye");
            var value = fn("goodbye");

        Functions may be bound to any scope.

            // binds function 'bar' to scope 'foo'
            var fn = mfe.bind(foo, bar);
            // the value of bar.call(foo);
            var value = fn();
    */
    mfe.bind = function(scope, method/*, bound arguments*/){
        if (!method) {
            method = scope;
            scope = null;
        }
        scope = scope || mfe.global;
        if (mfe.isString(method)) {
            if (scope[method]) {
                method = scope[method];
            } else {
                throw('mfe.bind: scope["' + method + '"] is null (scope="' + scope + '")');
            }
        }
        if (mfe.isFunction(method)) {
            var args = mfe.cloneArray(arguments, 2);
            if (method.bind) {
                return method.bind.apply(method, [scope].concat(args));
            } else {
                return function() {
                    var nargs = mfe.cloneArray(arguments);
                    // invoke with collected args
                    return method.apply(scope, args.concat(nargs));
                };
            }
        } else {
            throw('mfe.bind: scope["' + method + '"] is not a function (scope="' + scope + '")');
        }
    };

    //*@public
    /**
        Binds a callback to a scope.  If the object has a "destroyed" property that's truthy,
        then the callback will not be run if called.  This can be used to implement both
        mfe.Object.bindSafely and for mfe.Object-like objects like mfe.Model and mfe.Collection.
    */
    mfe.bindSafely = function(scope, method/*, bound arguments*/) {
        if (mfe.isString(method)) {
            if (scope[method]) {
                method = scope[method];
            } else {
                throw('mfe.bindSafely: scope["' + method + '"] is null (this="' + this + '")');
            }
        }
        if (mfe.isFunction(method)) {
            var args = mfe.cloneArray(arguments, 2);
            return function() {
                if (scope.destroyed) {
                    return;
                }
                var nargs = mfe.cloneArray(arguments);
                return method.apply(scope, args.concat(nargs));
            };
        } else {
            throw('mfe.bindSafely: scope["' + method + '"] is not a function (this="' + this + '")');
        }
    };


    /**
        Calls method _inMethod_ on _inScope_ asynchronously.

        Uses _window.setTimeout_ with minimum delay, usually around 10ms.

        Additional arguments are passed to _inMethod_ when it is invoked.
    */
    mfe.asyncMethod = function(inScope, inMethod/*, inArgs*/) {
        return setTimeout(mfe.bind.apply(mfe, arguments), 1);
    };

    /**
        Calls named method _inMethod_ (String) on _inObject_ with optional
        arguments _inArguments_ (Array), if the object and method exist.

            mfe.call(myWorkObject, "doWork", [3, "foo"]);
    */
    mfe.call = function(inObject, inMethod, inArguments) {
        var context = inObject || this;
        if (inMethod) {
            var fn = context[inMethod] || inMethod;
            if (fn && fn.apply) {
                return fn.apply(context, inArguments || []);
            }
        }
    };

    /**
        Returns the current time.

        The returned value is equivalent to _new Date().getTime()_.
    */
    mfe.now = Date.now || function() {
        return new Date().getTime();
    };

    //* @protected

    mfe.nop = function(){};
    mfe.nob = {};
    mfe.nar = [];

    // this name is reported in inspectors as the type of objects created via delegate,
    // otherwise we would just use mfe.nop
    mfe.instance = function() {};

    // some platforms need alternative syntax (e.g., when compiled as a v8 builtin)
    if (!mfe.setPrototype) {
        mfe.setPrototype = function(ctor, proto) {
            ctor.prototype = proto;
        };
    }

    // boodman/crockford delegation w/cornford optimization
    mfe.delegate = function(proto) {
        mfe.setPrototype(mfe.instance, proto);
        return new mfe.instance();
    };

    //* @public
    /**
        Takes a string and trims leading and trailing spaces. If the string
        has no length, is not a string, or is a falsy value, it will be returned
        without modification.
    */
    mfe.trim = function (str) {
        return str && str.replace? (str.replace(/^\s+|\s+$/g, "")): str;
    };

    // use built-in .trim when available in JS runtime
    if (String.prototype.trim) {
        mfe.trim = function(str) {
            return str && str.trim? str.trim() : str;
        };
    }

    //*@public
    /**
        Efficient _uuid_ generator according to RFC4122 for the browser.
    */
    mfe.uuid = function () {
        // TODO: believe this can be even faster...
        var t, p = (
            (Math.random().toString(16).substr(2,8)) + "-" +
            ((t=Math.random().toString(16).substr(2,8)).substr(0,4)) + "-" +
            (t.substr(4,4)) +
            ((t=Math.random().toString(16).substr(2,8)).substr(0,4)) + "-" +
            (t.substr(4,4)) +
            (Math.random().toString(16).substr(2,8))
        );
        return p;
    };







    /**
        Invokes function _inJob_ after _inWait_ milliseconds have elapsed since the
        last time _inJobName_ was referenced.

        Jobs can be used to throttle behaviors.  If some event may occur once or
        multiple times, but we want a response to occur only once every _n_ seconds,
        we can use a job.

            onscroll: function() {
                // updateThumb will be called, but only when 1s has elapsed since the
                // last onscroll
                mfe.job("updateThumb", this.bindSafely("updateThumb"), 1000);
            }
    */
    mfe.job = function(inJobName, inJob, inWait) {
        mfe.job.stop(inJobName);
        mfe.job._jobs[inJobName] = setTimeout(function() {
            mfe.job.stop(inJobName);
            inJob();
        }, inWait);
    };

    /**
        Cancels the named job, if it has not already fired.
    */
    mfe.job.stop = function(inJobName) {
        if (mfe.job._jobs[inJobName]) {
            clearTimeout(mfe.job._jobs[inJobName]);
            delete mfe.job._jobs[inJobName];
        }
    };

    /**
        Invoke _inJob_ immediately, then prevent any other calls to
        mfe.job.throttle with the same _inJobName_ from running for
        the next _inWait_ milliseconds.

        This is used for throttling user events when you want an
        immediate response, but later invocations might just be noise
        if they arrive too often.
    */
    mfe.job.throttle = function(inJobName, inJob, inWait) {
        // if we still have a job with this name pending, return immediately
        if (mfe.job._jobs[inJobName]) {
            return;
        }
        inJob();
        mfe.job._jobs[inJobName] = setTimeout(function() {
            mfe.job.stop(inJobName);
        }, inWait);
    };

    mfe.job._jobs = {};


    ///////////////////////////////////////////////
    ///////////////////////////////////////////////
    ///
    ///  MFE Generate a unique callback on global
    ///
    ///////////////////////////////////////////////
    ///////////////////////////////////////////////

    var callbacks = window.mfe_callbacks = {};

    mfe.globalCallback = function (fn){
        var id = mfe.uid();
        var newId = "mfe_callbacks" + id;
        window[newId] = fn;
        return newId;
    }



    ///////////////////////////////////////////////
    ///////////////////////////////////////////////
    ///
    ///  MFE OOP block
    ///
    ///////////////////////////////////////////////
    ///////////////////////////////////////////////


    var Aspect = (function() {

        var Aspect = {};
        // Aspect
        // ---------------------
        // Thanks to:
        //  - http://yuilibrary.com/yui/docs/api/classes/Do.html
        //  - http://code.google.com/p/jquery-aop/
        //  - http://lazutkin.com/blog/2008/may/18/aop-aspect-javascript-dojo/
        // 在指定方法执行前，先执行 callback
        Aspect.before = function(methodName, callback, context) {
            return weave.call(this, "before", methodName, callback, context);
        };
        // 在指定方法执行后，再执行 callback
        Aspect.after = function(methodName, callback, context) {
            return weave.call(this, "after", methodName, callback, context);
        };
        // Helpers
        // -------
        var eventSplitter = /\s+/;
        function weave(when, methodName, callback, context) {
            var names = methodName.split(eventSplitter);
            var name, method;
            while (name = names.shift()) {
                method = getMethod(this, name);
                if (!method.__isAspected) {
                    wrap.call(this, name);
                }
                this.on(when + ":" + name, callback, context);
            }
            return this;
        }
        function getMethod(host, methodName) {
            var method = host[methodName];
            if (!method) {
                throw new Error("Invalid method name: " + methodName);
            }
            return method;
        }
        function wrap(methodName) {
            var old = this[methodName];
            this[methodName] = function() {
                var args = Array.prototype.slice.call(arguments);
                var beforeArgs = [ "before:" + methodName ].concat(args);
                // prevent if trigger return false
                if (this.trigger.apply(this, beforeArgs) === false) return;
                var ret = old.apply(this, arguments);
                var afterArgs = [ "after:" + methodName, ret ].concat(args);
                this.trigger.apply(this, afterArgs);
                return ret;
            };
            this[methodName].__isAspected = true;
        }
        return Aspect;
    })();
    mfe.Aspect = Aspect;




    var Attribute = (function() {
        var Attribute = {};
        // Attribute
        // -----------------
        // Thanks to:
        //  - http://documentcloud.github.com/backbone/#Model
        //  - http://yuilibrary.com/yui/docs/api/classes/AttributeCore.html
        //  - https://github.com/berzniz/backbone.getters.setters
        // 负责 attributes 的初始化
        // attributes 是与实例相关的状态信息，可读可写，发生变化时，会自动触发相关事件
        Attribute.initAttrs = function(config) {
            // initAttrs 是在初始化时调用的，默认情况下实例上肯定没有 attrs，不存在覆盖问题
            var attrs = this.attrs = {};
            // Get all inherited attributes.
            var specialProps = this.propsInAttrs || [];
            mergeInheritedAttrs(attrs, this, specialProps);
            // Merge user-specific attributes from config.
            if (config) {
                mergeUserValue(attrs, config);
            }
            // 对于有 setter 的属性，要用初始值 set 一下，以保证关联属性也一同初始化
            setSetterAttrs(this, attrs, config);
            // Convert `on/before/afterXxx` config to event handler.
            parseEventsFromAttrs(this, attrs);
            // 将 this.attrs 上的 special properties 放回 this 上
            copySpecialProps(specialProps, this, attrs, true);
        };
        // Get the value of an attribute.
        Attribute.get = function(key) {
            var attr = this.attrs[key] || {};
            var val = attr.value;
            return attr.getter ? attr.getter.call(this, val, key) : val;
        };
        // Set a hash of model attributes on the object, firing `"change"` unless
        // you choose to silence it.
        Attribute.set = function(key, val, options) {
            var attrs = {};
            // set("key", val, options)
            if (isString(key)) {
                attrs[key] = val;
            } else {
                attrs = key;
                options = val;
            }
            options || (options = {});
            var silent = options.silent;
            var override = options.override;
            var now = this.attrs;
            var changed = this.__changedAttrs || (this.__changedAttrs = {});
            for (key in attrs) {
                if (!attrs.hasOwnProperty(key)) continue;
                var attr = now[key] || (now[key] = {});
                val = attrs[key];
                if (attr.readOnly) {
                    throw new Error("This attribute is readOnly: " + key);
                }
                // invoke setter
                if (attr.setter) {
                    val = attr.setter.call(this, val, key);
                }
                // 获取设置前的 prev 值
                var prev = this.get(key);
                // 获取需要设置的 val 值
                // 如果设置了 override 为 true，表示要强制覆盖，就不去 merge 了
                // 都为对象时，做 merge 操作，以保留 prev 上没有覆盖的值
                if (!override && isPlainObject(prev) && isPlainObject(val)) {
                    val = merge(merge({}, prev), val);
                }
                // set finally
                now[key].value = val;
                // invoke change event
                // 初始化时对 set 的调用，不触发任何事件
                if (!this.__initializingAttrs && !isEqual(prev, val)) {
                    if (silent) {
                        changed[key] = [ val, prev ];
                    } else {
                        this.trigger("change:" + key, val, prev, key);
                    }
                }
            }
            return this;
        };
        // Call this method to manually fire a `"change"` event for triggering
        // a `"change:attribute"` event for each changed attribute.
        Attribute.change = function() {
            var changed = this.__changedAttrs;
            if (changed) {
                for (var key in changed) {
                    if (changed.hasOwnProperty(key)) {
                        var args = changed[key];
                        this.trigger("change:" + key, args[0], args[1], key);
                    }
                }
                delete this.__changedAttrs;
            }
            return this;
        };
        // for test
        Attribute._isPlainObject = isPlainObject;
        // Helpers
        // -------
        var toString = Object.prototype.toString;
        var hasOwn = Object.prototype.hasOwnProperty;
        /**
       * Detect the JScript [[DontEnum]] bug:
       * In IE < 9 an objects own properties, shadowing non-enumerable ones, are
       * made non-enumerable as well.
       * https://github.com/bestiejs/lodash/blob/7520066fc916e205ef84cb97fbfe630d7c154158/lodash.js#L134-L144
       */
        /** Detect if own properties are iterated after inherited properties (IE < 9) */
        var iteratesOwnLast;
        (function() {
            var props = [];
            function Ctor() {
                this.x = 1;
            }
            Ctor.prototype = {
                valueOf: 1,
                y: 1
            };
            for (var prop in new Ctor()) {
                props.push(prop);
            }
            iteratesOwnLast = props[0] !== "x";
        })();
        var isArray = Array.isArray || function(val) {
            return toString.call(val) === "[object Array]";
        };
        function isString(val) {
            return toString.call(val) === "[object String]";
        }
        function isFunction(val) {
            return toString.call(val) === "[object Function]";
        }
        function isWindow(o) {
            return o != null && o == o.window;
        }
        function isPlainObject(o) {
            // Must be an Object.
            // Because of IE, we also have to check the presence of the constructor
            // property. Make sure that DOM nodes and window objects don't
            // pass through, as well
            if (!o || toString.call(o) !== "[object Object]" || o.nodeType || isWindow(o)) {
                return false;
            }
            try {
                // Not own constructor property must be Object
                if (o.constructor && !hasOwn.call(o, "constructor") && !hasOwn.call(o.constructor.prototype, "isPrototypeOf")) {
                    return false;
                }
            } catch (e) {
                // IE8,9 Will throw exceptions on certain host objects #9897
                return false;
            }
            var key;
            // Support: IE<9
            // Handle iteration over inherited properties before own properties.
            // http://bugs.jquery.com/ticket/12199
            if (iteratesOwnLast) {
                for (key in o) {
                    return hasOwn.call(o, key);
                }
            }
            // Own properties are enumerated firstly, so to speed up,
            // if last one is own, then all properties are own.
            for (key in o) {}
            return key === undefined || hasOwn.call(o, key);
        }
        function isEmptyObject(o) {
            if (!o || toString.call(o) !== "[object Object]" || o.nodeType || isWindow(o) || !o.hasOwnProperty) {
                return false;
            }
            for (var p in o) {
                if (o.hasOwnProperty(p)) return false;
            }
            return true;
        }
        function merge(receiver, supplier) {
            var key, value;
            for (key in supplier) {
                if (supplier.hasOwnProperty(key)) {
                    value = supplier[key];
                    // 只 clone 数组和 plain object，其他的保持不变
                    if (isArray(value)) {
                        value = value.slice();
                    } else if (isPlainObject(value)) {
                        var prev = receiver[key];
                        isPlainObject(prev) || (prev = {});
                        value = merge(prev, value);
                    }
                    receiver[key] = value;
                }
            }
            return receiver;
        }
        var keys = Object.keys;
        if (!keys) {
            keys = function(o) {
                var result = [];
                for (var name in o) {
                    if (o.hasOwnProperty(name)) {
                        result.push(name);
                    }
                }
                return result;
            };
        }
        function mergeInheritedAttrs(attrs, instance, specialProps) {
            var inherited = [];
            var proto = instance.constructor.prototype;
            while (proto) {
                // 不要拿到 prototype 上的
                if (!proto.hasOwnProperty("attrs")) {
                    proto.attrs = {};
                }
                // 将 proto 上的特殊 properties 放到 proto.attrs 上，以便合并
                copySpecialProps(specialProps, proto.attrs, proto);
                // 为空时不添加
                if (!isEmptyObject(proto.attrs)) {
                    inherited.unshift(proto.attrs);
                }
                // 向上回溯一级
                proto = proto.constructor.superclass;
            }
            // Merge and clone default values to instance.
            for (var i = 0, len = inherited.length; i < len; i++) {
                merge(attrs, normalize(inherited[i]));
            }
        }
        function mergeUserValue(attrs, config) {
            merge(attrs, normalize(config, true));
        }
        function copySpecialProps(specialProps, receiver, supplier, isAttr2Prop) {
            for (var i = 0, len = specialProps.length; i < len; i++) {
                var key = specialProps[i];
                if (supplier.hasOwnProperty(key)) {
                    receiver[key] = isAttr2Prop ? receiver.get(key) : supplier[key];
                }
            }
        }
        var EVENT_PATTERN = /^(on|before|after)([A-Z].*)$/;
        var EVENT_NAME_PATTERN = /^(Change)?([A-Z])(.*)/;
        function parseEventsFromAttrs(host, attrs) {
            for (var key in attrs) {
                if (attrs.hasOwnProperty(key)) {
                    var value = attrs[key].value, m;
                    if (isFunction(value) && (m = key.match(EVENT_PATTERN))) {
                        host[m[1]](getEventName(m[2]), value);
                        delete attrs[key];
                    }
                }
            }
        }
        // Converts `Show` to `show` and `ChangeTitle` to `change:title`
        function getEventName(name) {
            var m = name.match(EVENT_NAME_PATTERN);
            var ret = m[1] ? "change:" : "";
            ret += m[2].toLowerCase() + m[3];
            return ret;
        }
        function setSetterAttrs(host, attrs, config) {
            var options = {
                silent: true
            };
            host.__initializingAttrs = true;
            for (var key in config) {
                if (config.hasOwnProperty(key)) {
                    if (attrs[key].setter) {
                        host.set(key, config[key], options);
                    }
                }
            }
            delete host.__initializingAttrs;
        }
        var ATTR_SPECIAL_KEYS = [ "value", "getter", "setter", "readOnly" ];
        // normalize `attrs` to
        //
        //   {
        //      value: 'xx',
        //      getter: fn,
        //      setter: fn,
        //      readOnly: boolean
        //   }
        //
        function normalize(attrs, isUserValue) {
            var newAttrs = {};
            for (var key in attrs) {
                var attr = attrs[key];
                if (!isUserValue && isPlainObject(attr) && hasOwnProperties(attr, ATTR_SPECIAL_KEYS)) {
                    newAttrs[key] = attr;
                    continue;
                }
                newAttrs[key] = {
                    value: attr
                };
            }
            return newAttrs;
        }
        function hasOwnProperties(object, properties) {
            for (var i = 0, len = properties.length; i < len; i++) {
                if (object.hasOwnProperty(properties[i])) {
                    return true;
                }
            }
            return false;
        }
        // 对于 attrs 的 value 来说，以下值都认为是空值： null, undefined, '', [], {}
        function isEmptyAttrValue(o) {
            return o == null || // null, undefined
            (isString(o) || isArray(o)) && o.length === 0 || // '', []
            isEmptyObject(o);
        }
        // 判断属性值 a 和 b 是否相等，注意仅适用于属性值的判断，非普适的 === 或 == 判断。
        function isEqual(a, b) {
            if (a === b) return true;
            if (isEmptyAttrValue(a) && isEmptyAttrValue(b)) return true;
            // Compare `[[Class]]` names.
            var className = toString.call(a);
            if (className != toString.call(b)) return false;
            switch (className) {
              // Strings, numbers, dates, and booleans are compared by value.
                case "[object String]":
                // Primitives and their corresponding object wrappers are
                // equivalent; thus, `"5"` is equivalent to `new String("5")`.
                return a == String(b);

              case "[object Number]":
                // `NaN`s are equivalent, but non-reflexive. An `equal`
                // comparison is performed for other numeric values.
                return a != +a ? b != +b : a == 0 ? 1 / a == 1 / b : a == +b;

              case "[object Date]":
              case "[object Boolean]":
                // Coerce dates and booleans to numeric primitive values.
                // Dates are compared by their millisecond representations.
                // Note that invalid dates with millisecond representations
                // of `NaN` are not equivalent.
                return +a == +b;

              // RegExps are compared by their source patterns and flags.
                case "[object RegExp]":
                return a.source == b.source && a.global == b.global && a.multiline == b.multiline && a.ignoreCase == b.ignoreCase;

              // 简单判断数组包含的 primitive 值是否相等
                case "[object Array]":
                var aString = a.toString();
                var bString = b.toString();
                // 只要包含非 primitive 值，为了稳妥起见，都返回 false
                return aString.indexOf("[object") === -1 && bString.indexOf("[object") === -1 && aString === bString;
            }
            if (typeof a != "object" || typeof b != "object") return false;
            // 简单判断两个对象是否相等，只判断第一层
            if (isPlainObject(a) && isPlainObject(b)) {
                // 键值不相等，立刻返回 false
                if (!isEqual(keys(a), keys(b))) {
                    return false;
                }
                // 键相同，但有值不等，立刻返回 false
                for (var p in a) {
                    if (a[p] !== b[p]) return false;
                }
                return true;
            }
            // 其他情况返回 false, 以避免误判导致 change 事件没发生
            return false;
        }

        return Attribute;
    })();
    mfe.Attribute = Attribute;




    /*=========================================
    =            MFE Class Section            =
    =========================================*/
    var Class = (function() {
        // Class
        // -----------------
        // Thanks to:
        //  - http://mootools.net/docs/core/Class/Class
        //  - http://ejohn.org/blog/simple-javascript-inheritance/
        //  - https://github.com/ded/klass
        //  - http://documentcloud.github.com/backbone/#Model-extend
        //  - https://github.com/joyent/node/blob/master/lib/util.js
        //  - https://github.com/kissyteam/kissy/blob/master/src/seed/src/kissy.js
        // The base Class implementation.
        function Class(o) {
            // Convert existed function to Class.
            if (!(this instanceof Class) && isFunction(o)) {
                return classify(o);
            }
        }
        // Create a new Class.
        //
        //  var SuperPig = Class.create({
        //    Extends: Animal,
        //    Implements: Flyable,
        //    initialize: function() {
        //      SuperPig.superclass.initialize.apply(this, arguments)
        //    },
        //    Statics: {
        //      COLOR: 'red'
        //    }
        // })
        //
        Class.create = function(parent, properties) {
            if (!isFunction(parent)) {
                properties = parent;
                parent = null;
            }
            properties || (properties = {});
            parent || (parent = properties.Extends || Class);
            properties.Extends = parent;
            // The created class constructor
            function SubClass() {
                // Call the parent constructor.
                parent.apply(this, arguments);
                // Only call initialize in self constructor.
                if (this.constructor === SubClass && this.initialize) {
                    this.initialize.apply(this, arguments);
                }
            }
            // Inherit class (static) properties from parent.
            if (parent !== Class) {
                mix(SubClass, parent, parent.StaticsWhiteList);
            }
            // Add instance properties to the subclass.
            implement.call(SubClass, properties);
            // Make subclass extendable.
            return classify(SubClass);
        };
        function implement(properties) {
            var key, value;
            for (key in properties) {
                value = properties[key];
                if (Class.Mutators.hasOwnProperty(key)) {
                    Class.Mutators[key].call(this, value);
                } else {
                    this.prototype[key] = value;
                }
            }
        }
        // Create a sub Class based on `Class`.
        Class.extend = function(properties) {
            properties || (properties = {});
            properties.Extends = this;
            return Class.create(properties);
        };
        function classify(cls) {
            cls.extend = Class.extend;
            cls.implement = implement;
            return cls;
        }
        // Mutators define special properties.
        Class.Mutators = {
            Extends: function(parent) {
                var existed = this.prototype;
                var proto = createProto(parent.prototype);
                // Keep existed properties.
                mix(proto, existed);
                // Enforce the constructor to be what we expect.
                proto.constructor = this;
                // Set the prototype chain to inherit from `parent`.
                this.prototype = proto;
                // Set a convenience property in case the parent's prototype is
                // needed later.
                this.superclass = parent.prototype;
            },
            Implements: function(items) {
                isArray(items) || (items = [ items ]);
                var proto = this.prototype, item;
                while (item = items.shift()) {
                    mix(proto, item.prototype || item);
                }
            },
            Statics: function(staticProperties) {
                mix(this, staticProperties);
            }
        };
        // Shared empty constructor function to aid in prototype-chain creation.
        function Ctor() {}
        // See: http://jsperf.com/object-create-vs-new-ctor
        var createProto = Object.__proto__ ? function(proto) {
            return {
                __proto__: proto
            };
        } : function(proto) {
            Ctor.prototype = proto;
            return new Ctor();
        };
        // Helpers
        // ------------
        function mix(r, s, wl) {
            // Copy "all" properties including inherited ones.
            for (var p in s) {
                if (s.hasOwnProperty(p)) {
                    if (wl && indexOf(wl, p) === -1) continue;
                    // 在 iPhone 1 代等设备的 Safari 中，prototype 也会被枚举出来，需排除
                    if (p !== "prototype") {
                        r[p] = s[p];
                    }
                }
            }
        }
        var toString = Object.prototype.toString;
        var isArray = Array.isArray || function(val) {
            return toString.call(val) === "[object Array]";
        };
        var isFunction = function(val) {
            return toString.call(val) === "[object Function]";
        };
        var indexOf = Array.prototype.indexOf ? function(arr, item) {
            return arr.indexOf(item);
        } : function(arr, item) {
            for (var i = 0, len = arr.length; i < len; i++) {
                if (arr[i] === item) {
                    return i;
                }
            }
            return -1;
        };
        return Class;
    })();
    mfe.Class = Class;
    /*-----  End of MFE Class Section  ------*/






    /*================================================
    =            MFE Events Class Section            =
    ================================================*/
    var Events = (function() {

        // Events
        // -----------------
        // Thanks to:
        //  - https://github.com/documentcloud/backbone/blob/master/backbone.js
        //  - https://github.com/joyent/node/blob/master/lib/events.js
        // Regular expression used to split event strings
        var eventSplitter = /\s+/;
        // A module that can be mixed in to *any object* in order to provide it
        // with custom events. You may bind with `on` or remove with `off` callback
        // functions to an event; `trigger`-ing an event fires all callbacks in
        // succession.
        //
        //     var object = new Events();
        //     object.on('expand', function(){ alert('expanded'); });
        //     object.trigger('expand');
        //
        function Events() {}
        // Bind one or more space separated events, `events`, to a `callback`
        // function. Passing `"all"` will bind the callback to all events fired.
        Events.prototype.on = function(events, callback, context) {
            var cache, event, list;
            if (!callback) return this;
            cache = this.__events || (this.__events = {});
            events = events.split(eventSplitter);
            while (event = events.shift()) {
                list = cache[event] || (cache[event] = []);
                list.push(callback, context);
            }
            return this;
        };
        // Remove one or many callbacks. If `context` is null, removes all callbacks
        // with that function. If `callback` is null, removes all callbacks for the
        // event. If `events` is null, removes all bound callbacks for all events.
        Events.prototype.off = function(events, callback, context) {
            var cache, event, list, i;
            // No events, or removing *all* events.
            if (!(cache = this.__events)) return this;
            if (!(events || callback || context)) {
                delete this.__events;
                return this;
            }
            events = events ? events.split(eventSplitter) : keys(cache);
            // Loop through the callback list, splicing where appropriate.
            while (event = events.shift()) {
                list = cache[event];
                if (!list) continue;
                if (!(callback || context)) {
                    delete cache[event];
                    continue;
                }
                for (i = list.length - 2; i >= 0; i -= 2) {
                    if (!(callback && list[i] !== callback || context && list[i + 1] !== context)) {
                        list.splice(i, 2);
                    }
                }
            }
            return this;
        };
        // Trigger one or many events, firing all bound callbacks. Callbacks are
        // passed the same arguments as `trigger` is, apart from the event name
        // (unless you're listening on `"all"`, which will cause your callback to
        // receive the true name of the event as the first argument).
        Events.prototype.trigger = function(events) {
            var cache, event, all, list, i, len, rest = [], args, returned = {
                status: true
            };
            if (!(cache = this.__events)) return this;
            events = events.split(eventSplitter);
            // Fill up `rest` with the callback arguments.  Since we're only copying
            // the tail of `arguments`, a loop is much faster than Array#slice.
            for (i = 1, len = arguments.length; i < len; i++) {
                rest[i - 1] = arguments[i];
            }
            // For each event, walk through the list of callbacks twice, first to
            // trigger the event, then to trigger any `"all"` callbacks.
            while (event = events.shift()) {
                // Copy callback lists to prevent modification.
                if (all = cache.all) all = all.slice();
                if (list = cache[event]) list = list.slice();
                // Execute event callbacks.
                callEach(list, rest, this, returned);
                // Execute "all" callbacks.
                callEach(all, [ event ].concat(rest), this, returned);
            }
            return returned.status;
        };
        // Mix `Events` to object instance or Class function.
        Events.mixTo = function(receiver) {
            receiver = receiver.prototype || receiver;
            var proto = Events.prototype;
            for (var p in proto) {
                if (proto.hasOwnProperty(p)) {
                    receiver[p] = proto[p];
                }
            }
        };
        // Helpers
        // -------
        var keys = Object.keys;
        if (!keys) {
            keys = function(o) {
                var result = [];
                for (var name in o) {
                    if (o.hasOwnProperty(name)) {
                        result.push(name);
                    }
                }
                return result;
            };
        }
        // Execute callbacks
        function callEach(list, args, context, returned) {
            var r;
            if (list) {
                for (var i = 0, len = list.length; i < len; i += 2) {
                    r = list[i].apply(list[i + 1] || context, args);
                    // trigger will return false if one of the callbacks return false
                    r === false && returned.status && (returned.status = false);
                }
            }
        }
        return Events;
    })();
    mfe.Events = Events;
    /*-----  End of MFE Events Class Section  ------*/






    /*==============================================
    =            MFE Base Class Section            =
    ==============================================*/
    var Base = (function() {
        function parseEventsFromInstance(host, attrs) {
            for (var attr in attrs) {
                if (attrs.hasOwnProperty(attr)) {
                    var m = "_onChange" + ucfirst(attr);
                    if (host[m]) {
                        host.on("change:" + attr, host[m]);
                    }
                }
            }
        }
        function ucfirst(str) {
            return str.charAt(0).toUpperCase() + str.substring(1);
        }
        var Base = Class.create({
            Implements: [ Events, Aspect, Attribute ],
            initialize: function(config) {
                this.initAttrs(config);
                // Automatically register `this._onChangeAttr` method as
                // a `change:attr` event handler.
                parseEventsFromInstance(this, this.attrs);
            },
            destroy: function() {
                this.off();
                for (var p in this) {
                    if (this.hasOwnProperty(p)) {
                        delete this[p];
                    }
                }
                // Destroy should be called only once, generate a fake destroy after called
                // https://github.com/aralejs/widget/issues/50
                this.destroy = function() {};
            }
        });
        return Base;
    })();
    mfe.Base = Base;
    /*-----  End of MFE Base Class Section  ------*/

    /**
     * 根据名称返回flash对象的引用
     * @param  {[type]} movieName [swfobject 注册时候的id]
     * @return {[type]}           [swf对象的引用]
     */
    mfe.getSwf = function (movieName){
        if(window.document[movieName]){
            return window.document[movieName];   
        }else if(navigator.appName.indexOf("Microsoft") == -1){
            if(document.embeds && document.embeds[movieName])   
                return document.embeds[movieName];
        }else{
            return document.getElementById(movieName);
        }
    }

    if (typeof module!="undefined" && module.exports ) {
        module.exports = mfe;
    }
});








