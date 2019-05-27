<?php
class Utilities {
    public function getPaging($page, $total_rows, $record_per_page, $page_url){
        // array paging
        $paging_arr = array();
        // button untuk halaman pertama
        $paging_arr["first"] = $page > 1 ? "{$page_url}page=1" : "";
        // jumlahkan semua product dalam database untuk mengkalkulasi jumlah halaman
        $total_pages = ceil($total_rows / $record_per_page);
        // jarak link untuk ditampilkan
        $range = 2;
        // menampilkan link to 'range of pages' around 'current page'
        $initial_num = $page - $range;
        $condition_limit_num = ($page + $range) + 1;
        $paging_arr['pages'] = array();
        $page_count = 0;

        for($x = $initial_num; $x < $condition_limit_num;$x++){
            // pastikan $x > 0
            if(($x > 0) && ($x <= $total_pages)){
                $paging_arr['pages'][$page_count]["page"] = $x;
                $paging_arr['pages'][$page_count]["url"] = "{$page_url}page={$x}";
                $paging_arr['pages'][$page_count]["current_page"] = $x == $page ? "yes" : "no";
                $page_count++;
            }
        }
        // button untuk halaman terakhir
        $paging_arr["last"] = $page < $total_pages ? "{$page_url}page={$total_pages}": "";
        // format json
        return $paging_arr;
    }
}