$(function() {
    $("#spinner").hide();
    $("#no-packs-warning").hide();
    $("#select-pack-alert").hide();

    var availableTags = $("#delivery-area-names").val();
    var NoResultsLabel = "Location not found, Try any other nearest location";
    var jsonParsedAreaNames = JSON.parse(availableTags);

    function appendCards(areaName = "All") {
        $("#card-columns").empty();
        $("#select-pack-alert").hide();
        $("#spinner").show();
        $("#area_name").val(areaName);
        $.get("flyers?area=" + areaName, function(packs) {
            $("#spinner").hide();
            if (packs.length > 0) {
                $("#no-packs-warning").hide();
                $("#select-pack-alert").show();
            } else {
                $("#no-packs-warning").show();
                $("#select-pack-alert").hide();
            }

            packs.forEach(pack => {
                var card = "";
                card += '<div class="card text-dark bg-default pack">';
                card +=
                    '<a href="/images/flyers/' +
                    pack.file_name +
                    '" data-lightbox="roadtrip">';
                card +=
                    '<img class="card-img-top" src="/images/flyers/thumb-' +
                    pack.file_name +
                    '" alt="Pack">';
                card += "</a>";
                card += '<div class="card-body" style="padding: 0.8rem;">';
                if (pack.details) {
                    card +=
                        '<div class="card-text" style="font-weight:bold;">' +
                        pack.details +
                        "</div>";
                } else {
                    card +=
                        '<div class="card-text" style="font-weight:bold;">No Details</div>';
                }

                card += "</div>";
                card += "</div>";

                $("#card-columns").append(card);
            });
        }).fail(function() {
            $("#spinner").hide();
            alert("error");
        });
    }

    appendCards();

    $("#search-input").autocomplete({
        autoFocus: true,
        source: function(request, response) {
            var matcher = new RegExp(
                "^" + $.ui.autocomplete.escapeRegex(request.term),
                "i"
            );
            var results = $.grep(jsonParsedAreaNames, function(item) {
                return matcher.test(item);
            });

            if (!results.length) {
                results = [NoResultsLabel];
            }

            response(results.slice(0, 10));
        },
        select: function(event, ui) {
            if (ui.item.label === NoResultsLabel) {
                event.preventDefault();
            } else {
                appendCards(ui.item.value);
            }
        },
        focus: function(event, ui) {
            if (ui.item.label === NoResultsLabel) {
                event.preventDefault();
            }
        }
    });

    $("#file")
        .fileinput({
            uploadUrl: $("#file").attr("data-upload-url"),
            theme: "explorer",
            removeFromPreviewOnError: true,
            browseOnZoneClick: true,
            showUpload: false,
            showCancel: false,
            showRemove: false,
            validateInitialCount: true,
            required: true,
            browseLabel: "Select Photo",
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
        var deliveryAreas = $("#delivery-areas").val();
        if ($("#file").fileinput("getFilesCount") == 0) {
            alert("Please select image");
            return false;
        } else if (deliveryAreas.length == 0) {
            alert("Please add delivery areas");
            return false;
        } else {
            $("#file").fileinput("upload");
        }
    });

    $("#delivery-areas").tagsInput({
        minChars: 0,
        maxChars: null,
        placeholder: "Add areas by pressing enter key",
        limit: null,
        validationPattern: null,
        unique: true,
        autocomplete: {
            autoFocus: true,
            source: function(request, response) {
                var matcher = new RegExp(
                    "^" + $.ui.autocomplete.escapeRegex(request.term),
                    "i"
                );
                var results = $.grep(jsonParsedAreaNames, function(item) {
                    return matcher.test(item);
                });

                if (!results.length) {
                    results = [NoResultsLabel];
                }

                response(results.slice(0, 10));
            }
        }
    });

    $(".alert")
        .fadeTo(2000, 500)
        .slideUp(500, function() {
            $(".alert").slideUp(500);
        });
});
