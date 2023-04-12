<!DOCTYPE html>
<html>
   <head>
        <!-- Basic -->
      
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- Mobile Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <!-- Site Metas -->
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <link rel="shortcut icon" href="{{asset('images/favicon.png') }}" type="">
        <title>Famms - Fashion HTML Template</title>
        <!-- bootstrap core css -->
        <link rel="stylesheet" type="text/css" href="{{asset('home/css/bootstrap.css')}}" />
        <!-- font awesome style -->
        <link href="{{asset('home/css/font-awesome.min.css')}}" rel="stylesheet" />
        <!-- Custom styles for this template -->
        <link href="{{asset('home/css/style.css')}}" rel="stylesheet" />
        <!-- responsive style -->
        <link href="{{asset('home/css/responsive.css') }}" rel="stylesheet" />

      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
      integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
      crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   </head>
   <body>
      <div class="hero_area">
        {{-- including the header section --}}
        @include('home.header')
        {{-- end of the include header section --}}
  
      <!-- product section -->
        @include('home.product_view')
      <!-- end product section -->

      {{-- Comment and reply system starts here--}}
          <div style="text-align: center; padding-bottom: 30px;">
            <h1 style="font-size:30px; text-align:center; padding-top:20px; padding-bottom:20px;">Comments</h1>

            <form action="{{ url('add_comment') }}" method="post">
              @csrf
              <textarea name="comment" style="height:150px; width:600px;" placeholder="Comment Something here" ></textarea>
              <br>
              
              <input type="submit" value="comment" class="btn btn-primary">
            </form>
          </div>

          <div style="padding-left:20%">
            <h1 style="font-size: 30px; padding-bottom: 20px;">All Comments</h1>

            @foreach($comment as $comment )
            <div>
              <b>{{ $comment->name }}</b>
              <p>{{ $comment->comment }}</p>
              <a href="javascript::void(0)" class="text text-primary" onclick="reply(this)" data-Commentid="{{ $comment->id }}"><b>Reply</b></a>
            </div>

            
            {{-- Displaying all the reply text from the reply table --}}
            @foreach ($reply as $rep)

            @if ($rep->comment_id == $comment->id)
            <div style="padding-left: 3%; padding-bottom: 10px; padding-bottom: 10px;">
              
              <b>{{ $rep->name }}</b>     
             :         
              {{ $rep->reply }}  
              <br>
              <a href="javascript::void(0)" class="text text-primary" onclick="reply(this)" data-Commentid="{{ $comment->id }}"><b>Reply</b></a>           

            </div>
            @endif

            @endforeach
           
           
            @endforeach

            {{-- Reply Text Box --}}

            {{-- Show this textbox whenever someone clicks on the replay button on the comments section above. --}}
            <div style="display:none;" class="replyDiv">
              <form action="{{ url('add_reply') }}" method="post">
                @csrf
              <input type="text" name="commentId" id="commentId" hidden>

              <textarea style="height:100px; width:500px;" name="reply" placeholder="write something here"></textarea>
              <br>

              <button type="submit" class="btn btn-warning">Reply</button>
              <a href="javascript::void(0)"  class="btn btn-primary" onclick="reply_close(this)">Close</a>
            </form>
            </div>
      

          </div>
      {{-- Comment and reply system ends here --}}

    
      <!-- footer end -->
      <div class="cpy_">
         <p class="mx-auto">© 2021 All Rights Reserved By <a href="https://html.design/">Free Html Templates</a><br>
         
            Distributed By <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>
         
         </p>
      </div>

      {{-- <script>
        document.addEventListener("DOMContentLoaded", function(event) { 
            var scrollpos = localStorage.getItem('scrollpos');
            if (scrollpos) window.scrollTo(0, scrollpos);
        });

        window.onbeforeunload = function(e) {
            localStorage.setItem('scrollpos', window.scrollY);
        };
    </script> --}}

    <script>
      document.addEventListener("DOMContentLoaded", function (event) {
          var scrollpos = sessionStorage.getItem('scrollpos');
          if (scrollpos) {
              window.scrollTo(0, scrollpos);
              sessionStorage.removeItem('scrollpos');
          }
      });
  
      window.addEventListener("beforeunload", function (e) {
          sessionStorage.setItem('scrollpos', window.scrollY);
      });
  </script>

      <script type="text/javascript">

        function reply(caller)
        {
          document.getElementById('commentId').value = $(caller).attr('data-Commentid');

          //calling the class name
          $('.replyDiv').insertAfter($(caller));

          $('.replyDiv').show();
        }

        function reply_close(caller)
        {
          $('.replyDiv').hide();
        }

      </script>

      <!-- jQery -->
      <script src="home/js/jquery-3.4.1.min.js"></script>
      <!-- popper js -->
      <script src="home/js/popper.min.js"></script>
      <!-- bootstrap js -->
      <script src="home/js/bootstrap.js"></script>
      <!-- custom js -->
      <script src="home/js/custom.js"></script>
   </body>
</html>