$(function() {
    $("#spinner").hide();
    var authUserId = $("#auth-user-id").val();

    function getUrlParameter(sParam) {
        var sPageURL = window.location.search.substring(1),
            sURLVariables = sPageURL.split("&"),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split("=");

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined
                    ? true
                    : decodeURIComponent(sParameterName[1]);
            }
        }
    }

    if (getUrlParameter("action") == "openAddPackDialog") {
        $("#add-pack-modal").modal("toggle");
    }

    var availableTags = $("#delivery-area-names").val();
    var NoResultsLabel = "Location not found, Try any other nearest location";
    var jsonParsedAreaNames = JSON.parse(availableTags);

    function appendCards(areaName) {
        var cityName = areaName ? areaName : "";

        $("#share-btn-text").text(cityName.length>0?'Share '+cityName+' Results on Facebook':'Share on Facebook')

        $("#card-columns").empty();
        $("#spinner").show();
        $("#share-btn").hide();
        $("#area_name").val(cityName);
        $.get("flyers?area=" + cityName, function(packs) {
            $("#share-btn").show();
            $("#spinner").hide();
            if (packs.length > 0) {
                $("#no-packs-warning").addClass("d-none");
            } else {
                $("#no-packs-warning").removeClass("d-none");
            }

            packs.forEach(pack => {
                var card = "";
                card +=
                    '<div class="card text-dark bg-default pack" id="pack-wrap-' +
                    pack.id +
                    '">';
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
                card +=
                    '<h6 class="card-subtitle mb-2 text-muted"><img class="avatar" src="https://graph.facebook.com/' +
                    pack.user.provider_id +
                    '/picture?type=small"> ' +
                    pack.user.name +
                    "</h6>";
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
                if (authUserId == pack.user_id) {
                    card +=
                        '<div class="card-footer"><button pack-id="' +
                        pack.id +
                        '" title="Delete" type="button" class="btn btn-md btn-danger pack-delete-btn">';
                    card += '<i class="fa fa-trash"></i></button></div>';
                }

                card += "</div>";

                $("#card-columns").append(card);
            });
        }).fail(function() {
            $("#share-btn").show();
            $("#spinner").hide();
            console.error("Something Went Wrong");
        });
    }

    appendCards(getUrlParameter("city"));

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

    $(".main-alert")
        .fadeTo(2000, 500)
        .slideUp(500, function() {
            $(".main-alert").slideUp(500);
        });

    $(document).on("click", ".pack-delete-btn", function() {
        var packId = $(this).attr("pack-id");

        $.post(
            {
                url: "flyers/" + packId + "/delete",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                }
            },
            function(response) {
                $("#pack-wrap-" + packId).slideUp(500);
            }
        ).fail(function() {
            console.error("Something Went Wrong");
        });
    });

    $("#share-btn").click(function() {
        var cityName = $("#search-input").val();

        $.post(
            {
                url: "cities/generate-share-image",
                data: {
                    city_name: cityName
                },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                }
            },
            function(response) {
                FB.ui(
                    {
                        method: "share",
                        href:
                            cityName.length > 0
                                ? "https://" +
                                  window.location.hostname +
                                  "?city=" +
                                  cityName
                                : "https://" + window.location.hostname
                    },
                    function(response) {
                        console.error("Shared successfully");
                    }
                );
            }
        ).fail(function() {
            console.error("Something Went Wrong");
        });
    });
});
