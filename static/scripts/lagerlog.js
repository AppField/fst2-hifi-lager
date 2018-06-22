(function () {

    $('#lagerlogliste').load('../php/lagerlogtabelle.php', () => {
    });

}());

function mySearch() {
    var input, filter, table, tr, td, i, v;
    input = document.getElementById("myInput");
    filter = input.value.toLowerCase();
    table = document.getElementById("myTable");

    $( "table" ).removeClass( "table-striped" );

    var cnt = 0;

    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[2];   // aid
        td1 = tr[i].getElementsByTagName("td")[3];  // a bezeichnung
        //td2 = tr[i].getElementsByTagName("td")[7]; datum
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