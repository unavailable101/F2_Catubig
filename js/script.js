$(document).on('click', '.btn-add', function(e){
    e.preventDefault();
    var prev = $("#to-add").children().first();
    if (prev.length){
        var btn = prev.find('.btn-add');
        btn.val('Remove');
        btn.removeClass('btn-add').addClass('btn-remove');
    }
    $("#to-add").prepend(`
    <div class="add-more">
        <input class="typing" type="text" name="org[]" >
        <input type="button" class="btn-add" value="Add">
    </div>
    `);
});

$(document).on('click', '.btn-remove', function(e){
    e.preventDefault();
    let row = $(this).parent();
    $(row).remove();
});

// $("#update-profile").submit(function(e){
//     e.preventDefault();
//     $.ajax({
//         url: '../includes/org-update.php',
//         method: 'post',
//         data: $(this).serialize(),
//         success: function(response){
//             console.log(response);
//         }
//     })
// });