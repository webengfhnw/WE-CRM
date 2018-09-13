$('#confirm-modal').on('show.bs.modal', function(e) {
    $(this).find('.btn-primary').attr('href', $(e.relatedTarget).data('href'));
});