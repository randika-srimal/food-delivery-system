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
            console.log(packs);

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

    appendCards();

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
                appendCards(ui.item.value);
            }
        },
        focus: function(event, ui) {
            if (ui.item.label === NoResultsLabel) {
                event.preventDefault();
            }
        }
    });
});
