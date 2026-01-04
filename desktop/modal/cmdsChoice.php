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
sendVarToJS([
  'eqLogicId' => $eqLogicId,
  'idOriginal' => $idOriginal
]);
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
<table id="tableVirtual" class="table table-condensed">
	<thead>
		<tr>
			<th>{{Nom Commande}}</th>
			<th>{{Type}}</th>
			<th>{{Valeur}}</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
      <?php
      if (is_object(eqLogic::byId($eqLogicId))) {
        $cmds = cmd::byEqLogicId($eqLogicId);
        foreach($cmds as $cmd) {
          $cmdId = $cmd->getId();
          $cmdName = $cmd->getName();
          $cmdType = $cmd->getType();
          $cmdSubType = $cmd->getSubType();
          if ($cmdType == 'info') {
            $cmdValue = $cmd->execCmd();
          } else {
            $cmdValue = '';
          }
          $cmdIsVisible = $cmd->getIsVisible();
          $tr = '<tr>';
          $tr .= '<td><span class="label label-info"  style="font-size : 1em;cursor:default;">' .  $cmdName . ' </span></td>';
          $tr .= '<td><span class="' . ($cmdType == 'action' ? 'label label-warning' : 'label label-info') . '" style="font-size : 1em;cursor:default;">' . $cmdType . ' </span></td>';
          $tr .= '<td><span class="label label-info" style="font-size : 1em;cursor:default;">' .  $cmdValue . ' </span></td>';
          $tr .= '<td><input type="checkbox" class="checkContext ' . ($cmdType == 'action' ? 'checkAction' : 'checkInfos') . '"  data-idCmd="'.$cmdId.'" style="font-size: 1em; cursor: default;"></td>';
          $tr .= '</tr>';
          echo $tr;
        }
      }
      ?>
	</tbody>
</table>
<script>
  // DataTable
  new DataTable(document.getElementById('tableVirtual'), {
    columns: [
      { select: 0, sort: "asc" }
    ],
    searchable: true,
    paging: true,
    perPage: 30,
    perPageSelect: [10, 20, 30, 50, 100],
  })
  // ContextMenu
  var checkContextMenuCallback = function(_el) {
    _el.triggerEvent('change')
  }
  jeedomUtils.setCheckContextMenu(checkContextMenuCallback)
        
  function updateTableFilter(check) {
    document.querySelectorAll('#tableVirtual input[type="checkbox"].' + check).forEach(_checkbox => {
      if (!_checkbox.checked) {
        _checkbox.checked = true
      }
    })
  }

  document.getElementById('bt_selectAllInfos').addEventListener('click', function() {
    updateTableFilter('checkInfos');
  })
    
  document.getElementById('bt_selectAllActions').addEventListener('click', function() {
    updateTableFilter('checkAction');
  })
    
  document.getElementById('bt_validateObjectlist').addEventListener('click', function() {
    var checkedCheckboxes = [];
    document.querySelectorAll('#tableVirtual tbody input[type="checkbox"]:checked').forEach(function(_checkbox) {
      checkedCheckboxes.push(_checkbox.getAttribute('data-idCmd'));
    });
    if (checkedCheckboxes.length !== 0) {
      domUtils.ajax({
        type: "POST",
        url: "plugins/virtual/core/ajax/virtual.ajax.php",
        data: {
          action: "copyCmdsFromEqLogic",
          eqLogic_id: eqLogicId,
          id: idOriginal,
          cmdsSelected: checkedCheckboxes
        },
        dataType: "json",
        error: function (request, status, error) {
          domUtils.handleAjaxError(request, status, error)
        },
        success: function (data) {
          if (data.state != "ok") {
            jeedomUtils.showAlert({ message: data.result, level: "danger" })
            return
          }
          jeedomUtils.closeJeeDialogs()
          document.querySelector('.eqLogicDisplayCard[data-eqLogic_id="' + document.querySelector('#eqlogictab .eqLogicAttr[data-l1key=id]')?.jeeValue() + '"]')?.click()
        }
      })
    } else {
      jeedomUtils.showAlert({ message: '{{Aucune commande sélectionnée}}', level: "danger" })
    }
  });
</script>