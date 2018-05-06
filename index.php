<html>
    <head>
        <meta charset="UTF-8">
        <title>Google Plagiarism</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="js/jquery.min.js" type="text/javascript"></script>
    </head>
    <body>
        <br/>
        <?php
        function cURL($query) {
        $curl = curl_init(); //Inisialisasi session CURL
        if (!$curl) die("Couldn't initialize a cURL handle");
        curl_setopt ($curl, CURLOPT_URL, "http://www.google.com/search?hl=en&tbo=d&site=&source=hp&q=".urlencode($query)); //mengatur alamat request
        curl_setopt($curl, CURLOPT_USERAGENT, 'Googlebot/2.1 (+http://www.google.com/bot.html)'); //mengatur user agent, untuk mendapatkan tampilan sesuai user agent, bisa mozilla/chrome  dll
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_FAILONERROR, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); //menegembalikan hasil request dalam bentuk asli bukan true atau false (sukses atau gagal rquest)
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 1000); // mengatur timeout
        curl_setopt($curl, CURLOPT_TIMEOUT, 5000); // mengatur timeout
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $html = curl_exec($curl);
        if (curl_errno($curl)) echo 'cURL error: '.curl_error($curl);  // menampilkan error saat request
        else{
        echo "<div style='display:none'>".$html."</div>"; //menyembunyikan hasil request asli
        }
        curl_close($curl);//menutup session
        }
        ?>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="POST">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Masukan Kalimat</label>
                                    <textarea  class="form-control" name="query" id="" cols="30" rows="10"></textarea>
                                </div>
                                
                                <button type="submit" name="kirim" class="btn btn-primary">Periksa</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <?php
                            if(isset($_POST['kirim'])){
                            echo "Pencarian:<br/><div id='hasil'>".$_POST['query']."</div><br/>";
                            cUrl($_POST['query']); // Request http ke alamat pencarian google
                            ?>
                            
                                <script>
                                var z = document.getElementsByClassName("r"); //mengambil hasil judul google
                                var y=document.getElementsByTagName("cite"); // mengambil hasil situs goole
                                var x = document.getElementsByClassName("st"); //mengambil hasil isi google
                                
                                for (var i = 0; i < 3; i++) {//looping  untuk mendapatkan 3 hasil situs teratas pencarian google
                                document.write("<div class='card'><div class='card-body'>");
                                document.write("<br/>"+z[i].innerHTML);
                                document.write("<br/>"+y[i].innerHTML);
                                $(".st").find( "b" ).css( "color", "red" ); //merubah yang dibold google menjadi merah
                                document.write("<br/>"+x[i].innerHTML);
                                document.write("<hr/>");
                                var str = ""; // mendapatkan dan menggabungkan kata yang dibold google menjadi kalimat
                                $('span.st:eq('+i+') > b').each(function(){
                                str += $(this).text() + " ";
                                })
                                var kalimat1split = str.split(" "); // memecah kalimat hasil goole
                                var kalimat2split =  document.getElementById('hasil').innerHTML.split(" "); // memecah kalimat hasil inputan
                                var plagiasi1 = []; // array tampungan untuk hasil kata unik dari kalimat google
                                var plagiasi2 = []; // array tampungan untuk hasil kata unik dari kalimat input
                                var sama=[]; // array tampungan untuk hasil kata yang sama
                                var plagiasi3 = []; // array tampungan untuk hasil kata unik yang sama
                                $.each(kalimat1split, function(i, el){
                                if($.inArray(el, plagiasi1) === -1) plagiasi1.push(el.toLowerCase());
                                }); // fungsi untuk memasukan kata unik ke dalam array tampungan
                                $.each(kalimat2split, function(i, el){
                                if($.inArray(el, plagiasi2) === -1) plagiasi2.push(el.toLowerCase());
                                }); // fungsi untuk memasukan kata unik ke dalam array tampungan
                                document.write("Hasil Google : "+plagiasi1.sort()+"<br/>"); // Menampilkan kata unik dari google
                                document.write("Hasil Input : "+plagiasi2.sort()+"<br/>"); // Menampilkan kata unik dari inputan
                                
                                for (var i2 = 0; i2 < plagiasi1.length; i2++) {
                                if (plagiasi2.indexOf(plagiasi1[i2]) !== -1) {
                                sama.push(plagiasi1[i2]);
                                }
                                } // Mencari kata yang sama dari array kata google dan inputan
                                $.each(sama, function(i, el){
                                if($.inArray(el, plagiasi3) === -1) plagiasi3.push(el.toLowerCase());
                                }); // memasukan kata yang unik kedalam array tampungan
                                
                                document.write("Kata yang sama : "+plagiasi3.sort()+"<br/>");// Menampilkan kata unik yang sama dari google dan inputan
                                var probab=plagiasi3.length/plagiasi2.length; //menghitung probabilitas
                                /*
                                kata yang unik dibandingkan dengan kata inputan
                                */
                                document.write("Probabilitas : "+probab+"<br/>");
                                document.write("</div></div><br/>");
                                }
                                </script>
                            
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        
    </body>
</html>