$(document).ready(function() {
    $('body').on("click", ".modalLink", function(e) {
        e.preventDefault();
        $('.modal-backdrop').show();
        $("#showDetaildModal").show();
        $("div.modal-dialog").removeClass('modal-md');
        $("div.modal-dialog").removeClass('modal-lg');
        $("div.modal-dialog").removeClass('modal-bg');
        var modal_size = $(this).attr('data-modal-size');
        if (modal_size !== '' && typeof modal_size !== typeof undefined && modal_size !== false) {
            $("#modalSize").addClass(modal_size);
        } else {
            $("#modalSize").addClass('modal-md');
        }
        var title = $(this).attr('title');
        $("#showDetaildModalTile").text(title);
        var data_title = $(this).attr('data-original-title');
        $("#showDetaildModalTile").text(data_title);
        $("#showDetaildModal").modal('show');
        $('div.ajaxLoader').show();
        $.ajax({
            type: "GET",
            url: $(this).attr('href'),
            success: function(data) {
                $("#showDetaildModalBody").html(data);
                $("#showDetaildModal").modal('show');
            }
        });
    });
});