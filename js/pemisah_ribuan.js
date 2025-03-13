/*
# rupiahnumerik
Fungsi isi dibuat untuk memecah ribuan otomatis pada inputan angka untuk ditampilkan pada user, dan mengembalikan format awal (yaitu tanpa koma dan titik sebagai pemisah desimal) ketika melempar ke database.

Terimakasih pada pembuat fungsi number_format (http://kevin.vanzonneveld.net)
Terimakasih pada pembuat fungsi formatRupiah (https://www.malasngoding.com/membuat-format-rupiah-dengan-javascript/)

Anda hanya perlu memasukkan fungsi ini [rupiahnumerik(this)] pada onkeyup di elemen input.
Jika elemen input bertipe selain text maka akan otomatis dirubah menjadi bertipe text.
Hasil post tetap akan melemparkan angka yg dapat diterima oleh database (yaitu tanpa koma dan titik sebagai pemisah desimal).
Perhatian : Wajib mengisi id pada elemen input.
Perhatian : Membutuhkan Jquery.
Contoh:
<input onkeyup="rupiahnumerik(this);" type="number" id="isian" name="isian"/>
<script>rupiahnumerik($("#request1_proposed_nom"))</script>

Pembuat Fungsi 'rupiahnumerik': ihsandulu (https://www.qithy.com)
Catatan: Silahkan merubah sourcecode tanpa menghilangkan catatan ini.
*/

/* function rupiahnumerik(a) {

    function number_format(number, decimals, dec_point, thousands_sep) {
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            toFixedFix = function (n, prec) {
                // Fix for IE parseFloat(0.55).toFixed(0) = 0;
                var k = Math.pow(10, prec);
                return Math.round(n * k) / k;
            },
            s = (prec ? toFixedFix(n, prec) : Math.round(n)).toString().split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }

    var exampleNumber = 1;

    function formatRupiah1(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
    }

    function rupiah_numerik(a) {
        var rupiah;
        var angka = $(a).val();
        $(a).attr('type', 'text');
        var id1 = $(a).attr('id') + '1';
        var name = $(a).attr('name');
        var txt1 = "<input type='hidden' id='" + id1 + "' class='" + name + "' name='" + name + "' value=''>";


        if ($(a).attr('name') == $(a).attr('id')) {
            $(a).after(txt1);
            $(a).attr('name', '');
            rupiah = number_format(angka, 2, ',', '.');
            if (angka <= 0) { rupiah = ''; }
            $(a).val(rupiah);
            $("#" + id1).val(angka);
        } else {
            rupiah = formatRupiah1(angka, '');


            var pecahkoma = rupiah.split(',');
            var koma;
            if (pecahkoma.length > 1) {
                koma = '.' + pecahkoma[1];
            } else {
                koma = '';
            }
            var awal = pecahkoma[0].replace(/\./g, "");
            var gabung = awal + koma;

            $(a).val(rupiah);
            $("#" + id1).val(gabung);
        }
    }

    rupiah_numerik(a);

} */
function rupiahnumerik(a) {
  function number_format(number, decimals, dec_point, thousands_sep) {
    var n = !isFinite(+number) ? 0 : +number,
      prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
      sep = typeof thousands_sep === "undefined" ? "," : thousands_sep,
      dec = typeof dec_point === "undefined" ? "." : dec_point,
      toFixedFix = function (n, prec) {
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        var k = Math.pow(10, prec);
        return Math.round(n * k) / k;
      },
      s = (prec ? toFixedFix(n, prec) : Math.round(n)).toString().split(".");
    if (s[0].length > 3) {
      s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || "").length < prec) {
      s[1] = s[1] || "";
      s[1] += new Array(prec - s[1].length + 1).join("0");
    }
    return s.join(dec);
  }

  var exampleNumber = 1;

  function formatRupiah1(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, "").toString(),
      split = number_string.split(","),
      sisa = split[0].length % 3,
      rupiah = split[0].substr(0, sisa),
      ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
      separator = sisa ? "." : "";
      rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    return prefix == undefined ? rupiah : rupiah ? "" + rupiah : "";
  }

  function rupiah_numerik(a) {
    var rupiah;
    var angka = $(a).val();
    angka = angka.replace(/^0+/, "");
    var digitangka = 0;
    $(a).attr("type", "text");
    var id1 = $(a).attr("id") + "1";
    var name = $(a).attr("name");
    var onchange = $(a).attr("change");
    var txt1 =
      '<input type="hidden" id="' +
      id1 +
      '" class="' +
      name +
      '" name="' +
      name +
      '" value="" onchange="' +
      onchange +
      '">';

    if ($(a).attr("name") == $(a).attr("id")) {
      $(a).after(txt1);
      $(a).attr("name", "");
      setTimeout(() => {
        document.getElementById(id1).value = angka;
      }, 500);
      // alert(angka);
      digitangka = angka.toString().split(".")[1].length;
      rupiah = number_format(angka, digitangka, ",", ".");
      if (angka <= 0) {
        rupiah = "";
      }
      $(a).val(rupiah);
      //   $("#" + id1).val(angka);
    } else {
      rupiah = formatRupiah1(angka, "");

      var pecahkoma = rupiah.split(",");
      var koma;
      if (pecahkoma.length > 1) {
        koma = "." + pecahkoma[1];
      } else {
        koma = "";
      }
      var awal = pecahkoma[0].replace(/\./g, "");
      var gabung = awal + koma;
      $(a).val(rupiah);
      //   $("#" + id1).val(gabung);
      document.getElementById(id1).value = gabung;
    }

    var onchangex = $("#" + id1).attr("onchange");
    var valuex = $("#" + id1).val();
    onchangex = onchangex.replace("this.value", valuex);
    eval(onchangex);
  }

  rupiah_numerik(a);
}
