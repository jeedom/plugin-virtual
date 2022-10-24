
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

$('#bt_importTemplate').off('click').on('click', function () {
  $.ajax({
    type: "POST",
    url: "plugins/virtual/core/ajax/virtual.ajax.php",
    data: {
      action: "getTemplateList",
    },
    dataType: 'json',
    error: function (request, status, error) {
      handleAjaxError(request, status, error);
    },
    success: function (data) {
      var inputOptions = [];
      for (var i in data.result) {
        inputOptions.push({
          text: data.result[i].name,
          value: i
        })
      }
      bootbox.prompt({
        title: "{{Choisir un template (Attention : les commandes existantes seront écrasées).}}",
        inputType: 'select',
        inputOptions: inputOptions,
        callback: function (result) {
          $.ajax({
            type: "POST",
            url: "plugins/virtual/core/ajax/virtual.ajax.php",
            data: {
              action: "applyTemplate",
              id: $('.eqLogicAttr[data-l1key=id]').value(),
              name: result
            },
            dataType: 'json',
            error: function (request, status, error) {
              handleAjaxError(request, status, error)
            },
            success: function (data) {
              $('.eqLogicDisplayCard[data-eqLogic_id=' + $('.eqLogicAttr[data-l1key=id]').value() + ']').click()
            }
          })
        }
      })
    }
  })
})

$('#bt_importEqLogic').off('click').on('click', function () {
  jeedom.eqLogic.getSelectModal({}, function (result) {
    $.ajax({
      type: "POST",
      url: "plugins/virtual/core/ajax/virtual.ajax.php",
      data: {
        action: "copyFromEqLogic",
        eqLogic_id: result.id,
        id: $('.eqLogicAttr[data-l1key=id]').value()
      },
      dataType: 'json',
      global: false,
      error: function (request, status, error) {
        handleAjaxError(request, status, error)
      },
      success: function (data) {
        if (data.state != 'ok') {
          $('#div_alert').showAlert({ message: data.result, level: 'danger' })
          return
        }
        $('.eqLogicDisplayCard[data-eqLogic_id=' + $('.eqLogicAttr[data-l1key=id]').value() + ']').click()
      }
    })
  })
})

$("#bt_addVirtualInfo").on('click', function (event) {
  addCmdToTable({ type: 'info' })
  modifyWithoutSave = true
})

$("#bt_addVirtualAction").on('click', function (event) {
  addCmdToTable({ type: 'action' })
  modifyWithoutSave = true
})

$('#bt_showExpressionTest').off('click').on('click', function () {
  $('#md_modal').dialog({ title: "{{Testeur d'expression}}" })
  $("#md_modal").load('index.php?v=d&modal=expression.test').dialog('open')
})

$("#table_cmd").delegate(".listEquipementInfo", 'click', function () {
  var el = $(this)
  jeedom.cmd.getSelectModal({ cmd: { type: 'info' } }, function (result) {
    var calcul = el.closest('tr').find('.cmdAttr[data-l1key=configuration][data-l2key=' + el.data('input') + ']')
    calcul.atCaret('insert', result.human)
  })
})

$("#table_cmd").delegate(".listEquipementAction", 'click', function () {
  var el = $(this)
  var subtype = $(this).closest('.cmd').find('.cmdAttr[data-l1key=subType]').value()
  jeedom.cmd.getSelectModal({ cmd: { type: 'action', subType: subtype } }, function (result) {
    var calcul = el.closest('tr').find('.cmdAttr[data-l1key=configuration][data-l2key=' + el.attr('data-input') + ']')
    calcul.atCaret('insert', result.human);
  })
})

$("#table_cmd").sortable({ axis: "y", cursor: "move", items: ".cmd", placeholder: "ui-state-highlight", tolerance: "intersect", forcePlaceholderSize: true })

