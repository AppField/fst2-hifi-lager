(function () {

    $('#bestellListe').load('../php/lieferantenbestellungen.php', () => {
    });

}());

function mySearch() {
    var input, filter, table, tr, td, i;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");

    $( "table" ).removeClass( "table-striped" );

    var cnt = 0;

    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
            if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {

                tr[i].style.display = "";

                if(cnt % 2 != 0){
                    tr[i].style.background = "#EEF4F7";
                }else{
                    tr[i].style.background = "#E2E8EA";
                }
                cnt = cnt + 1;

            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

function filterOffen(input) {
    // Declare variables
    var table, tr, td, i;
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");

    var cnt = 0;

    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[2];

        if (td) {
            if (td.innerHTML == input) {
                tr[i].style.display = "";

                if(cnt % 2 != 0){
                    tr[i].style.background = "#EEF4F7";
                }else{
                    tr[i].style.background = "#E2E8EA";
                }
                cnt = cnt + 1;
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

function filterOffenReturn() {
    // Declare variables
    var table, tr, td, i;
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");

    var cnt = 0;
    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[2];
        if (td) {

            tr[i].style.display = "";
            if(cnt % 2 != 0){
                tr[i].style.background = "#EEF4F7";
            }else{
                tr[i].style.background = "#E2E8EA";
            }
            cnt = cnt + 1;
        }
    }
}
