function monolith() {
    var self = this;
    var navstarted_event = new Event("monolith_navigation_started");
    var navended_event = new Event("monolith_navigation_ended");
    var preloadstarted_event = new Event("monolith_preload_started");
    var preloadended_event = new Event("monolith_preload_ended");
    var stages_ready = new Event("monolith_stages_ready");

    var queuedTransition = "";

    self.consts = {
        version: "0.2b",
        stage_transitions: {
            CROSSFADE: 1,
            SLIDE_LEFT: 2,
            SLIDE_RIGHT: 3,
            FADE: 4
        }
    }

    self.currentPage = "";

    self.attachables = {}

    self.utils = {
        fetchAsync: function(url,params,action) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if(this.readyState == 4){
                    if(this.status == 200){action(this.responseText);}
                    if(this.status != 200){
                        // trouble in paradise
                    }
                }
            };
            xhttp.open("POST", url, true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send(params);
        }
    }

    function init() {
        document.addEventListener("DOMContentLoaded", function(event) {
            self.processActionQueue();
            document.querySelector("monolith-event-emitter").dispatchEvent(stages_ready);
        });
        self.handlerForEvent("monolith_preload_ended",self.performStageTransition);
    }

    self.performStageTransition = function(){
        var stage = document.querySelector("[data-relevance='stage']");
        var buffer = document.querySelector("[data-relevance='buffer']");

        var sstyle = stage.style;
        var bstyle = buffer.style;
        sstyle.transition = "";
        bstyle.transition = "";

        switch(queuedTransition){
            case self.consts.stage_transitions.CROSSFADE:
                sstyle.transition = "opacity 200ms ease-in-out";
                bstyle.transition = "opacity 200ms ease-in-out";
                sstyle.opacity = 0;
                bstyle.opacity = 1;
                sstyle.pointerEvents = "none";
                bstyle.pointerEvents = "all";

                stage.dataset.relevance = "buffer";
                buffer.dataset.relevance = "stage";

                setTimeout(function(){
                    document.querySelector("[data-relevance='buffer']").innerHTML = "";
                    window.scrollTo(0, 0);
                },200);
                break;
            case self.consts.stage_transitions.SLIDE_LEFT:
            case self.consts.stage_transitions.SLIDE_RIGHT:
                
                if(queuedTransition==self.consts.stage_transitions.SLIDE_LEFT)
                    bstyle.transform = "translateX(100%)";
                if(queuedTransition==self.consts.stage_transitions.SLIDE_RIGHT)
                    bstyle.transform = "translateX(-100%)";

                setTimeout(function(){
                    bstyle.display = "none";
                    bstyle.display = "block";
                    sstyle.transition = "transform 500ms ease-in-out";
                    bstyle.transition = "transform 500ms ease-in-out";
                    sstyle.opacity = 1;
                    bstyle.opacity = 1;
                    sstyle.pointerEvents = "none";
                    bstyle.pointerEvents = "all";
                    
                    if(queuedTransition==self.consts.stage_transitions.SLIDE_LEFT)
                        sstyle.transform = "translateX(-100%)";                        
                        
                    if(queuedTransition==self.consts.stage_transitions.SLIDE_RIGHT)
                        sstyle.transform = "translateX(100%)";

                    bstyle.transform = "translateX(0%)";

                    stage.dataset.relevance = "buffer";
                    buffer.dataset.relevance = "stage";

                    setTimeout(function(){
                        document.querySelector("[data-relevance='buffer']").innerHTML = "";
                        window.scrollTo(0, 0);
                    },500);
                },50);
                break;
            case self.consts.stage_transitions.FADE:
                sstyle.transition = "opacity 200ms ease-in-out";
                bstyle.transition = "opacity 200ms ease-in-out";
                sstyle.opacity = 0;
                bstyle.opacity = 0;
                sstyle.pointerEvents = "none";

                stage.dataset.relevance = "buffer";
                buffer.dataset.relevance = "stage";

                setTimeout(function(){
                    document.querySelector("[data-relevance='buffer']").innerHTML = "";
                    document.querySelector("[data-relevance='stage']").style.opacity = 1;
                    document.querySelector("[data-relevance='stage']").style.pointerEvents = "all";
                    window.scrollTo(0, 0);
                },200);
                break;
        }
    }

    self.navigate = function(page,transition) {

        if(page == self.currentPage && !(monolith_stack.configs.allowSamePageNavigation == "1"))
            return;

        document.querySelector("monolith-event-emitter").dispatchEvent(navstarted_event);
        document.querySelector("monolith-event-emitter").dispatchEvent(preloadstarted_event);
        if(!transition)
            transition = self.consts.stage_transitions.SLIDE_LEFT;

        queuedTransition = transition;

        var params = "monolith_navigation";
        params += "&page=" + page;
        self.currentPage = page;

        self.utils.fetchAsync("/" + page,params,function(response){
            var buffer = document.querySelector("[data-relevance='buffer']");
            var dummy = document.createElement("DIV");
            response = JSON.parse(response);
            dummy.innerHTML = response.output;
            document.title = response.pagetitle;
            while (dummy.children.length > 0) {
                buffer.appendChild(dummy.children[0]);
            }

            var remscripts = buffer.querySelectorAll("monolith-remote-script");
			for(var s=0;s<remscripts.length;s++){
				var jsi = remscripts[s];
				var s = document.createElement("script");
                s.async = jsi.dataset.async == "yes";
				s.src = jsi.dataset.source;
				buffer.appendChild(s);
                jsi.parentNode.removeChild(jsi);
			}

            if(monolith_stack.configs.defaultPage == page && monolith_stack.configs.omitDefaultRoute == "1")
                history.pushState({}, "", "/");
            else
                history.pushState({}, "", page);

            self.attachScripts(buffer);
            self.attachNavigation();
            document.querySelector("monolith-event-emitter").dispatchEvent(navended_event);
        });        
    }

    self.processActionQueue = function() {
        if(!window.monolith_stack || !window.monolith_stack.action_queue)
            return;
        var aq = window.monolith_stack.action_queue;
        while(aq.length > 0){
            var entry = aq.pop();
            switch(entry.action){
                case "auto_load":
                    self.navigate(entry.data);
                    break;
            }
        }
    }

    self.attachScripts = function(node) {
        node.querySelectorAll("[data-attach]").forEach(function(n){
            var attachableName = n.dataset.attach + "Attachable";
            self.attachables[attachableName] = new window[attachableName](n);
        });
    }

    self.attachNavigation = function() {
        document.querySelectorAll("[data-goto]").forEach(function(mi){
            if(mi.dataset.navigationHandled == "yes")
                return;
            mi.addEventListener("click",window.navigation.goto);
            mi.dataset.navigationHandled = "yes";
        });
    }

    self.togglePreloadCurtain = function(toggle) {
        document.getElementsByTagName("MONOLITH-PRELOAD-CURTAIN")[0].style.opacity = (toggle) ? 1 : 0;
    }

    self.handlerForEvent = function(eventname,handler) {
        document.querySelector("monolith-event-emitter").addEventListener(eventname,handler);
    }

    self.signalPreloadEnd = function(){
        document.querySelector("monolith-event-emitter").dispatchEvent(preloadended_event);
    }

    self.preloadImages = function(images,callback) {
        var c2rr = 0;
        var checkCallbackFire = function(){
            c2rr--;
            if(c2rr==0)
                callback();
        };

        images.forEach(function(iurl){
            var img = new Image();
            img.onload = checkCallbackFire;
            img.onerror = checkCallbackFire;
            img.src = iurl;
            c2rr++;
        });        
    }

    init();
}

(function(){
    function polyfills() {
        if ( typeof window.CustomEvent !== "function" ){
            function CustomEvent ( event, params ) {
                params = params || { bubbles: false, cancelable: false, detail: undefined };
                var evt = document.createEvent("CustomEvent");
                evt.initCustomEvent( event, params.bubbles, params.cancelable, params.detail );
                return evt;
            }

            CustomEvent.prototype = window.Event.prototype;

            window.CustomEvent = CustomEvent;
            window.Event = CustomEvent;
        }

        if ( typeof NodeList.prototype.forEach !== "function" ){
            NodeList.prototype.forEach = Array.prototype.forEach
        }
    }

    polyfills();
    window.monolith = new monolith();
})();