<!--  content -->

				<div class="col-md-10" >
					<div class="panel panel-primary" style="margin:2% 0% 1% 0%;">
	  					<div class="panel-heading">
	    					<h3 class="panel-title"> เตือน </h3>
	  					</div>
	  					<div class="panel-body"></br>
	  						<p style="text-align:center;font-size:20px;"><?php echo $data;?></p>
	  						<input type="hidden" name="url" value="<?php echo base_url();?>">
	  						<input type="hidden" name="privileges" value="<?php echo $this->session->userdata("sess_type")?>">
	  						<input type="hidden" name="" value="<?php echo $this->session->userdata("sess_id")?>">
	  					</div>
					</div>
				</div>
			<!--  end content -->
			</div>
		</div>
