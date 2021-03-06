@php use Laravel\Socialite\Facades\Socialite;
    use App\Models\User;
@endphp
<html>
  <head>
    <title>Redirect example</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    
  </head>

  <body>
    
    <h2>Redirect example</h2>
    <ul style="margin-left: 0; padding-left: 15px;">
      <li>
        <a href="exp://REPLACE_ME/">
          Go back with no params
        </a>
      </li>
      <li>
        <a href="exp://REPLACE_ME/message=Hello%20World">
          Pass back a message of "hello world"
        </a>
      </li>
      <li>
        <a href="exp://REPLACE_ME/authToken=ststs">
          Pass back some fake auth token
        </a>
      </li>
    </ul>
    <p>
      @php
          $token = 'dfkdsk'; 
      @endphp
      Redirecting automatically back to app in <span class="countdown">5</span> seconds
    </p>
    @php $token = '23432423'; @endphp

    <script>
      document.addEventListener("DOMContentLoaded", function(event) {
        var links = document.querySelectorAll('a');
        var baseUri = 'exp://wg-qka.notbrent.app.exp.direct';

        // Take the uri from the params
        var qs = decodeURIComponent(document.location.search);
        if (qs) {
          baseUri = qs.split('?linkingUri=')[1];
        }

        // Update the link urls
        for (var i = 0; i < links.length; ++i) {
          links[i].href = links[i].href.replace('exp://REPLACE_ME/', baseUri);
          console.log(links[i].href);
        }

        var redirectInterval = setInterval(function() {
          var countdown = document.querySelector('.countdown');
          var t = parseInt(countdown.innerText, 10);
          t -= 1;

          countdown.innerText = t;

          if (t === 0) {
            clearInterval(redirectInterval);
            window.location.href = baseUri + 'message=' + encodeURIComponent("{{$token}}");
          }
        }, 1000);
      });
    </script>
  </body>
</html>