window.OrangeFulfillment = (timeslot) => {
    let map = null;
    return {
        orderDate: null,
        orderTime: null,
        timeslot: timeslot,
        hideDeliveryAddress: false,
        showTimePicker: false,
        marker: null,
        mapKey: null,
        init() {
            this.mapKey = this.$wire.mapKey
            this.orderDate = this.$wire.get('orderDate');
            this.orderTime = this.$wire.get('orderTime');

            this.hideDeliveryAddress = this.$wire.get('orderType') !== 'delivery';
            this.showTimePicker = !this.$wire.get('previewMode') && this.$wire.get('isAsap') == 0;

            this.$wire.$watch('orderDate', value => {
                this.orderDate = value;
            });

            this.$wire.$watch('orderType', value => {
                this.hideDeliveryAddress = value !== 'delivery';
            });

            this.$wire.$watch('isAsap', value => {
                this.showTimePicker = value == 0;
            });

            this.$wire.on('resetMap', () => {
                if (map) {
                    map = null;
                }
            })

            this.$wire.on('updateDeliveryLocationMap', ({ lat, lng, geocoder}) => {
                if(!map) {
                    setTimeout(() => {
                        if (geocoder === 'nominatim') {
                            this.initializeOpenStreetMap(this.getPosition(lat, lng));
                        } else {
                            this.initializeGoogleMap(this.getPosition(lat, lng));
                        }
                    }, 500)
                } else {
                    if(geocoder === 'nominatim') {
                        map.setView(this.getPosition(lat, lng), 15);
                        this.marker.setLatLng(this.getPosition(lat, lng));
                    } else {
                        map.setCenter(this.getPosition(lat, lng));
                        this.marker.position = this.getPosition(lat, lng);
                    }
                }
            });
        },
        async initializeGoogleMap(position) {
            const {Map} = await google.maps.importLibrary('maps');
            const {AdvancedMarkerElement} = await google.maps.importLibrary('marker');

            map = new Map(document.getElementById('map'), {
                zoom: 15,
                center: position,
                mapId: 'DELIVERY_MAP_ID',
                disableDefaultUI: true,
            });

            this.marker = new AdvancedMarkerElement({
                map,
                position,
                title: 'Delivery Location',
            });

            const self = this;

            map.addListener('drag', () => {
                self.marker.position = map.getCenter();
            });
            map.addListener('dragend', () => {
                self.$wire.dispatch('userPositionUpdated', {
                    position: [ map.getCenter().lat(), map.getCenter().lng() ]
                });
            });
            map.addListener('click', (e) => {
                self.marker.position = e.latLng
                map.panTo(e.latLng);
                self.$wire.dispatch('userPositionUpdated', {
                    position: [ map.getCenter().lat(), map.getCenter().lng() ]
                });
            });
        },
        initializeOpenStreetMap(position) {
            map = L.map('map').setView(position, 15);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',

            }).addTo(map);
            this.marker = L.marker(position).addTo(map)
                .bindPopup('Delivery Location');

            const self = this;

            map.on('click', function(e) {
                self.marker.setLatLng(e.latlng);
                map.panTo(e.latlng);
                self.$wire.dispatch('userPositionUpdated', {
                    position: [e.latlng.lat, e.latlng.lng]
                });
            });
            map.on('drag', function() {
                self.marker.setLatLng(map.getCenter());
            });
            map.on('dragend', function() {
                self.$wire.dispatch('userPositionUpdated', {
                    position: [map.getCenter().lat, map.getCenter().lng]
                });
            });
        },
        getPosition(lat, lng) {
            return { lat: parseFloat(lat), lng: parseFloat(lng) };
        },
    };
}
