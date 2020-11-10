<div id="google_translate_element"></div>
{{-- @push('before_styles_stack') --}}
<style>
    .goog-te-banner-frame{display: none;}
    .goog-te-combo{border: 1px solid #ddd;display: block;width: 100%;height: 38px;padding: .5rem .75rem;font-size: .85rem;line-height: 1.25;color: #464a4c;background-color: #fff;height: 42px;border-radius: 3px;}
    .goog-logo-link {display:none !important;}
    .goog-te-gadget {margin-top: 10px;margin-left: 10px;color: transparent !important;}
    body{top: 0px !important;}
</style>
{{-- @endpush --}}

{{-- @push('after_scripts_stack') --}}
<script type="text/javascript">
// localStorage.setItem("language", '{{$data["lan"]}}');
    // function getCookie(cname) {
    //     var name = cname + "=";
    //     var decodedCookie = decodeURIComponent(document.cookie);
    //     var ca = decodedCookie.split(';');
    //     for(var i = 0; i < ca.length; i++) {
    //         var c = ca[i];
    //         while (c.charAt(0) == ' ') {
    //         c = c.substring(1);
    //         }
    //         if (c.indexOf(name) == 0) {
    //         return c.substring(name.length, c.length);
    //         }
    //     }
    //     return "";
    // }

    function setCookie(key, value, expiry) {
      var expires = new Date();
      expires.setTime(expires.getTime() + (expiry * 24 * 60 * 60 * 1000));
      document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
    }
    function googleTranslateElementInit() {
        // let lang = getCookie('googtrans')
        // if(lang === ""){
            // let lang = localStorage.getItem("language");
            // setCookie('googtrans', lang ,1);
        // }
        new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
    }
    // var el = document.querySelector('.goog-te-combo');
    // if(el){
    //     el.addEventListener('change', function(e){
    //         localStorage.setItem("language", '/en/'+e.target.value);
    //     });
    // }
    // goog-te-combo
</script>
{{-- @endpush --}}