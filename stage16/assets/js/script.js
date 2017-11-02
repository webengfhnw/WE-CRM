$('#confirm-modal').on('show.bs.modal', function(e) {
    $(this).find('.btn-primary').attr('data-id', $(e.relatedTarget).data('id'));
});