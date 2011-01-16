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
            branch: "#b2b19d",
            code: "orange",
            doc: "#922E00",
            demo: "#a7af00"
        }

        var theUI = {
            nodes: {
                "CultureScore": {
                    color: "red",
                    shape: "dot",
                    alpha: 1
                },
                Your: {
                    color: CLR.branch,
                    shape: "dot",
                    alpha: 1
                },
                Culture: {
                    color: CLR.branch,
                    shape: "dot",
                    alpha: 1
                },
                Score: {
                    color: CLR.branch,
                    shape: "dot",
                    alpha: 1
                },
            },
            edges: {
                "CultureScore": {
                    Your: {
                        length: 6
                    },
                    Culture: {
                        length: 6
                    },
                    Score: {
                        length: 6
                    }
                },
                Your: {},
                Culture: {},
                Score: {}
            }
        }


        var sys = arbor.ParticleSystem()
        sys.parameters({
            stiffness: 900,
            repulsion: 2000,
            gravity: true,
            dt: 0.015
        })
        sys.renderer = Renderer("#vis")
        sys.graft(theUI)
    });
})(this.jQuery)