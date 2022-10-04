<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nota PDF</title>

    <style>
        table td {
            /* font-family: Arial, Helvetica, sans-serif; */
            font-size: 18px;
        }
        table.data td,
        table.data th {
            border: none;
            padding: 5px;
        }
        table.data {
            border-collapse: collapse;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        body {
          /* background-image: url('https://static.vecteezy.com/system/resources/previews/003/423/898/original/gray-background-with-texture-white-abstract-modern-background-free-vector.jpg'); */
          background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTf_kAvGUQbzbmLgclnmBGpJ_fbBKFkhCvQrw&usqp=CAU');
          /* background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT5RS7qtSGW3uKECu_msxtFbC_h_vupXSxuWg&usqp=CAU'); */
          /* background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS6xi3uZQ7KvclzRKs6xIJaeCfADe_jh8QPpA&usqp=CAU'); */
          background-repeat: no-repeat;
          background-size: cover;
          
        }
    </style>
</head>
<body>
    <table class="data" width="100%">
      <thead>
        <tr>
          <th class="" colspan="5"><h1>SURAT PEMANDIAN</h1></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class=""></td>
          <td class="">Tanggal Lahir</td>
          <td class="">{{$baptis->tanggal_lahir }}</td>
          <td class="">Di</td>
          <td class="">{{$baptis->tempat_lahir }}</td>
        </tr>
        <tr>
          <td class=""></td>
          <td class="">Tanggal Baptis</td>
          <td class="">{{ tanggal_indonesia($baptis->jadwal) }}</td>
          <td class="">Di</td>
          <td class="">{{$baptis->lokasi }}</td>
        </tr>
        <tr>
          <td class="" colspan="2"></td>
          <td class="" colspan="2"></td>
          <td class=""></td>
        </tr>
        <tr>
          <td class="text-center" colspan="5"><h2>{{$baptis->nama_lengkap }}</h2></td>
        </tr>
        <tr>
          <td class=""></td>
          <td class="">Nama Orang Tua</td>
          <td class="">{{$baptis->orangtua_ayah }}</td>
          <td class="">{{$baptis->orangtua_ibu }}</td>
          <td class=""></td>
        </tr>
        <tr>
          <td class=""></td>
          <td class="">Nama Bapak/Ibu Pemandian</td>
          <td class="">{{$baptis->wali_baptis_ayah }}</td>
          <td class="">{{$baptis->wali_baptis_ibu }}</td>
          <td class=""></td>
        </tr>
        <tr>
          <td class=""></td>
          <td class="">Dipermandikan oleh</td>
          <td class="">{{$baptis->romo }}</td>
          <td class=""></td>
          <td class=""></td>
        </tr>
        <tr>
          <td class=""></td>
          <td class="">Tanggal Krisma</td>
          <td class=""></td>
          <td class="">Di</td>
          <td class=""></td>
        </tr>
        <tr>
          <td class=""></td>
          <td class="">Tanggal Pernikahan</td>
          <td class=""></td>
          <td class="">Di</td>
          <td class=""></td>
        </tr>
        <tr>
          <td class=""></td>
          <td class="">Dengan</td>
          <td class=""></td>
          <td class=""></td>
          <td class=""></td>
        </tr>
        <tr>
          <td class=""></td>
          <td class="">Komuni Pertama</td>
          <td class=""></td>
          <td class="">Di</td>
          <td class=""></td>
        </tr>
        <tr>
          <td class=""></td>
          <td class=""></td>
          <td class=""></td>
          <td class=""></td>
          <td class=""></td>
        </tr>
        <tr>
          <td class=""></td>
          <td class=""></td>
          <td class=""></td>
          <td class=""></td>
          <td class="text-center">{{ tanggal_indonesia(date('Y-m-d h:i:s')) }}</td>
        </tr>
        <tr>
          <td class=""></td>
          <td class=""></td>
          <td class=""></td>
          <td class=""></td>
          <td class="text-center"><img src="data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 640 512'%3e%3cpath fill='%23000000' d='M623.2 192c-51.8 3.5-125.7 54.7-163.1 71.5-29.1 13.1-54.2 24.4-76.1 24.4-22.6 0-26-16.2-21.3-51.9 1.1-8 11.7-79.2-42.7-76.1-25.1 1.5-64.3 24.8-169.5 126L192 182.2c30.4-75.9-53.2-151.5-129.7-102.8L7.4 116.3C0 121-2.2 130.9 2.5 138.4l17.2 27c4.7 7.5 14.6 9.7 22.1 4.9l58-38.9c18.4-11.7 40.7 7.2 32.7 27.1L34.3 404.1C27.5 421 37 448 64 448c8.3 0 16.5-3.2 22.6-9.4 42.2-42.2 154.7-150.7 211.2-195.8-2.2 28.5-2.1 58.9 20.6 83.8 15.3 16.8 37.3 25.3 65.5 25.3 35.6 0 68-14.6 102.3-30 33-14.8 99-62.6 138.4-65.8 8.5-.7 15.2-7.3 15.2-15.8v-32.1c.2-9.1-7.5-16.8-16.6-16.2z'/%3e%3c/svg%3e" alt="Image" width="100" height="100"></td>
        </tr>
        <tr>
          <td class=""></td>
          <td class=""></td>
          <td class=""></td>
          <td class=""></td>
          <td class="text-center">{{ $baptis->romo }}</td>
        </tr>
      </tbody>
    </table>
</body>
</html>