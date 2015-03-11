$(document).ready(function()
{
    function inverseButton()
    {
        // Presse = désactivée
        if (enablePressButton.prop('disabled')) {
            enablePressButton.show();
            enablePressButton.prop('disabled', false);
            disablePressButton.hide();
            disablePressButton.prop('disabled', true);
            statusPress.text("Désactivé");
            statusPress.attr('class', "text-danger");
        } else {
            enablePressButton.hide();
            enablePressButton.prop('disabled', true);
            disablePressButton.show();
            disablePressButton.prop('disabled', false);
            statusPress.text("Activé");
            statusPress.attr('class', "text-success");
        }
    }

    function hideButton()
    {
        if (enablePressButton.prop('disabled')) {
            enablePressButton.hide();
        } else {
            disablePressButton.hide();
        }
    }

    function sendChange(url)
    {
        //console.log(url);

        $.ajax({
            type: "POST",
            url: url
        })

            .done(function() {
                inverseButton();
            })

            .fail(function() {
                alert("Une erreur est survénu");
            })

    }

    function disablePress() {
        var url = Routing.generate('sabroso_admin_disable_press', {}, true);
        sendChange(url);
    }

    function enablePress() {
        var url = Routing.generate('sabroso_admin_enable_press', {}, true);
        sendChange(url);
    }

    var disablePressButton = $('#disablePressButton');
    var enablePressButton = $('#enablePressButton');
    var statusPress = $('#statusPress');

    disablePressButton.on('click', disablePress);
    enablePressButton.on('click', enablePress);

    hideButton();
});