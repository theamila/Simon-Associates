
    <style>
        /* Center the loader horizontally and vertically */
        #main {
            width: 100%;
            height: 100vh;
            position: absolute;
            top: 0;
            left: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #fff;
        }

        .loader {
            width: 50px;
            height: 50px;
            position: relative;
            animation: animate 2s linear infinite;
            z-index: 9999;
        }

        .loader .dot {
            width: 20px;
            height: 20px;
            margin: auto;
            border-radius: 100%;
            position: absolute;
        }

        .loader .dot:nth-child(1) {
            background: #ff4444;
            top: 0;
            left: 0;
        }

        .loader .dot:nth-child(2) {
            background: #ffbb33;
            top: 0;
            right: 0;
        }

        .loader .dot:nth-child(3) {
            background: #99cc00;
            bottom: 0;
            left: 0;
        }

        .loader .dot:nth-child(4) {
            background: #33b5e5;
            bottom: 0;
            right: 0;
        }

        @keyframes animate {
            0% {
                transform: scale(1) rotate(0);
            }

            20%,
            25% {
                transform: scale(1.3) rotate(90deg);
            }

            45%,
            50% {
                transform: scale(1) rotate(180deg);
            }

            70%,
            75% {
                transform: scale(1.3) rotate(270deg);
            }

            95%,
            100% {
                transform: scale(1) rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <div id="main">
    <div class="loader" id="loader">
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
    </div>
    </div>
</body>


<script>
    var loader = document.getElementById('main');
    window.addEventListener('load', function(){
        loader.style.display = 'none';
    })
</script>