/*------------------------------------------------------------------
* Bootstrap Simple Admin Template
* Version: 2.1
* Author: Alexis Luna
* Website: https://github.com/alexis-luna/bootstrap-simple-admin-template
-------------------------------------------------------------------*/
var startNum = 1;
var endNum = 10;
var totalNum = 0;
$('#center-box.form').submit(false);
$('#recipient_id').selectpicker();
$('#attachments').selectpicker();

// Toggle sidebar on Menu button click
$('#sidebarCollapse').on('click', function() {
    $('#sidebar').toggleClass('active');
    $('#body').toggleClass('active');
});

$('#search-text').change(function() {
    getMessagesNum();
    getMessages();
})

$('.prev').click(function() {
    if (startNum >= 11) {
        startNum = startNum > 10 ? startNum - 10 : 1;
        endNum = endNum > 20 ? endNum - 10 : 10;
        $('.start-num').html(startNum);
        $('.end-num').html(endNum);
        getMessages();
    }
});

$('.next').click(function() {
    if (endNum < totalNum) {
        startNum += 10;
        endNum = endNum + 10 > totalNum ? totalNum : endNum + 10;
        $('.start-num').html(startNum);
        $('.end-num').html(endNum);
        getMessages();
    }
});

function openCompose() {
    $('.compose-modal').css('display', 'flex');
}

function closeCompose() {
    $('.compose-modal').css('display', 'none');
}

function send() {
    $.post(
        'index.php',
        {
            recipientIds: $('#recipient_id').val(),
            subject: $('#subject').val(),
            body: $('#message').val(),
            attachments: $('#attachment').val()
        },
        function(res) {
            
        }
    );
}

function getMessages() {
    $.post(
        'index.php',
        {
            startNum: startNum,
            search: $('#search-text').val()
        },
        function(res) {
            $('.mailbox-box-body tbody').html('');
            var rows = JSON.parse(res);
            for (row of rows) {
                var tr = '<tr>';
                        tr += '<td>';
                            tr += '<div aria-checked="false" aria-disabled="false" class="icheckbox_flat-blue" style="position: relative;">';
                                tr += '<input style="position: absolute; opacity: 0;" type="checkbox">';
                                    tr += '<ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins>';
                                tr += '</input>';
                            tr += '</div>';
                        tr += '</td>';
                        tr += '<td class="mailbox-star">';
                            tr += '<a href="#">';
                                tr += '<i class="fa fa-star text-yellow"></i>';
                            tr += '</a>';
                        tr += '</td>';
                        tr += '<td class="mailbox-name">';
                            tr += '<a href="read.html">'+ row['subject'] +'</a>';
                        tr += '</td>';
                        tr += '<td class="mailbox-subject">'+ row['body'] +'</td>';
                        tr += '<td class="mailbox-attachment"></td>';
                        tr += '<td class="mailbox-date">12 mins ago</td>';
                tr += '</tr>';
                $('.mailbox-box-body tbody').append(tr);
            }
        }
    );
}

function getMessagesNum() {
    $.post(
        'index.php',
        {
            flag: true,
            search: $('#search-text').val()
        },
        function(res) {
            totalNum = res;
            console.log(res);
            $(".total-num").html(totalNum);
            if (totalNum == 0) {
                startNum = 0;
                $('.start-num').html(0);
                endNum = 0;
                $('.end-num').html(0);
            } else if (totalNum < 10) {
                startNum = 1;
                $('.start-num').html(1);
                endNum = totalNum;
                $('.end-num').html(endNum);
            } else {
                startNum = 1;
                $('.start-num').html(1);
                endNum = 10;
                $('.end-num').html(10);
            }
        }
    );
}
getMessagesNum();
getMessages();

// Auto-hide sidebar on window resize if window size is small
// $(window).on('resize', function () {
//     if ($(window).width() <= 768) {
//         $('#sidebar, #body').addClass('active');
//     }
// });