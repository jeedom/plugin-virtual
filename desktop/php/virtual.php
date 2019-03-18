<?php
if (!isConnect('admin')) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
$plugin = plugin::byId('virtual');
sendVarToJS('eqType', $plugin->getId());
$eqLogics = eqLogic::byType($plugin->getId());
?>

<div class="row row-overflow">
	<div class="col-xs-12 eqLogicThumbnailDisplay" style="padding-left: 25px;">
		<legend><i class="icon loisir-two28"></i> {{Gestion}}</legend>
		<div class="eqLogicThumbnailContainer">
			<div class="cursor eqLogicAction" data-action="add" style="text-align: center; background-color : #ffffff; height : 120px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >
				<i class="fa fa-plus-circle" style="font-size : 6em;color:#94ca02;"></i>
				<br>
				<span style="font-size : 1.1em;position:relative; top : 23px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#94ca02">{{Ajouter}}</span>
			</div>
		</div>
		<legend><i class="fa fa-table"></i> {{Mes virtuels}}</legend>
		<input class="form-control" placeholder="{{Rechercher}}" style="margin-bottom:4px;" id="in_searchEqlogic" />
		<div class="eqLogicThumbnailContainer">
			<?php
			foreach ($eqLogics as $eqLogic) {
				$opacity = ($eqLogic->getIsEnable()) ? '' : jeedom::getConfiguration('eqLogic:style:noactive');
				echo '<div class="eqLogicDisplayCard cursor" data-eqLogic_id="' . $eqLogic->getId() . '" style="text-align: center; background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;' . $opacity . '" >';
				echo '<img src="' . $plugin->getPathImgIcon() . '" height="105" width="95" />';
				echo "<br>";
				echo '<span class="name" style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;">' . $eqLogic->getHumanName(true, true) . '</span>';
				echo '</div>';
			}
			?>
		</div>
	</div>
	
	<div class="col-xs-12 eqLogic" style="padding-left: 25px;display: none;">
		<div class="input-group pull-right" style="display:inline-flex">
			<span class="input-group-btn">
				<a class="btn btn-primary btn-sm bt_showExpressionTest roundedLeft"><i class="fa fa-check"></i> {{Expression}}</a><a class="btn btn-default btn-sm" id="bt_importEqLogic"><i class="fa fa-share"></i> {{Importer équipement}}</a><a class="btn btn-default btn-sm eqLogicAction" data-action="configure"><i class="fa fa-cogs"></i> {{Configuration avancée}}</a><a class="btn btn-default btn-sm eqLogicAction" data-action="copy"><i class="fa fa-copy"></i> {{Dupliquer}}</a><a class="btn btn-sm btn-success eqLogicAction" data-action="save"><i class="fa fa-check-circle"></i> {{Sauvegarder}}</a><a class="btn btn-danger btn-sm eqLogicAction roundedRight" data-action="remove"><i class="fa fa-minus-circle"></i> {{Supprimer}}</a>
			</span>
		</div>
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation"><a href="#" class="eqLogicAction" aria-controls="home" role="tab" data-toggle="tab" data-action="returnToThumbnailDisplay"><i class="fa fa-arrow-circle-left"></i></a></li>
			<li role="presentation" class="active"><a href="#eqlogictab" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-tachometer"></i> {{Equipement}}</a></li>
			<li role="presentation"><a href="#commandtab" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-list-alt"></i> {{Commandes}}</a></li>
		</ul>
		<div class="tab-content" style="height:calc(100% - 50px);overflow:auto;overflow-x: hidden;">
			<div role="tabpanel" class="tab-pane active" id="eqlogictab">
				<br/>
				<form class="form-horizontal">
					<fieldset>
						<div class="form-group">
							<label class="col-sm-2 control-label">{{Nom de l'équipement virtual}}</label>
							<div class="col-sm-3">
								<input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display : none;" />
								<input type="text" class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom de l'équipement virtuel}}"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" >{{Objet parent}}</label>
							<div class="col-sm-3">
								<select class="form-control eqLogicAttr" data-l1key="object_id">
									<option value="">{{Aucun}}</option>
									<?php
									foreach (object::all() as $object) {
										echo '<option value="' . $object->getId() . '">' . $object->getName() . '</option>';
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">{{Catégorie}}</label>
							<div class="col-sm-8">
								<?php
								foreach (jeedom::getConfiguration('eqLogic:category') as $key => $value) {
									echo '<label class="checkbox-inline">';
									echo '<input type="checkbox" class="eqLogicAttr" data-l1key="category" data-l2key="' . $key . '" />' . $value['name'];
									echo '</label>';
								}
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label"></label>
							<div class="col-sm-9">
								<label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isEnable" checked/>{{Activer}}</label>
								<label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isVisible" checked/>{{Visible}}</label>
							</div>
						</div>
						<div class="form-group expertModeVisible">
							<label class="col-sm-2 control-label">{{Auto-actualisation (cron)}}</label>
							<div class="col-sm-2">
								<input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="autorefresh" placeholder="{{Auto-actualisation (cron)}}"/>
							</div>
							<div class="col-sm-1">
								<i class="fa fa-question-circle cursor floatright" id="bt_cronGenerator"></i>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">{{URL de retour}}</label>
							<div class="col-sm-9 callback">
								<span>
									<?php
									echo network::getNetworkAccess('external') . '/core/api/jeeApi.php?plugin=virtual&apikey=' . jeedom::getApiKey($plugin->getId()) . '&type=virtual&id=#cmd_id#&value=#value#';
									?>
								</span>
							</div>
						</div>
					</fieldset>
				</form>
				
			</div>
			<div role="tabpanel" class="tab-pane" id="commandtab">
				<a class="btn btn-default btn-sm pull-right" id="bt_addVirtualInfo" style="margin-top:5px;"><i class="fa fa-plus-circle"></i> {{Ajouter une info virtuelle}}</a>
				<a class="btn btn-default btn-sm  pull-right" id="bt_addVirtualAction" style="margin-top:5px;"><i class="fa fa-plus-circle"></i> {{Ajouter une commande virtuelle}}</a><br/><br/>
				<table id="table_cmd" class="table table-bordered table-condensed">
					<thead>
						<tr>
							<th style="width: 50px;">#</th>
							<th style="width: 230px;">{{Nom}}</th>
							<th style="width: 110px;">{{Sous-Type}}</th>
							<th>{{Valeur}}</th>
							<th style="width: 100px;">{{Unité}}</th>
							<th style="width: 200px;">{{Paramètres}}</th>
							<th style="width: 100px;"></th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
				
			</div>
		</div>
		
	</div>
</div>

<?php include_file('desktop', 'virtual', 'js', 'virtual');?>
<?php include_file('core', 'plugin.template', 'js');?>
