<?php
if (!isConnect('admin')) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
$plugin = plugin::byId('virtual');
sendVarToJS('eqType', $plugin->getId());
$eqLogics = eqLogic::byType($plugin->getId());
?>
<style>
	div.callback span.encrypt {
		font-family: "text-security-disc" !important;
	}
</style>
<div class="row row-overflow">
	<div class="col-xs-12 eqLogicThumbnailDisplay">
		<legend><i class="fas fa-cog"></i> {{Gestion}}</legend>
		<div class="eqLogicThumbnailContainer">
			<div class="cursor eqLogicAction logoPrimary" data-action="add">
				<i class="fas fa-plus-circle"></i>
				<br>
				<span>{{Ajouter}}</span>
			</div>
			<div class="cursor logoSecondary" id="bt_createJeedomMonitor">
				<i class="fas fa-heartbeat"></i>
				<br>
				<span>{{Créer/Mettre à jour Jeedom monitor}}</span>
			</div>
		</div>
		<legend><i class="fas fa-clone"></i> {{Mes virtuels}}</legend>
		<?php
		if (count($eqLogics) == 0) {
			echo '<br><div class="text-center" style="font-size:1.2em;font-weight:bold;">{{Aucun équipement virtuel trouvé, cliquer sur "Ajouter" pour commencer}}</div>';
		} else {
			echo '<div class="input-group" style="margin:5px;">';
			echo '<input class="form-control roundedLeft" placeholder="{{Rechercher}}" id="in_searchEqlogic">';
			echo '<div class="input-group-btn">';
			echo '<a id="bt_resetSearch" class="btn" style="width:30px"><i class="fas fa-times"></i></a>';
			echo '<a class="btn roundedRight hidden" id="bt_pluginDisplayAsTable" data-coreSupport="1" data-state="0"><i class="fas fa-grip-lines"></i></a>';
			echo '</div>';
			echo '</div>';
			echo '<div class="eqLogicThumbnailContainer">';
			foreach ($eqLogics as $eqLogic) {
				$opacity = ($eqLogic->getIsEnable()) ? '' : 'disableCard';
				echo '<div class="eqLogicDisplayCard cursor ' . $opacity . '" data-eqLogic_id="' . $eqLogic->getId() . '">';
				$file = 'plugins/virtual/plugin_info/' . $eqLogic->getConfiguration('icon') . '.png';
				if (file_exists(__DIR__ . '/../../../../' . $file)) {
					echo '<img src="' . $file . '" height="105" width="95">';
				} else {
					echo '<img src="' . $plugin->getPathImgIcon() . '">';
				}
				echo '<br>';
				echo '<span class="name">' . $eqLogic->getHumanName(true, true) . '</span>';
				echo '<span class="hiddenAsCard displayTableRight hidden">';
				if ($eqLogic->getConfiguration('autorefresh', '') != '') {
					echo '<span class="label label-info">' . $eqLogic->getConfiguration('autorefresh') . '</span>';
				}
				echo ($eqLogic->getIsVisible() == 1) ? '<i class="fas fa-eye" title="{{Equipement visible}}"></i>' : '<i class="fas fa-eye-slash" title="{{Equipement non visible}}"></i>';
				echo '</span>';
				echo '</div>';
			}
			echo '</div>';
		}
		?>
	</div>

	<div class="col-xs-12 eqLogic" style="display:none;">
		<div class="input-group pull-right" style="display:inline-flex">
			<span class="input-group-btn">
				</a><a class="btn btn-primary btn-sm roundedLeft" id="bt_importTemplate"><i class="fas fa-cubes"></i><span class="hidden-xs"> {{Template}}</span>
				</a><a class="btn btn-default btn-sm" id="bt_importEqLogic"><i class="fas fa-share"></i><span class="hidden-xs"> {{Importer équipement}}</span>
				</a><a class="btn btn-default btn-sm" id="bt_eqLogicCmds"><i class="fas fa-share"></i><span class="hidden-xs"> {{Importer Commandes}}</span>
				</a><a class="btn btn-sm btn-default eqLogicAction" data-action="configure"><i class="fas fa-cogs"></i><span class="hidden-xs"> {{Configuration avancée}}</span>
				</a><a class="btn btn-sm btn-default eqLogicAction" data-action="copy"><i class="fas fa-copy"></i><span class="hidden-xs"> {{Dupliquer}}</span>
				</a><a class="btn btn-sm btn-success eqLogicAction" data-action="save"><i class="fas fa-check-circle"></i> {{Sauvegarder}}
				</a><a class="btn btn-danger btn-sm eqLogicAction roundedRight" data-action="remove"><i class="fas fa-minus-circle"></i> {{Supprimer}}</a>
			</span>
		</div>
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation"><a href="#" class="eqLogicAction" aria-controls="home" role="tab" data-toggle="tab" data-action="returnToThumbnailDisplay"><i class="fas fa-arrow-circle-left"></i></a></li>
			<li role="presentation" class="active"><a href="#eqlogictab" aria-controls="home" role="tab" data-toggle="tab"><i class="fas fa-tachometer-alt"></i> {{Equipement}}</a></li>
			<li role="presentation"><a href="#commandtab" aria-controls="profile" role="tab" data-toggle="tab"><i class="fas fa-list"></i> {{Commandes}}</a></li>
		</ul>
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="eqlogictab">
				<form class="form-horizontal">
					<fieldset>
						<div class="col-lg-6">
							<legend><i class="fas fa-wrench"></i> {{Paramètres généraux}}</legend>
							<div class="form-group">
								<label class="col-sm-4 control-label">{{Nom du virtuel}}</label>
								<div class="col-sm-6">
									<input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display:none;">
									<input type="text" class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom de l'équipement virtuel}}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">{{Objet parent}}</label>
								<div class="col-sm-6">
									<select class="form-control eqLogicAttr" data-l1key="object_id">
										<option value="">{{Aucun}}</option>
										<?php $options = '';
										foreach ((jeeObject::buildTree(null, false)) as $object) {
											$options .= '<option value="' . $object->getId() . '">' . str_repeat('&nbsp;&nbsp;', $object->getConfiguration('parentNumber')) . $object->getName() . '</option>';
										}
										echo $options;
										?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">{{Catégorie}}</label>
								<div class="col-sm-6">
									<?php foreach (jeedom::getConfiguration('eqLogic:category') as $key => $value) {
										echo '<label class="checkbox-inline">';
										echo '<input type="checkbox" class="eqLogicAttr" data-l1key="category" data-l2key="' . $key . '">' . $value['name'];
										echo '</label>';
									}	?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">{{Options}}</label>
								<div class="col-sm-6">
									<label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isEnable" checked />{{Activer}}</label>
									<label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isVisible" checked />{{Visible}}</label>
								</div>
							</div>

							<legend><i class="fas fa-cogs"></i> {{Paramètres spécifiques}}</legend>
							<div class="form-group">
								<label class="col-sm-4 control-label">{{Auto-actualisation}}
									<sup><i class="fas fa-question-circle tooltips" title="{{Fréquence de rafraîchissement des commandes infos de l'équipement}}"></i></sup>
								</label>
								<div class="col-sm-6">
									<div class="input-group">
										<input type="text" class="eqLogicAttr form-control roundedLeft" data-l1key="configuration" data-l2key="autorefresh" placeholder="{{Cliquer sur ? pour afficher l'assistant cron}}">
										<span class="input-group-btn">
											<a class="btn btn-default cursor jeeHelper roundedRight" data-helper="cron" title="Assistant cron">
												<i class="fas fa-question-circle"></i>
											</a>
										</span>
									</div>
								</div>
							</div>
						</div>

						<div class="col-lg-6">
							<legend><i class="fas fa-info"></i> {{Informations}}</legend>
							<div class="form-group">
								<label class="col-sm-4 control-label">{{Description du virtuel}}</label>
								<div class="col-sm-6">
									<textarea class="form-control eqLogicAttr autogrow" data-l1key="comment"></textarea>
								</div>
							</div>
							<legend><i class="fas fa-at"></i> {{URL de retour}}</legend>
							<div class="form-group">
								<div class="alert alert-info col-xs-10 col-xs-offset-1 text-center callback">
									<a class="btn btn-default btn-xs decrypt pull-right" data-plugin="virtual"><i class="fas fa-eye"></i></a>
									<?php echo '<span class="encrypt">' . network::getNetworkAccess('external') . '</span>/core/api/jeeApi.php?plugin=virtual&type=event&apikey=<span class="encrypt">' . jeedom::getApiKey($plugin->getId()) . '</span>&id=#cmd_id#&value=#value#';
									?>
								</div>
							</div>
						</div>
					</fieldset>
				</form>
				<hr>
			</div>

			<div role="tabpanel" class="tab-pane" id="commandtab">
				<div class="input-group pull-right" style="display:inline-flex;margin-top:5px;">
					<span class="input-group-btn">
						<a class="btn btn-info btn-xs roundedLeft" id="bt_addVirtualInfo"><i class="fas fa-plus-circle"></i> {{Ajouter une info virtuelle}}
						</a><a class="btn btn-warning btn-xs roundedRight" id="bt_addVirtualAction"><i class="fas fa-plus-circle"></i> {{Ajouter une action virtuelle}}</a>
					</span>
				</div>
				<br><br>
				<div class="table-responsive">
					<table id="table_cmd" class="table table-bordered table-condensed">
						<thead>
							<tr>
								<th class="hidden-xs" style="min-width:50px;width:70px;"> ID</th>
								<th style="min-width:120px;width:250px;">{{Nom}}</th>
								<th style="width:130px;">{{Type}}</th>
								<th style="min-width:180px;">{{Valeur}}</th>
								<th style="min-width:100px;width:200px;">{{Paramètres}}</th>
								<th>{{Etat}}</th>
								<th style="min-width:260px;width:310px;">{{Options}}</th>
								<th style="min-width:80px;width:140px;">{{Actions}}</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>

		</div>
	</div>
</div>
<?php
include_file('desktop', 'virtual', 'js', 'virtual');
include_file('core', 'plugin.template', 'js');
?>
