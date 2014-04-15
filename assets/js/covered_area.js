function LocationMap($map, serializedMap, editable) {
  var selectedArea,
      allAreas = [],
      map,
      addButton,
      deleteButton;

  console.log('creating map');

  //getBounds() method for the google.maps.Polygon class
	if (!google.maps.Polygon.prototype.getBounds) {
		google.maps.Polygon.prototype.getBounds = function() {
			var bounds = new google.maps.LatLngBounds();
			var paths = this.getPaths();
			var path;        
			for (var i = 0; i < paths.getLength(); i++) {
				path = paths.getAt(i);
				for (var ii = 0; ii < path.getLength(); ii++) {
					bounds.extend(path.getAt(ii));
				}
			}
			return bounds;
		}
	}

  map = new GoogleMap($map);

  google.maps.event.addDomListener(map, 'click',function(e){
    setSelectedArea(null);
  });

  loadMap(serializedMap);

  if (editable){
    $('#locationsForm').on('submit', onSubmitLocationForm);

    addButton = new CreateDeliveryAreaButton(map);
    deleteButton = new DeleteDeliveryAreaButton(map);


    $('.currentDeliveryArea').on('change', function(e){
      selectedArea.title = $(this).val();
    });
    $('.currentDeliveryAreaFee').on('change', function(e){
      selectedArea.fee = $(this).val();
    });

    $('#setDeliveryAreaColor').simpleColorPicker({
      onChangeColor: function(color){
        if(!selectedArea){
          return;
        }
        selectedArea.color = color;
        selectedArea.setOptions({ 
          fillColor: color,
          strokeColor: color
        });

      }

    });

  }//if editable

  function onSubmitLocationForm(e){

    var $map = $('input[name="map"]'),
        serialized;
  
    try {
      serialized = serialize(); 
    } catch (ex) {
      console.log(ex);
      alert(ex);
      // don't save
      e.preventDefault();
      return false;

    }

    $map.val(serialized);


  }

  function GoogleMap($map){

    // default is to center the map on the US
    // this will be overridden if map areas have been defined.
    var myLatLng = new google.maps.LatLng(39.8282, -98.5795);
    var mapOptions = {
      zoom: 4,
      center: myLatLng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };


    google.maps.visualRefresh = true;

    var map = new google.maps.Map($map.get(0),
        mapOptions);

    return map;
  }

  function loadMap(serializedMap){

    deserialize(serializedMap);


  }

  // object representing a button on the map
  function Control(map, title, text, clickHandler){
    this.controlDiv = document.createElement('div');
    var controlDiv = this.controlDiv;
    controlDiv.index = 1;

    // Set CSS styles for the DIV containing the control
    // Setting padding to 5 px will offset the control
    // from the edge of the map
    controlDiv.style.marginTop = '5px';
    controlDiv.style.marginRight = '5px';

    $(controlDiv).button();

    // Set CSS for the control border
    var controlUI = document.createElement('div');
    controlUI.style.backgroundColor = 'white';
    controlUI.style.borderStyle = 'solid';
    controlUI.style.borderWidth = '1px';
    controlUI.style.cursor = 'pointer';
    controlUI.style.textAlign = 'center';
    controlUI.title = title;
    controlDiv.appendChild(controlUI);

    // Set CSS for the control interior
    var controlText = document.createElement('div');
    controlText.style.fontFamily = 'Arial,sans-serif';
    controlText.style.fontSize = '12px';
    controlText.style.paddingLeft = '4px';
    controlText.style.paddingRight = '4px';
    controlText.innerHTML = text;
    controlUI.appendChild(controlText);

    google.maps.event.addDomListener(controlUI, 'click', clickHandler);

    map.controls[google.maps.ControlPosition.TOP_RIGHT].push(controlDiv);

  }


  function setSelectedArea(area){
    var text = 'None',
        fee = '';
    selectedArea = area;

    allAreas.forEach(function(thisArea){
      if (thisArea != area) {
        onAreaDeselected(thisArea);
      }
    });

    if (area) {
      text = area.title;
      fee = area.fee;
      onAreaSelected(area);
    } 

    $('.currentDeliveryArea').val(text);
    $('.currentDeliveryAreaFee').val(fee);
  }

  function onAreaDeselected(area){
    area.setOptions({ strokeWeight: 0, zIndex: 1, editable: false });
  }

  function onAreaSelected(area){
    area.setOptions({ strokeWeight: 3, zIndex: 2, editable: editable });
  }


  function onMouseDownArea(e){
    setSelectedArea(this);
  }

  function getNewDeliveryArea(map){
    var mapCenter,
        ne,
        sw,
        scale = 0.3,
        windowWidth,
        windowHeight,
        widthMargin,
        heightMargin,
        top,
        bottom,
        left,
        right,
        areaCoords,
        options,
        area;

    mapCenter = map.getCenter();
    ne = map.getBounds().getNorthEast();
    sw = map.getBounds().getSouthWest();
    scale = 0.3;
    windowWidth = ne.lng() - sw.lng();
    windowHeight = ne.lat() - sw.lat();
    widthMargin = windowWidth * scale;
    heightMargin = windowHeight * scale;

    top = ne.lat() - heightMargin;
    bottom = sw.lat() + heightMargin;
    left = sw.lng() + widthMargin;
    right = ne.lng() - widthMargin;

    areaCoords = [ 
      new google.maps.LatLng(top, right),
      new google.maps.LatLng(bottom, right),
      new google.maps.LatLng(bottom, left),
      new google.maps.LatLng(top, left)
      // auto-completes the rectagle; don't need to send back to first coord
    ];

    options = defaultPolygonOptions();
    options.editable = editable;
    options.paths = areaCoords;

    area = new google.maps.Polygon(options);

    area.title = 'delivery area ' + (allAreas.length + 1);
    area.fee = '';
    area.color = '#FF0000';

    return area;
  }

  function defaultPolygonOptions(){
    return {
      strokeColor: '#FF0000',
      fillColor: '#FF0000',
      strokeOpacity: 0.8,
      strokeWeight: 0,
      fillOpacity: 0.35
    };

  }
  
  function addDeliveryAreaToMap(area, map){

      allAreas.push(area);

      area.setMap(map);
      setSelectedArea(area);
      addDeliveryAreaEventHandlers(area);

  }

  function createDeliveryArea(map){
      var area;

      area = getNewDeliveryArea(map); 

      addDeliveryAreaToMap(area, map);

      return area;
  }

  function CreateDeliveryAreaButton(map) {
    var control = new Control(map, 'Click to add a delivery area', '<b>Add Delivery Area</b>', function(){
      var area;
      area = createDeliveryArea(map);
    }); 

    return control;
  }

  function decodeLevels(encodedLevelsString) {
      var decodedLevels = [];

      for (var i = 0; i < encodedLevelsString.length; ++i) {
          var level = encodedLevelsString.charCodeAt(i) - 63;
          decodedLevels.push(level);
      }
      return decodedLevels;
  }

  function removeArea(area){
    area.setMap(null);
    setSelectedArea(null);
    // remove the area from the list.
    index = allAreas.indexOf(area);
    allAreas.splice(index,1);
  }

  function DeleteDeliveryAreaButton(map){
    var control = new Control(map, 'Click to delete the delivery area', '<b>Delete</b>', function(){
      var index;

      if (selectedArea) {
        removeArea(selectedArea);
      } else {
        console.log('no delivery areas selected yet');
      }

    });

    return control;
  }



  function addDeliveryAreaEventHandlers(area){
    google.maps.event.addListener(area, 'mousedown', onMouseDownArea);
  }


  function reset(){
    
    allAreas.forEach(removeArea);

  }

  function resizeMaptoDeliveryAreas(map, areas){

    var allAreasBounds;

    if (!areas.length){
      return;
    }

    allAreasBounds = areas[0].getBounds();
    areas.forEach(function(area){
        var bounds = area.getBounds();
        allAreasBounds.union(bounds);
    });

    map.fitBounds(allAreasBounds);

  }

  function serialize(){
    var output = [];

    allAreas.forEach(function(area){
      output.push({ 
        title: area.title, 
        fee: area.fee,
        color: area.color,
        path: mapEncode(area.getPath())
      });

    });

    output = JSON.stringify(output)

    return output;
    
  }

  function mapEncode(valToEncode){
    var tmp1, tmp2;
    tmp1 = google.maps.geometry.encoding.encodePath(valToEncode);
    tmp2 = tmp1.replace(/\\/g,',').replace(/\//g,'-');
    return tmp2;
  }

  function mapDecode(valToDecode){
    var tmp1, tmp2;
    tmp1 = valToDecode.replace(/,/g,'\\').replace(/-/g,'\/');
    tmp2 = google.maps.geometry.encoding.decodePath(tmp1);
    return tmp2;
  }

  function deserialize(json){
    var decodedLevels = decodeLevels("BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB"),
        input = [];
   
    if (!json) {
      return;
    }
    try {
      input = JSON.parse(json);
    } catch (e){
      console.log(e);
      alert('There was a problem encountered loading the map for this location.  If you save this location you will overwrite the map in the database.  Contact restaurantbiller.com if you need assistance.');

    }

    reset();
    input.forEach(function(area){
      var polygon, 
          options,
          decodedPath;

      if (!area.path){
        return;
      }

      decodedPath = mapDecode(area.path);
      options = defaultPolygonOptions();
      options.path = decodedPath;
      options.strokeColor = area.color;
      options.fillColor = area.color;
      
      polygon = new google.maps.Polygon(options);
      polygon.title = area.title;
      polygon.fee = area.fee;
      polygon.color = area.color;

      addDeliveryAreaToMap(polygon, map);

    });
  
    resizeMaptoDeliveryAreas(map, allAreas);

  }
}