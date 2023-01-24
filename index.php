<?php
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "mail_db";

  $con = new mysqli($servername, $username, $password, $dbname);

  if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
  }

  if (isset($_POST['subject']) && $_POST['subject'] !== "") {
    foreach($_POST['recipientIds'] as $recipient) {
      $attachmentFlag = count($_POST['attachments']) > 0 ? 1 : 0;
      $query = 'INSERT INTO messages (recipientId, recipientString, senderId, attachmentFlag, replyFlag, forwardFlag, subject, body, date) VALUES ('. $recipient .', "", 0, '. $attachmentFlag .', 0, 0, "'. $_POST['subject'] .'", "'. $_POST['body'] .'", "'. date('Y-m-d H:m:s') .'")';
      if ($con->query($query) === TRUE) {
        $last_id = $con->insert_id;
        if ($attachmentFlag === 1) {
          foreach($_POST['attachments'] as $attachment) {
            $query1 = 'INSERT INTO attachments (messageId, directoryPath, date) VALUES ('. $last_id .', "'. $attachment .'", "'. date('Y-m-d H:m:s') .'")';
            if ($con->query($query1) === TRUE) {
  
            } else {
              exit("attachemnts save error");
            }
          }
        }
      } else {
        exit("error");
      }
    }
  }

  if (isset($_POST['startNum'])) {
    $startNum = $_POST['startNum'] == 0 ? 0 : $_POST['startNum'] - 1;
    if ($_POST['search'] !== "") {
      $query = "SELECT * FROM messages WHERE subject LIKE '%". $_POST['search'] ."%' LIMIT " . $startNum . ", 10";
    } else {
      $query = "SELECT * FROM messages LIMIT " . $startNum . ", 10";
    }
    $result = $con->query($query);
    $messages = [];
    while($message = mysqli_fetch_array($result)) {
      $messages[] = $message;
    }
    exit(json_encode($messages));
  }

  if (isset($_POST['flag']) && $_POST['flag'] == true) {
    $messageQuery = "SELECT * FROM messages";
    if ($_POST['search'] !== "") {
      $messageQuery .= " WHERE subject LIKE '%". $_POST['search'] ."%'";
    }
    $messageResult = $con->query($messageQuery);
    $messageNum = $messageResult->num_rows;
    echo $messageNum;exit;
  }

  $userSql = "SELECT * FROM users";
  $userResult = $con->query($userSql);
  $users = [];
  while($user = mysqli_fetch_array($userResult)) {
    $users[] = $user;
  }

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Dashboard | Page Vectors</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

  <!--  Bootstrap cdn -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
  <link href="bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
  <link href="index.css" rel="stylesheet">

  <title>Mailbox - Moein Porkamel</title>
</head>

