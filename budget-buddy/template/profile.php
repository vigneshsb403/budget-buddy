<?php
$hacker = Session::getUser()->getUsername();
$contactInfo = fetchUserContactInfo($hacker);
?>
<body>
<div class="container py-4">
    <div class="p-5 mb-4 bg-body-tertiary rounded-3">
      <div class="container-fluid py-5">
          <h1 class="display-5 fw-bold">Hi, <? echo $hacker?></h1>
        <p class="col-md-8 fs-4">some text here.</p>
        <button class="btn btn-primary btn-lg" type="button">Example button</button>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6 offset-md-3">
        <div class="profile-info">
          <h1>About Me</h1>
          <p>Some text here must come.</p>
        </div>
      </div>
    </div>


    <div class="row">
      <div class="col-md-6 offset-md-3">
        <div class="contact">
        <?
            if ($contactInfo) {
                echo "<h1>Contact Information</h1>";
                echo "<p>Email: " . $contactInfo['email'] . "</p>";
                echo "<p>Phone: " . $contactInfo['phone'] . "</p>";
            } else {
                echo "User not found or contact information not available.";
            }?>
        </div>
      </div>
    </div>
  </div>
      </div>
</body>
</html>
