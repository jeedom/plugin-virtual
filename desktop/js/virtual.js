
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

document.getElementById('bt_createJeedomMonitor').addEventListener('click', function() {
  domUtils.ajax({
    type: "POST",
    url: "plugins/virtual/core/ajax/virtual.ajax.php",
    data: {
      action: "createJeedomMonitor",
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
      window.location.reload()
    }
  })
})

document.getElementById('bt_importTemplate').addEventListener('click', function() {
  domUtils.ajax({
    type: "POST",
    url: "plugins/virtual/core/ajax/virtual.ajax.php",
    data: {
      action: "getTemplateList",
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
      var inputOptions = []
      for (var i in data.result) {
        inputOptions.push({
          text: data.result[i].name,
          value: i
        })
      }
      jeeDialog.prompt({
        title: "{{Choisir un template (Attention : les commandes existantes seront écrasées).}}",
        inputType: 'select',
        inputOptions: inputOptions,
        callback: function(result) {
          domUtils.ajax({
            type: "POST",
            url: "plugins/virtual/core/ajax/virtual.ajax.php",
            data: {
              action: "applyTemplate",
              id: document.querySelector('#eqlogictab .eqLogicAttr[data-l1key=id]').jeeValue(),
              name: result
            },
            dataType: "json",
            error: function (request, status, error) {
              domUtils.handleAjaxError(request, status, error)
            },
            success: function (data) {
              document.querySelector('.eqLogicDisplayCard[data-eqLogic_id="' + document.querySelector('#eqlogictab .eqLogicAttr[data-l1key=id]')?.jeeValue() + '"]')?.click()
            }
          })
        }
      })
    }
  })
})

document.getElementById('bt_importEqLogic').addEventListener('click', function() {
  jeedom.eqLogic.getSelectModal({}, function(result) {
    domUtils.ajax({
      type: "POST",
      url: "plugins/virtual/core/ajax/virtual.ajax.php",
      data: {
        action: "copyFromEqLogic",
        eqLogic_id: result.id,
        id: document.querySelector('#eqlogictab .eqLogicAttr[data-l1key=id]').jeeValue(),
      },
      dataType: "json",
      global: false,
      error: function (request, status, error) {
       domUtils.handleAjaxError(request, status, error)
      },
      success: function (data) {
        if (data.state != 'ok') {
          jeedomUtils.showAlert({ message: data.result, level: "danger" })
          return
        }
        document.querySelector('.eqLogicDisplayCard[data-eqLogic_id="' + document.querySelector('#eqlogictab .eqLogicAttr[data-l1key=id]')?.jeeValue() + '"]')?.click()
      }
    })
  })
})

document.getElementById('bt_eqLogicCmds').addEventListener('click', function() {
  let idOriginal =  document.querySelector('#eqlogictab .eqLogicAttr[data-l1key=id]')?.jeeValue()
  jeedom.eqLogic.getSelectModal({}, function(result) {
    jeeDialog.dialog({
      title: "{{Tableaux Commandes}}",
      contentUrl: 'index.php?v=d&plugin=virtual&modal=cmdsChoice&eqLogic=' + result.id + '&idOriginal=' + idOriginal
    })
  })
})

document.getElementById('bt_addVirtualInfo').addEventListener('click', function() {
  addCmdToTable({ type: 'info' })
  modifyWithoutSave = true
})

document.getElementById('bt_addVirtualAction').addEventListener('click', function() {
  addCmdToTable({ type: 'action' })
  modifyWithoutSave = true
})

document.querySelector('div.callback a.decrypt').addEventListener('click', function() {
  this.parentNode.querySelectorAll('span').forEach(function(e) {
    e.classList.toggle('encrypt')
  })
  this.querySelector('i').classList.toggle('fa-eye-slash')
})

document.querySelector('#table_cmd').addEventListener('click', function(event) {
  var _target = null
  if (_target = event.target.closest('.listEquipementInfo')) {
    let calcul = _target.closest('tr').querySelector('.cmdAttr[data-l1key=configuration][data-l2key=' + _target.getAttribute('data-input') + ']')
    jeedom.cmd.getSelectModal({ cmd: { type: 'info' } }, function(result) {
        calcul.jeeValue(result.human)
    })
    return
  }
  if (_target = event.target.closest('.listEquipementAction')) {
    let subtype = _target.closest('.cmd').querySelector('.cmdAttr[data-l1key=subType]').jeeValue()
    let calcul = _target.closest('tr').querySelector('.cmdAttr[data-l1key=configuration][data-l2key=' + _target.getAttribute('data-input') + ']')
    jeedom.cmd.getSelectModal({ cmd: { type: 'action', subType: subtype } }, function(result) {
      calcul.jeeValue(result.human)
    })
    return
  }
})

