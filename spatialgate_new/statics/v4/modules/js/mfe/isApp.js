define('mfe/isApp', function(require, exports, module) {
    
    var isApp=false;
    var isWhatApp = '';

    var ua = navigator.userAgent.toLowerCase();

    if (/mfyxb/i.test(ua)) {

        isApp = true;

        if(/mfyxb/i.test(ua)){
           isWhatApp='mfyxb';
        }
    }

    if(typeof module!="undefined" && module.exports){
        module.exports = {
            isApp : isApp,
            isWhatApp : isWhatApp
        };
    }

});























