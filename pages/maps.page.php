<input type="text" id="myInput" onkeyup="myFunction()" placeholder="szukaj miasta...">

<table id="myTable">
  <tr class="header">
    <th style="width:10%;">lp</th>
    <th style="width:30%;">Miasto</th>
    <th style="width:30%;">Mapa</th>
    <th style="width:30%;">Patron</th>
  </tr>
<?php 

include('/home/zlasu/pokeZlasuMap/config_maps.php');

echo getMapsList();

?>
</table>


<script>
function myFunction() {
  // Declare variables 
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    } 
  }
}
</script>
