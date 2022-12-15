$(document).ready(function() {
    let import_status = 0;
    RepeatFun();
    $('.uploading-progress-bar').removeClass('d-none');
    function RepeatFun() {
        setInterval(function () {
            if (import_status !== 1) {
                $.ajax({
                    url: status_url,
                }).
                done(function ({current_row, started, total_rows}) {
                    if(started === false){
                        window.location.href = route + '?success=true';
                    }
                    if (started === true) {
                        let percent = ((current_row /total_rows) * 100 );
                        $('#progress-bar-percentage').html(Math.round(percent) + '%');
                        $("#progress-bar").width(Math.round(percent) +"%");
                    }
                }).
                fail(function (data) {
                    console.log('Job not added....' + data);
                });
            }
        }, 3000);
    }
});
