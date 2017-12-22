<div class="page-header">
	<h1><?=$title;?></h1>
</div>
<script type="text/javascript">
	window.onload = function() {
		CanvasJS.addColorSet("greenShades",
		[//colorSet Array

			"#FF0000",
			"#008080",
			"#2E8B57",
			"#3CB371",
			"#90EE90"
		]);
		<?php foreach($data['resultado']['nome'] as $key => $result){ ?>
			$("#chartContainer_<?php echo $key; ?>").CanvasJSChart({
				title: {
					text: "<?php echo $result; ?>"
				},
				colorSet: "greenShades",
				theme: "theme2",
				exportEnabled: true,
				data: [
					{
						indexLabelLineThickness: 6,
						type: "stepLine",
						toolTipContent: "{x}: {y}",
						markerSize: 2,
						dataPoints: [
							<?php foreach($data['resultado']['retorno'][$key] as $k => $r){ ?>
							{x: <?php echo $k; ?>, y: <?php echo $r; ?>},
							<?php } ?>
						]
					}
				]
			});
		<?php } ?>
	}
</script>
<?php foreach($data['resultado']['nome'] as $key => $result){ ?>
<div id="chartContainer_<?php echo $key; ?>" style="width: 100%; height: 300px"></div>
<?php } ?>