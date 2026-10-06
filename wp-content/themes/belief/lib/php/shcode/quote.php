<?php 
	$quote_style =array('none','boxed');
	$quote_float =array('none','left','right');
?>

<table class="sh_code_tbl">
	<tr>
		<td class="label_td fl_r">
			<label>Quote:</label>
		</td>
		<td>
			<textarea id="quote_content" cols="50" rows="7"></textarea>
		</td>
		<td rowspan="4" style="padding-left:20px;">
			<label>Preview</label>
			<div id="quote_demo">
				<div class="cosmo-blockquote">
					<p>Pellentesque risus diam vestibulum phasellus.</p>
					<span class="quote_source">John Doe</span>
				</div>
			</div>
		</td>
	</tr>
	<tr>	
		<td class="label_td fl_r">
			<label>Source:</label>	
		</td>
		<td>
			<input type="text" id="quote_source">
		</td>
	</tr>
	<tr>	
		<td class="label_td fl_r">
			<label>Style:</label>	
		</td>
		<td>
			<select id="quote_style" class="select_medium">
				<?php 
					foreach ($quote_style as $style) {
						echo "<option value='$style'>".$style."</option>";
					}
				?>
			</select>
		</td>
	</tr>
	<tr>	
		<td class="label_td fl_r">
			<label>Float:</label>	
		</td>
		<td>
			<select id="quote_float" class="select_medium">
				<?php 
					foreach ($quote_float as $float) {
						echo "<option value='$float'>".$float."</option>";
					}
				?>
			</select>
		</td>
	</tr>
	
</table>
<div>
	<a href="javascript:void(0);" onclick="resetQuoteSettings();" class="button">Reset</a>
	<input type="button" class="button-primary" value='Insert' id='insert_quote_btn' onclick='insertQuote()'>
</div>	