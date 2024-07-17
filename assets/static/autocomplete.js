/********************************
 * Written by Filipe Laborde / fil@rezox.com
 * version 1.0, June-2024
 * 
 * Painless auto-complete form for TastyIgniter to auto-complete address locations
 * 
 */

// gets actual element from the name & type; auto-adjusts some field parts based on TI formating
function _getElement( field,type='id' ){
  const el = type=='id' ? document.getElementById(field) 
           : document.getElementsByName(field.replace('-','_') + (field.includes('[') ? ']' : '') )[0];
  return el;
}

// function to attach google autocomplete to some html element (and fill it's associated form fields)
function attachAutocomplete( input, type='id', namePrefix='' ) {
    if( !google || !google.maps || !google.maps.places ){
      console.log( `[autocomplete-js] GoogleMaps 'places' library not loaded, aborting.` );
      if(intervalAutocomplete) clearInterval(intervalAutocomplete);
      intervalAutocomplete = null;
      return false;
    }
    console.log( `[autocomplete-js] attaching(${type=='id'?'id='+input.id:'name='+input.name})`);

    try {
      const autocomplete = new google.maps.places.Autocomplete(input);
      // When the user selects an address from the dropdown, you can get more details about the place
      autocomplete.addListener('place_changed', function () {
        const place = autocomplete.getPlace();
        if (!place.geometry) {
          // User entered the name of a Place that was not suggested and pressed the Enter key
          window.alert("No details available for input: '" + place.name + "'");
          return;
        }

        const addressComponents = place.address_components;

        const addressDetails = {
          street: '',
          city: '',
          state: '',
          country: '',
          postcode: '',
          locationId: place.place_id,
          latitude: place.geometry.location.lat(),
          longitude: place.geometry.location.lng()
        };

        // decode google's info block to an addressDetails block we can map to form fields
        addressComponents.forEach(component => {
          const types = component.types;
          if (types.includes('street_number')) {
            addressDetails.street = component.long_name + ' ' + addressDetails.street;
          }
          if (types.includes('route')) {
            addressDetails.street += component.long_name;
          }
          if (types.includes('locality')) {
            addressDetails.city = component.long_name;
          } else if( addressDetails.city==='' && types.includes('administrative_area_level_2')){
            addressDetails.city = component.long_name;
          }
          if (types.includes('administrative_area_level_1')) {
            addressDetails.state = component.long_name;
          }
          if (types.includes('country')) {
            addressDetails.country = component.long_name;
          }
          if (types.includes('postal_code')) {
            addressDetails.postcode = component.long_name;
          }
        });
        // console.log( ` .. extracted from google addressComponents: `, addressComponents ) // if debugging see Google's fields here

        // fill in details on the form
        input.value = addressDetails.street;
        ['city','state','postcode'].forEach( name=>{
          const el = _getElement(namePrefix+name,type); // type=='id' ? document.getElementById(namePrefix+name) : document.getElementByName(namePrefix+name+']');
          if( el ){
            console.log( `[autocomplete-js] field[${type=='id'?'id='+el.id:'name='+el.name}]='${addressDetails[name]}'` );
            el.value = addressDetails[name]
          } else {
            console.log( `[autocomplete-js] invalid element for ${name}!`)
          }
        })
        
        const elSelect = type=='id' && namePrefix=='' && document.getElementById('country') ? document.getElementById('country') :
                        _getElement(namePrefix+'country-id',type)
        if( elSelect ){
            for (let i = 0; i < elSelect.options.length; i++) {
              if (elSelect.options[i].text.trim() == addressDetails.country) {
                elSelect.selectedIndex = i;
                elSelect.value = i+1;
                // triggers update for BS modified SELECT boxes
                elSelect.dispatchEvent(new Event('change'));
                break;
              }
            }
        }

        console.log( `[autocomplete-js] Autocomplete finished; Location: ${addressDetails.latitude},${addressDetails.longitude}` );
      });
    } catch( e ){
      console.log( `[autocomplete-js] Problem with autocomplete:`, e );
    }
}

function autoBindAddressToAutocomplete(){
    const els = document.getElementsByTagName('INPUT');
    // console.log( `[autocomplete-js] els (${els.length})` )
    for (let i = 0; i < els.length; i++) {
        const el_name = els[i].name.toLowerCase();
        if( el_name.includes('address_1') || el_name.includes('address_2') || el_name.includes('street') ){
            const el = els[i];
            const bindSet = el?.dataset?.autocomplete || false;
            if( !bindSet ){
              el.dataset['autocomplete'] = true; // mark as autocomplete attached
              if( el.id ){
                // if it's got an ID, then we can use that for all the form fields
                // get the prefix being all the field-name up to that last 'address_1/2'
                const namePrefix = el.id.substring(0,el.id.lastIndexOf('address'))
                attachAutocomplete( el,'id', namePrefix )
              } else {
                // no ID, use the name field, and again determine prefix field-name
                const namePrefix = el.name.substring(0,el.name.lastIndexOf('address'))
                attachAutocomplete( el,'name', namePrefix )
              }
            }
        }
    }
}

// start scanning for address INPUT fields to attach autocomplete to, scans every 5s
let intervalAutocomplete;
document.addEventListener('DOMContentLoaded', ()=>{ intervalAutocomplete=setInterval(autoBindAddressToAutocomplete, 5000);autoBindAddressToAutocomplete(); });