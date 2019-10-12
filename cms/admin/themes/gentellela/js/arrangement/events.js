/**
 * Created by ManTran on 6/24/2015.
 */
$(function(){
    $('#arrangement-form').on('submit', function(){
        var dataString = [];
        $('#arrangementSelected li').each(function(i, e){
            dataString.push($(this).data('id'));
        });
        $('#arrangementProduct').val(dataString.toString());
    });

    var support = $('.support-config');
    if(support.length > 0) {
        support.sortable();
        $('.add-support').on('click', function () {
            var children = support.find('li');
            var index = children.length;
            children.each(function(i, e) {
                var idx = $(this).data('index');
                if(index <= idx) {
                    index = idx + 1;
                }
            });

            support.append(
                '<li class="contact contact-item-' + index + '" data-index="' + index + '" draggable="true">' +
                    '<div class="row">' +
                        '<div class="col-2"><div class="form-group">' +
                            '<label class="control-label">Type</label>' +
                            '<select class="form-control" name="Support[' + index + '][type]">' +
                                '<option value="yahoo" selected="">Yahoo</option>' +
                                '<option value="skype">Skype</option>' +
                            '</select>' +
                        '</div></div>' +
                        '<div class="col-3"><div class="form-group">' +
                            '<label class="control-label">Name</label>' +
                            '<input type="text" class="form-control" name="Support[' + index + '][name]">' +
                        '</div></div>' +
                        '<div class="col-3"><div class="form-group">' +
                            '<label class="control-label">Nickname</label>' +
                            '<input type="text" class="form-control" name="Support[' + index + '][nickname]">' +
                        '</div></div>' +
                        '<div class="col-3"><div class="form-group">' +
                            '<label class="control-label">Phone</label>' +
                            '<input type="text" class="form-control" name="Support[' + index + '][phone]">' +
                        '</div></div>' +
                        '<div class="col-1"><div class="form-group">' +
                            '<label style="display: block">&nbsp;</label>' +
                            '<a class="remove-suport" href="javascript:void(0);"><i class="fa fa-trash-o"></i></a>' +
                        '</div></div>' +
                    '</div>' +
                '</li>'
            );
            support.sortable('destroy');
            support.sortable();
        });
        support.on('click', '.remove-suport', function () {
            $(this).parents('.contact').remove();
        });
    }
});
