(function () {

    $('#bestellListe').load('../php/kundenbestellungen.php', () => {
    });

}());

function mySearch() {
    var input, filter, table, tr, td, i, v;
    input = document.getElementById("myInput");
    filter = input.value.toLowerCase();
    table = document.getElementById("myTable");

    $( "#offen" ).removeClass( "active" );
    $( "#all" ).addClass( "active" );

    $( "table" ).removeClass( "table-striped" );

    var cnt = 0;

    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        td1 = tr[i].getElementsByTagName("td")[1];
        if (td || td1) {
            if (td.innerHTML.toLowerCase().indexOf(filter) > -1 || td1.innerHTML.toLowerCase().indexOf(filter) > -1) {

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

    $( "#all" ).removeClass( "active" );
    $( "#offen" ).addClass( "active" );

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

    $( "#offen" ).removeClass( "active" );
    $( "#all" ).addClass( "active" );

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

