<?php

	function convert_date($value) {
		return date('d-m-Y', strtotime($value));
	}

	function status($status) {
		if($status == 1) {
			$status = 'Borrowed';
		  }
		  else {
			$status = 'Returned';
		  }
		  return $status;
	}

	function lama_pinjam($date_start, $date_end) {

		$datetime1 = new DateTime($date_start);//start time
		$datetime2 = new DateTime($date_end);//end time
		$durasi = $datetime1->diff($datetime2);
		{
			return $durasi->d;
		}

	}
	function numberWithSpaces($num) {
        $currency = "Rp. ".number_format($num, 0, ",", ".");

        return $currency;
    }

	function amount_days($date_end) {
        $today = strtotime(date('d-m-Y'));
        $limit = strtotime($date_end);
        $amount = abs($today - $limit);
        $count_days = $amount/60/60/24;

        return $count_days;
    }

?>
