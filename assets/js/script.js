const video = document.getElementById('video');
const container = document.getElementById('detected-face');
const baseUrl = window.location.origin;


var labels = [];
var videoInterval;
var clockInterval;

if(document.getElementById('clocknow'))
{
    clockInterval = setInterval(function(){
        currentTime();
    },1000);
}

function currentTime()
{
    var date = new Date();
    var hour = date.getHours();
    var min = date.getMinutes();
    var sec = date.getSeconds();

    hour = updateTime(hour);
    min = updateTime(min);
    sec= updateTime(sec);
    document.getElementById('clocknow').innerText = hour + " : " + min + " : " + sec;
}

function updateTime(k)
{
    if(k<10)
    {
        return "0"+k;
    }else{
        return k;
    }
}

Promise.all([
    showLoadingAssets(),
    faceapi.nets.faceRecognitionNet.loadFromUri('/attendance_app/assets/models'),
    faceapi.nets.faceLandmark68Net.loadFromUri('/attendance_app/assets/models'),
    faceapi.nets.ssdMobilenetv1.loadFromUri('/attendance_app/assets/models'),
    faceapi.nets.tinyFaceDetector.loadFromUri('/attendance_app/assets/models'),
    getLabels(),
]).then(startVideo);

function startVideo(){
    navigator.getUserMedia(
        {video:{}},
        stream=>video.srcObject=stream,
        error=>console.error(error)
        );
}

video.addEventListener('play',async ()=>{
    const canvas = faceapi.createCanvasFromMedia(video);
    container.append(canvas);
    const displaySize={width:video.width, height:video.height-60};
    faceapi.matchDimensions(canvas,displaySize);
    hideLoading();
    const LabeledFaceDescriptors = await loadLabeledImages();
    const faceMatcher = new faceapi.FaceMatcher(LabeledFaceDescriptors,0.6);
    var detectedBefore = null;
    while(true)
    {
        const detections = await faceapi.detectSingleFace(video).withFaceLandmarks().withFaceDescriptor();
        const bestMatch = faceMatcher.findBestMatch(detections.descriptor);
        if(detectedBefore = bestMatch._label && detectedBefore !='unknown' && bestMatch._label!='unknown')
        {
            clearInterval(clockInterval);
            video.pause();
            const clocknow = $('#clocknow').text();
            doAbsen(clocknow,bestMatch._label);
            break;  
        }
        detectedBefore = bestMatch._label;
    }
});

