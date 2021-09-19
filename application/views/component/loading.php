<style type="text/css">
    svg:not(:root) {
    overflow: hidden;
    }
    main {
    text-align: center;
    }
    h3.home-loading, p.home-loading {
    padding: 0;
    margin: 0;
    font-weight: 400;
    }
    .figures {
    margin-top: 19vh;
    height: 181px;
    }
    .figures__animation {
    max-width: 265px;
    position: relative;
    z-index: -9;
    }
    .tip {
    stroke-width: 3px;
    -webkit-transform: translateY(-7px);
    transform: translateY(-7px);
    }
    .body {
    fill: #6DDCBD;
    -webkit-transform: scaleX(1.25);
    transform: scaleX(1.25);
    -webkit-transform-origin: center;
    transform-origin: center;
    stroke-width: 3px;
    }
    .box {
    position: absolute;
    bottom: 0;
    left: 0;
    }
    .circle {
    fill: #6DDCBD;
    stroke: #fff;
    stroke-width: 7px;
    }
    .exhaust {
    border-bottom-left-radius: 4px;
    }
    .exhaust.two, .exhaust__line {
    -webkit-animation: thurst 70ms infinite ease-in-out alternate;
    animation: thurst 70ms infinite ease-in-out alternate;
    }
    .smoke {
    -webkit-animation: smoke .1s infinite ease-in-out alternate;
    animation: smoke .1s infinite ease-in-out alternate;
    -webkit-transform-origin: center;
    transform-origin: center;
    opacity: .8;
    }
    @-moz-document url-prefix() {
    .smoke {
    animation: smokeFirefox .2s infinite ease-in-out alternate;
    }
    }
    @-webkit-keyframes smoke {
    0% {
    -webkit-transform: scale(1.58, 1.2) translateY(-55px) skew(3deg);
    transform: scale(1.58, 1.2) translateY(-55px) skew(3deg);
    }
    100% {
    -webkit-transform: scale(1.6, 1.22) translateY(-55px) skew(-3deg);
    transform: scale(1.6, 1.22) translateY(-55px) skew(-3deg);
    }
    }
    @keyframes smoke {
    0% {
    -webkit-transform: scale(1.58, 1.2) translateY(-55px) skew(3deg);
    transform: scale(1.58, 1.2) translateY(-55px) skew(3deg);
    }
    100% {
    -webkit-transform: scale(1.6, 1.22) translateY(-55px) skew(-3deg);
    transform: scale(1.6, 1.22) translateY(-55px) skew(-3deg);
    }
    }
    @-webkit-keyframes smokeFirefox {
    0% {
    -webkit-transform: scale(1.58, 1.2) translateY(-75px) skew(0);
    transform: scale(1.58, 1.2) translateY(-75px) skew(0);
    }
    100% {
    -webkit-transform: scale(1.58, 1.21) translateY(-75px) skew(1deg);
    transform: scale(1.58, 1.21) translateY(-75px) skew(1deg);
    }
    }
    @keyframes smokeFirefox {
    0% {
    -webkit-transform: scale(1.58, 1.2) translateY(-75px) skew(0);
    transform: scale(1.58, 1.2) translateY(-75px) skew(0);
    }
    100% {
    -webkit-transform: scale(1.58, 1.21) translateY(-75px) skew(1deg);
    transform: scale(1.58, 1.21) translateY(-75px) skew(1deg);
    }
    }
    .flame {
    -webkit-animation: burnInner2 .1s infinite ease-in-out alternate;
    animation: burnInner2 .1s infinite ease-in-out alternate;
    }
    @-webkit-keyframes burnInner2 {
    0% {
    -webkit-transform: translate(265px, 249px) scale(1.9) rotate(180deg) skew(5deg);
    transform: translate(265px, 249px) scale(1.9) rotate(180deg) skew(5deg);
    }
    100% {
    -webkit-transform: translate(265px, 253px) scale(2.2) rotate(180deg) skew(-5deg);
    transform: translate(265px, 253px) scale(2.2) rotate(180deg) skew(-5deg);
    }
    }
    @keyframes burnInner2 {
    0% {
    -webkit-transform: translate(265px, 249px) scale(1.9) rotate(180deg) skew(5deg);
    transform: translate(265px, 249px) scale(1.9) rotate(180deg) skew(5deg);
    }
    100% {
    -webkit-transform: translate(265px, 253px) scale(2.2) rotate(180deg) skew(-5deg);
    transform: translate(265px, 253px) scale(2.2) rotate(180deg) skew(-5deg);
    }
    }
    @-webkit-keyframes thurst {
    0% {
    opacity: 1;
    }
    100% {
    opacity: .5;
    }
    }
    @keyframes thurst {
    0% {
    opacity: 1;
    }
    100% {
    opacity: .5;
    }
    }
    main p.home-loading {
    font-size: 16px;
    line-height: 20px;
    max-width: 390px;
    margin: 15px auto 0;
    color: #888888;
    }
    @media (max-width: 800px) {
    .figures {
    margin-top: 10px;
    }
    }
    @media (min-width: 801px) and (max-height: 730px) {
    .figures {
    margin-top: 80px;
    }
    }
    @media (min-width: 801px) and (max-height: 600px) {
    .figures {
    margin-top: 50px;
    }
    }
  </style>
  <main>
    <div class="figures">
       <img src="<?php echo base_url()?>assets/image/AdminLTELogo.png" alt="">
       <!-- <svg class="figures__animation" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
          <path fill="#f4f6f9" d="M0 0h512v512H0z"></path>
          <text transform="translate(97.173 475.104)"></text>
          <path d="M307.2 224.6c0 4.6-.5 9-1.6 13.2-2.5-4.4-5.6-8.4-9.2-12-4.6-4.6-10-8.4-16-11.2 2.8-11.2 4.5-22.9 5-34.6 1.8 1.4 3.5 2.9 5 4.5 10.5 10.3 16.8 24.5 16.8 40.1zM232.2 214.6c-6 2.8-11.4 6.6-16 11.2-3.5 3.6-6.6 7.6-9.1 12-1-4.3-1.6-8.7-1.6-13.2 0-15.7 6.3-29.9 16.6-40.1 1.6-1.6 3.3-3.1 5.1-4.5.6 11.8 2.2 23.4 5 34.6z" fill="#2E3B39"></path>
          <path class="body" d="M279.7 217.6c12.9-48.1 5.1-104-23.4-142.6-28.5 38.5-36.2 94.5-23.4 142.6h46.8z" fill="#FF7058"></path>
          <path class="tip" d="M273 104.7c-4.4-10.6-9.9-20.6-16.6-29.7-6.7 9-12.2 19-16.6 29.7H273z" fill="#2E3B39"></path>
          <circle cx="256.3" cy="144.8" fill="#FFF" r="15.5"></circle>
          <circle class="circle" cx="256.3" cy="144.8" fill="#84DBFF" r="12.2"></circle>
          <path class="removehole" d="M267.5 139.9l-16 16c4.5 2 9.8 1.1 13.5-2.5 3.6-3.7 4.5-9.1 2.5-13.5z" fill="#54C0EB"></path>
          <path class="fuel" d="M276.8 234.9c.4-2.4.6-5.1.6-7.9 0-12.1-3.9-21.8-8.8-21.8s-8.8 9.8-8.8 21.8c0 2.8.2 5.4.6 7.9h16.4zM252.3 234.9c.4-2.4.6-5.1.6-7.9 0-12.1-3.9-21.8-8.8-21.8-4.8 0-8.8 9.8-8.8 21.8 0 2.8.2 5.4.6 7.9h16.4z" fill="#FFD05B"></path>
          <path class="smoke" d="M416.6 358.8c0-1.8-.4-3.6-1-5.2-2.1-5.6-7.5-9.6-13.8-9.6-.7 0-1.4.1-2.1.2-.3-9.6-8.2-17.3-17.9-17.3-2.1 0-4.2.4-6.1 1.1-3-5.6-8.9-9.4-15.7-9.4-.5 0-1 0-1.5.1-.5 0-1-.1-1.5-.1-6.8 0-12.7 3.8-15.7 9.4-1.9-.7-3.9-1.1-6.1-1.1-9.9 0-17.9 8-17.9 17.9 0 1.1.1 2.3.3 3.3-.9-.2-1.8-.3-2.8-.3-5.1 0-9.5 2.6-12.1 6.5-2.2-1.4-4.9-2.3-7.8-2.3-7.6 0-13.8 5.9-14.4 13.3h-.1c-5.9 0-11 3.6-13.2 8.7-2.6-3-6.5-5-10.9-5h-.1-.5-.1-.1c-4.3 0-8.2 1.9-10.9 5-2.2-5.1-7.3-8.7-13.2-8.7h-.1c-.6-7.5-6.8-13.3-14.4-13.3-2.9 0-5.5.8-7.8 2.3-2.6-3.9-7-6.5-12.1-6.5-.9 0-1.9.1-2.8.3.2-1.1.3-2.2.3-3.3 0-9.9-8-17.9-17.9-17.9-2.1 0-4.2.4-6.1 1.1-3-5.6-8.9-9.4-15.7-9.4-.5 0-1 0-1.5.1-.5 0-1-.1-1.5-.1-6.8 0-12.7 3.8-15.7 9.4-1.9-.7-3.9-1.1-6.1-1.1-9.7 0-17.6 7.7-17.9 17.3-.7-.1-1.4-.2-2.1-.2-6.3 0-11.7 4-13.8 9.6-.6 1.6-1 3.4-1 5.2 0 4 1.6 7.6 4.2 10.3-.5 1.2-.8 2.6-.8 4 0 6 4.9 10.9 10.9 10.9H402c6 0 10.9-4.9 10.9-10.9 0-1.4-.3-2.8-.8-4 2.9-2.7 4.5-6.3 4.5-10.3z" fill="#4b545c"></path>
          <rect class="exhaust" fill="#6DDCBD" x="241" y="220" width="30" height="8"></rect>
          <rect class="exhaust two" fill="#FF871C" x="245" y="231" width="20" height="9"></rect>
          <rect class="exhaust__line" fill="#E6E9EE" x="252" y="240" width="7" height="90"></rect>
          <path class="flame" d="M 6.7 1.14 l 2.8 4.7 s 1.3 3 -1.82 3.22 l -5.4 0 s -3.28 -.14 -1.74 -3.26 l 2.76 -4.7 s 1.7 -2.3 3.4 0 z" fill="#AA2247"></path>
       </svg> -->
    </div>
    <!-- <h3 class="home-loading">Sedang mempersiapkan permintaan anda!</h3>
    <p class="home-loading">Pastikan koneksi internet anda stabil.</p> -->
  </main>
  