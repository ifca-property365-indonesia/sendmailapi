<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting">
    <title></title>
    
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,600" rel="stylesheet" type="text/css">
    @include('template.style')

</head>

<body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #e6f0eb;">
	<div style="width: 100%; background-color: #e6f0eb;">
        <table width="50%" border="0" cellpadding="0" cellspacing="0" bgcolor="#e6f0eb" style="margin-left: auto;margin-right: auto;" >
            <tr>
               <td style="padding: 40px 0;">
                    <table style="width:100%;max-width:620px;margin:0 auto;">
                        @include('template.header')
                    </table>
                    <table style="width:100%;max-width:620px;margin:0 auto;background-color:#ffffff;">
                        <tbody>
                            <tr>
                                <td style="text-align:center;padding: 30px 30px 20px">
                                    <h5 style="margin-bottom: 24px; color: #526484; font-size: 20px; font-weight: 400; line-height: 28px;">Untuk Bapak/Ibu {{ $data['user_name'] }}</h5>
                                    <p style="margin-bottom: 15px; color: #526484; font-size: 16px;">Tolong berikan persetujuan untuk Surat Pelepasan HAK dengan nomor dokumen {{ $data['doc_no'] }}, NOP: {{ $data['nop_no'] }}, Nama Pemilik: {{ $data['name_owner'] }} Luas tanah yang disepakati: {{ $data['laf'] }}m&sup2; Luas bangunan yang disepakati: {{ $data['baf'] }}m&sup2; Nominal SPH sebesar Rp.{{ $data['sph_amt'] }}, dengan rincian: Uang Tanda Jadi yang sudah dibayarkan sebesar Rp.{{ $data['book_amt'] }}, dan Pelunasan Pembayaran Bidang Tanah Sebesar Rp.{{ $data['total_amt'] }}.</p>
                                    <p style="margin-bottom: 15px; color: #526484; font-size: 16px;">Terima Kasih</p>
                                    <a href="{{ url('api') }}/{{ $data['link'] }}/A/{{ $data['entity_cd'] }}/{{ $data['doc_no'] }}/{{ $data['level_no'] }}" style="background-color:#1ee0ac;border-radius:4px;color:#ffffff;display:inline-block;font-size:13px;font-weight:600;line-height:44px;text-align:center;text-decoration:none;text-transform: uppercase; padding: 0px 40px;margin: 10px">Approve</a>
                                    <a href="{{ url('api') }}/{{ $data['link'] }}/R/{{ $data['entity_cd'] }}/{{ $data['doc_no'] }}/{{ $data['level_no'] }}" style="background-color:#f4bd0e;border-radius:4px;color:#ffffff;display:inline-block;font-size:13px;font-weight:600;line-height:44px;text-align:center;text-decoration:none;text-transform: uppercase; padding: 0px 40px;margin: 10px">Revise</a>
                                    <a href="{{ url('api') }}/{{ $data['link'] }}/C/{{ $data['entity_cd'] }}/{{ $data['doc_no'] }}/{{ $data['level_no'] }}" style="background-color:#e85347;border-radius:4px;color:#ffffff;display:inline-block;font-size:13px;font-weight:600;line-height:44px;text-align:center;text-decoration:none;text-transform: uppercase; padding: 0px 40px;margin: 10px">Cancel</a>
                                    <br>
                                    <p style="text-align:left;margin-bottom: 15px; color: #000000; font-size: 16px">
                                        <b style="font-style:italic;">Untuk melihat lampiran, tolong klik tautan dibawah ini : </b><br>
                                        @if ( is_array($data['url_link']) || is_object($data['url_link']) )
                                            @foreach ($data['url_link'] as $tampil)
                                                <a href={{ $tampil }} target="_blank">{{ trim(str_replace('%20',' ',substr($tampil, strrpos($tampil, '/') + 1))) }}</a><br><br>
                                            @endforeach
                                        @else
                                            <a href={{ $data['url_link'] }} target="_blank">{{ trim(str_replace('%20',' ',substr($data['url_link'], strrpos($data['url_link'], '/') + 1))) }}</a><br><br>
                                        @endif
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table style="width:100%;max-width:620px;margin:0 auto;">
                        @include('template.footer')
                    </table>
               </td>
            </tr>
        </table>
    </div>
</body>
</html>