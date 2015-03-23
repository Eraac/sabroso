
$(document).ready(function()
{
    function postDelete() {
        var id = this.getAttribute('data-id');
        var type = this.getAttribute('data-type');
        var url = Routing.generate('sabroso_admin_delete_' + type, {'id': id}, true);

        //console.log(url);

        $.ajax({
            type: "POST",
            url: url
        })

        .done(function() {
                $('#line-' + id).remove();
                //console.log("success");
            })

        .fail(function() {
                alert("Une erreur est survénu");
                //console.log("error");
            })

        .always(function() {
                $('#' + id).modal('hide');
                //console.log("always");
            });
    }

    var listModal = document.querySelectorAll(".confirm-delete");

    for (var i = 0; i < listModal.length; i++)
        listModal[i].addEventListener('click', postDelete);
});