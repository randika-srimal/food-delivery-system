$(function() {
    $("#file")
        .fileinput({
            uploadUrl: $("#file").attr("data-upload-url"),
            theme: "explorer-fas",
            browseOnZoneClick: true,
            showUpload: false,
            showCancel: false,
            showRemove: false,
            validateInitialCount: true,
            required: true,
            browseLabel: "Select Flyer",
            allowedFileExtensions: ["jpg", "png", "jpeg"],
            fileActionSettings: {
                showUpload: false,
                showZoom: false,
                showDrag: false
            },
            ajaxSettings: {
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                }
            }
        })
        .on("fileuploaded", function(event, data, previewId, index) {
            $("#flyer-file-name").val(data.response.uploadedFileName);
            $("#save-flyer-form").submit();
        });

    $("#submit-flyer-btn").click(function() {
        $("#file").fileinput("upload");
    });
});