<body>
  <div class="wrapper">
    <nav id="sidebar" class="active">
      <div class="sidebar-header">
      </div>
    </nav>
    <div id="body" class="active">
      <nav class="navbar navbar-expand-lg navbar-white bg-white">
        <button type="button" id="sidebarCollapse" class="btn btn-light"><i
            class="fas fa-bars"></i><span></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

        </div>
      </nav>

      <div class="content container1">
        <div>
          <div class="container2 mailbox">
            <div>
              <a href="javascript:openCompose();" class="btn btn-primary btn-block">Compose</a>
              <div class="mailbox-box mailbox-box-solid">
                <div class="mailbox-box-header nav-item nav-link dropdown-toggle text-secondary" data-toggle="dropdown">
                  <h3 class="mailbox-box-title">Folders</h3>
                </div>
                <div class="dropdown-menu mailbox-box-body">
                  <ul class="vertical-list nav-list">
                    <li class="active">
                      <a href="index.html">
                        <i class="fa fa-inbox"></i>
                        Inbox
                        <span class="label label-primary pull-right flip">12</span>
                      </a>
                    </li>
                    <li>
                      <a href="index.html">
                        <i class="fa fa-envelope-o"></i>
                        Sent
                      </a>
                    </li>
                    <li>
                      <a href="index.html">
                        <i class="fa fa-file-text-o"></i>
                        Drafts
                        <span class="label label-warning pull-right flip">45</span>
                      </a>
                    </li>
                    <li>
                      <a href="index.html">
                        <i class="fa fa-filter"></i>
                        Junk
                      </a>
                    </li>
                    <li>
                      <a href="index.html">
                        <i class="fa fa-trash"></i>
                        Trash
                      </a>
                    </li>
                  </ul>
                </div>
              </div> <!-- End Box -->
              <div class="mailbox-box mailbox-box-solid">
                <div class="mailbox-box-header nav-item nav-link dropdown-toggle text-secondary" data-toggle="dropdown">
                  <h3 class="mailbox-box-title">Labels</h3>
                </div>
                <div class="dropdown-menu mailbox-box-body">
                  <ul class="vertical-list">
                    <li>
                      <a href="#">
                        <i class="fa fa-circle-o"></i>
                        Important
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <i class="fa fa-circle-o"></i>
                        Promotions
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <i class="fa fa-circle-o"></i>
                        Social
                      </a>
                    </li>
                  </ul>
                </div>
              </div> <!-- End Box -->
            </div>
            <!-- Sidebar -->
            <div class="">
              <div class="mailbox-box mailbox-box-primary">
                <div class="mailbox-box-header">
                  <h3 class="mailbox-box-title">Inbox</h3>
                  <div class="mailbox-box-tools pull-right flip">
                    <form id="center-box" class="form form-horizontal search-form">
                      <input type="text" class="form-control" placeholder="Search for..." id="search-text">
                      <i class="fas fa-search fa-btn"></i>
                    </form>
                  </div>
                </div>
                <div id="center-box" class="mailbox-box-body">
                  <div id="center-box" class="mailbox-controls">
                    <button class="btn btn-default btn-sm" type="button">
                      <i class="fa fa-square-o"></i>
                    </button>
                    <div class="btn-group">
                      <button class="btn btn-default btn-sm" type="button">
                        <i class="fas fa-trash"></i>
                      </button>
                      <button class="btn btn-default btn-sm" type="button">
                        <i class="fa fa-reply"></i>
                      </button>
                      <button class="btn btn-default btn-sm" type="button">
                        <i class="fa fa-share"></i>
                      </button>
                    </div>
                    <button class="btn btn-default btn-sm" type="button">
                      <i class="fa fa-refresh"></i>
                    </button>
                    <div class="pull-right flip">
                      <span class="start-num">1</span>-<span class="end-num">10</span>/<span class="total-num">0</span>
                      <div class="btn-group">
                        <button class="btn btn-default btn-sm prev" type="button">
                          <i class="fa fa-chevron-left"></i>
                        </button>
                        <button class="btn btn-default btn-sm next" type="button">
                          <i class="fa fa-chevron-right"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                  <!-- Controls -->
                  <div class="table-responsive mailbox-messages">
                    <table class="table table-hover table-striped">
                      <tbody>
                        
                      </tbody>
                    </table>
                  </div> <!-- Messages -->
                  <div class="mailbox-controls">
                    <button class="btn btn-default btn-sm" type="button">
                      <i class="fa fa-square-o"></i>
                    </button>
                    <div class="btn-group">
                      <button class="btn btn-default btn-sm" type="button">
                        <i class="fa fa-trash-o"></i>
                      </button>
                      <button class="btn btn-default btn-sm" type="button">
                        <i class="fa fa-reply"></i>
                      </button>
                      <button class="btn btn-default btn-sm" type="button">
                        <i class="fa fa-share"></i>
                      </button>
                    </div>
                    <button class="btn btn-default btn-sm" type="button">
                      <i class="fa fa-refresh"></i>
                    </button>
                    <div class="pull-right flip">
                      <span class="start-num">1</span>-<span class="end-num">10</span>/<span class="total-num">0</span>
                      <div class="btn-group">
                        <button class="btn btn-default btn-sm prev" type="button">
                          <i class="fa fa-chevron-left"></i>
                        </button>
                        <button class="btn btn-default btn-sm next" type="button">
                          <i class="fa fa-chevron-right"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                  <!-- Controls -->
                </div>
              </div> <!-- End Box -->
            </div>
          </div>
          <div class="container3 ">
            <div class="mailbox-box mailbox-box-primary">
              <div class="mailbox-box-header">
                <h3 class="mailbox-box-title">Read Mail</h3>
                <div class="mailbox-box-tools pull-right flip">
                  <a href="read.html" class="btn btn-sm"><i class="fa fa-chevron-left"></i></a>
                  <a href="read.html" class="btn btn-sm"><i class="fa fa-chevron-right"></i></a>
                </div>
              </div>
              <div class="mailbox-box-body">
                <div class="mailbox-read-info">
                  <h3>
                    Message Subject Is Placed Here
                  </h3>
                  <h5>
                    From: tje3d@yahoo.com
                    <span class="mailbox-read-info-time pull-right flip">
                      15 Feb. 2015 11:03 PM
                    </span>
                  </h5>
                </div>
                <!-- Read Info -->
                <div class="mailbox-controls text-center">
                  <div class="btn-group">
                    <button class="btn btn-default btn-sm" data-container="body" data-toggle="tooltip" title="Delete"
                      type="button">
                      <i class="fa fa-trash-o">
                      </i>
                    </button>
                    <button class="btn btn-default btn-sm" data-container="body" data-toggle="tooltip" title="Reply"
                      type="button">
                      <i class="fa fa-reply">
                      </i>
                    </button>
                    <button class="btn btn-default btn-sm" data-container="body" data-toggle="tooltip" title="Forward"
                      type="button">
                      <i class="fa fa-share">
                      </i>
                    </button>
                  </div>
                  <button class="btn btn-default btn-sm" data-toggle="tooltip" title="Print" type="button">
                    <i class="fa fa-print"></i>
                  </button>
                </div>
                <!-- Controls -->
                <div class="mailbox-read-message">
                  <p>
                    Hello Moein,
                  </p>
                  <p>
                    Keffiyeh blog actually fashion axe vegan, irony biodiesel. Cold-pressed hoodie
                    chillwave put a bird
                    on it aesthetic, bitters brunch meggings vegan iPhone. Dreamcatcher vegan
                    scenester mlkshk. Ethical
                    master cleanse Bushwick, occupy Thundercats banjo cliche ennui farm-to-table
                    mlkshk fanny pack
                    gluten-free. Marfa butcher vegan quinoa, bicycle rights disrupt tofu scenester
                    chillwave 3 wolf moon
                    asymmetrical taxidermy pour-over. Quinoa tote bag fashion axe, Godard disrupt
                    migas church-key tofu
                    blog locavore. Thundercats cronut polaroid Neutra tousled, meh food truck
                    selfies narwhal American
                    Apparel.
                  </p>
                  <p>
                    Raw denim McSweeney's bicycle rights, iPhone trust fund quinoa Neutra VHS kale
                    chips vegan PBR&B
                    literally Thundercats +1. Forage tilde four dollar toast, banjo health goth
                    paleo butcher. Four dollar
                    toast Brooklyn pour-over American Apparel sustainable, lumbersexual listicle
                    gluten-free health goth
                    umami hoodie. Synth Echo Park bicycle rights DIY farm-to-table, retro kogi
                    sriracha dreamcatcher PBR&B
                    flannel hashtag irony Wes Anderson. Lumbersexual Williamsburg Helvetica next
                    level. Cold-pressed
                    slow-carb pop-up normcore Thundercats Portland, cardigan literally meditation
                    lumbersexual crucifix.
                    Wayfarers raw denim paleo Bushwick, keytar Helvetica scenester keffiyeh 8-bit
                    irony mumblecore
                    whatever viral Truffaut.
                  </p>
                  <p>
                    Post-ironic shabby chic VHS, Marfa keytar flannel lomo try-hard keffiyeh cray.
                    Actually fap fanny
                    pack yr artisan trust fund. High Life dreamcatcher church-key gentrify. Tumblr
                    stumptown four dollar
                    toast vinyl, cold-pressed try-hard blog authentic keffiyeh Helvetica lo-fi tilde
                    Intelligentsia. Lomo
                    locavore salvia bespoke, twee fixie paleo cliche brunch Schlitz blog McSweeney's
                    messenger bag swag
                    slow-carb. Odd Future photo booth pork belly, you probably haven't heard of them
                    actually tofu ennui
                    keffiyeh lo-fi Truffaut health goth. Narwhal sustainable retro disrupt.
                  </p>
                  <p>
                    Skateboard artisan letterpress before they sold out High Life messenger bag.
                    Bitters chambray
                    leggings listicle, drinking vinegar chillwave synth. Fanny pack hoodie American
                    Apparel twee. American
                    Apparel PBR listicle, salvia aesthetic occupy sustainable Neutra kogi. Organic
                    synth Tumblr viral
                    plaid, shabby chic single-origin coffee Etsy 3 wolf moon slow-carb Schlitz roof
                    party tousled squid
                    vinyl. Readymade next level literally trust fund. Distillery master cleanse
                    migas, Vice sriracha
                    flannel chambray chia cronut.
                  </p>
                  <p>
                    Thanks,
                    <br>
                    Jane
                    </br>
                  </p>
                </div> <!-- Read Message -->
                <ul class="mailbox-attachment clearfix">
                  <li>
                    <span class="mailbox-attachment-icon">
                      <i class="fa fa-file-pdf-o"></i>
                    </span>
                    <div class="mailbox-attachment-info">
                      <a class="mailbox-attachment-name" href="#">
                        <i class="fa fa-paperclip"></i>
                        Sep2014-report.pdf
                      </a>
                      <span class="mailbox-attachment-size">
                        1,245 KB
                        <a class="btn btn-default btn-xs pull-right flip" href="#">
                          <i class="fa fa-cloud-download"></i>
                        </a>
                      </span>
                    </div>
                  </li>
                  <li>
                    <span class="mailbox-attachment-icon">
                      <i class="fa fa-file-word-o"></i>
                    </span>
                    <div class="mailbox-attachment-info">
                      <a class="mailbox-attachment-name" href="#">
                        <i class="fa fa-paperclip"></i>
                        App Description.docx
                      </a>
                      <span class="mailbox-attachment-size">
                        1,245 KB
                        <a class="btn btn-default btn-xs pull-right flip" href="#">
                          <i class="fa fa-cloud-download"></i>
                        </a>
                      </span>
                    </div>
                  </li>
                  <li>
                    <span class="mailbox-attachment-icon has-img">
                      <img alt="Attachment" src="img/photo1.png" />
                    </span>
                    <div class="mailbox-attachment-info">
                      <a class="mailbox-attachment-name" href="#">
                        <i class="fa fa-camera"></i>
                        photo1.png
                      </a>
                      <span class="mailbox-attachment-size">
                        2.67 MB
                        <a class="btn btn-default btn-xs pull-right flip" href="#">
                          <i class="fa fa-cloud-download"></i>
                        </a>
                      </span>
                    </div>
                  </li>
                  <li>
                    <span class="mailbox-attachment-icon has-img">
                      <img alt="Attachment" src="img/photo2.png" />
                    </span>
                    <div class="mailbox-attachment-info">
                      <a class="mailbox-attachment-name" href="#">
                        <i class="fa fa-camera"></i>
                        photo2.png
                      </a>
                      <span class="mailbox-attachment-size">
                        1.9 MB
                        <a class="btn btn-default btn-xs pull-right flip" href="#">
                          <i class="fa fa-cloud-download"></i>
                        </a>
                      </span>
                    </div>
                  </li>

                </ul> <!-- Attachments -->

              </div>

              <div class="mailbox-box-footer">
                <div class="pull-right flip">
                  <button class="btn btn-default" type="button">
                    <i class="fa fa-reply"></i>
                    Reply
                  </button>
                  <button class="btn btn-default" type="button">
                    <i class="fa fa-share"></i>
                    Forward
                  </button>
                </div>
                <button class="btn btn-default" type="button">
                  <i class="fa fa-trash-o"></i>
                  Delete
                </button>
                <button class="btn btn-default" type="button">
                  <i class="fa fa-print"></i>
                  Print
                </button>
              </div>
            </div> <!-- End Box -->
          </div>
          <!-- Content -->
        </div>
      </div>

      <div class="compose-modal">
        <div class="compose-modal-header">
          <h3>Compose New Message</h3>
          <i class="fa fa-close" onclick="javascript:closeCompose();"></i>
        </div>
        <div class="compose-modal-content">
          <div class="recipient">
            <span>To</span>
            <select name="" id="recipient_id" class="selectpicker" multiple data-live-search="true">
              <?php
                foreach ($users as $user) {
                  echo '<option value="'. $user['userId'] .'">'. $user['username'] .'</option>';
                }
              ?>
            </select>
          </div>
          <div class="subject">
            <span>Subject</span>
            <input type="text" id="subject">
          </div>
          <div class="message-content">
            <textarea name="" id="message" cols="30" rows="10"></textarea>
          </div>
          <div class="attachment">
            <span>Attachment</span>
            <select name="" id="attachment" class="selectpicker" multiple data-live-search="true">
              <option value="1.png">1.png</option>
              <option value="2.png">2.png</opt☻ion>
            </select>
          </div>
        </div>
        <div class="compose-modal-footer">
          <button id="send" onclick="javascript:send();">Send</button>
          <button id="draft">Draft</button>
          <button id="discard">Discard</button>
        </div>
      </div>

    </div>
    <script src="jquery.min.js"></script>
    <script src="bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <script src="script.js"></script>
  </div>
</body>

</html>