function addCmdToTable(_cmd) {
  if (!isset(_cmd)) {
    var _cmd = { configuration: {} }
  }
  if (!isset(_cmd.configuration)) {
    _cmd.configuration = {}
  }
  if (init(_cmd.logicalId) == 'refresh') {
    return;
  }

  if (init(_cmd.type) == 'info') {
    var tr = '<tr class="cmd" data-cmd_id="' + init(_cmd.id) + '" virtualAction="' + init(_cmd.configuration.virtualAction) + '">'
    tr += '<td class="hidden-xs">'
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
    tr += '<label class="checkbox-inline"><input type="checkbox" class="cmdAttr" data-l1key="isVisible" checked/>{{Afficher}}</label> '
    tr += '<label class="checkbox-inline"><input type="checkbox" class="cmdAttr" data-l1key="isHistorized" checked/>{{Historiser}}</label> '
    tr += '<label class="checkbox-inline"><input type="checkbox" class="cmdAttr" data-l1key="display" data-l2key="invertBinary"/>{{Inverser}}</label> '
    tr += '<div style="margin-top:7px;">'
    tr += '<input class="tooltips cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="minValue" placeholder="{{Min}}" title="{{Min}}" style="width:30%;max-width:80px;display:inline-block;margin-right:2px;">'
    tr += '<input class="tooltips cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="maxValue" placeholder="{{Max}}" title="{{Max}}" style="width:30%;max-width:80px;display:inline-block;margin-right:2px;">'
    tr += '<input class="tooltips cmdAttr form-control input-sm" data-l1key="unite" placeholder="{{Unité}}" title="{{Unité}}" style="width:30%;max-width:80px;display:inline-block;margin-right:2px;">'
    tr += '</div>'
    tr += '</td>'
    tr += '<td>';
    tr += '<span class="cmdAttr" data-l1key="htmlstate"></span>';
    tr += '</td>';
    tr += '<td>'
    if (is_numeric(_cmd.id)) {
      tr += '<a class="btn btn-default btn-xs cmdAction" data-action="configure"><i class="fas fa-cogs"></i></a> '
      tr += '<a class="btn btn-default btn-xs cmdAction" data-action="test"><i class="fas fa-rss"></i> {{Tester}}</a>'
    }
    tr += '<i class="fas fa-minus-circle pull-right cmdAction cursor" data-action="remove"></i></td>'
    tr += '</tr>'
    $('#table_cmd tbody').append(tr)
    $('#table_cmd tbody tr').last().setValues(_cmd, '.cmdAttr')
    if (isset(_cmd.type)) {
      $('#table_cmd tbody tr:last .cmdAttr[data-l1key=type]').value(init(_cmd.type))
    }
    jeedom.cmd.changeType($('#table_cmd tbody tr').last(), init(_cmd.subType))
  }

  if (init(_cmd.type) == 'action') {
    var tr = '<tr class="cmd" data-cmd_id="' + init(_cmd.id) + '">';
    tr += '<td class="hidden-xs">'
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
    tr += '<option value="">{{Aucune}}</option>';
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
    tr += '<label class="checkbox-inline"><input type="checkbox" class="cmdAttr" data-l1key="isVisible" checked/>{{Afficher}}</label> '
    tr += '<div style="margin-top:7px;">'
    tr += '<input class="tooltips cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="minValue" placeholder="{{Min}}" title="{{Min}}" style="width:30%;max-width:80px;display:inline-block;margin-right:2px;">'
    tr += '<input class="tooltips cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="maxValue" placeholder="{{Max}}" title="{{Max}}" style="width:30%;max-width:80px;display:inline-block;">'
    tr += '<input class="tooltips cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="listValue" placeholder="{{Liste : valeur|texte (séparées par un point-virgule)}}" title="{{Liste : valeur|texte}}">'
    tr += '</div>'
    tr += '</td>'
    tr += '<td>';
    tr += '</td>';
    tr += '<td>'
    if (is_numeric(_cmd.id)) {
      tr += '<a class="btn btn-default btn-xs cmdAction" data-action="configure"><i class="fas fa-cogs"></i></a> '
      if (init(_cmd.type) == 'action') {
        tr += '<a class="btn btn-default btn-xs cmdAction" data-action="test"><i class="fas fa-rss"></i> {{Tester}}</a>';
      }
    }
    tr += '<i class="fas fa-minus-circle pull-right cmdAction cursor" data-action="remove"></i></td>'
    tr += '</tr>'

    $('#table_cmd tbody').append(tr)
    $('#table_cmd tbody tr').last().setValues(_cmd, '.cmdAttr')
    var tr = $('#table_cmd tbody tr').last()
    jeedom.eqLogic.builSelectCmd({
      id: $('.eqLogicAttr[data-l1key=id]').value(),
      filter: { type: 'info' },
      error: function (error) {
        $('#div_alert').showAlert({ message: error.message, level: 'danger' })
      },
      success: function (result) {
        tr.find('.cmdAttr[data-l1key=value]').append(result)
        tr.find('.cmdAttr[data-l1key=configuration][data-l2key=updateCmdId]').append(result)
        tr.setValues(_cmd, '.cmdAttr')
        jeedom.cmd.changeType(tr, init(_cmd.subType))
      }
    })
  }
}
