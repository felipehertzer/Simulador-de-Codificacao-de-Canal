<div class="page-header">
	<h1><?=$title;?></h1>
</div>
<?php
$form = new \Helpers\Form();
echo $form->open(array("action" => "resultado", "method" => "post"));
echo '<div class="form-group">';
echo $form->input(array("name"=>"binary", "placeholder" => "Digite o código binário", "class" => "form-control", "required" => true));
echo '</div><div class="form-group">';
echo $form->checkbox(array(
	0=>array('id'=>'0', 'name'=>'tipo[]', 'value'=>'0', 'label'=>'NRZ-L' ),
	1=>array('id'=>'1', 'name'=>'tipo[]', 'value'=>'1', 'label'=>'NRZI' ),
	2=>array('id'=>'2', 'name'=>'tipo[]', 'value'=>'2', 'label'=>'BIPOLAR-AMI' ),
	3=>array('id'=>'3', 'name'=>'tipo[]', 'value'=>'3', 'label'=>'PSEUDOTERNARY' ),
	4=>array('id'=>'4', 'name'=>'tipo[]', 'value'=>'4', 'label'=>'MANCHESTER' ),
	5=>array('id'=>'5', 'name'=>'tipo[]', 'value'=>'5', 'label'=>'DIFERENTIAL MANCHESTER')
	));
echo '</div>';
echo $form->submit(array("name" => "submit", "value" => "Gerar", "class" =>"btn btn-success"));
echo $form->close(); ?>
