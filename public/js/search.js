$(function() {
    $("#spinner").hide();
    $("#no-packs-warning").hide();
    $("#select-pack-alert").hide();

    var availableTags = $("#delivery-area-names").val();
    var NoResultsLabel = "Location not found, Try any other nearest location";
    var jsonParsedAreaNames = JSON.parse(availableTags);

    $("#search-input").autocomplete({
        autoFocus: true,
        source: function(request, response) {
            var results = $.ui.autocomplete.filter(
                jsonParsedAreaNames,
                request.term
            );

            if (!results.length) {
                results = [NoResultsLabel];
            }

            response(results);
        },
        select: function(event, ui) {
            if (ui.item.label === NoResultsLabel) {
                event.preventDefault();
            } else {
                $("#card-columns").empty();
                $("#select-pack-alert").hide();
                $("#spinner").show();
                $("#area_name").val(ui.item.value);
                $.get("flyers?area=" + ui.item.value, function(packs) {
                    $("#spinner").hide();
                    if (packs.length > 0) {
                        $("#no-packs-warning").hide();
                        $("#select-pack-alert").show();
                    } else {
                        $("#no-packs-warning").show();
                        $("#select-pack-alert").hide();
                    }
                    packs.sort(function(a, b) {
                        return a.price - b.price;
                    });
                    packs.forEach(pack => {
                        var card = "";
                        card +=
                            '<div class="card text-dark bg-default pack" style="width: 18rem;">';
                        card +=
                            '<a href="/images/flyers/' +
                            pack.file_name +
                            '" data-lightbox="roadtrip">';
                        card +=
                            '<img class="card-img-top" src="/images/flyers/thumb-' +
                            pack.file_name +
                            '" alt="Pack">';
                        card += '</a>';
                        card +=
                            '<div class="card-body" style="padding: 0.8rem;">';
                        card +=
                            '<h5 class="card-title" style="font-weight:bold;">Rs: ' +
                            pack.price +
                            "</h5>";
                        card += "</div>";
                        card += "</div>";

                        $("#card-columns").append(card);
                    });
                }).fail(function() {
                    $("#spinner").hide();
                    alert("error");
                });
            }
        },
        focus: function(event, ui) {
            if (ui.item.label === NoResultsLabel) {
                event.preventDefault();
            }
        }
    });
});
