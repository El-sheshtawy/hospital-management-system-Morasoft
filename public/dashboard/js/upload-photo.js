$(function () {
    $('#photo').change(function () {
        if (typeof (FileReader) != "undefined") {
            var dvPreview = $('#dvPreview');
            var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
            $($(this)[0].files).each(function () {
                var file = $(this);
                if (regex.test(file[0].name.toLowerCase())) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var img = $("<img />");
                        img.attr("style", "max-height:250px;width: 150px");
                        img.attr("src", e.target.result);
                        var div = $("<div style='float:left;' />");
                        $(div).html("<span style='float:right; cursor: pointer;' title='cancel' class='closeDiv'>X<span>");
                        div.append(img);

                        dvPreview.append(div);
                    }
                    reader.readAsDataURL(file[0]);
                } else {
                    alert(file[0].name + " is not a valid image file.");
                    dvPreview.html("");
                    return false;
                }
            });
        } else {
            alert("This browser does not support HTML5 FileReader.");
        }
    });

    $('body').on('click', '.closeDiv', function () {
        $(this).closest('div').remove();
        $('#photo').val('');
    });
});