function addCmdToTable(_cmd) {
  if (document.getElementById('table_cmd') == null) return
  if (!isset(_cmd)) {
    var _cmd = { configuration: {} }
  }
  if (!isset(_cmd.configuration)) {
    _cmd.configuration = {}
  }
  if (init(_cmd.logicalId) == 'refresh') {
    return
  }

  if (init(_cmd.type) == 'info') {
    var tr = '<td class="hidden-xs">'
    tr += '<span class="cmdAttr" data-l1key="id"></span>'
    tr += '</td>'
    tr += '<td>'
    tr += '<div class="input-group">'
    tr += '<input class="cmdAttr form-control input-sm roundedLeft" data-l1key="name" placeholder="{{Nom de la commande}}">'
    tr += '<span class="input-group-btn">'
    tr += '<a class="cmdAction btn btn-sm btn-default" data-l1key="chooseIcon" title="{{Choisir une icône}}"><i class="fas fa-icons"></i></a>'
    tr += '</span>'
    tr += '<span class="cmdAttr input-group-addon roundedRight" data-l1key="display" data-l2key="icon" style="font-size:19px;padding:0 5px 0 0!important;"></span>'
    tr += '</div>'
    tr += '</td>'
    tr += '<td>'
    tr += '<input class="cmdAttr form-control type input-sm" data-l1key="type" value="info" disabled style="margin-bottom:5px;">'
    tr += '<span class="subType" subType="' + init(_cmd.subType) + '"></span>'
    tr += '</td>'
    tr += '<td>'
    if (init(_cmd.configuration.virtualAction) != '1') {
      tr += '<textarea class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="calcul" style="height:35px;" placeholder="{{Calcul}}"></textarea>'
      tr += '<a class="btn btn-default listEquipementInfo btn-xs" data-input="calcul" style="width:100%;margin-top:2px;"><i class="fas fa-list-alt"></i> {{Rechercher équipement}}</a>'
    }
    tr += '</td>'
    tr += '<td>'
    tr += '<input class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="returnStateValue" placeholder="{{Valeur retour d\'état}}" style="margin-bottom:5px;">'
    tr += '<input class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="returnStateTime" placeholder="{{Durée avant retour d\'état (min)}}">'
    tr += '<select class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="updateCmdId" style="display:none;" title="{{Commande d\'information à mettre à jour}}">'
    tr += '<option value="">{{Aucune}}</option>'
    tr += '</select>'
    tr += '</td>'
    tr += '<td>'
    tr += '<span class="cmdAttr" data-l1key="htmlstate"></span>'
    tr += '</td>'
    tr += '<td>'
    tr += '<label class="checkbox-inline"><input type="checkbox" class="cmdAttr" data-l1key="isVisible" checked/>{{Afficher}}</label> '
    tr += '<label class="checkbox-inline"><input type="checkbox" class="cmdAttr" data-l1key="isHistorized" checked/>{{Historiser}}</label> '
    tr += '<label class="checkbox-inline"><input type="checkbox" class="cmdAttr" data-l1key="display" data-l2key="invertBinary"/>{{Inverser}}</label> '
    tr += '<div style="margin-top:7px;">'
    tr += '<input class="tooltips cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="minValue" placeholder="{{Min}}" title="{{Min}}" style="width:30%;max-width:80px;display:inline-block;margin-right:2px;">'
    tr += '<input class="tooltips cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="maxValue" placeholder="{{Max}}" title="{{Max}}" style="width:30%;max-width:80px;display:inline-block;margin-right:2px;">'
    tr += '<input class="tooltips cmdAttr form-control input-sm" data-l1key="unite" placeholder="{{Unité}}" title="{{Unité}}" style="width:30%;max-width:80px;display:inline-block;margin-right:2px;">'
    tr += '</div>'
    tr += '</td>'
    tr += '<td>'
    if (is_numeric(_cmd.id)) {
      tr += '<a class="btn btn-default btn-xs cmdAction" data-action="configure"><i class="fas fa-cogs"></i></a> '
      tr += '<a class="btn btn-default btn-xs cmdAction" data-action="test"><i class="fas fa-rss"></i> {{Tester}}</a>'
    }
    tr += '<i class="fas fa-minus-circle pull-right cmdAction cursor" data-action="remove"></i></td>'
    //tr += '</tr>'
    
    let newRow = document.createElement('tr')
    newRow.innerHTML = tr
    newRow.addClass('cmd')
    newRow.setAttribute('data-cmd_id', init(_cmd.id))
    newRow.setAttribute('virtualAction', init(_cmd.configuration.virtualAction))
    document.getElementById('table_cmd').querySelector('tbody').appendChild(newRow)
    newRow.setJeeValues(_cmd, '.cmdAttr')
    jeedom.cmd.changeType(newRow, init(_cmd.subType))
  }

  if (init(_cmd.type) == 'action') {
    var tr = '<td class="hidden-xs">'
    tr += '<span class="cmdAttr" data-l1key="id"></span>'
    tr += '</td>'
    tr += '<td>'
    tr += '<div class="input-group">'
    tr += '<input class="cmdAttr form-control input-sm roundedLeft" data-l1key="name" placeholder="{{Nom de la commande}}">'
    tr += '<span class="input-group-btn">'
    tr += '<a class="cmdAction btn btn-sm btn-default" data-l1key="chooseIcon" title="{{Choisir une icône}}"><i class="fas fa-icons"></i></a>'
    tr += '</span>'
    tr += '<span class="cmdAttr input-group-addon roundedRight" data-l1key="display" data-l2key="icon" style="font-size:19px;padding:0 5px 0 0!important;"></span>'
    tr += '</div>'
    tr += '<select class="cmdAttr form-control input-sm" data-l1key="value" style="display:none;margin-top:5px;" title="{{Commande information liée}}">'
    tr += '<option value="">{{Aucune}}</option>'
    tr += '</select>'
    tr += '</td>'
    tr += '<td>'
    tr += '<input class="cmdAttr form-control type input-sm" data-l1key="type" value="action" disabled style="margin-bottom:5px;" />'
    tr += '<span class="subType" subType="' + init(_cmd.subType) + '"></span>'
    tr += '<input class="cmdAttr" data-l1key="configuration" data-l2key="virtualAction" value="1" style="display:none;" />'
    tr += '</td>'
    tr += '<td>'
    tr += '<div class="input-group" style="margin-bottom:5px;">'
    tr += '<input class="cmdAttr form-control input-sm roundedLeft" data-l1key="configuration" data-l2key="infoName" placeholder="{{Nom information}}"/>'
    tr += '<span class="input-group-btn">'
    tr += '<a class="btn btn-default btn-sm listEquipementAction roundedRight" data-input="infoName"><i class="fas fa-list-alt"></i></a>'
    tr += '</span>'
    tr += '</div>'
    tr += '<div class="input-group">'
    tr += '<input class="cmdAttr form-control input-sm roundedLeft" data-l1key="configuration" data-l2key="value" placeholder="{{Valeur}}" />'
    tr += '<span class="input-group-btn">'
    tr += '<a class="btn btn-default btn-sm listEquipementInfo roundedRight" data-input="value"><i class="fas fa-list-alt"></i></a>'
    tr += '</span>'
    tr += '</div>'
    tr += '</td>'
    tr += '<td>'
    tr += '<select class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="updateCmdId" style="margin-bottom:5px;" title="{{Commande information à mettre à jour}}">'
    tr += '<option value="">{{Aucune}}</option>'
    tr += '</select>'
    tr += '<input class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="updateCmdToValue" placeholder="{{Valeur de l\'information}}" style="display:none;">'
    tr += '</td>'
    tr += '<td>'
    tr += '</td>'
    tr += '<td>'
    tr += '<label class="checkbox-inline"><input type="checkbox" class="cmdAttr" data-l1key="isVisible" checked/>{{Afficher}}</label> '
    tr += '<div style="margin-top:7px;">'
    tr += '<input class="tooltips cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="minValue" placeholder="{{Min}}" title="{{Min}}" style="width:30%;max-width:80px;display:inline-block;margin-right:2px;">'
    tr += '<input class="tooltips cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="maxValue" placeholder="{{Max}}" title="{{Max}}" style="width:30%;max-width:80px;display:inline-block;">'
    tr += '<input class="tooltips cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="listValue" placeholder="{{Liste : valeur|texte (séparées par un point-virgule)}}" title="{{Liste : valeur|texte}}">'
    tr += '</div>'
    tr += '</td>'
    tr += '<td>'
    if (is_numeric(_cmd.id)) {
      tr += '<a class="btn btn-default btn-xs cmdAction" data-action="configure"><i class="fas fa-cogs"></i></a> '
      if (init(_cmd.type) == 'action') {
        tr += '<a class="btn btn-default btn-xs cmdAction" data-action="test"><i class="fas fa-rss"></i> {{Tester}}</a>'
      }
    }
    tr += '<i class="fas fa-minus-circle pull-right cmdAction cursor" data-action="remove"></i></td>'
    
    let newRow = document.createElement('tr')
    newRow.innerHTML = tr
    newRow.addClass('cmd')
    newRow.setAttribute('data-cmd_id', init(_cmd.id))
    document.getElementById('table_cmd').querySelector('tbody').appendChild(newRow)
    jeedom.eqLogic.buildSelectCmd({
      id: document.querySelector('.eqLogicAttr[data-l1key="id"]').jeeValue(),
      filter: { type: 'info' },
      error: function(error) {
        jeedomUtils.showAlert({ message: error.message, level: 'danger' })
      },
      success: function(result) {
        newRow.querySelector('.cmdAttr[data-l1key=value]').innerHTML = '<option value="">{{Aucune}}</option>' + result
        newRow.querySelector('.cmdAttr[data-l1key=configuration][data-l2key=updateCmdId]').innerHTML = '<option value="">{{Aucune}}</option>' + result
        newRow.setJeeValues(_cmd, '.cmdAttr')
        jeedom.cmd.changeType(newRow, init(_cmd.subType))
      }
    })
  }
}
