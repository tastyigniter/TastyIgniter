+function ($) {
    "use strict"

    if (typeof google === "object" && typeof google.maps === "object" && !google.maps.Polygon.prototype.getBounds) {
        google.maps.Polygon.prototype.getBounds = function () {
            var bounds = new google.maps.LatLngBounds()
            var paths = this.getPaths()
            var path
            for (var i = 0; i < paths.getLength(); i++) {
                path = paths.getAt(i)
                for (var ii = 0; ii < path.getLength(); ii++) {
                    bounds.extend(path.getAt(ii))
                }
            }
            return bounds
        }
    }

    if ($.ti.mapView === undefined)
        $.ti.mapView = {}

    var MapViewShape = function (el, options) {
        this.$mapView = $(options.options.mapView)
        this.mapObjects = {}

        this.options = $.extend({}, MapViewShape.DEFAULTS, options)
        this.drawOptions = $.extend({}, MapViewShape.DRAWING_DEFAULTS, options.options)

        this.visibleType = this.options.default

        this.init()
    }

    MapViewShape.prototype.dispose = function () {
        this.options = null
        this.$mapView = null
        this.clearMapObjects()
        this.visibleType = null
        this.drawOptions = null
    }

    MapViewShape.prototype.init = function () {
        this.makeCircle()
        this.makePolygon()
    }

    MapViewShape.prototype.setVisibleType = function (type) {
        this.visibleType = type
    }

    MapViewShape.prototype.makeCircle = function () {
        var self = this,
            shape = this.options,
            drawOptions = this.drawOptions,
            center = this.getOrCreateCenter(shape)

        if (!center)
            return

        drawOptions.center = new google.maps.LatLng(center.lat, center.lng)
        drawOptions.radius = center.radius
        drawOptions.visible = shape.default === 'circle'

        var drawing = new google.maps.Circle(drawOptions)

        google.maps.event.addListener(drawing, 'radius_changed', function () {
            self.onEventTriggered('radius_changed')
        })

        google.maps.event.addListener(drawing, 'center_changed', function () {
            self.onEventTriggered('center_changed')
        })

        this.setMapObject('circle', drawing)
    }

    MapViewShape.prototype.makePolygon = function () {
        var self = this,
            shape = this.options,
            drawOptions = this.drawOptions,
            paths = this.getOrCreatePaths(shape)

        if (!paths)
            return

        drawOptions.paths = paths
        drawOptions.visible = shape.default === 'polygon'

        var drawing = new google.maps.Polygon(drawOptions)

        google.maps.event.addListener(drawing.getPath(), 'insert_at', function () {
            self.onEventTriggered('insert_at')
        })

        google.maps.event.addListener(drawing.getPath(), 'set_at', function () {
            self.onEventTriggered('set_at')
        })

        this.setMapObject('polygon', drawing)
    }

    MapViewShape.prototype.setMapObject = function (type, drawing) {
        var self = this

        drawing.addListener('click', function () {
            self.onEventTriggered('click')
        })
        drawing.addListener('mouseover', function () {
            self.onEventTriggered('mouseover')
        })
        drawing.addListener('mouseout', function () {
            self.onEventTriggered('mouseout')
        })
        drawing.addListener('dragend', function () {
            self.onEventTriggered('dragend')
        })

        drawing.type = type
        this.mapObjects[type] = drawing

        // trigger shape drawn event
        this.$mapView.trigger('drawn.shape.ti.mapview', [this, drawing])
    }

    MapViewShape.prototype.getMapObject = function (type) {
        return (this.mapObjects[type]) ? this.mapObjects[type] : null
    }

    MapViewShape.prototype.getVisibleMapObject = function () {
        return this.getMapObject(this.visibleType)
    }

    MapViewShape.prototype.getSelectedMapObject = function () {
        var shapeObj = this.getMapObject(this.visibleType)
        if (!shapeObj || !shapeObj.editable) {
            return null
        }

        return shapeObj
    }

    MapViewShape.prototype.edit = function () {
        var shapeObj = this.getVisibleMapObject()

        this.clearEdit()

        if (!shapeObj) return

        shapeObj.setOptions({
            editable: true,
            fillOpacity: this.drawOptions.fillOpacity * 4,
            zIndex: this.drawOptions.zIndex * 100
        })

        this.$mapView.trigger('edit.shape.ti.mapview', [shapeObj, this])
    }

    MapViewShape.prototype.clearEdit = function () {
        this.setObjectsOptions({
            editable: false,
            fillOpacity: this.drawOptions.fillOpacity,
            strokeWeight: this.drawOptions.strokeWeight,
            zIndex: this.drawOptions.zIndex
        })
    }

    MapViewShape.prototype.bringToFront = function () {
        var shapeObj = this.getVisibleMapObject()

        if (!shapeObj) return

        shapeObj.setOptions({
            strokeWeight: this.drawOptions.strokeWeight * 2,
            zIndex: this.drawOptions.zIndex * 100
        })
    }

    MapViewShape.prototype.toggleVisible = function () {
        if (!Object.keys(this.mapObjects).length) {
            return null
        }

        for (var index in this.mapObjects) {
            var shapeObj = this.mapObjects[index]

            if (!shapeObj) continue

            shapeObj.setOptions({visible: !shapeObj.visible})
            if (shapeObj.visible) this.setVisibleType(shapeObj.type)

            var eventName = shapeObj.visible ? 'hide' : 'show'
            this.$mapView.trigger(eventName + '.shape.ti.mapview', [shapeObj, this])
        }
    }

    MapViewShape.prototype.show = function (type) {
        if (!Object.keys(this.mapObjects).length) {
            return null
        }

        for (var index in this.mapObjects) {
            var shapeObj = this.mapObjects[index]

            if (!shapeObj || (type && index != type)) continue

            shapeObj.setOptions({visible: true})
            if (shapeObj.visible) this.setVisibleType(shapeObj.type)

            this.$mapView.trigger('show.shape.ti.mapview', [shapeObj, this])
        }
    }

    MapViewShape.prototype.hide = function (type) {
        if (!Object.keys(this.mapObjects).length) {
            return null
        }

        for (var index in this.mapObjects) {
            var shapeObj = this.mapObjects[index]

            if (!shapeObj || (type && index != type)) continue

            shapeObj.setOptions({visible: false})
            if (shapeObj.visible) this.setVisibleType(shapeObj.type)

            this.$mapView.trigger('hide.shape.ti.mapview', [shapeObj, this])
        }
    }

    // HELPER METHODS
    // ============================

    MapViewShape.prototype.setObjectsOptions = function (options) {
        if (!Object.keys(this.mapObjects).length) {
            return null
        }

        for (var index in this.mapObjects) {
            if (!this.mapObjects[index]) continue
            this.mapObjects[index].setOptions(options)
        }
    }

    MapViewShape.prototype.clearMapObjects = function () {
        if (!Object.keys(this.mapObjects).length) {
            return null
        }

        for (var index in this.mapObjects) {
            if (this.mapObjects[index]) {
                this.mapObjects[index].setMap(null)
            }
        }

        this.mapObjects = {}
    }

    MapViewShape.prototype.getId = function () {
        return this.options.id
    }

    MapViewShape.prototype.getBounds = function () {
        var visibleObj = this.getVisibleMapObject(),
            bounds

        if (visibleObj)
            bounds = visibleObj.getBounds()

        return bounds
    }

    MapViewShape.prototype.getOrCreateCenter = function (shape) {
        if (!this.drawOptions.map)
            return

        var centerLatLng = this.drawOptions.map.getCenter(),
            circle = {
                lat: centerLatLng.lat(),
                lng: centerLatLng.lng(),
                radius: 1000 * (1 / 2)
            }

        if (shape.circle && shape.circle.center) {
            return {
                lat: shape.circle.center.lat,
                lng: shape.circle.center.lng,
                radius: shape.circle.radius,
            }
        }

        if (shape.circle && shape.circle.radius) {
            return {
                lat: shape.circle.lat,
                lng: shape.circle.lng,
                radius: shape.circle.radius,
            }
        }

        return circle
    }

    MapViewShape.prototype.getOrCreatePaths = function (shape) {
        if (!this.drawOptions.map)
            return

        if (shape.polygon) {
            return google.maps.geometry.encoding.decodePath(
                shape.polygon.replace(/,/g, '\\').replace(/-/g, '\/')
            )
        }

        var scale = 0.15,
            circleObj = this.getMapObject('circle'),
            ne = circleObj.getBounds().getNorthEast(),
            sw = circleObj.getBounds().getSouthWest(),
            top = ne.lat() - ((ne.lat() - sw.lat()) * scale),
            bottom = sw.lat() + ((ne.lat() - sw.lat()) * scale),
            left = sw.lng() + ((ne.lng() - sw.lng()) * scale),
            right = ne.lng() - ((ne.lng() - sw.lng()) * scale)

        return [
            new google.maps.LatLng(top, right),
            new google.maps.LatLng(bottom, right),
            new google.maps.LatLng(bottom, left),
            new google.maps.LatLng(top, left)
        ]
    }

    // EVENT HANDLERS
    // ============================

    MapViewShape.prototype.onEventTriggered = function (event) {
        var visibleMapObject = this.getVisibleMapObject()

        if (!visibleMapObject)
            return

        switch (event) {
            case 'set_at':
            case 'insert_at':
            case 'radius_changed':
            case 'center_changed':
                this.$mapView.trigger('changed.shape.ti.mapview', [event, visibleMapObject, this])
                break
            case 'click':
                this.$mapView.trigger('click.shape.ti.mapview', [visibleMapObject, this])
                break
            case 'mouseover':
                if (!visibleMapObject.editable)
                    visibleMapObject.setOptions({fillOpacity: this.drawOptions.fillOpacity * 3})
                this.$mapView.trigger('mouseover.shape.ti.mapview', [visibleMapObject, this])
                break
            case 'mouseout':
                if (!visibleMapObject.editable)
                    visibleMapObject.setOptions({fillOpacity: this.drawOptions.fillOpacity})
                this.$mapView.trigger('mouseout.shape.ti.mapview', [visibleMapObject, this])
                break
            case 'dragstart':
                this.$mapView.trigger('drag.shape.ti.mapview', [visibleMapObject, this])
                break
            case 'drag':
                this.$mapView.trigger('dragging.shape.ti.mapview', [visibleMapObject, this])
                break
            case 'dragend':
                this.$mapView.trigger('dragged.shape.ti.mapview', [visibleMapObject, this])
                break
        }
    }

    // Default shape options when creating map objects
    // Can be overridden within shapes array 'options' index
    MapViewShape.DRAWING_DEFAULTS = {
        map: undefined,
        editable: false,
        visible: false,
        draggable: true,
        strokeColor: '#F16745',
        fillColor: '#F16745',
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillOpacity: 0.15,
        zIndex: 2,
    }

    MapViewShape.DEFAULTS = {
        id: undefined,
        default: null,
        options: {},
        circle: null,
        polygon: null,
        vertices: null,
        serialized: false,
        editable: false, // turn on or off
    }

    $.ti.mapView.shape = MapViewShape
}(window.jQuery)
