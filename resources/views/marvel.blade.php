@extends('layouts.master')
@section('main-content')

<div class="container">
    <!---START DISPLAY CARDS HERE --->
    <h2 class="text-center"> Marvel Characters </h2>
    <div class="row" id="charContainer">

    </div>

    <div id="paginationContainer">
    <!-- the pagination controls will be put here by pagination.js -->
    </div>

    <!--- END DISPLAY CARDS HERE --->

    <div id="loader">
        <img style="
        position:absolute;
        top:0;
        left:0;
        right:0;
        bottom:0;
        margin:auto;" src="{{url('/images/loader.gif')}}" alt="loader" />
    </div> 

</div>  

@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/paginationjs/2.1.5/pagination.min.js"></script>

<script>
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    $.ajax({
        type: 'GET',
        url: 'http://127.0.0.1:8000/marvel-universe-fetch',
        success: function(data) {
            if(data.code === 200) {
                console.log(data.data.results);

                var $cardsContainer = $('#charContainer');
                    $('#paginationContainer').pagination({
                    dataSource: data.data.results,
                    items: data.data.total,
                    itemsOnPage: 20,
                    cssStyle: 'light-theme',
                    totalNumberLocator: function(response) { 
                        return data.data.totals;
                    },
                })

                $.each(data.data.results, function(index, result) {
                    cardDisplay(result);
                })

                $("#loader").hide();
            } else {
                console.log(data);

                $("#loader").hide();
            }
        }
    });

    function cardDisplay(result) {
        // Function for display character data and generating a bootstrap card
        let img_path = `${result.thumbnail.path}.${result.thumbnail.extension}`;
        console.log(img_path);

        let card = "<div class='col-md-3 '>";
        card += "<div class='card text-white bg-dark' style='max-width: 25rem; margin-bottom:2rem'>";
        card += "<img class='card-img-top' src='" + img_path + "' alt='Card image cap' style='height: 20rem;'>";
        card += "<div class='card-body' style='backgound-color: black' >";
        card += "<h5 class='card-title'>" + result.name + "</h5>";
        card += "</div>";
        card += "</div>";
        card += "</div>";

        // Append the new character card to the character section div
        $("#charContainer").append(card)
    }
</script>