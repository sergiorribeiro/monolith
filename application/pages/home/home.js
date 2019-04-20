function homeAttachable(node) {
    var self = this;

    function init() {
        monolith.utils.preloadImages([
            monolith.utils.url("/assets/images/monolith.png")
        ],function(){
            // This may vary, but usually, you want to signal preload end at the page init
            window.monolith.signalPreloadEnd();
        });
    }

    init();

    return self;
}