
$(document).ready(function() {
    function updateAddressInput() {
        realAddress.value = displayAddress.value;
    }

    var displayAddress = document.getElementById('kls_adminbundle_planning_latlng_input');
    var realAddress = document.getElementById('kls_adminbundle_planning_address');

    displayAddress.addEventListener('change', updateAddressInput);
    displayAddress.value = realAddress.value;
});