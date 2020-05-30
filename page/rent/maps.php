
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Multiple Markers - Google Maps API demo - Augustus - Let's Write</title>
    <link rel="canonical" href="https://letswrite.tw/google-map-api-marker-custom/">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
      .container {
        padding-top: 30px;
        padding-bottom: 30px;
      }
      #map {
        background: #CCC;
      }
      .fixed-bottom {
        position: fixed;
        left: 16px;
        bottom: 0;
        max-width: 320px;
      }
    </style>
    
    <link rel="shortcut icon" href="https://i0.wp.com/letswrite.tw/wp-content/uploads/2019/07/cropped-letswrite512-1.jpg"/>
    <!-- Google Tag Manager-->
    <script>
      (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
      new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
      j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
      'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
      })(window,document,'script','dataLayer','GTM-PGQ9WQT');
    </script>
  </head>
  <body>
    <!-- Google Tag Manager (noscript)-->
    <noscript>
      <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PGQ9WQT" height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>

    <div id="app" class="container">

      <div class="row">
        <div class="col">
          <div id="map" class="embed-responsive embed-responsive-16by9"></div>
        </div>
      </div>

      <div class="row fixed-bottom">
        <div class="col">
          <div class="alert alert-info" role="alert">
            Let's Write 筆記文：<br/>
            <a href="https://letswrite.tw/google-map-api-marker-custom/" target="_blank">Google Maps API學習筆記-1</a>
          </div>
        </div>
      </div>
    
    </div>
    
    <!-- 將 YOUR_API_KEY 替換成你的 API Key 即可 -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAWONkZ5unzdAAcQM5XRH_ojvnFTEwlTps&callback=initMap" async defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js"></script>

    <!-- map -->
    <script>
const googleMap = new Vue({
  el: '#app',
  data: {
    map: null
  },
  methods: {
    // init google map
    initMap() {
      // 預設顯示的地點：台北市政府親子劇場
      let location = {
        lat: 25.0374865, // 經度
        lng: 121.5647688 // 緯度
      };
      
      // 建立地圖
      this.map = new google.maps.Map(document.getElementById('map'), {
        center: location,
        zoom: 16,
        mapTypeId: 'terrain'
      });
      
      // 放置多個marker
      fetch('./map.geojson')
        .then(results => results.json())
        .then(result => {
          let res = result.features;
          Array.prototype.forEach.call(res, r => {
            let latLng = new google.maps.LatLng(r.geometry.coordinates[0], r.geometry.coordinates[1]);
            let marker = new google.maps.Marker({
              position: latLng,
              icon: "https://akveo.github.io/eva-icons/outline/png/128/gift-outline.png", // 自定義圖標，google也有提供5個預設的圖標，參考下方*1
              map: this.map
            });

            /* *1 用google預設圖標的寫法
              let marker = new google.maps.Marker({
                icon: {
                  // icon圖例：https://developers.google.com/maps/documentation/javascript/symbols?hl=zh-tw#predefined
                  // google.maps.SymbolPath.CIRCLE
                  // google.maps.SymbolPath.BACKWARD_CLOSED_ARROW
                  // google.maps.SymbolPath.FORWARD_CLOSED_ARROW
                  // google.maps.SymbolPath.BACKWARD_OPEN_ARROW
                  // google.maps.SymbolPath.FORWARD_OPEN_ARROW
                  path: google.maps.SymbolPath.CIRCLE,
                  scale: 10
                }
              });
            */

          });
      });

    }
  },
  created() {
    window.addEventListener('load', () => {
      this.initMap();
    });
  }
});
    </script>

  </body>
</html>
