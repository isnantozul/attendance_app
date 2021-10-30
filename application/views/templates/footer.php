 <!-- Footer -->
 <footer>
   <p>&copy; CV Destinasi Computindo 2020.</p>
 </footer>
 <!-- Akhir Footer -->

 <!-- Modal -->
 <div id="mywebcam" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title modal-camera-title" id="staticBackdropLabel">Halo</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>
       <div class="modal-body">
         <input type="hidden" class="modal-camera-id" value="">
         <div class="container">
           <div id="my_camera">

           </div>
         </div>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="stop_camera()">Tutup</button>
         <button type="button" class="btn btn-primary" onclick="take_snapshot()">Ambil</button>
       </div>
     </div>
   </div>
 </div>

 </body>


 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

 <!-- Sweetaler -->
 <script src="<?= base_url("assets/js/sweetalert/sweetalert2.all.min.js") ?>"></script>

 <!-- DataTables -->
 <script src="<?= base_url("assets/plugins/datatables/jquery.dataTables.min.js") ?>"></script>
 <script src="<?= base_url("assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js") ?>"></script>
 <script src="<?= base_url("assets/plugins/datatables-responsive/js/dataTables.responsive.min.js") ?>"></script>
 <script src="<?= base_url("assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js") ?>"></script>
 <script language="JavaScript">
   $(function() {
     $("#tblDataAll").DataTable({
       "responsive": false,
       "autoWidth": false,
     });
   });

   function run_camera(name, id) {
     $('.modal-camera-title').html(`Upload foto ${name}`);
     $('.modal-camera-id').val(id);
     $('#mywebcam').modal('toggle');
     Webcam.set({
       width: 430,
       height: 380,
       image_format: 'jpeg',
       jpeg_quality: 100
     });

     Webcam.attach('#my_camera');
   }

   function stop_camera() {
     Webcam.reset();
     $('#mywebcam').modal('toggle');
   }

   function take_snapshot() {
     const id = $('.modal-camera-id').val();
     Webcam.snap(function(data_uri) {
       $('#svg-' + id).remove();
       if ($("#image-up-" + id).length) {
         $("#image-up-" + id).remove();
       }
       if ($("#image-save-" + id).length) {
         $("#image-save-" + id).remove();
       }
       $('#card-camera-' + id).prepend(`<img id="image-up-${id}" src="${data_uri}" class="card-img-top" alt="card-foto-${id}">`);
       $('#card-body-' + id).append(`<a href="#" id="image-save-${id}" onclick="save_snap(${id})" class="btn btn-info non-uppercase mt-2">Simpan Foto</a>`);
       Webcam.reset();
       $('#mywebcam').modal('toggle');
     });
   }

   function save_snap(id) {
     showLoading();
     var file = $('#image-up-' + id).attr('src');
     var user_id = $('#user_id').val();
     var user_name = $('#user_name').val();
     console.log(user_name);
     $.ajax({
       url: "<?= base_url("user/uploads/") ?>" + id,
       method: "POST",
       dataType: "JSON",
       data: {
         id: id,
         base64image: file,
         user_id: user_id,
         user_name: user_name
       },
       success: function(res) {
         if (res.status) {
           $("#image-save-" + id).remove();
           hideLoading();
           showSuccessMessage(id);
           console.log(res.data);
         } else {
           hideLoading();
           console.log(res.data);
         }
       },
       error: function(err) {
         console.log(err);
       }
     });
   }


   function showLoading() {
     Swal.fire({
       title: 'Menyimpan',
       html: 'Sedang proses, harap menunggu!!',
       didOpen: () => {
         Swal.showLoading();
       }
     });
   }

   function hideLoading() {
     Swal.close();
   }

   function showSuccessMessage(id) {
     Swal.fire({
       icon: 'success',
       title: 'Berhasil Menyimpan',
       text: 'Berhasil Menyimpan Gambar ke-' + id,
     });
   }


   //get user country

   $(document).ready(function() {
     $.ajax({
       url: 'https://dev.farizdotid.com/api/daerahindonesia/provinsi',
       method: 'GET',
       dataType: 'JSON',
       cache: false,
       success: function(res) {
         const provinsi = res.provinsi;
         $('#provinsi-list').append($('<option>', {
           value: '',
           text: '=== Pilih Provinsi ==='
         }));
         for (i = 0; i < provinsi.length; i++) {
           $('#provinsi-list').append($('<option>', {
             value: provinsi[i].id,
             text: provinsi[i].nama
           }));
         }
       },
       error: function(err) {
         console.log(err);
       }
     });
   });

   $('#provinsi-list').on('change', function() {
     const provid = $("#provinsi-list option:selected").val();
     console.log(provid);
     $.ajax({
       url: `https:/dev.farizdotid.com/api/daerahindonesia/kota?id_provinsi=${provid}`,
       method: 'GET',
       dataType: 'JSON',
       cache: false,
       success: function(res) {
         const kota = res.kota_kabupaten;
         $('#kota-list').empty();
         $('#kecamatan-list').empty();
         $('#kelurahan-list').empty();
         $('#kota-list').append($('<option>', {
           value: '',
           text: '=== Pilih Kabupaten ==='
         }));
         for (i = 0; i < kota.length; i++) {
           $('#kota-list').append($('<option>', {
             value: kota[i].id,
             text: kota[i].nama
           }));
         }
       },
       error: function(err) {
         console.log(err);
       }
     });
   });

   $('#kota-list').on('change', function() {
     const kotaid = $("#kota-list option:selected").val();
     $.ajax({
       url: `https://dev.farizdotid.com/api/daerahindonesia/kecamatan?id_kota=${kotaid}`,
       method: 'GET',
       dataType: 'JSON',
       cache: false,
       success: function(res) {
         const kecamatan = res.kecamatan;
         $('#kecamatan-list').empty();
         $('#kelurahan-list').empty();
         $('#kecamatan-list').append($('<option>', {
           value: '',
           text: '=== Pilih Kecamatan ==='
         }));
         for (i = 0; i < kecamatan.length; i++) {
           $('#kecamatan-list').append($('<option>', {
             value: kecamatan[i].id,
             text: kecamatan[i].nama
           }));
         }
       },
       error: function(err) {
         console.log(err);
       }
     });
   });


   $('#kecamatan-list').on('change', function() {
     const kecamatanid = $("#kecamatan-list option:selected").val();
     $.ajax({
       url: `https://dev.farizdotid.com/api/daerahindonesia/kelurahan?id_kecamatan=${kecamatanid}`,
       method: 'GET',
       dataType: 'JSON',
       cache: false,
       success: function(res) {
         $('#kelurahan-list').empty();
         const kelurahan = res.kelurahan;
         $('#kelurahan-list').append($('<option>', {
           value: '',
           text: '=== Pilih Kelurahan ==='
         }));
         for (i = 0; i < kelurahan.length; i++) {
           $('#kelurahan-list').append($('<option>', {
             value: kelurahan[i].id,
             text: kelurahan[i].nama
           }));
         }
       },
       error: function(err) {
         console.log(err);
       }
     });
   });
 </script>

 <?php if (isset($edit_profile_js)) : ?>
   <?php if ($edit_profile_js) : ?>
     <script>
       $(document).ready(function() {
         get_prov();
         get_kota();
         get_kecamatan();
         get_kelurahan();
       });

       function get_prov() {
         const selected_prov = $('#selected_prov').val();
         $.ajax({
           url: 'https://dev.farizdotid.com/api/daerahindonesia/provinsi',
           method: 'GET',
           dataType: 'JSON',
           cache: false,
           success: function(res) {
             const provinsi = res.provinsi;
             $('#provinsi-list').append($('<option>', {
               value: '',
               text: '=== Pilih Provinsi ==='
             }));
             for (i = 0; i < provinsi.length; i++) {
               $('#provinsi-list').append($('<option>', {
                 value: provinsi[i].id,
                 text: provinsi[i].nama
               }));
             }
             $("#provinsi-list").val(selected_prov);
           },
           error: function(err) {
             console.log(err);
           }
         });
       }

       function get_kota() {
         const selected_prov = $('#selected_prov').val();
         const selected_kota = $('#selected_kota').val();
         $.ajax({
           url: `https:/dev.farizdotid.com/api/daerahindonesia/kota?id_provinsi=${selected_prov}`,
           method: 'GET',
           dataType: 'JSON',
           cache: false,
           success: function(res) {
             const kota = res.kota_kabupaten;
             $('#kota-list').append($('<option>', {
               value: '',
               text: '=== Pilih Kabupaten ==='
             }));
             for (i = 0; i < kota.length; i++) {
               $('#kota-list').append($('<option>', {
                 value: kota[i].id,
                 text: kota[i].nama
               }));
             }
             $("#kota-list").val(selected_kota);
           },
           error: function(err) {
             console.log(err);
           }
         });
       }

       function get_kecamatan() {
         const selected_kota = $('#selected_kota').val();
         const selected_kecamatan = $('#selected_kecamatan').val();
         $.ajax({
           url: `https://dev.farizdotid.com/api/daerahindonesia/kecamatan?id_kota=${selected_kota}`,
           method: 'GET',
           dataType: 'JSON',
           cache: false,
           success: function(res) {
             const kecamatan = res.kecamatan;
             $('#kecamatan-list').append($('<option>', {
               value: '',
               text: '=== Pilih Kecamatan ==='
             }));
             for (i = 0; i < kecamatan.length; i++) {
               $('#kecamatan-list').append($('<option>', {
                 value: kecamatan[i].id,
                 text: kecamatan[i].nama
               }));
             }
             $("#kecamatan-list").val(selected_kecamatan);
           },
           error: function(err) {
             console.log(err);
           }
         });
       }

       function get_kelurahan() {
         const selected_kecamatan = $('#selected_kecamatan').val();
         const selected_kelurahan = $('#selected_kelurahan').val();
         $.ajax({
           url: `https://dev.farizdotid.com/api/daerahindonesia/kelurahan?id_kecamatan=${selected_kecamatan}`,
           method: 'GET',
           dataType: 'JSON',
           cache: false,
           success: function(res) {
             const kelurahan = res.kelurahan;
             $('#kelurahan-list').append($('<option>', {
               value: '',
               text: '=== Pilih Kelurahan ==='
             }));
             for (i = 0; i < kelurahan.length; i++) {
               $('#kelurahan-list').append($('<option>', {
                 value: kelurahan[i].id,
                 text: kelurahan[i].nama
               }));
             }
             $("#kelurahan-list").val(selected_kelurahan);
           },
           error: function(err) {
             console.log(err);
           }
         });
       }
     </script>
   <?php endif; ?>
 <?php endif ?>

 </html>