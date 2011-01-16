// http://raphaeljs.com/reference.html
//
// site.js
//
// the arbor.js website
//
(function($) {
    // var trace = function(msg){
    //   if (typeof(window)=='undefined' || !window.console) return
    //   var len = arguments.length, args = [];
    //   for (var i=0; i<len; i++) args.push("arguments["+i+"]")
    //   eval("console.log("+args.join(",")+")")
    // }
    $(document).ready(function() {
        var CLR = {
            branch: "#888888",
        }

        var theUI = {
            nodes: {
                "YOU": {
                    color: "black",
                    shape: "dot",
                    alpha: 1
                }
            },
            edges: {
            }
        }


        var sys = arbor.ParticleSystem()
        sys.parameters({
            stiffness: 350,
            repulsion: 2000,
            gravity: true,
            friction: 0.3,
            dt: 0.015
        })
        sys.renderer = Renderer("#vis")
        sys.graft(theUI)
    });
})(this.jQuery)