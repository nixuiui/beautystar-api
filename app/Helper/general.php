<?php
function checkDirectory($dir) {
    if (!file_exists(public_path($dir))) {
        mkdir(public_path($dir), 0755, true);
    }
}

function limitWord($string, $word_limit) {
    $words = explode(" ", $string);
    return implode(" ", array_splice($words, 0, $word_limit));
}

function myPhotoProfil() {
    return Auth::check() ? Auth::user()->foto : null;
}

function srcPhotoProfil($photo) {
    return $photo != null ? route('media', ['photo-profil', $photo]) : asset('asset-beagle/img/avatar.png');
}

function pusherAPI($param){
    if($param == 'key') return env("PUSHER_APP_KEY" );
}

function googleMapsAPIKey() {
    return "AIzaSyApyNhg4IsV5oEvyQf1Yc7vnK1SirBcuQY";
}

function getMapMarker($marker) {
    return asset('img/icons/mapmarker/' . $marker);
}

function generateID() {
    return date("d"). date("m") . substr(date("Y"),2,2) . date("h") . date("i") . date("s");
}

function timeElapsedString($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);
    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;
    $string = array(
        'y' => 'tahun',
        'm' => 'bulan',
        'w' => 'minggu',
        'd' => 'hari',
        'h' => 'jam',
        'i' => 'menit',
        's' => 'detik',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v;
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' yang lalu' : 'baru saja';
}

function hari($strTime = null) {
    if($strTime == null)
        $strTime = date("Y-m-d H:i:s");
    $array_hari = array(1=>"Senin","Selasa","Rabu","Kamis","Jumat", "Sabtu","Minggu");
    return $hari = $array_hari[date("N", strtotime($strTime))];
}
function bulan($strTime = null) {
    if($strTime == null)
        $strTime = date("Y-m-d H:i:s");
    $array_bulan = array(1=>"Januari","Februari","Maret", "April", "Mei", "Juni","Juli","Agustus","September","Oktober", "November","Desember");
    return $bulan = $array_bulan[date("n", strtotime($strTime))];
}
function tanggal($strTime = null) {
    if($strTime == null)
        $strTime = date("Y-m-d H:i:s");
    return date("d", strtotime($strTime)) . " " . bulan($strTime) . " " . date("Y", strtotime($strTime));
    # code...
}
function hariTanggal($strTime = null) {
    if($strTime == null)
        $strTime = date("Y-m-d G:i:s");
    return hari($strTime) . ", " . date("d", strtotime($strTime)) . " " . bulan($strTime) . " " . date("Y", strtotime($strTime));
    # code...
}
function hariTanggalWaktu($strTime = null) {
    if($strTime == null)
        $strTime = date("Y-m-d G:i");
    return hari($strTime) . ", " . date("d", strtotime($strTime)) . " " . bulan($strTime) . " " . date("Y H:i A", strtotime($strTime));
    # code...
}
function jamMenit($strTime = null) {
    if($strTime == null)
        $strTime = date("G:i");
    return date("H:i", strtotime($strTime));
    # code...
}
function jamMenitA($strTime = null) {
    if($strTime == null)
        $strTime = date("G:i");
    return date("H:i A", strtotime($strTime));
    # code...
}
function kelamin($kelamin) {
    return $kelamin == 0 ? "Laki - laki" : "Perempuan";
}
function marker($marker)   {
    return $marker != null ? asset("img/icons/mapmarker/" . $marker) : asset("img/icons/mapmarker/marker_default.png");
}
function formatUang($nilai) {
    if($nilai >= 0)
    return "IDR " . number_format($nilai, 0, ".", ".");
    else
    return "- IDR " . number_format(-($nilai), 0, ".", ".");
}
function plusSecond($startTime, $seconds) {
    $date = date_create($startTime);
    date_add($date, date_interval_create_from_date_string($seconds . ' seconds'));
    return date_format($date, 'Y-m-d H:i:s');
}

function randomNumber($jumlah){
    $a='';
    for ($i = 0; $i<$jumlah; $i++) {
        $a .= mt_rand(0,9);
    }
    return $a;
}

function angkaUrut($angka){
    if(strlen($angka) == 1)
        return "00" . $angka;
    else if(strlen($angka) == 2)
        return "0" . $angka;
    else if(strlen($angka >= 3))
        return substr($angka, -3);
    return $angka;
}

function durasi($seconds){
    $durasi = "";
    $jam = null;
    $menit = null;
    if(floor($seconds/3600)) {
        $durasi .= floor($seconds/3600) . " jam ";
        $jam = floor($seconds/3600);
    }
    if($jam != null) {
        $seconds = $seconds - ($jam*3600);
    }
    if(floor($seconds/60)) {
        $durasi .= floor($seconds/60) . " menit ";
        $menit = floor($seconds/60);
    }
    if($menit != null) {
        $seconds = $seconds - ($menit*60);
    }
    $durasi .= $seconds . " detik ";
    return $durasi;
}

function duration($minutes){
    $durasi = "";
    $jam = null;
    $menit = null;
    if(floor($minutes/60)) {
        $durasi .= floor($minutes/60) . " jam ";
        $jam = floor($minutes/60);
    }
    if($jam != null) {
        $minutes = $minutes - ($jam*60);
    }
    if($minutes)
        $durasi .= $minutes . " menit ";
    return $durasi;
}