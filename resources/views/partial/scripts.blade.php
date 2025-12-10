<!-- Bootstrap 5 Bundle JS (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<!-- AdminLTE v3 JS -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<!-- Optional: DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-countdown@2.2.0/dist/jquery.countdown.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/print-js@1.6.0/dist/print.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@3.3.4/dist/vue.global.prod.js"></script>

<script>
    var pusher = new Pusher('061e9baad7be01269391', {
        encrypted: true,
        cluster: 'ap1'
    });
    var channel = pusher.subscribe('exam-channel');
    channel.bind('exam-event', function(data) {
        $("span").remove();
        $(".notif").empty();
        if (data['notify'].length > 0) {
            $("#notify").append("<span class='badge custom-badge'>" + data['notify'].length + "</span>");
            data['notify'].forEach(function(value) {
                $(".notif").append(
                    "<li> <a id='app_modal' data-id =" + value['id'] +
                    " href='javascript:void(0)'>" +
                    "<div class='row'>" +
                    " <div class='col-sm-2'><div class=\"profile-circle-ex\" ><p>{{ substr("+value['name']+", 0, 1) }}</p></div></div>" +
                    "<div class='col-sm-8' style='line-height: .5;'>" +
                    "<p style='font-size: 1.6rem'>" + value['name'] + "</p>" +
                    "<p style='font-size: 1.2rem'>Just Completed the exam.</p>" +
                    "<p class='text-sm text-muted'><i class='fa fa-clock mr-1'></i> 4 Hours Ago</p>" +
                    "</div>" +
                    "<div class='col-sm-2 text-success'><i class='fa fa-star fa-lg'></i></div>" +
                    "</div></div></a>" +
                    "</li><div class='dropdown-divider'>"
                );
            });

        }
    });
</script>
