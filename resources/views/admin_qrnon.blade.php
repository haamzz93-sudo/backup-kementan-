<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Label Non</title>
<style>
body, html {
    margin: 0;
    padding: 0;
    width: 100%;
    height: 100%;
}

.page-break {
    page-break-after: always;
}

.centered-qr {
    display: flex;
    justify-content: center;
    align-items: center;
    width: calc(100% - 10px); /* Account for total margin of 5px on each side */
    height: calc(100% - 10px); /* Account for total margin of 5px on each side */
    margin: 5px;
    position: relative;
    box-sizing: border-box; /* Ensure padding and border are included in the total width/height */
}

.centered-qr img {
    width: 100%;
    height: 100%;
    display: block;
    margin: 0;
    padding: 0;
}
</style>
<body>
@php
    $nomor_awal = (int)$label->no_awal;
    $nomor_akhir = (int)$label->no_akhir;
    $max_length = strlen((string)$nomor_akhir);
@endphp

@if ($jenis->id == 7)
    @for($i = $nomor_awal; $i <= $nomor_akhir; $i++)
    @php
        $padding_length = strlen((string)$nomor_akhir);
        $formatted_number = str_pad($i, $padding_length, '0', STR_PAD_LEFT);
    @endphp
        <div class="centered-qr">
            <img src="data:image/png;base64, {{ base64_encode(QrCode::format('svg')->size(150)->generate($url.'/detail-produsen-non/'.$id.'?no_urut='.$label->kode_urut_awal.$formatted_number)) }}">
        </div>
    @endfor
@else
    <div class="centered-qr">
        <img src="data:image/png;base64, {{ base64_encode(QrCode::format('svg')->size(150)->generate($url.'/detail-produsen-non/'.$id)) }}">
    </div>
@endif

</body>
</html>
