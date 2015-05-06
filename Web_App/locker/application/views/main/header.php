<!DOCTYPE html>
<html>
<header>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Web Locker</title>
        <link type="text/css" rel="stylesheet" href="<?php echo base_url();?>/css/bootstrap.css">
        <link type="text/css" rel="stylesheet" href="<?php echo base_url();?>/css/jquery_ui.css">
        <link type="text/css" rel="stylesheet" href="<?php echo base_url();?>/css/jquery-ui-timepicker-addon.css">
        <script type="text/javascript" src='<?php echo base_url();?>/js/jquery.js'></script>
        <script type="text/javascript" src='<?php echo base_url();?>/js/jquery_ui.js'></script>
        <script type="text/javascript" src='<?php echo base_url();?>/js/bootstrap.js'></script>
        <script type="text/javascript" src='<?php echo base_url();?>/js/highcharts.js'></script>
        <script type="text/javascript" src='<?php echo base_url();?>/js/jquery-ui-sliderAccess.js'></script>
        <script type="text/javascript" src='<?php echo base_url();?>/js/jquery-ui-timepicker-addon.js'></script>

        
</header>
<body  background='<?php echo base_url();?>/images/bg.jpg'>

    <!-- Header -->
    <nav class="navbar navbar-inverse" style="margin: 4% 5% 0% 5%;" role="navigation">          
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bt_nav">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="bt_nav">
            <ul class="nav navbar-nav">
            <?php if( $this->session->userdata("sess_type") == "ผู้ดูแลระบบ" ){?>
                <li><a href="<?php echo base_url();?>history_controller/view_add"> การแจ้งเตือน <?php if( $this->session->userdata("sess_message") != null ){?> <span class='badge'><?php echo $this->session->userdata("sess_message"); ?></span><?php }?></a></li>
                <li><a href="<?php echo base_url();?>subject_controller/view_add">รายวิชา</a></li>
                <li><a href="<?php echo base_url();?>subject_table_controller/view_add">ตารางสอน</a></li>
                <li><a href="<?php echo base_url();?>overtime_room_controller/view_add">ขอใช้ห้อง</a></li>
                <li><a href="<?php echo base_url();?>history_controller/view_show">รายงาน</a></li>
                <li><a href="<?php echo base_url();?>account_controller/view_show">บัญชีผู้ใช้</a></li>
                <li><a href="<?php echo base_url();?>config_controller/view_show">ตั้งค่า</a></li>
            <?php }else{?>  
                <li><a href="<?php echo base_url();?>history_controller/view_add"> การแจ้งเตือน <?php if( $this->session->userdata("sess_message") != null ){?> <span class='badge'><?php echo $this->session->userdata("sess_message"); ?></span><?php }?></a></li>
                <li><a href="<?php echo base_url();?>subject_table_controller/view_show">ตารางสอน</a></li>
                <li><a href="<?php echo base_url();?>history_controller/view_show">รายงาน</a></li>
            <?php }?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <form class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                        <label name="icon_user" style="font-size:20px;margin:0px 20px 0px 20px;color:white;"><i class="glyphicon glyphicon-user" style="margin-right:20px;"></i><?php echo $this->session->userdata("sess_name")." ".$this->session->userdata("sess_sname");?></label>
                        <button type="button" class="btn btn-danger btn-logout">ออกจากระบบ</button>
                        <input type="hidden" name="base_url" value="<?php echo base_url();?>">
                    </div>
                </form>
                <form method="post" action="<?php echo base_url();?>account_controller/logout" id="f_logout"></form>
                <form method="post" action="<?php echo base_url();?>historydetail_controller/view_show" id="detail">
                    <input type="hidden" name="st">
                </form>
            </ul>
        </div>
    </nav>
    <div class="modal fade" id="dl_Modal_out">
        <div class="modal-dialog modal-sm " style="margin-top:10%">
            <div class="modal-content">
                <div class="modal-header modal-header-primary" >
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5> คุณต้องการออกจากระบบ ? </h5>
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-sm btn-out" data-dismiss="modal"> ตกลง </button>
                    <button type="button" class="btn btn-danger btn-sm btn-no" data-dismiss="modal"> ยกเลิก </button>
                </div>
            </div>
        </div>
    </div>
<!--end Header -->
<script type="text/javascript">
    $(document).ready(function(){
        $(".btn-logout").click(function(){
            $('#dl_Modal_out').modal('show');
        });

        $(".btn-out").click(function(){
            $("#f_logout").submit();
        });
});
</script>
<?php date_default_timezone_set('America/Los_Angeles'); ?>