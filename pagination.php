<?php

echo "<ul class='pagination'>";
echo "<p class='p-2'>Page:</p>";

// button for first page
// if($page>1){
//     echo "<li><a href='{$page_url}' title='Go to the first page.'>
//         First
//     </a></li>";
// }
  
// calculate total pages
$total_pages = ceil($total_rows / $records_per_page);
  
// range of links to show
$range = 5;
  
// display links to 'range of pages' around 'current page'
$initial_num = $page - $range;
$condition_limit_num = ($page + $range)  + 1;
  
for ($x=$initial_num; $x<$condition_limit_num; $x++) {
  
    // be sure '$x is greater than 0' AND 'less than or equal to the $total_pages'
    if (($x > 0) && ($x <= $total_pages)) {
  
        // current page
        // if ($x == $page) {
        //     echo "<li class='active'><a href=\"#\"> $x </a></li>";
        // } 
              echo "<li><a href='{$page_url}page=$x'><div class='p-2'> $x </div></a></li>";

        // not current page
        // if {
        // }
    }
}
  
// button for last page
// if($page<$total_pages){
//     echo "<li><a href='" .$page_url. "page={$total_pages}' title='Last page is {$total_pages}.'>
//     </a></li>";
// }
  
echo "</ul>";
?>