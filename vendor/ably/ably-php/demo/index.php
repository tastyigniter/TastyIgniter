<?php
// include the ably library
require_once __DIR__ . '/../vendor/autoload.php';
// if not using composer, use this include instead:
// require_once __DIR__ . '/../ably-loader.php';

$apiKey = getenv( 'ABLY_KEY' ); // private api key
$host = getenv( 'ABLY_HOST' ); // ably server
$wshost = getenv( 'ABLY_WS_HOST' ); // ably websocket server

if (!$apiKey) {
    die( 'Please provide your Ably key as an environment variable ABLY_KEY.' );
}

$channelName = isset($_REQUEST['channel']) ? $_REQUEST['channel'] : 'persist:chat';
$eventName = isset($_REQUEST['event']) ? $_REQUEST['event'] : 'guest';
$settings = array(
    'key'  => $apiKey,
);

if ($host) {
    $settings['host'] = $host;
}

// instantiate Ably
$app = new \Ably\AblyRest($settings);
$channel = $app->channel($channelName);

if (!empty($_POST)) {
    // publish a message
    $channel->publish( $eventName, array('handle' => $_POST['handle'], 'message' => $_POST['message']) );
    die();
}

// get a list of recent messages and render the interface
$messages = $channel->history( array('direction' => 'backwards') )->items;

?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1; user-scalable=no">
    <title>Simple Chat Demo</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
    <style>
        body { padding: 10px; overflow: hidden; background: url(//d6i46dwqrtafp.cloudfront.net/images/bg/carbon_fibre.png) }
        .chat-window { overflow: hidden; border-top: 1px solid #e1e1e1; position: relative; }
        .chat-window-content { overflow: auto; color: #888; height: 500px; }
        .chat-window-content > ul { list-style: none; margin: 25px 0 50px; padding: 0; }
        .chat-window-shadow { position: absolute; z-index: 100; height: 50px; width: 100%; }
        .chat-window-shadow-top { top: 0; background-image: -webkit-linear-gradient(top, rgba(255,255,255, 1), rgba(255,255,255, 0)) }
        .chat-window-shadow-bottom { bottom: 0; background-image: -webkit-linear-gradient(bottom, rgba(255,255,255, 1), rgba(255,255,255, 0)) }
        .handle { color: #2f91ff; font-weight: bold }
        .time { float: right; color: #ccc; }
        h1.panel-title small { font-size: 12px; }
    </style>
</head>
<body>

<div class="panel panel-default">
    <div class="panel-heading">
        <h1 class="panel-title">Let's Chat <small>[api_time: <?php echo gmdate('r', $app->time()/1000) ?> | server_time: <?php echo gmdate('r', time()) ?>]</small></h1>
    </div>
    <div class="panel-body">
        <form id="message_form" method="post" action="index.php" class="form-inline" role="form">
            <input type="hidden" name="channel" value="<?= $channelName ?>">
            <input type="hidden" name="event" value="<?= $eventName ?>">
            <div id="form-group-handle" class="form-group">
                <input type="text" name="handle" class="form-control input-sm" placeholder="Your handle">
            </div>
            <div class="form-group">
                <input type="text" name="message" class="form-control input-sm" placeholder="Say something">
            </div>
            <button id="rest" type="button" class="btn btn-default btn-sm">Send via PHP REST</button>
            <button id="realtime" type="button" class="btn btn-default btn-sm">Send via JS realtime</button>
            <button id="resetHandle" type="button" class="btn btn-default btn-sm">Reset Handle</button>
        </form>
    </div>
    <div class="chat-window list-group">
        <div class="chat-window-content">
            <ul id="message_pool">
                <?php $date_format = 'D jS F, Y'; $stamp = date($date_format, time()); ?>
                <?php foreach ($messages as $message): ?>
                    <?php if (property_exists($message, 'data')) :
                        $timestamp = intval($message->timestamp / 1000);
                        $day = date($date_format, $timestamp); ?>
                        <?php if ($stamp != $day) : ?>
                            <li class="list-group-item"><h2 class="h4"><?= $day ?></h2></li>
                        <?php $stamp = $day; endif; ?>
                        <li class="list-group-item"><span class="time"><?= gmdate('h:i a', $timestamp) ?></span> 
                        <b class="handle"><?= $message->data->handle ?>:</b> <?= $message->data->message ?></li>
                    <?php endif; endforeach; ?>
            </ul>
            <div class="chat-window-shadow chat-window-shadow-top"></div>
            <div class="chat-window-shadow chat-window-shadow-bottom"></div>
        </div>
    </div>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="//cdn.ably.io/lib/ably.js"></script>
<script type="text/javascript">

    (function($) {

        var $handle = $('#form-group-handle input');

        var showStoredHandle = function(){
            if(localStorage.handle){
                $handle.val(localStorage.handle).hide();
                if (!$handle.siblings('label').length) {
                    $handle.parent().append('<label>'+localStorage.handle+'</label>');
                }
                
            }
        }

        showStoredHandle();
        
        // adjust chat window height
        var $chatWindowContent = $('.chat-window-content');

        $(window).on('resize', function() {
            $chatWindowContent.height($(this).height() - $chatWindowContent.offset().top - 10);
        }).resize();

        var ably = new Ably.Realtime({
            key: '<?= $apiKey ?>',
            tls: true,
            log: {level:4}
            <?php if ($host): ?>,host: '<?= $host ?>'<?php endif; ?>
            <?php if ($wshost): ?>,wsHost: '<?= $wshost ?>'<?php endif; ?>
        });

        var channel = ably.channels.get('<?= $channelName ?>');

        channel.subscribe('<?= $eventName ?>', function(response) {
            var data = response.data;
            var timestamp = response.timestamp
            var d = new Date( timestamp.toString().length > 10 ? timestamp : timestamp*1000 );
            var hours = d.getUTCHours();
            var ampm = hours > 12 ? ' pm' : ' am';
            hours = hours % 12;
            hours = hours === 0 ? 12 : hours;
            var minutes = ('0'+d.getUTCMinutes()).substr(-2);
            var post_time = [hours, minutes].join(':') + ampm;
            $('#message_pool').prepend(
                '<li class="list-group-item"><span class="label label-danger">received</span> <time>'+
                post_time +'</time> <b class="handle">'+ data.handle +':</b> '+ data.message +'</li>'
            );
        });

        function sendMessage(mode) {
            var $form = $('#message_form'),
                broadcast = true,
                $handle = $('[name="handle"]', $form),
                $message = $('[name="message"]', $form);

            if ($.trim($handle.val()) === '') {
                alert('you must provide a handle');
                $handle.focus();
                broadcast = false;
            }
            else {
                localStorage.handle = $handle.val();
                showStoredHandle();
            }

            if ($.trim($message.val()) === '') {
                alert('you must type a message');
                $message.focus();
                broadcast = false;
            }

            if (broadcast) {
                if (mode === 'realtime') {
                    channel.publish('<?= $eventName ?>', { handle: $handle.val(), message: $message.val() } );
                    $message.val('');
                } else {
                    $.ajax({
                        url: $form[0].action,
                        data: $form.serialize(),
                        type: $form[0].method,
                        dataType: 'json',
                        complete: function() {
                            $message.val('');
                        }
                    });
                }
            }
        }

        $('#rest').on('click', function() {
            sendMessage('rest');
            return false;
        });

        $('#realtime').on('click', function() {
            sendMessage('realtime');
            return false;
        });
        $('#resetHandle').on('click', function() {
            localStorage.removeItem('handle');
            $handle.siblings('label').remove().end().val('').fadeIn();
        });

    })(jQuery);
</script>

</body>
</html>