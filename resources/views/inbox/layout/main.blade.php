<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - SB Admin</title>
    <base href="{{asset('')}}">
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/inbox.css">
    <script src="js/all.min.js" crossorigin="anonymous"></script>
    @php
    $name = Session::get('name');
    $img = Session::get('img');
    $inforCustomer = Session::get('inforCustomer');
    @endphp
</head>

<body class="sb-nav-fixed">
    @include('home.layout.header')
    <div id="layoutSidenav">
        @include('home.layout.menu')
        <div id="layoutSidenav_content" style="min-height: calc(100vh - 96px);">
            <main>
                <div class="container-fluid">
                    <div class="people-list" id="people-list" style="background: #444753; height: 550px; width: 22%">
                        <ul class="list" style="height: 80px;">
                            <li class="clearfix" style="list-style: none; display: flex">
                                <img src={{$img}} style="border-radius: 50%; height: 45px" alt="avatar" />
                                <div class="about">
                                    <div class="name">{{$name}}</div>
                                    <div class="status">
                                        <i class="fa fa-circle online"></i> online
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="search" style="display: flex;">
                            <input type="text" placeholder="search" style="border-radius: 30px; width:92%; height: 30px; outline: none" />
                            <i class="fa fa-search" style="left: -10%; margin-top: 9px"></i>
                        </div>
                        <ul class="list" style="height: 490px;">
                            @foreach($inforCustomer as $inf)
                            <li class="clearfix" style="list-style: none;">
                                <a href="{{url('/detail_inbox/' .$inf['id'])}}" class="hover detail_inbox" style="display: flex; border-radius: 10px; text-decoration: none; color: white;">
                                    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/195612/chat_avatar_01.jpg" alt="avatar" />
                                    <div class="about">
                                        <div class="name">
                                            {{$inf['senders']['data'][0]['name']}}
                                        </div>
                                        <div class="status">
                                            <i class="fa fa-circle online"></i> online
                                        </div>
                                    </div>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @yield('content')
                </div>
            </main>
            @include('home.layout.footer')
        </div>
    </div>
    </div>
    <script src="js/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="js/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/datatables-demo.js"></script>
    <!-- <script type="text/javascript">
        $(document).ready(function() {
            $('.detail_inbox').click(function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'get',
                    url: $(this).attr('href'),
                    success: function(res) {
                        document.getElementById('name-chat').innerHTML = res.data.senders.data[0].name;
                        document.getElementById('messages_chat').innerHTML = res.data.messages.data.length + ' ' + 'tin nhắn';
                        // let arr = [];
                        // for (const chat of res.data.messages.data) {
                        //     arr.unshift(chat);
                        // }
                        // for (const inf of arr) {
                        //     let node = document.createElement("LI");
                        //     let div = document.createElement("DIV");
                        //     let time = document.createElement("SPAN");
                        //     let name = document.createElement("SPAN");
                        //     let icon = document.createElement("I");
                        //     let chat = document.createElement("DIV");

                        //     node.classList.add('clearfix');
                        //     node.style = 'list-style: none';
                        //     div.classList.add('message-data align-right');
                        //     time.classList.add('message-data-time');
                        //     name.classList.add('message-data-name');
                        //     icon.classList.add('fa fa-circle me');
                        //     chat.classList.add('message other-message float-right');

                        //     let times = document.createTextNode('10:10 AM, Today');
                        //     let names = document.createTextNode('Olia');
                        //     let chat = document.createTextNode(inf.message);

                        //     node.appendChild(div,chat);
                        //     div.appendChild(time,name);

                        //     document.getElementById('list_chat').appendChild(node);
                        // }
                    }
                });
            });
        });
    </script> -->
    <script>
        (function() {
            var chat = {
                messageToSend: '',
                messageResponses: [
                    'Why did the web developer leave the restaurant? Because of the table layout.',
                    'How do you comfort a JavaScript bug? You console it.',
                    'An SQL query enters a bar, approaches two tables and asks: "May I join you?"',
                    'What is the most used language in programming? Profanity.',
                    'What is the object-oriented way to become wealthy? Inheritance.',
                    'An SEO expert walks into a bar, bars, pub, tavern, public house, Irish pub, drinks, beer, alcohol'
                ],
                init: function() {
                    this.cacheDOM();
                    this.bindEvents();
                    this.render();
                },
                cacheDOM: function() {
                    this.$chatHistory = $('.chat-history');
                    this.$button = $('button');
                    this.$textarea = $('#message-to-send');
                    this.$chatHistoryList = this.$chatHistory.find('ul');
                },
                bindEvents: function() {
                    this.$button.on('click', this.addMessage.bind(this));
                    this.$textarea.on('keyup', this.addMessageEnter.bind(this));
                },
                render: function() {
                    this.scrollToBottom();
                    if (this.messageToSend.trim() !== '') {
                        var template = Handlebars.compile($("#message-template").html());
                        var context = {
                            messageOutput: this.messageToSend,
                            time: this.getCurrentTime()
                        };

                        this.$chatHistoryList.append(template(context));
                        this.scrollToBottom();
                        this.$textarea.val('');

                        // responses
                        var templateResponse = Handlebars.compile($("#message-response-template").html());
                        var contextResponse = {
                            response: this.getRandomItem(this.messageResponses),
                            time: this.getCurrentTime()
                        };

                        setTimeout(function() {
                            this.$chatHistoryList.append(templateResponse(contextResponse));
                            this.scrollToBottom();
                        }.bind(this), 1500);

                    }

                },

                addMessage: function() {
                    this.messageToSend = this.$textarea.val()
                    this.render();
                },
                addMessageEnter: function(event) {
                    // enter was pressed
                    if (event.keyCode === 13) {
                        this.addMessage();
                    }
                },
                scrollToBottom: function() {
                    this.$chatHistory.scrollTop(this.$chatHistory[0].scrollHeight);
                },
                getCurrentTime: function() {
                    return new Date().toLocaleTimeString().
                    replace(/([\d]+:[\d]{2})(:[\d]{2})(.*)/, "$1$3");
                },
                getRandomItem: function(arr) {
                    return arr[Math.floor(Math.random() * arr.length)];
                }

            };

            chat.init();

            var searchFilter = {
                options: {
                    valueNames: ['name']
                },
                init: function() {
                    var userList = new List('people-list', this.options);
                    var noItems = $('<li id="no-items-found">No items found</li>');

                    userList.on('updated', function(list) {
                        if (list.matchingItems.length === 0) {
                            $(list.list).append(noItems);
                        } else {
                            noItems.detach();
                        }
                    });
                }
            };

            searchFilter.init();

        })();
    </script>
</body>

</html>
