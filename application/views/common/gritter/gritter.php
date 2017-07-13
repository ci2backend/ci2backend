<link rel="stylesheet" type="text/css" href="<?php echo base_url(ASSETS.EXTENSIONS.'admin_dashboard/assets/gritter');?>/css/jquery.gritter.css" />

<script src="<?php echo base_url(ASSETS.EXTENSIONS.'pusher');?>/src/lib/gritter/js/jquery.gritter.min.js"></script>

<script src="<?php echo base_url(ASSETS.EXTENSIONS.'pusher');?>/src/pusher.min.js"></script>

<script src="<?php echo base_url(ASSETS.EXTENSIONS.'pusher');?>/src/PusherNotifier.js"></script>

<script>

    $(function() {
        
        var pusher = new Pusher('36340713248ca08f63be');

        var channel = pusher.subscribe('my_notifications');

        var notifier = new PusherNotifier(channel);

    });

</script>