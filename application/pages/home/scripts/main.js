function homeAttachable(node) {
    var self = this;

    function init() {
        
        // This may vary, but usually, you want to signal preload end at the page init
        monolith.utils.preloadImages([
            "/application/assets/images/monolith.png"
        ],function(){
            window.monolith.signalPreloadEnd();
        });
    }

    init();

    return self;
}