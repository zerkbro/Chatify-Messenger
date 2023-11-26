<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.header')

    @stack('styles')
    @livewireStyles()
</head>


<body>

    <!-- Loader ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper compact-sidebar" id="pageWrapper">
        {{-- Page Header Top Nav Start --}}


        @include('layouts.navbar')



        {{-- <!-- Page Header Ends --> --}}



        {{-- Page Body Starts --}}
        <div class="page-body-wrapper sidebar-icon">
            <!-- Page Sidebar Start-->
            @include('layouts.sidenavbar')

            <!-- Page Sidebar Ends-->
            <div class="page-body">
                <!-- Container-fluid starts-->
                <div class="container-fluid">
                    @yield('main_content')
                </div>
                <!-- Container-fluid Ends-->
            </div>
            <!-- footer start-->
            {{-- @include('layouts.footer') --}}
        </div>
        {{-- Page Body Ends --}}

    </div>

    {{-- Test Code For Audio Notificationn Sound --}}
    {{-- <audio id="MyAudioElement" autoplay style="display: none">
        <source src="{{ asset('talkster/sounds/friend_request.mp3') }}" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio> --}}

    {{-- page wrapper Ends --}}
    @include('layouts.script')

    {{-- Test Script Code for notification sound --}}

    {{-- <script>
        // JavaScript
        const audio = new Audio('/talkster/sounds/friend_request.mp3');
        // Wrap the native DOM audio element play function and handle any autoplay errors
        Audio.prototype.play = (function(play) {
        return function () {
        var audio = this,
            args = arguments,
            promise = play.apply(audio, args);
        if (promise !== undefined) {
            promise.catch(_ => {
            // Autoplay was prevented. This is optional, but add a button to start playing.
            var el = document.createElement("button");
            el.innerHTML = "Play";
            el.addEventListener("click", function(){play.apply(audio, args);});
            this.parentNode.insertBefore(el, this.nextSibling)
            });
        }
        };
        })(Audio.prototype.play);

        // Try automatically playing our audio via script. This would normally trigger and error.

        // document.getElementById('MyAudioElement').play()
        audio.play();
    </script> --}}



    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = false;

        var pusher = new Pusher('39d8b4ffd7de9257d701', {
            cluster: 'ap2'
        });

        // display the latest message in notification
        var channel3 = pusher.subscribe('newMsg-channel');
        channel3.bind('new-message', function(data) {
            if (data.recieverId == {{ auth()->user()->id }}) {
                var routeUrl = '{{ url('user/chat') }}/' + data.senderId;
                new Noty({
                    type: 'info',
                    timeout: '9000',
                    progressBar: true,
                    text: `<i class="fa-regular fa-comments"></i>  ${data.senderName} : ${data.message}`,
                    sounds: {
                        sources: [
                        'talkster/sounds/newmessage.mp3'], // Relative path to the public directory
                        volume: 1,
                        conditions: ['docVisible', 'docHidden'],
                    },
                    callbacks: {
                        onClick: function() {
                            window.location.href = routeUrl;
                        }
                    } // end of callbacks
                }).show(); // end of noty


                // Notification sound for new message
                const audio = new Audio('/talkster/sounds/newmessage.mp3');
                // Wrap the native DOM audio element play function and handle any autoplay errors
                Audio.prototype.play = (function(play) {
                    return function() {
                        var audio = this,
                            args = arguments,
                            promise = play.apply(audio, args);
                        if (promise !== undefined) {
                            promise.catch(_ => {
                                // Autoplay was prevented. This is optional, but add a button to start playing.
                                var el = document.createElement("button");
                                el.innerHTML = "Play";
                                el.addEventListener("click", function() {
                                    play.apply(audio, args);
                                });
                                this.parentNode.insertBefore(el, this.nextSibling)
                            });
                        }
                    };
                })(Audio.prototype.play);
                audio.play();


            } // end of if statement
        }); // end of channel3


        // display the incomming friend request notification
        var channel2 = pusher.subscribe('newFrnRequest-channel');
        channel2.bind('new-frnreq', function(data) {
            // console.log('Received data:', data);
            if (data.recieverId == {{ auth()->user()->id }}) {
                new Noty({
                    type: 'error',
                    timeout: '9000', //9second
                    text: `<i class="fas fa-user-plus"></i> ${data.senderName} wants to be friend with you.`,
                    callbacks: {
                        onClick: function() {
                            window.location.href =
                            '/dashboard'; // Redirect to the user dashboard when clicked
                        }
                    }
                }).show();

                const audio = new Audio('/talkster/sounds/friend_request.mp3');
                // Wrap the native DOM audio element play function and handle any autoplay errors
                Audio.prototype.play = (function(play) {
                    return function() {
                        var audio = this,
                            args = arguments,
                            promise = play.apply(audio, args);
                        if (promise !== undefined) {
                            promise.catch(_ => {
                                // Autoplay was prevented. This is optional, but add a button to start playing.
                                var el = document.createElement("button");
                                el.innerHTML = "Play";
                                el.addEventListener("click", function() {
                                    play.apply(audio, args);
                                });
                                this.parentNode.insertBefore(el, this.nextSibling)
                            });
                        }
                    };
                })(Audio.prototype.play);
                audio.play();
            }
        });


        // display the friendship success notification
        var channel4 = pusher.subscribe('friendship-success');
        channel4.bind('friendship-alert', function(data) {
            // senderId means the one who has sends the friend request first
            if (data.senderId == {{ auth()->user()->id }}) {
                new Noty({
                    type: 'success',
                    theme: 'nest',
                    text: `<i class="fas fa-user"></i> ${data.recieverName} has accepted your friend request.`,
                }).show();

                const audio = new Audio('/talkster/sounds/request_accepted.mp3');
                // Wrap the native DOM audio element play function and handle any autoplay errors
                Audio.prototype.play = (function(play) {
                    return function() {
                        var audio = this,
                            args = arguments,
                            promise = play.apply(audio, args);
                        if (promise !== undefined) {
                            promise.catch(_ => {
                                // Autoplay was prevented. This is optional, but add a button to start playing.
                                var el = document.createElement("button");
                                el.innerHTML = "Play";
                                el.addEventListener("click", function() {
                                    play.apply(audio, args);
                                });
                                this.parentNode.insertBefore(el, this.nextSibling)
                            });
                        }
                    };
                })(Audio.prototype.play);
                audio.play();

            }
        });
    </script>

    @stack('scripts')

    @livewireScripts()
</body>

</html>
