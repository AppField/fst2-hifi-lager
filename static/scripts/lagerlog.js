(function () {

    $('#lagerlogliste').load('../php/lagerlogtabelle.php', () => {
    });

}());

function mySearch() {
    var input, filter, table, tr, td, i;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");
    var cnt = 0;
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[2];
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