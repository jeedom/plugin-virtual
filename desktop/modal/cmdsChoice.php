<?php

/* This file is part of Jeedom.
*
* Jeedom is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* Jeedom is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
*/

if (!isConnect('admin')) {
    throw new Exception('{{401 - Accès non autorisé}}');
}
$plugin = plugin::byId('virtual');
$eqLogicId = init('eqLogic'); 
$idOriginal = init('idOriginal');  
?>
<span class='pull-right'>
	<a class="btn btn-default pull-left" id="bt_selectAllInfos">{{Selectionner Commandes Infos}}</a>
</span>
<span class='pull-right'>
	<a class="btn btn-default pull-left" id="bt_selectAllActions">{{Selectionner Commandes Action}}</a>
</span>
<span class='pull-right'>
	<a class="btn btn-success pull-right" id="bt_validateObjectlist"><i class="fas fa-check-circle"></i> {{Valider}}</a>
</span>
<br/><br/>
<div id='div_Alert' style="display: none;"></div>
<table id="tableVirtual" data-toggle="table" data-height="600" data-pagination="true" data-search="true">
	<thead>
    <tr>
      <th data-field="nomobjet">{{Nom Commande}}</th>
      <th data-field="typeobjet">{{Type}}</th>
      <th data-field="value">{{Valeur}}</th>
      <th></th>
    </tr>
	</thead>
<tbody>
  <?php
  if(is_object(eqLogic::byId($eqLogicId))){
    $cmds = cmd::byEqLogicId($eqLogicId);
    foreach($cmds as $cmd){
      $cmdId = $cmd->getId();
      $cmdName = $cmd->getName();
      $cmdType = $cmd->getType();
      $cmdSubType = $cmd->getSubType();
      if($cmdType == 'info'){
        $cmdValue = $cmd->execCmd();
      }else{
        $cmdValue = '';
      }
      $cmdIsVisible = $cmd->getIsVisible();
      echo '<tr><td><span class="label label-info"  style="font-size : 1em;cursor:default;">' .  $cmdName . ' </span></td>';
      echo '<td><span class="' . ($cmdType == 'action' ? 'label label-warning' : 'label label-info') . '" style="font-size : 1em;cursor:default;">' . $cmdType . ' </span></td>';
      echo '<td><span class="label label-info" style="font-size : 1em;cursor:default;">' .  $cmdValue . ' </span></td>';
      echo '<td><input type="checkbox" class="' . ($cmdType == 'action' ? 'checkAction' : 'checkInfos') . '"  data-idCmd="'.$cmdId.'" style="font-size: 1em; cursor: default;"></td></tr>';
    }
  }
  ?>
</tbody>

<script>
  function updateTableFilter(check) {
    var searchText = $('.search-input').val().toLowerCase();
    $('#tableVirtual tbody tr').each(function() {
      var $row = $(this);
      var $nomobjet = $row.find('td:eq(0)').text().toLowerCase();
      var $checkbox = $row.find('input[type="checkbox"].' + check);
      if ($nomobjet.includes(searchText)) {
        if( $checkbox.prop('checked')){
              $checkbox.not(this).prop('checked', false);
            }else{
              $checkbox.not(this).prop('checked', true);
            }
        
      } else {
        $checkbox.not(this).prop('checked', false);
      }
    });
  }

 $('#bt_selectAllInfos').on('click',function(){
      updateTableFilter('checkInfos');
});

$('#bt_selectAllActions').on('click',function(){
      updateTableFilter('checkAction');
});

document.getElementById('bt_validateObjectlist').addEventListener('click', function() {
  var checkedCheckboxes = [];
  var eqLogicid = <?= $eqLogicId; ?>;
  var idOriginal = <?= $idOriginal; ?>;
  var checkboxes = document.querySelectorAll('#tableVirtual tbody input[type="checkbox"]:checked');
  checkboxes.forEach(function(checkbox) {
    checkedCheckboxes.push(checkbox.getAttribute('data-idCmd'));
  });
  if(checkedCheckboxes.length !== 0){
      $.ajax({
      type: "POST",
      url: "plugins/virtual/core/ajax/virtual.ajax.php",
      data: {
        action: "copyCmdsFromEqLogic",
        eqLogic_id: eqLogicid,
        id: idOriginal,
        cmdsSelected: checkedCheckboxes
      },
      dataType: 'json',
      global: false,
      error: function(error) {
        $('#div_alert').showAlert({ message: error.message, level: 'danger' })
      },
      success: function(data) {
        if (data.state != 'ok') {
          $('#div_alert').showAlert({ message: data.result, level: 'danger' })
          return
        }
        $('#md_modal').load('index.php?v=d&plugin=virtual&modal=cmdsChoice&eqLogic='+eqLogicid+'&idOriginal='+idOriginal).dialog('close');
        $('.eqLogicDisplayCard[data-eqLogic_id=' + idOriginal + ']').click()

      }
    })
  }else{
    $('#div_Alert').showAlert({ message: 'Aucune commande sélectionnée', level: 'danger' })
  }
});
</script>
<?php include_file('desktop', 'boot_table', 'css', 'virtual');?>
<?php include_file('desktop', 'boot_table', 'js', 'virtual');?>
<?php include_file('desktop', 'virtual', 'js', 'virtual');?>