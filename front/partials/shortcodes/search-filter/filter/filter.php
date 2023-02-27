<h3>Filter</h3>
<div id="date-range" class="search-section">
	<form>
		<h3>Search</h3>
		<div class="form-group">
			<label for="search_input">Search through the database</label>
			<input type="text" class="form-control" name="search_input" aria-describedby="search_input" value="<?php echo $_GET['search_input'];?>"/>
		</div>

		<h4>By Bid Date</h4>
		
		<div class="form-group">
			<label for="from_date">From</label>
			<input type="date" class="form-control" name="from_date" id="from_date" aria-describedby="from_date" value="<?php echo $_GET['from_date']; ?>"/>
			<small id="from_date" class="form-text text-muted">Enter the FROM Bid Date to filter.</small>
		</div>
		<div class="form-group">
			<label for="to_date">To</label>
			<input type="date" class="form-control" name="to_date" id="to_date" aria-describedby="to_date" value="<?php echo $_GET['to_date']; ?>"/>
			<small id="to_date" class="form-text text-muted">Enter the TO Bid Date to filter.</small>
		</div>


		<hr>
		<h4>By City</h4>
		<div class="form-group">
			<select class="custom-select" id="" name="city_of_project">
				<option value="">Select City</option>
				<?php
				$cities = get_terms( array(
					'taxonomy'   => 'city',
					'orderby'    => 'name',
					'order'      => 'ASC',
					'hide_empty' => false,
				) );
				foreach ( $cities as $city ) {
					?>
					<option value="<?php echo $city->term_id; ?>" <?php selected( $_GET['city_of_project'], $city->term_id ); ?>><?php echo $city->name; ?></option>
					<?php
				}
				?>
			</select>
			<div class="invalid-feedback">Select City Please*</div>
		</div>

		<hr>
		<h4>By CSI Division</h4>
		<?php
		global $csi_divisions;
		?>
		<div class="form-group cs-division-verticle">
			<?php
			//foreach ( $csi_divisions as $key => $div ) {
				$csidivion_terms = get_terms( array(
					'taxonomy'   => 'csidiv',
					'orderby'    => 'DATE',
					'order'      => 'ASC',
					'hide_empty' => false,
				) );
				foreach ( $csidivion_terms as $csi ) {
				?>
				<div class="checkbox">
					<input
						type="checkbox"
						class="checkbox csi_division"
						id="<?php echo $csi->term_id; ?>"
						name="csi_division[]"
						value="<?php echo $csi->term_id; ?>" 
						 <?php if(isset($_GET['csi_division'])) { echo (in_array($csi->term_id , $_GET['csi_division'])) ? 'checked' : '' ; } ?>/>
					<label for="<?php echo $csi->name; ?>"><?php echo $csi->name; ?></label>
				</div>
				<?php
			}
			?>
		</div>
		<hr>
		<div class="form-group">
			<h5 class="active_list_title">Active Postings</h5>
			<input type="checkbox"
			 class="form-control"
			 id="active_checkbox" name="active_postings" value="active_postings" aria-describedby="active_postings"
			 <?php echo ('active_postings' == $_GET['active_postings']) ? 'checked' : '' ; ?> />
			<small id="active_postings" class="form-text text-muted">Enter the date for active postings filter.</small>
		</div>
		<div class="form-group">
			<input type="submit"class="btn btn-primary" value="Filter Records">
			<a href="<?php echo get_site_url().'/search-postings';?>" class="btn btn-warning" style="background-color:#5f8fc4 !important;color:#fff;" >Clear Filters</a> 
		</div>
	</form>
</div>

<div class="search-footer" style="display:none;">
	<a id="filter" class="btn btn-primary">Apply Filter</a>
	<a id="reset" style="background-color:#5f8fc4 !important;color:#fff;"  class="btn btn-secondary">Reset</a>
</div>

