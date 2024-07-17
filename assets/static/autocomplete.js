/********************************
 * Written by Filipe Laborde / fil@rezox.com
 * version 1.0, June-2024
 * 
 * Auto-complete form for TastyIgniter to auto-populate address locations
 * 
 */

function initAutocomplete() {
    // Create the autocomplete object, restricting the search to geographical location types
    let input_id, formPrefix = '';
    if( document.getElementById('street') ){
      input_id = 'street';
    } else if( document.getElementById('form-field-location-location-address-1') ){
      // admin edit location
      formPrefix = 'form-field-location-location-';
      input_id = 'address-1';
    } else {
      console.log( '[autocomplete-js] No fields needing google-maps autocomplete' );
      return false;
    }
    const input = document.getElementById(formPrefix+input_id);
    console.log( `[autocomplete-js] listening for changes on field #${formPrefix+input_id}: ` );
    if( !google || !google.maps || !google.maps.places ){
      console.log( `[autocomplete-js] GoogleMaps 'places' library not loaded, aborting.` );
      return false;
    }
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
        region: '',
        country: '',
        postalCode: '',
        locationId: place.place_id,
        latitude: place.geometry.location.lat(),
        longitude: place.geometry.location.lng()
      };

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
          addressDetails.region = component.long_name;
        }
        if (types.includes('country')) {
          addressDetails.country = component.long_name;
        }
        if (types.includes('postal_code')) {
          addressDetails.postalCode = component.long_name;
        }
      });
      // console.log( ` .. found address: addressDetails: `, addressDetails )
      // console.log( ` .. extracted from google addressComponents: `, addressComponents )

      // fill in details on the form
      if( document.getElementById(formPrefix+input_id))     document.getElementById(formPrefix+input_id).value = addressDetails.street;
      if( document.getElementById(formPrefix+'city'))       document.getElementById(formPrefix+'city').value = addressDetails.city;
      if( document.getElementById(formPrefix+'state'))      document.getElementById(formPrefix+'state').value = addressDetails.region;
      if( document.getElementById(formPrefix+'postcode'))   document.getElementById(formPrefix+'postcode').value = addressDetails.postalCode; 
      
      const countrySelect = document.getElementById(formPrefix+'country-id') || document.getElementById(formPrefix+'country');
      if( countrySelect ){
          for (let i = 0; i < countrySelect.options.length; i++) {
            if (countrySelect.options[i].text.trim() == addressDetails.country) {
              countrySelect.selectedIndex = i;
              countrySelect.value = i+1;
              // triggers update for BS modified SELECT boxes
              countrySelect.dispatchEvent(new Event('change'));
              break;
            }
          }
      }

      console.log( `[autocomplete-js] Autocomplete finished; Location: ${addressDetails.latitude},${addressDetails.longitude}` );
	  });
}

// Load the initAutocomplete function once the API has loaded, or in this case once everything loaded
window.addEventListener('load', initAutocomplete);

// document.addEventListener('DOMContentLoaded', 
//   ()=>{ google.maps.event.addDomListener(window, 'load', initAutocomplete); }
// );
// 