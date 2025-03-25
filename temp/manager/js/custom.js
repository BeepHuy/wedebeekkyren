$(document).ready(function () {
    //alert(adminurl);
    // alert(base_url);
    /*------ Number field show--category chose----------
    ------------------------------------------------*/
    $('.filter select').change(function () {
        var ajurl = adminurl + 'ajax/' + $(this).attr('name') + '/' + $(this).attr('title');
        var num = $(this).val();
        $.ajax({
            type: "POST",
            url: ajurl,
            data: { data: num },
            success: function () { location.reload(); }

        });
    });
    ///---tim kiem theo ten or id
    $('.timkiem').click(function () {
        var ajurl = adminurl + 'search/users';
        var dtst = $('#sdt').serialize();
        $.ajax({
            type: "POST",
            url: ajurl,
            data: dtst,
            success: function () { location.reload(); }

        });
    });
    //--------------------------- change rate ajax---------------
    $('.dislead').click(function () {
        var id = $(this).attr('id');
        var sll = '.showstatus';
        $(sll).html('<img src="' + base_url + 'temp/admin/images/loading.gif"/>');
        var val = $(this).parent().find('input').val();
        var url = adminurl + 'ajaxdislead/';
        $.ajax({
            type: "POST",
            url: url,
            data: { id: id, val: val },
            success: function (data) {
                $(sll).html('<span class="glyphicon glyphicon-ok"></span>');
            }
        });
        ///thuc hien ajax glyphicon glyphicon-ok
    })
    ////--------------banner uesr of manager
    var url = adminurl + 'ajax/ban_user/';
    $('.statusc').on('change', function () {
        $va = $(this).val();
        $id = $(this).attr('id');
        $.ajax({
            type: "POST",
            url: url,
            data: { id: $id, val: $va, data: 1 },
            success: unpub,

        });
    });
    //manager for publisher 

    $('.manager').on('change', function () {
        $va = $(this).val();
        $id = $(this).attr('id');
        $.ajax({
            type: "POST",
            url: adminurl + 'ajax/manager/',
            data: { id: $id, val: $va, data: 1 },
            error: function () { alert('error'); }

        });
    });

    //offer request    
    $('.rqst').on('change', function () {
        $va = $(this).val();
        $id = $(this).attr('id');
        $.ajax({
            type: "POST",
            url: adminurl + 'ajax/requestoff/',
            data: { id: $id, val: $va, data: 1 },
            error: function () { alert('error'); },
            success: function(data){

                // Cập nhật màu của dòng
                row.removeClass('success warning danger');
                if(newStatus === 'Approved'){
                    row.addClass('success');
                } else if(newStatus === 'Deny'){
                    row.addClass('danger');
                } else if(newStatus === 'Pending'){
                    row.addClass('warning');
                }
                
                // Cập nhật nội dung status trong modal tương ứng
                $('#detailModal-' + rowId).find('.status-text').text(newStatus);
            }

        });
    });
    ////* ---------- Submenu  ---------- */
    $('.dropmenu').click(function (e) {
        e.preventDefault();
        $(this).parent().find('ul').slideToggle();

    });
    /*
    $('li').hover(function(){        
        $(this).parent().find('ul').show();
    },function(){
        $(this).parent().find('ul').hide()
    }    
    )
    */
    ////mini content
    $('.btn-close').click(function (e) {
        e.preventDefault();
        $(this).parent().parent().parent().fadeOut();
    });
    $('.btn-minimize').click(function (e) {
        e.preventDefault();
        var $target = $(this).parent().parent().next('.box-content');
        if ($target.is(':visible')) $('i', $(this)).removeClass('icon-chevron-up').addClass('icon-chevron-down');
        else $('i', $(this)).removeClass('icon-chevron-down').addClass('icon-chevron-up');
        $target.slideToggle();
    });
    ///setting admin
    $('.btn-setting').click(function (e) {
        e.preventDefault();
        $('#setting').modal('show');
    });

    //$('#setting').modal('show');//
    $('#setting_save').on('click', function () {
        var str = $("#form_setting").serialize();
        $(this).text('Saving.....');
        $.ajax({
            type: "POST",
            url: adminurl + 'ajaxsetting',
            data: str,
            success: function () {
                $('#setting_save').text('Done!!!');
                setTimeout(function () {
                    $('#setting_save').text('Save changes');
                }, 2000);

            }

        });
    });
    // setting smartlionk
    $('.btn-smartlink').click(function (e) {
        e.preventDefault();
        $('#smartlink').modal('show');
    });
    //$('#setting').modal('show');//
    $('#smartlink_save').on('click', function () {
        var str = $("#form_smartlink").serialize();
        $(this).text('Saving.....');
        $.ajax({
            type: "POST",
            url: adminurl + 'ajaxsmartlink',
            data: str,
            success: function () {
                $('#smartlink_save').text('Done!!!');
                setTimeout(function () {
                    $('#smartlink_save').text('Save changes');
                }, 2000);

            }

        });
    });
    // hide custom
    if ($('#atcsm').val() == 2) {
        $('.chide').hide();
    } else {
        $('.chide').show();
    }
    $('#atcsm').on('change', function () {
        if ($('#atcsm').val() == 2) {
            $('.chide').hide();
        } else {
            $('.chide').show();
        }
    });


    ///-----------------Tạo invoice lấy lại của usermodal--------------------------------


    $('.invoice').click(function () {
        var title = $(this).attr('data-email');
        $('#myModalLabel').text('INVOICE: ' + title);
        id = $(this).attr('title');
        $('.cusermodal').load(adminurl + 'invoice/aj_invoice/' + id);
        $('.userview').modal('show');
    })
    ///-----------------view user modal--------------------------------
    $('.usermodal').click(function () {
        id = $(this).attr('title');
        $('.cusermodal').load(adminurl + 'show_user/' + id);
        $('.userview').modal('show');
    })

    /* ---------- Add class .active to current link  ---------- */
    $('ul.main-menu li a').each(function () {

        if ($(this).hasClass('submenu')) {

            if ($($(this))[0].href == String(window.location)) {

                $(this).parent().parent().parent().addClass('active');

            }

        } else {

            if ($($(this))[0].href == String(window.location)) {

                $(this).parent().addClass('active');

            }

        }


    });
    //--------------------------- payout ajax---------------
    $('.pay').click(function () {
        var id = $(this).attr('id');
        var sll = '.sl-' + id;
        $(sll).html('<img src="' + base_url + 'temp/admin/images/loading.gif"/>');
        var val = $(this).parent().find('input').val();
        var url = adminurl + 'ajaxpayout/';
        $.ajax({
            type: "POST",
            url: url,
            data: { id: id, val: val },
            success: function (data) {
                $('.s-' + id).text(data);
                $(sll).html('<span class="glyphicon glyphicon-ok"></span>');
            }
        });
        ///thuc hien ajax glyphicon glyphicon-ok
    })

    /*------------------on/off buttom------------------
    ---------------------------------------------------*/


    $('.box_switch').click(function () {
        var iputv = $(this).parent().find('input');
        var t = iputv.val();
        if (t == 1) {
            t = 0;
            $(this).addClass('off');
        } else {
            t = 1;
            $(this).removeClass('off')
        }
        $(iputv).val(t);
        return false;
    });
    ///////////////////--------------------ajax approved admin
    $('.approved').click(function () {
        var parent = $(this).parent();
        parent.find('span').hide();
        parent.find('select').show();
    })
    $('.sapproved').change(function () {
        var id = $(this).attr('id');
        var val = $(this).val();
        var th = $(this);
        var cl = '';
        var txt = '';
        var url = adminurl + 'ajax/ban_user/';
        $.ajax({
            type: "POST",
            url: url,
            data: { id: id, val: val },
            success: function (data) {
                $(th).hide();
                $(th).parent().find('span').show();
                if (data == 0) { cl = 'label label-warning'; txt = 'Pending'; }
                if (data == 1) { cl = 'label label-success'; txt = 'Approved'; }
                if (data == 2) { cl = 'label label-default'; txt = 'Pause'; }
                if (data == 3) { cl = 'label label-danger'; txt = 'Banned'; }
                if (data == 4) { cl = 'label label-danger'; txt = 'Rejected'; }
                $(th).parent().find('.label').removeClass().addClass(cl).text(txt);
            }
        });

    })
    ///------------------canh bao delete
    $('.del').click(function () {
        return confirm('Are you sure?');
    });

    /*-------------ajax kich unpublish----------------
-------------------------------------------------*/
    $('.ajaxst').click(function () {
        var ht = $(this);
        var url = adminurl + 'ajax/unpub/';
        var vdata = $(this).attr('data');
        vdata = vdata + '&current=' + $(this).text();
        var up_cla = $(this).attr('class');
        //data = data+'&class='+cla;
        if (up_cla == 'label label-success ajaxst' || up_cla == 'request ajax unpub') {
            newclass = 'label label-warning ajaxst';
            vdata = vdata + '&value=0';
        }
        if (up_cla == 'label label-warning ajaxst') {
            newclass = 'label label-success ajaxst';
            vdata = vdata + '&value=1'
        }
        $.ajax({
            type: "POST",
            url: url,
            data: vdata,
            success: function (data, status) {
                ht.removeClass(up_cla);
                ht.addClass(newclass);
                ht.text(data);
            },
            error: err
        });
        return false;
    });


    /*------------end--------------*/



});
function unpub(data, status) {
    $(data).removeClass('up_cla');
}

function err(xhr, reason, ex) {
    // alert('loi');
    console.log();
    //$("div .box_ajax").html('loi');
}
function chage_content(data, status) {
    alert(data);
    // $('.box_content').html(data);
    location.reload();
}

