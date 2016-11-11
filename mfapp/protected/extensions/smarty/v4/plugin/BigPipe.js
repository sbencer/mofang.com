var BigPipe = function() {

    var pagelets = [],
        loadedResource = {},
        container,
        containerId,
        pageUrl = location.pathname + (location.search ? "?" + location.search : ""),
        resource,
        resourceCache = {},
        onReady,
        LOADED = 1,
        cacheMaxTime = 5 * 60 * 1000;

    function parseJSON (json) {
        return window.JSON? JSON.parse(json) : eval('(' + json + ')');
    }


    function ajax(url, cb, data) {
        var xhr = new (window.XMLHttpRequest || ActiveXObject)("Microsoft.XMLHTTP");

        xhr.onreadystatechange = function() {
            if (this.readyState == 4) {
                cb(this.responseText);
            }
        };
        xhr.open(data?'POST':'GET', url + '&t=' + ~~(Math.random() * 1e6), true);

        if (data) {
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        }
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.send(data);
    }

    function getCommentById(html_id) {
        //
        // 取出html_id元素內保存的注釋內容
        //
        var dom = document.getElementById(html_id);
        if (!dom) {
            return "";
        }
        var html = dom.firstChild.nodeValue;
        html = html.substring(1, html.length - 1).
            replace(/\\([\s\S]|$)/g,'$1');
        dom.parentNode.removeChild(dom);
        return html;
    }

    function renderPagelet(obj, pageletsMap, rendered) {
        if (obj.id in rendered) {
            return;
        }
        rendered[obj.id] = true;

        if (obj.parent_id) {
            renderPagelet(
                pageletsMap[obj.parent_id], pageletsMap, rendered);
        }

        //
        // 將pagelet填充到對應的DOM裡
        //
        var dom = document.getElementById(obj.id);
        if (!dom) {
            dom = document.createElement('div');
            dom.id = obj.id;
            if (container) {
                container.appendChild(dom);
            } else {
                document.body.appendChild(dom);
            }
        }
        dom.innerHTML = obj.html || getCommentById(obj.html_id);
    }


    function render(options) {
        var i, n = pagelets.length;
        var pageletsMap = {};
        var rendered = {};
        var options = options || {};

        //
        // pagelet.id => pagelet 映射表
        //
        for(i = 0; i < n; i++) {
            var obj = pagelets[i];
            pageletsMap[obj.id] = obj;
        }

        for(i = 0; i < n; i++) {
            renderPagelet(pagelets[i], pageletsMap, rendered);
        }

        if(options.trigger === true) {
            trigger('pagerendercomplete', {
                'url': pageUrl,
                'resource': resource
            });
        }
    }


    function process(rm, cb) {
        if (rm.async) {
            require.resourceMap(rm.async);
        }
        var css = getNeedLoad(rm.css);

        function loadNext() {
            var js = getNeedLoad(rm.js);

            if (rm.style) {
                var dom = document.createElement('style');
                dom.innerHTML = rm.style;
                document.getElementsByTagName('head')[0].appendChild(dom);
            }

            cb();

            if (js) {
                LazyLoad.js(js, function() {
                    recordLoaded(js);
                    rm.script && window.eval(rm.script);
                    trigger("onpageloaded");
                });
            }
            else {
                rm.script && window.eval(rm.script);
                trigger("onpageloaded");
            }
        }

        css
            ? LazyLoad.css(css.reverse(), function(){
                recordLoaded(css);
                loadNext();
            })
            : loadNext();
    }


    /**
     * 獲取需要加載的資源列表
     * @param  {array|string} resource 資源地址或者數組
     * @return {array}        資源列表
     */
    function getNeedLoad (resource) {
        var needLoad = [];
        if(typeof resource === "string") {
            needLoad = [resource]
        } else if(Object.prototype.toString.call(resource) === "[object Array]") {
            for (var i = 0; i < resource.length; i++) {
                if(loadedResource[resource[i]] !== LOADED) {
                    needLoad.push(resource[i]);
                }
            };
        }

        if(needLoad.length === 0) {
            needLoad = null;
        } 

        return needLoad;

    }

    /**
     * 記錄下載資源
     * @param  {array|string} resource 已下載的資源
     * @return {void}         
     */
    function recordLoaded (resource) {
        var needCache = resource;
        if(typeof needCache === "string") {
            needCache = [needCache];
        }

        for (var i = 0; i < needCache.length; i++) {
            loadedResource[resource[i]] = LOADED;
        };

    }

    function register(obj) {
        process(obj, function() {
            render({trigger:true});
            if(typeof onReady === "function") {
                onReady();
            }
        });
    }

    function fetch(url, id, options, callback) {
        //
        // Quickling請求局部
        //
        var currentPageUrl = location.href,
            options = options || {},
            data;
        containerId = id;

        var success = function(data){
            // 如果數據返回回來前，發生切頁，則不再處理，否則當前頁面有可能被干掉
            if(currentPageUrl !== location.href) {
                return;
            }

            if (id == containerId) {
                pageUrl = url;
                var json = parseJSON(data);
                resource = json;
                onPagelets(json, id, callback);
            }
        }

        // 緩存策略
        if(isCacheAvailable(url) && options.cache !== false) {
            data = getCachedResource(url);
            success(data);
            // 統計URL
            statRecord(url);
        } else {
            ajax(url, function(data){
                addResourceToCache(url,data);
                success(data);
            });
        }
    }

    function refresh(url, id, options, callback) {
        fetch(url, id, options, callback);
    }

    /**
     * 異步加載pagelets
     */
    function asyncLoad(pageletIDs, param) {
        if (!(pageletIDs instanceof Array)) {
            pageletIDs = [pageletIDs];
        }

        var i, args = [],
            currentPageUrl = location.href;
        for(i = pageletIDs.length - 1; i >= 0; i--) {
            var id = pageletIDs[i].id;
            if (!id) {
                throw Error('[BigPipe] missing pagelet id');
            }
            args.push('pagelets[]=' + id);
        }

        param = param ? '&' + param : '';

        var url = location.href.split('#')[0] + '&' + args.join('&') + '&force_mode=1&fis_widget=true' +param;

        // 異步請求pagelets
        ajax(url, function(res) {
            // 如果數據返回回來前，發生切頁，則不再處理，否則當前頁面有可能被干掉
            if(currentPageUrl !== location.href) {
                return;
            }

            var data = parseJSON(res);
            resource = data;
            pageUrl = url;
            pagelets = data.pagelets;
            process(data.resource_map, function() {
                render();
            });
        });
    }

    /**
     * 記錄統計
     * @param  {String} url 
     */
    function statRecord(url){
        if(typeof url === "string") {
            var sep = url.indexOf('?') === -1 ? "/?" : "&";
            url = url + sep + "pagecache=1";
            ajax(url,function(res){
                //console.log("%ccache stat","color:red");
            });
        }
    }

    function addResourceToCache(url,resource){
        resourceCache[url] = {
            data : resource,
            time : Date.now()
        };
    }

    function getCachedResource(url) {
        if(resourceCache[url]) {
            return resourceCache[url].data;
        }
    }

    function isCacheAvailable(url) {
        return !!resourceCache[url] && Date.now() - resourceCache[url].time <= cacheMaxTime;
    }

    /**
     * 添加一個pagelet到緩衝隊列
     */
    function onPageletArrived(obj) {
        pagelets.push(obj);
    }

    function onPagelets(obj, id, callback) {
        //
        // Quickling請求響應
        //
        if (obj.title) {
            document.title = obj.title;
        }

        //
        // 清空需要填充的DOM容器
        //
        container = document.getElementById(id);
        container.innerHTML = '';
        pagelets = obj.pagelets;

        trigger('pagearrived', pagelets);

        process(obj.resource_map, function() {
            callback && callback();
            render({trigger:true});
        });
    }

    function onPageReady(f) {
        onReady = f;
        trigger('pageready', pagelets);
    }

    function onPageChange(pid) {
        fetch(location.pathname +
            (location.search? location.search + '&' : '?') + 'pagelets=' + pid);
    }


    // -------------------- 事件隊列 --------------------
    var SLICE = [].slice;
    var events = {};

    function trigger(type /* args... */) {
        var list = events[type];
        if (!list) {
            return;
        }

        var arg = SLICE.call(arguments, 1);
        for(var i = 0, j = list.length; i < j; i++) {
            var cb = list[i];
            if (cb.f.apply(cb.o, arg) === false) {
                break;
            }
        }
    }

    function on(type, listener, context) {
        var queue = events[type] || (events[type] = []);
        queue.push({f: listener, o: context});
    }


    return {
        asyncLoad: asyncLoad,
        register: register,
        refresh: refresh,

        onPageReady: onPageReady,
        onPageChange: onPageChange,

        onPageletArrived: onPageletArrived,
        onPagelets: onPagelets,

        on: on,
        trigger: trigger
    }
}();