function doAbsen(clocknow,user_name)
{
    showLoading();
    $.ajax({
        url:`${baseUrl}/attendance_app/user/doabsen`,
        method:"POST",
        dataType:"JSON",
        data:{
            clocknow:clocknow,
            user_name:user_name
        },
        success:function(res){
            hideLoading();
            if(res.status)
            {
                if(res.msg!=null)
                {
                    Swal.fire(
                        {
                            icon:'warning',
                            title:'Peringatan !!',
                            text:res.msg
                        }
                    );
                }
                const data = res.data;
                if(data.STATUS_USER == 1)
                {
                    $('#detected-face').append(`<a href="${baseUrl}/attendance_app/user/riwayat_absen/${data.USER_ID}" class="btn btn-blue-navy">Riwayat Absen</a>`);
                    $('#detected-face').append(`<a href="${baseUrl}/attendance_app/user/edit/${data.USER_ID}" class="btn btn-info ml-3">EDIT PROFIL</a>`);
                    $('#detected-face').append(`<button onclick="refreshPage()" class="btn btn-warning ml-3">REFRESH</button>`);
                    $('#square-info').html(`
                    <div class="header-square-success">
                        Selamat anda datang tepat waktu
                    </div>
                    <div class="content-square">
                        <p class="employee-info-title">Informasi Karyawan</p>
                        <div class="row employee-info-text">
                            <div class="col-sm-4">Nama</div>
                            <div class="col-sm-4 text-center">:</div>
                            <div class="col-sm-4">${data.NAMA_USER}</div>
                        </div>
                        <div class="row employee-info-text">
                            <div class="col-sm-4">Tanggal Absen</div>
                            <div class="col-sm-4 text-center">:</div>
                            <div class="col-sm-4">${data.TGL_ABSEN}</div>
                        </div>
                        <div class="row employee-info-text">
                            <div class="col-sm-4">Jam Masuk</div>
                            <div class="col-sm-4 text-center">:</div>
                            <div class="col-sm-4">${data.JAM_MASUK}</div>
                        </div>
                        <div class="row employee-info-text">
                            <div class="col-sm-4">Jam Pulang</div>
                            <div class="col-sm-4 text-center">:</div>
                            <div class="col-sm-4">${data.JAM_PULANG}</div>
                        </div>
                    </div>
                    `);
                }else if(data.STATUS_USER == 2){
                    $('#detected-face').append(`<a href="${baseUrl}/attendance_app/user/riwayat_absen/${data.USER_ID}" class="btn btn-blue-navy">Riwayat Absen</a>`);
                    $('#detected-face').append(`<a href="${baseUrl}/attendance_app/user/edit/${data.USER_ID}" class="btn btn-info ml-3">EDIT PROFIL</a>`);
                    $('#detected-face').append(`<button onclick="refreshPage()" class="btn btn-warning ml-3">REFRESH</button>`);
                    $('#square-info').html(`
                    <div class="header-square-warning">
                        Absen Terlambat
                    </div>
                    <div class="content-square">
                        <p class="employee-info-title">Informasi Karyawan</p>
                        <div class="row employee-info-text">
                            <div class="col-sm-4">Nama</div>
                            <div class="col-sm-4 text-center">:</div>
                            <div class="col-sm-4">${data.NAMA_USER}</div>
                        </div>
                        <div class="row employee-info-text">
                            <div class="col-sm-4">Tanggal Absen</div>
                            <div class="col-sm-4 text-center">:</div>
                            <div class="col-sm-4">${data.TGL_ABSEN}</div>
                        </div>
                        <div class="row employee-info-text">
                            <div class="col-sm-4">Jam Masuk</div>
                            <div class="col-sm-4 text-center">:</div>
                            <div class="col-sm-4">${data.JAM_MASUK}</div>
                        </div>
                        <div class="row employee-info-text">
                            <div class="col-sm-4">Jam Pulang</div>
                            <div class="col-sm-4 text-center">:</div>
                            <div class="col-sm-4">${data.JAM_PULANG}</div>
                        </div>
                    </div>
                    `);
                }else{
                    Swal.fire(
                        {
                            icon:'warning',
                            title:'Peringatan !!',
                            text:'Anda bolos !'
                        }
                    );

                    $('#detected-face').append(`<a href="${baseUrl}/attendance_app/user/riwayat_absen/${data.USER_ID}" class="btn btn-blue-navy">Riwayat Absen</a>`);
                    $('#detected-face').append(`<a href="${baseUrl}/attendance_app/user/edit/${data.USER_ID}" class="btn btn-info ml-3">EDIT PROFIL</a>`);
                    $('#detected-face').append(`<button onclick="refreshPage()" class="btn btn-warning ml-3">REFRESH</button>`);
                    $('#square-info').html(`
                    <div class="header-square-danger">
                        Anda bolos
                    </div>
                    <div class="content-square">
                        <p class="employee-info-title">Informasi Karyawan</p>
                        <div class="row employee-info-text">
                            <div class="col-sm-4">Nama</div>
                            <div class="col-sm-4 text-center">:</div>
                            <div class="col-sm-4">${data.NAMA_USER}</div>
                        </div>
                        <div class="row employee-info-text">
                            <div class="col-sm-4">Tanggal Absen</div>
                            <div class="col-sm-4 text-center">:</div>
                            <div class="col-sm-4">${data.TGL_ABSEN}</div>
                        </div>
                        <div class="row employee-info-text">
                            <div class="col-sm-4">Jam Masuk</div>
                            <div class="col-sm-4 text-center">:</div>
                            <div class="col-sm-4">${data.JAM_MASUK}</div>
                        </div>
                        <div class="row employee-info-text">
                            <div class="col-sm-4">Jam Pulang</div>
                            <div class="col-sm-4 text-center">:</div>
                            <div class="col-sm-4">${data.JAM_PULANG}</div>
                        </div>
                    </div>
                    `);
                }
            }else{
                Swal.fire(
                    {
                        icon:'warning',
                        title:'Peringatan !!',
                        text:res.errors
                    }
                );
                console.log(res.errors);
            }
        },
        error:function(err){
            console.log(err);
        }
    });
}


function pauseVideo()
{
    video.pause();
}


function getLabels()
{
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status ==200)
        {
            var res = JSON.parse(xhr.responseText);
            var data = res.data;
            for(var i=0;i<data.length;i++)
            {
                labels.push(data[i].NAMA_USER);
            }
            // console.log(labels);
        }
    }
    xhr.open("GET",`${baseUrl}/attendance_app/user/user_listall`,true);
    xhr.send();
}


function loadLabeledImages(){
    return Promise.all(
        labels.map(async label=>{
            const descriptions = [];
            for(let i=1; i<=2; i++){
                const img = await faceapi.fetchImage(`https://raw.githubusercontent.com/isnantozul/face_recognition/main/labeled-images/${label}/${i}.jpg`);
                const detections = await faceapi.detectSingleFace(img).withFaceLandmarks().withFaceDescriptor();
                descriptions.push(detections.descriptor);
            }
            return new faceapi.LabeledFaceDescriptors(label,descriptions);
        })
    );
}

function showLoadingAssets()
{
    Swal.fire({
        title:'Loading',
        html:'Sedang Mengambil Assets',
        width: 600,
        padding:'3em',
        background: '#fff url(./assets/loading_images/trees.png)',
        // backdrop: `
        //     rgba(0,0,123,0.4)
        //     url("./assets/loading_images/nyan-cat.gif")
        //     left top
        //     no-repeat
        // `,
        didOpen:()=>{
          Swal.showLoading();
        }
      });
}

function showLoading()
{
  Swal.fire({
      title:'Menyimpan',
      html:'Sedang proses, harap menunggu!!',
      didOpen:()=>{
        Swal.showLoading();
      }
    });
}

function hideLoading()
{
  Swal.close();
}

function refreshPage()
{
    window.location.reload();
}