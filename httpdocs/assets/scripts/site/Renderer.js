// javascript:var%20Renderer%20=%20function(elt){var%20dom%20=%20$(elt)var%20canvas%20=%20dom.get(0)var%20ctx%20=%20canvas.getContext(%222d%22);var%20gfx%20=%20arbor.Graphics(canvas)var%20sys%20=%20nullvar%20_vignette%20=%20nullvar%20selected%20=%20null,nearest%20=%20null,_mouseP%20=%20null;var%20that%20=%20{init:function(pSystem){sys%20=%20pSystemsys.screen({size:{width:%20520,%20height:%20685},padding:[36,60,36,60]})$(window).resize(that.resize)that.resize()that._initMouseHandling()if%20(document.referrer.match(/echolalia|atlas|halfviz/)){that.switchSection(%27demos%27)}},resize:function(){canvas.width%20=%20560canvas.height%20=%20685sys.screen({size:{width:canvas.width,%20height:canvas.height}})_vignette%20=%20nullthat.redraw()},redraw:function(){gfx.clear()sys.eachEdge(function(edge,%20p1,%20p2){if%20(edge.source.data.alpha%20*%20edge.target.data.alpha%20==%200)%20returngfx.line(p1,%20p2,%20{stroke:%22#b2b19d%22,%20width:2,%20alpha:edge.target.data.alpha})})sys.eachNode(function(node,%20pt){var%20w%20=%20Math.max(20,%2020+gfx.textWidth(node.name)%20)if%20(node.data.alpha===0)%20returnif%20(node.data.shape==%27dot%27){gfx.oval(pt.x-w/2,%20pt.y-w/2,%20w,%20w,%20{fill:node.data.color,%20alpha:node.data.alpha})gfx.text(node.name,%20pt.x,%20pt.y+7,%20{color:%22white%22,%20align:%22center%22,%20font:%22Arial%22,%20size:12})gfx.text(node.name,%20pt.x,%20pt.y+7,%20{color:%22white%22,%20align:%22center%22,%20font:%22Arial%22,%20size:12})}else{gfx.rect(pt.x-w/2,%20pt.y-8,%20w,%2020,%204,%20{fill:node.data.color,%20alpha:node.data.alpha})gfx.text(node.name,%20pt.x,%20pt.y+9,%20{color:%22white%22,%20align:%22center%22,%20font:%22Arial%22,%20size:12})gfx.text(node.name,%20pt.x,%20pt.y+9,%20{color:%22white%22,%20align:%22center%22,%20font:%22Arial%22,%20size:12})}})that._drawVignette()},_drawVignette:function(){var%20w%20=%20canvas.widthvar%20h%20=%20canvas.heightvar%20r%20=%2020if%20(!_vignette){var%20top%20=%20ctx.createLinearGradient(0,0,0,r)top.addColorStop(0,%20%22#e0e0e0%22)top.addColorStop(.7,%20%22rgba(255,255,255,0)%22)var%20bot%20=%20ctx.createLinearGradient(0,h-r,0,h)bot.addColorStop(0,%20%22rgba(255,255,255,0)%22)bot.addColorStop(1,%20%22white%22)_vignette%20=%20{top:top,%20bot:bot}}ctx.fillStyle%20=%20_vignette.topctx.fillRect(0,0,%20w,r)ctx.fillStyle%20=%20_vignette.botctx.fillRect(0,h-r,%20w,r)},switchMode:function(e){if%20(e.mode==%27hidden%27){dom.stop(true).fadeTo(e.dt,0,%20function(){if%20(sys)%20sys.stop()$(this).hide()})}else%20if%20(e.mode==%27visible%27){dom.stop(true).css(%27opacity%27,0).show().fadeTo(e.dt,1,function(){that.resize()})if%20(sys)%20sys.start()}},switchSection:function(newSection){var%20parent%20=%20sys.getEdgesFrom(newSection)[0].sourcevar%20children%20=%20$.map(sys.getEdgesFrom(newSection),%20function(edge){return%20edge.target})sys.eachNode(function(node){if%20(node.data.shape==%27dot%27)%20return%20//%20skip%20all%20but%20leafnodesvar%20nowVisible%20=%20($.inArray(node,%20children)>=0)var%20newAlpha%20=%20(nowVisible)%20?%201%20:%200var%20dt%20=%20(nowVisible)%20?%20.5%20:%20.5sys.tweenNode(node,%20dt,%20{alpha:newAlpha})if%20(newAlpha==1){node.p.x%20=%20parent.p.x%20+%20.05*Math.random()%20-%20.025node.p.y%20=%20parent.p.y%20+%20.05*Math.random()%20-%20.025node.tempMass%20=%20.001}})},_initMouseHandling:function(){selected%20=%20null;nearest%20=%20null;var%20dragged%20=%20null;var%20oldmass%20=%201var%20_section%20=%20nullvar%20handler%20=%20{moved:function(e){var%20pos%20=%20$(canvas).offset();_mouseP%20=%20arbor.Point(e.pageX-pos.left,%20e.pageY-pos.top)nearest%20=%20sys.nearest(_mouseP);if%20(!nearest.node)%20return%20falseif%20(nearest.node.data.shape!=%27dot%27){selected%20=%20(nearest.distance%20<%2050)%20?%20nearest%20:%20nullif%20(selected){dom.addClass(%27linkable%27)window.status%20=%20selected.node.data.link.replace(/^\//,%22http://%22+window.location.host+%22/%22).replace(/^#/,%27%27)}else{dom.removeClass(%27linkable%27)window.status%20=%20%27%27}}else%20if%20($.inArray(nearest.node.name,%20[%27arbor.js%27,%27code%27,%27docs%27,%27demos%27])%20>=0%20){if%20(nearest.node.name!=_section){_section%20=%20nearest.node.namethat.switchSection(_section)}dom.removeClass(%27linkable%27)window.status%20=%20%27%27}return%20false},clicked:function(e){var%20pos%20=%20$(canvas).offset();_mouseP%20=%20arbor.Point(e.pageX-pos.left,%20e.pageY-pos.top)nearest%20=%20dragged%20=%20sys.nearest(_mouseP);if%20(nearest%20&&%20selected%20&&%20nearest.node===selected.node){var%20link%20=%20selected.node.data.linkif%20(link.match(/^#/)){$(that).trigger({type:%22navigate%22,%20path:link.substr(1)})}else{window.location%20=%20link}return%20false}if%20(dragged%20&&%20dragged.node%20!==%20null)%20dragged.node.fixed%20=%20true$(canvas).unbind(%27mousemove%27,%20handler.moved);$(canvas).bind(%27mousemove%27,%20handler.dragged)$(window).bind(%27mouseup%27,%20handler.dropped)return%20false},dragged:function(e){var%20old_nearest%20=%20nearest%20&&%20nearest.node._idvar%20pos%20=%20$(canvas).offset();var%20s%20=%20arbor.Point(e.pageX-pos.left,%20e.pageY-pos.top)if%20(!nearest)%20returnif%20(dragged%20!==%20null%20&&%20dragged.node%20!==%20null){var%20p%20=%20sys.fromScreen(s)dragged.node.p%20=%20p}return%20false},dropped:function(e){if%20(dragged===null%20||%20dragged.node===undefined)%20returnif%20(dragged.node%20!==%20null)%20dragged.node.fixed%20=%20falsedragged.node.tempMass%20=%201000dragged%20=%20null;$(canvas).unbind(%27mousemove%27,%20handler.dragged)$(window).unbind(%27mouseup%27,%20handler.dropped)$(canvas).bind(%27mousemove%27,%20handler.moved);_mouseP%20=%20nullreturn%20false}}$(canvas).mousedown(handler.clicked);$(canvas).mousemove(handler.moved);}}return%20that}var%20Nav%20=%20function(elt){var%20dom%20=%20$(elt)var%20_path%20=%20nullvar%20that%20=%20{init:function(){$(window).bind(%27popstate%27,that.navigate)dom.find(%27>%20a%27).click(that.back)$(%27.more%27).one(%27click%27,that.more)$(%27#docs%20dl:not(.datastructure)%20dt%27).click(that.reveal)that.update()return%20that},more:function(e){$(this).removeAttr(%27href%27).addClass(%27less%27).html(%27&nbsp;%27).siblings().fadeIn()$(this).next(%27h2%27).find(%27a%27).one(%27click%27,%20that.less)return%20false},less:function(e){var%20more%20=%20$(this).closest(%27h2%27).prev(%27a%27)$(this).closest(%27h2%27).prev(%27a%27).nextAll().fadeOut(function(){$(more).text(%27creation%20&%20use%27).removeClass(%27less%27).attr(%27href%27,%27#%27)})$(this).closest(%27h2%27).prev(%27a%27).one(%27click%27,that.more)return%20false},reveal:function(e){$(this).next(%27dd%27).fadeToggle(%27fast%27)return%20false},back:function(){_path%20=%20%22/%22if%20(window.history%20&&%20window.history.pushState){window.history.pushState({path:_path},%20%22%22,%20_path);}that.update()return%20false},navigate:function(e){var%20oldpath%20=%20_pathif%20(e.type==%27navigate%27){_path%20=%20e.pathif%20(window.history%20&&%20window.history.pushState){window.history.pushState({path:_path},%20%22%22,%20_path);}else{that.update()}}else%20if%20(e.type==%27popstate%27){var%20state%20=%20e.originalEvent.state%20||%20{}_path%20=%20state.path%20||%20window.location.pathname.replace(/^\//,%27%27)}if%20(_path%20!=%20oldpath)%20that.update()},update:function(){var%20dt%20=%20%27fast%27if%20(_path===null){_path%20=%20window.location.pathname.replace(/^\//,%27%27)dt%20=%200dom.find(%27p%27).css(%27opacity%27,0).show().fadeTo(%27slow%27,1)}switch%20(_path){case%20%27%27:case%20%27/%27:dom.find(%27p%27).text(%27a%20graph%20visualization%20library%20using%20web%20workers%20and%20jQuery%27)dom.find(%27>%20a%27).removeClass(%27active%27).attr(%27href%27,%27#%27)$(%27#docs%27).fadeTo(%27fast%27,0,%20function(){$(this).hide()$(that).trigger({type:%27mode%27,%20mode:%27visible%27,%20dt:dt})})document.title%20=%20%22arbor.js%22breakcase%20%27introduction%27:case%20%27reference%27:$(that).trigger({type:%27mode%27,%20mode:%27hidden%27,%20dt:dt})dom.find(%27>%20p%27).text(_path)dom.find(%27>%20a%27).addClass(%27active%27).attr(%27href%27,%27#%27)$(%27#docs%27).stop(true).css({opacity:0}).show().delay(333).fadeTo(%27fast%27,1)$(%27#docs%27).find(%22>div%22).hide()$(%27#docs%27).find(%27#%27+_path).show()document.title%20=%20%22arbor.js%20%C2%BB%20%22%20+%20_pathbreak}}}return%20that}
var Renderer = function(elt) {
    var dom = $(elt)
    var canvas = dom.get(0)
    var ctx = canvas.getContext("2d");
    var gfx = arbor.Graphics(canvas)
    var sys = null

    var _vignette = null
    var selected = null,
    nearest = null,
    _mouseP = null;


    var that = {
        init: function(pSystem) {
            sys = pSystem
            sys.screen({
                size: {
                    width: 520,
                    height: 685
                },
                padding: [36, 60, 36, 60]
            })

            $(window).resize(that.resize)
            that.resize()
            that._initMouseHandling()

            if (document.referrer.match(/echolalia|atlas|halfviz/)) {
                // if we got here by hitting the back button in one of the demos,
                // start with the demos section pre-selected
                that.switchSection('demos')
            }
        },
        resize: function() {
            canvas.width = 560
            canvas.height = 685
            sys.screen({
                size: {
                    width: canvas.width,
                    height: canvas.height
                }
            })
            _vignette = null
            that.redraw()
        },
        redraw: function() {
            gfx.clear()
            sys.eachEdge(function(edge, p1, p2) {
                if (edge.source.data.alpha * edge.target.data.alpha == 0) return
                gfx.line(p1, p2, {
                    stroke: "#b2b19d",
                    width: 2,
                    alpha: edge.target.data.alpha
                })
            })
            sys.eachNode(function(node, pt) {
                var w = Math.max(20, 20 + gfx.textWidth(node.name))
                if (node.data.alpha === 0) return
                if (node.data.shape == 'dot') {
                    gfx.oval(pt.x - w / 2, pt.y - w / 2, w, w, {
                        fill: node.data.color,
                        alpha: node.data.alpha
                    })
                    gfx.text(node.name, pt.x, pt.y + 7, {
                        color: "white",
                        align: "center",
                        font: "Helvetica",
                        size: 15
                    })
                    gfx.text(node.name, pt.x, pt.y + 7, {
                        color: "white",
                        align: "center",
                        font: "Helvetica",
                        size: 15
                    })
                } else {
                    gfx.rect(pt.x - w / 2, pt.y - 8, w, 20, 4, {
                        fill: node.data.color,
                        alpha: node.data.alpha
                    })
                    gfx.text(node.name, pt.x, pt.y + 9, {
                        color: "white",
                        align: "center",
                        font: "Helvetica",
                        size: 11
                    })
                }
            })
            that._drawVignette()
        },

        _drawVignette: function() {
            var w = canvas.width
            var h = canvas.height
            var r = 20

            if (!_vignette) {
                var top = ctx.createLinearGradient(0, 0, 0, r)
                top.addColorStop(0, "#e0e0e0")
                top.addColorStop(.7, "rgba(255,255,255,0)")

                var bot = ctx.createLinearGradient(0, h - r, 0, h)
                bot.addColorStop(0, "rgba(255,255,255,0)")
                bot.addColorStop(1, "white")

                _vignette = {
                    top: top,
                    bot: bot
                }
            }

            // top
            ctx.fillStyle = _vignette.top
            ctx.fillRect(0, 0, w, r)

            // bot
            ctx.fillStyle = _vignette.bot
            ctx.fillRect(0, h - r, w, r)
        },

        switchMode: function(e) {
            if (e.mode == 'hidden') {
                dom.stop(true).fadeTo(e.dt, 0,
                function() {
                    if (sys) sys.stop()
                    $(this).hide()
                })
            } else if (e.mode == 'visible') {
                dom.stop(true).css('opacity', 0).show().fadeTo(e.dt, 1,
                function() {
                    that.resize()
                })
                if (sys) sys.start()
            }
        },

        switchSection: function(newSection) {
            var parent = sys.getEdgesFrom(newSection)[0].source
            var children = $.map(sys.getEdgesFrom(newSection),
            function(edge) {
                return edge.target
            })

            sys.eachNode(function(node) {
                if (node.data.shape == 'dot') return
                // skip all but leafnodes
                var nowVisible = ($.inArray(node, children) >= 0)
                var newAlpha = (nowVisible) ? 1: 0
                var dt = (nowVisible) ? .5: .5
                sys.tweenNode(node, dt, {
                    alpha: newAlpha
                })

                if (newAlpha == 1) {
                    node.p.x = parent.p.x + .05 * Math.random() - .025
                    node.p.y = parent.p.y + .05 * Math.random() - .025
                    node.tempMass = .001
                }
            })
        },


        _initMouseHandling: function() {
            // no-nonsense drag and drop (thanks springy.js)
            selected = null;
            nearest = null;
            var dragged = null;
            var oldmass = 1

            var _section = null

            var handler = {
                moved: function(e) {
                    var pos = $(canvas).offset();
                    _mouseP = arbor.Point(e.pageX - pos.left, e.pageY - pos.top)
                    nearest = sys.nearest(_mouseP);

                    sys.eachNode(function(node) {
                    	node.mass = (nearest.node.data.shape == 'dot') ? 120 : 3;
                    });

                    if (!nearest.node) return false

                    nearest.node.mass = (nearest.node.data.shape == 'dot') ? 840 : 20;

                    return false
                },
                clicked: function(e) {
                    var pos = $(canvas).offset();
                    _mouseP = arbor.Point(e.pageX - pos.left, e.pageY - pos.top)
                    nearest = dragged = sys.nearest(_mouseP);

                    if (nearest && selected && nearest.node === selected.node) {
                        var link = selected.node.data.link
                        if (link.match(/^#/)) {
                            $(that).trigger({
                                type: "navigate",
                                path: link.substr(1)
                            })
                        } else {
                            window.location = link
                        }
                        return false
                    }


                    if (dragged && dragged.node !== null) dragged.node.fixed = true

                    $(canvas).unbind('mousemove', handler.moved);
                    $(canvas).bind('mousemove', handler.dragged)
                    $(window).bind('mouseup', handler.dropped)

                    return false
                },
                dragged: function(e) {
                    var old_nearest = nearest && nearest.node._id
                    var pos = $(canvas).offset();
                    var s = arbor.Point(e.pageX - pos.left, e.pageY - pos.top)

                    if (!nearest) return
                    if (dragged !== null && dragged.node !== null) {
                        var p = sys.fromScreen(s)
                        dragged.node.p = p
                    }

                    return false
                },

                dropped: function(e) {
                    if (dragged === null || dragged.node === undefined) return
                    if (dragged.node !== null) dragged.node.fixed = false
                    dragged.node.tempMass = 1000
                    dragged = null;
                    // selected = null
                    $(canvas).unbind('mousemove', handler.dragged)
                    $(window).unbind('mouseup', handler.dropped)
                    $(canvas).bind('mousemove', handler.moved);
                    _mouseP = null
                    return false
                }


            }

            $(canvas).mousedown(handler.clicked);
            $(canvas).mousemove(handler.moved);

        }
    }

    return that
}


var Nav = function(elt) {
    var dom = $(elt)

    var _path = null

    var that = {
        init: function() {
            $(window).bind('popstate', that.navigate)
            dom.find('> a').click(that.back)
            $('.more').one('click', that.more)

            $('#docs dl:not(.datastructure) dt').click(that.reveal)
            that.update()
            return that
        },
        more: function(e) {
            $(this).removeAttr('href').addClass('less').html('&nbsp;').siblings().fadeIn()
            $(this).next('h2').find('a').one('click', that.less)

            return false
        },
        less: function(e) {
            var more = $(this).closest('h2').prev('a')
            $(this).closest('h2').prev('a')
            .nextAll().fadeOut(function() {
                $(more).text('creation & use').removeClass('less').attr('href', '#')
            })
            $(this).closest('h2').prev('a').one('click', that.more)

            return false
        },
        reveal: function(e) {
            $(this).next('dd').fadeToggle('fast')
            return false
        },
        back: function() {
            _path = "/"
            if (window.history && window.history.pushState) {
                window.history.pushState({
                    path: _path
                },
                "", _path);
            }
            that.update()
            return false
        },
        navigate: function(e) {
            var oldpath = _path
            if (e.type == 'navigate') {
                _path = e.path
                if (window.history && window.history.pushState) {
                    window.history.pushState({
                        path: _path
                    },
                    "", _path);
                } else {
                    that.update()
                }
            } else if (e.type == 'popstate') {
                var state = e.originalEvent.state || {}
                _path = state.path || window.location.pathname.replace(/^\//, '')
            }
            if (_path != oldpath) that.update()
        },
        update: function() {
            var dt = 'fast'

        }
    }
    return that
}