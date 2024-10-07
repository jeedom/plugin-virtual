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

/* * ***************************Includes********************************* */
require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';

class virtual extends eqLogic {

	/*     * ***********************Methode static*************************** */

	public static function createJeedomMonitor(){
		$eqLogic = self::byLogicalId('jeedom::monitor','virtual');
		if(!is_object($eqLogic)){
			$eqLogic = new virtual();
			$eqLogic->setName(__('Jeedom interne', __FILE__));
			$eqLogic->setIsEnable(1);
			$eqLogic->setConfiguration('autorefresh','*/10 * * * *');
		}
		$eqLogic->setEqType_name('virtual');
		$eqLogic->setLogicalId('jeedom::monitor');
		try {
			$eqLogic->save();
		} catch (Exception $e) {
			$eqLogic->setName($eqLogic->getName() . ' remote ' . rand(0, 9999));
			$eqLogic->save();
		}

		$cmd = $eqLogic->getCmd(null, 'jeedom::monitor::update::nb');
		if (!is_object($cmd)) {
			$cmd = new virtualCmd();
			$cmd->setName(__('Nombre de mise à jour',__FILE__));
			$cmd->setTemplate('mobile', 'line');
			$cmd->setTemplate('dashboard', 'line');
		}
		$cmd->setConfiguration('infoName','jeedom::internal');
		$cmd->setEqLogic_id($eqLogic->getId());
		$cmd->setLogicalId('jeedom::monitor::update::nb');
		$cmd->setType('info');
		$cmd->setSubType('numeric');
		$cmd->save();

		$cmd = $eqLogic->getCmd(null, 'jeedom::monitor::message::nb');
		if (!is_object($cmd)) {
			$cmd = new virtualCmd();
			$cmd->setName(__('Nombre de message',__FILE__));
			$cmd->setTemplate('mobile', 'line');
			$cmd->setTemplate('dashboard', 'line');
		}
		$cmd->setConfiguration('infoName','jeedom::internal');
		$cmd->setEqLogic_id($eqLogic->getId());
		$cmd->setLogicalId('jeedom::monitor::message::nb');
		$cmd->setType('info');
		$cmd->setSubType('numeric');
		$cmd->save();

		$cmd = $eqLogic->getCmd(null, 'jeedom::monitor::version');
		if (!is_object($cmd)) {
			$cmd = new virtualCmd();
			$cmd->setName(__('Version',__FILE__));
			$cmd->setTemplate('mobile', 'line');
			$cmd->setTemplate('dashboard', 'line');
		}
		$cmd->setConfiguration('infoName','jeedom::internal');
		$cmd->setEqLogic_id($eqLogic->getId());
		$cmd->setLogicalId('jeedom::monitor::version');
		$cmd->setType('info');
		$cmd->setSubType('string');
		$cmd->save();

		$cmd = $eqLogic->getCmd(null, 'jeedom::monitor::update');
		if (!is_object($cmd)) {
			$cmd = new virtualCmd();
			$cmd->setName(__('Mettre à jour',__FILE__));
			$cmd->setTemplate('mobile', 'line');
			$cmd->setTemplate('dashboard', 'line');
		}
		$cmd->setConfiguration('infoName','jeedom::internal');
		$cmd->setEqLogic_id($eqLogic->getId());
		$cmd->setLogicalId('jeedom::monitor::update');
		$cmd->setType('action');
		$cmd->setSubType('other');
		$cmd->save();

		$cmd = $eqLogic->getCmd(null, 'jeedom::monitor::backup');
		if (!is_object($cmd)) {
			$cmd = new virtualCmd();
			$cmd->setName(__('Backuper',__FILE__));
			$cmd->setTemplate('mobile', 'line');
			$cmd->setTemplate('dashboard', 'line');
		}
		$cmd->setConfiguration('infoName','jeedom::internal');
		$cmd->setEqLogic_id($eqLogic->getId());
		$cmd->setLogicalId('jeedom::monitor::backup');
		$cmd->setType('action');
		$cmd->setSubType('other');
		$cmd->save();

		foreach (plugin::listPlugin(true) as $plugin) {
			if ($plugin->getHasOwnDeamon() != 1) {
				continue;
			}
			$cmd = $eqLogic->getCmd(null, 'jeedom::monitor::deamonState::' . $plugin->getId());
			if (!is_object($cmd)) {
				$cmd = new virtualCmd();
				$cmd->setName(__('Démon', __FILE__) . ' ' . $plugin->getName());
				$cmd->setTemplate('mobile', 'line');
				$cmd->setTemplate('dashboard', 'line');
			}
			$cmd->setConfiguration('infoName','jeedom::internal');
			$cmd->setConfiguration('deamon', $plugin->getId());
			$cmd->setEqLogic_id($eqLogic->getId());
			$cmd->setLogicalId('jeedom::monitor::deamonState::' . $plugin->getId());
			$cmd->setType('info');
			$cmd->setSubType('binary');
			$cmd->save();

			$cmd = $eqLogic->getCmd(null, 'jeedom::monitor::deamonStart::' . $plugin->getId());
			if (!is_object($cmd)) {
				$cmd = new virtualCmd();
				$cmd->setName(__('Démarrer démon', __FILE__) . ' ' . $plugin->getName());
			}
			$cmd->setConfiguration('infoName','jeedom::internal');
			$cmd->setConfiguration('deamon', $plugin->getId());
			$cmd->setEqLogic_id($eqLogic->getId());
			$cmd->setLogicalId('jeedom::monitor::deamonStart::' . $plugin->getId());
			$cmd->setType('action');
			$cmd->setSubType('other');
			$cmd->save();

			$cmd = $eqLogic->getCmd(null, 'jeedom::monitor::deamonStop::' . $plugin->getId());
			if (!is_object($cmd)) {
				$cmd = new virtualCmd();
				$cmd->setName(__('Arrêter démon', __FILE__) . ' ' . $plugin->getName());
			}
			$cmd->setConfiguration('infoName','jeedom::internal');
			$cmd->setConfiguration('deamon', $plugin->getId());
			$cmd->setEqLogic_id($eqLogic->getId());
			$cmd->setLogicalId('jeedom::monitor::deamonStop::' . $plugin->getId());
			$cmd->setType('action');
			$cmd->setSubType('other');
			$cmd->save();
		}
		self::updateJeedomMonitor();
	}

	public static function updateJeedomMonitor(){
		$eqLogic = self::byLogicalId('jeedom::monitor','virtual');
		if(!is_object($eqLogic)){
			return;
		}
		$eqLogic->checkAndUpdateCmd('jeedom::monitor::update::nb',update::nbNeedUpdate());
		$eqLogic->checkAndUpdateCmd('jeedom::monitor::message::nb',message::nbMessage());
		$eqLogic->checkAndUpdateCmd('jeedom::monitor::version',jeedom::version());
		foreach (plugin::listPlugin(true) as $plugin) {
			if ($plugin->getHasOwnDeamon() != 1) {
				continue;
			}
			$eqLogic->checkAndUpdateCmd('jeedom::monitor::deamonState::' . $plugin->getId(),($plugin->deamon_info()['state'] == 'ok'));
		}
	}

	public static function event() {
		log::add('virtual', 'debug', json_encode($_GET));
		if (init('id') != '') {
			$cmd = virtualCmd::byId(init('id'));
			if (!is_object($cmd) || $cmd->getEqType() != 'virtual') {
				throw new Exception(__('Commande ID virtuel inconnu ou la commande n\'est pas de type virtuel', __FILE__) . ' : ' . init('id'));
			}
		} else if (init('eid') != '') {
			$eqLogic = virtual::byId(init('eid'));
			if (!is_object($eqLogic) || $eqLogic->getEqType_name() != 'virtual') {
				throw new Exception(__('Equipement ID virtuel inconnu ', __FILE__) . ' : ' . init('eid'));
			}
			if (!is_object($eqLogic) || $eqLogic->getEqType_name() != 'virtual') {
				throw new Exception(__('L\'équipement n\'est pas de type virtuel', __FILE__) . ' : ' . $eqLogic->getEqType_name());
			}
			$cmd = null;
			foreach ($eqLogic->getCmd('info') as $eqCmd) {
				if (strtolower(init('name', init('cn'))) == strtolower($eqCmd->getName())) {
					$cmd = $eqCmd;
					break;
				}
			}
		}
		if (!is_object($cmd)) {
			throw new Exception(__('Commande introuvable', __FILE__) . ' : ' . json_encode($_GET));
		}
		$cmd->event(init('value', init('v')));
	}

	public static function cron() {
		foreach (eqLogic::byType('virtual', true) as $eqLogic) {
			$autorefresh = $eqLogic->getConfiguration('autorefresh');
			if ($autorefresh != '') {
				try {
					$c = new Cron\CronExpression(checkAndFixCron($autorefresh), new Cron\FieldFactory);
					if ($c->isDue()) {
						try {
							log::add('virtual', 'debug', __('Mise à jour des valeurs pour : ', __FILE__) . $eqLogic->getHumanName());
							$eqLogic->refresh();
						} catch (Exception $exc) {
							log::add('virtual', 'error', __('Erreur pour ', __FILE__) . $eqLogic->getHumanName() . ' : ' . $exc->getMessage());
						}
					}
				} catch (Exception $exc) {
					log::add('virtual', 'error', __('Expression cron non valide pour', __FILE__) . ' ' . $eqLogic->getHumanName() . ' : ' . $autorefresh);
				}
			}
		}
	}

	public static function templateParameters($_template = '') {
		$return = array();
		foreach (ls(dirname(__FILE__) . '/../config/template', '*.json', false, array('files', 'quiet')) as $file) {
			try {
				$content = file_get_contents(dirname(__FILE__) . '/../config/template/' . $file);
				if (is_json($content)) {
					$return += json_decode($content, true);
				}
			} catch (Exception $e) {
			}
		}
		if (isset($_template) && $_template != '') {
			if (isset($return[$_template])) {
				return $return[$_template];
			}
			return array();
		}
		return $return;
	}

	public static function deadCmd() {
		$return = array();
		foreach (eqLogic::byType('virtual') as $virtual) {
			foreach ($virtual->getCmd() as $cmd) {
				preg_match_all("/#([0-9]*)#/", $cmd->getConfiguration('infoName', ''), $matches);
				foreach ($matches[1] as $cmd_id) {
					if (!cmd::byId(str_replace('#', '', $cmd_id))) {
						$return[] = array('detail' => __('Virtuel', __FILE__) . ' ' . $virtual->getHumanName() . ' ' . __('dans la commande', __FILE__) . ' ' . $cmd->getName(), 'help' => __('Nom Information', __FILE__), 'who' => '#' . $cmd_id . '#');
					}
				}
				preg_match_all("/#([0-9]*)#/", $cmd->getConfiguration('calcul', ''), $matches);
				foreach ($matches[1] as $cmd_id) {
					if (!cmd::byId(str_replace('#', '', $cmd_id))) {
						$return[] = array('detail' => __('Virtuel', __FILE__) . ' ' . $virtual->getHumanName() . ' ' . __('dans la commande', __FILE__) . ' ' . $cmd->getName(), 'help' => __('Calcul', __FILE__), 'who' => '#' . $cmd_id . '#');
					}
				}
			}
		}
		return $return;
	}

	/*     * *********************Methode d'instance************************* */

	public function applyTemplate($_template) {
		$template = self::templateParameters($_template);
		if (!is_array($template)) {
			return true;
		}
		$this->import($template);
	}

	public function refresh() {
		if($this->getLogicalId() == 'jeedom::monitor'){
			self::updateJeedomMonitor();
			return;
		}
		try {
			foreach ($this->getCmd('info') as $cmd) {
				if ($cmd->getConfiguration('calcul') == '' || $cmd->getConfiguration('virtualAction', 0) != '0') {
					continue;
				}
				$value = $cmd->execute();
				if ($cmd->execCmd() != $cmd->formatValue($value)) {
					$cmd->event($value);
				}
			}
		} catch (Exception $exc) {
			log::add('virtual', 'error', __('Erreur pour', __FILE__) . ' ' . $this->getHumanName() . ' : ' . $exc->getMessage());
		}
	}

	public function postSave() {
		$createRefreshCmd = true;
		$refresh = $this->getCmd(null, 'refresh');
		if (!is_object($refresh)) {
			$refresh = cmd::byEqLogicIdCmdName($this->getId(), __('Rafraichir', __FILE__));
			if (is_object($refresh)) {
				$createRefreshCmd = false;
			}
		}
		if ($createRefreshCmd) {
			if (!is_object($refresh)) {
				$refresh = new virtualCmd();
				$refresh->setLogicalId('refresh');
				$refresh->setIsVisible(1);
				$refresh->setName(__('Rafraichir', __FILE__));
			}
			$refresh->setType('action');
			$refresh->setSubType('other');
			$refresh->setEqLogic_id($this->getId());
			$refresh->save();
		}
	}

	public function copyFromEqLogic($_eqLogic_id) {
		$eqLogic = eqLogic::byId($_eqLogic_id);

		if (!is_object($eqLogic)) {
			throw new Exception(__('Impossible de trouver l\'équipement', __FILE__) . ' : ' . $_eqLogic_id);
		}
		if ($eqLogic->getEqType_name() == 'virtual') {
			throw new Exception(__('Vous ne pouvez importer la configuration d\'un équipement virtuel', __FILE__));
		}
		foreach ($eqLogic->getCategory() as $key => $value) {
			$this->setCategory($key, $value);
		}
		$arrayEquipmentCmd = $this->getCmd();
		if (sizeof($arrayEquipmentCmd) > 1) {
			$virtual_with_commands = true;
		} else {
			$virtual_with_commands = false;
		}
		foreach ($eqLogic->getCmd() as $cmd_def) {
			$cmd_name = $cmd_def->getName();
			if ($cmd_name == __('Rafraichir', __FILE__)) {
				$cmd_name .= '_1';
			}
			if ($virtual_with_commands) {
				$cmd_name .= '_' . $cmd_def->getId();
			}
			log::add('virtual', 'debug', __('import équipement', __FILE__) . ' : ' . $eqLogic->getName() . ' > ' . __('ajout de la commande', __FILE__) . ' : ' . $cmd_name);
			$cmd = new virtualCmd();
			$cmd->setName($cmd_name);
			$cmd->setEqLogic_id($this->getId());
			$cmd->setIsVisible($cmd_def->getIsVisible());
			$cmd->setType($cmd_def->getType());
			$cmd->setUnite($cmd_def->getUnite());
			$cmd->setOrder($cmd_def->getOrder());
			$cmd->setGeneric_type($cmd_def->getGeneric_type());
			$cmd->setDisplay('icon', $cmd_def->getDisplay('icon'));
			$cmd->setDisplay('invertBinary', $cmd_def->getDisplay('invertBinary'));
			$cmd->setConfiguration('listValue', $cmd_def->getConfiguration('listValue', ''));
			foreach ($cmd_def->getTemplate() as $key => $value) {
				$cmd->setTemplate($key, $value);
			}
			$cmd->setSubType($cmd_def->getSubType());
			if ($cmd->getType() == 'info') {
				$cmd->setConfiguration('calcul', '#' . $cmd_def->getId() . '#');
				$cmd->setValue($cmd_def->getId());
			} else {
				$cmd->setValue($cmd_def->getValue());
				$cmd->setConfiguration('infoName', '#' . $cmd_def->getId() . '#');
			}
			try {
				$cmd->save();
			} catch (Exception $e) {
			}
		}
		$this->save();
	}

	public function copyCmdsFromEqLogic($_eqLogic_id, $cmdsSelected) {
		$eqLogic = eqLogic::byId($_eqLogic_id);

		if (!is_object($eqLogic)) {
			throw new Exception(__('Impossible de trouver l\'équipement', __FILE__) . ' : ' . $_eqLogic_id);
		}
		if ($eqLogic->getEqType_name() == 'virtual') {
			throw new Exception(__('Vous ne pouvez importer la configuration d\'un équipement virtuel', __FILE__));
		}
		foreach ($eqLogic->getCategory() as $key => $value) {
			$this->setCategory($key, $value);
		}
		$arrayEquipmentCmd = $this->getCmd();
		if (sizeof($arrayEquipmentCmd) > 1) {
			$virtual_with_commands = true;
		} else {
			$virtual_with_commands = false;
		}
		foreach ($cmdsSelected as $cmdId) {
			$cmd_def = cmd::byId($cmdId);
			$cmd_name = $cmd_def->getName();
			if ($cmd_name == __('Rafraichir', __FILE__)) {
				$cmd_name .= '_1';
			}
			if ($virtual_with_commands) {
				$cmd_name .= '_' . $cmd_def->getId();
			}
			log::add('virtual', 'debug', __('import équipement', __FILE__) . ' : ' . $eqLogic->getName() . ' > ' . __('ajout de la commande', __FILE__) . ' : ' . $cmd_name);
			$cmd = new virtualCmd();
			$cmd->setName($cmd_name);
			$cmd->setEqLogic_id($this->getId());
			$cmd->setIsVisible($cmd_def->getIsVisible());
			$cmd->setType($cmd_def->getType());
			$cmd->setUnite($cmd_def->getUnite());
			$cmd->setOrder($cmd_def->getOrder());
			$cmd->setGeneric_type($cmd_def->getGeneric_type());
			$cmd->setDisplay('icon', $cmd_def->getDisplay('icon'));
			$cmd->setDisplay('invertBinary', $cmd_def->getDisplay('invertBinary'));
			$cmd->setConfiguration('listValue', $cmd_def->getConfiguration('listValue', ''));
			foreach ($cmd_def->getTemplate() as $key => $value) {
				$cmd->setTemplate($key, $value);
			}
			$cmd->setSubType($cmd_def->getSubType());
			if ($cmd->getType() == 'info') {
				$cmd->setConfiguration('calcul', '#' . $cmd_def->getId() . '#');
				$cmd->setValue($cmd_def->getId());
			} else {
				$cmd->setValue($cmd_def->getValue());
				$cmd->setConfiguration('infoName', '#' . $cmd_def->getId() . '#');
			}
			try {
				$cmd->save();
			} catch (Exception $e) {
			}
		}
		$this->save();
	}
}

class virtualCmd extends cmd {

	public function dontRemoveCmd() {
		if ($this->getLogicalId() == 'refresh') {
			return true;
		}
		return false;
	}

	public function preSave() {
		if ($this->getLogicalId() == 'refresh') {
			return;
		}
		if ($this->getConfiguration('virtualAction') == 1) {
			$actionInfo = virtualCmd::byEqLogicIdCmdName($this->getEqLogic_id(), $this->getName());
			if (is_object($actionInfo)) {
				$this->setId($actionInfo->getId());
			}
			$this->setConfiguration('calcul', '');
			if ($this->getType() == 'info') {
				$this->setValue('');
			}
		}
		if ($this->getType() == 'action') {
			if ($this->getConfiguration('infoName') == '') {
				throw new Exception(__('Le nom de la commande info ne peut être vide', __FILE__));
			}
			if (strpos($this->getConfiguration('infoName'), 'jeedom::internal') !== false) {
				return;
			}
			if (strpos($this->getConfiguration('infoName'), 'core::jeeObject::summary') !== false) {
				return;
			}
			$cmd = cmd::byId(str_replace('#', '', $this->getConfiguration('infoName')));
			if (is_object($cmd)) {
				if ($cmd->getId() == $this->getId()) {
					throw new Exception(__('Vous ne pouvez appeler la commande elle-même (boucle infinie) sur', __FILE__) . ' : ' . $this->getName());
				}
				$this->setSubType($cmd->getSubType());
				$this->setConfiguration('infoId', '');
			} else {
				$actionInfo = virtualCmd::byEqLogicIdCmdName($this->getEqLogic_id(), $this->getConfiguration('infoName'));
				if (!is_object($actionInfo)) {
					$actionInfo = new virtualCmd();
					$actionInfo->setType('info');
					switch ($this->getSubType()) {
						case 'slider':
							$actionInfo->setSubType('numeric');
							break;
						default:
							$actionInfo->setSubType('string');
							break;
					}
				} else {
					if ($actionInfo->getId() == $this->getId()) {
						throw new Exception(__('Vous ne pouvez appeler la commande elle-même (boucle infinie) sur', __FILE__) . ' : ' . $this->getName());
					}
				}
				$actionInfo->setConfiguration('virtualAction', 1);
				$actionInfo->setName($this->getConfiguration('infoName'));
				$actionInfo->setEqLogic_id($this->getEqLogic_id());
				$actionInfo->save();
				$this->setConfiguration('infoId', $actionInfo->getId());
			}
		} else {
			$calcul = $this->getConfiguration('calcul');
			if (strpos($calcul, '#' . $this->getId() . '#') !== false) {
				throw new Exception(__('Vous ne pouvez appeler la commande elle-même (boucle infinie) sur', __FILE__) . ' : ' . $this->getName());
			}
			$added_value = [];
			preg_match_all("/#([0-9]*)#/", $calcul, $matches);
			$value = '';
			foreach ($matches[1] as $cmd_id) {
				if (is_numeric($cmd_id)) {
					$cmd = self::byId($cmd_id);
					if (is_object($cmd) && $cmd->getType() == 'info') {
						if (isset($added_value[$cmd_id])) {
							continue;
						}
						$value .= '#' . $cmd_id . '#';
						$added_value[$cmd_id] = $cmd_id;
					}
				}
			}
			preg_match_all("/variable\((.*?)\)/", $calcul, $matches);
			foreach ($matches[1] as $variable) {
				if (isset($added_value['#variable(' . $variable . ')#'])) {
					continue;
				}
				$value .= '#variable(' . $variable . ')#';
				$added_value['#variable(' . $variable . ')#'] = '#variable(' . $variable . ')#';
			}
			$this->setValue($value);
		}
	}

	public function postSave() {
		if ($this->getType() == 'info' && $this->getConfiguration('virtualAction', 0) == '0' && $this->getConfiguration('calcul') != '') {
			try {
				$this->event($this->execute());
			} catch (\Throwable $th) {
				log::error('virtual','error',$th->getMessage());
			}
		}
	}

	public function execute($_options = null) {
		$eqLogic = $this->getEqLogic();
		if ($this->getLogicalId() == 'refresh') {
			$eqLogic->refresh();
			return;
		}
		switch ($this->getType()) {
			case 'info':
				if ($this->getConfiguration('virtualAction', 0) == '0') {
					try {
						$result = jeedom::evaluateExpression($this->getConfiguration('calcul'));
						if (is_string($result)) {
							$result = str_replace('"', '', $result);
						}
						return $result;
					} catch (Exception $e) {
						log::add('virtual', 'info', $e->getMessage());
						return $this->getConfiguration('calcul');
					}
				}
				break;
			case 'action':
				if (strpos($this->getLogicalId(), 'jeedom::monitor') !== false) {
					if (strpos($this->getLogicalId(), 'deamonStart') !== false) {
						$plugin = plugin::byId($this->getConfiguration('deamon'));
						if(is_object($plugin)){
							$plugin->deamon_start();
						}
					}
					if (strpos($this->getLogicalId(), 'deamonStop') !== false) {
						$plugin = plugin::byId($this->getConfiguration('deamon'));
						if(is_object($plugin)){
							$plugin->deamon_stop();
						}
					}
					if (strpos($this->getLogicalId(), 'update') !== false) {
						jeedom::update();
					}
					if (strpos($this->getLogicalId(), 'backup') !== false) {
						jeedom::backup(true);
					}
					virtual::updateJeedomMonitor();
					return;
				}
				if (strpos($this->getConfiguration('infoName'), 'core::jeeObject::summary') !== false) {
					jeeObject::actionOnSummary($this, $_options);
					return;
				}
				$virtualCmd = virtualCmd::byId($this->getConfiguration('infoId'));
				if (!is_object($virtualCmd)) {
					$cmds = explode('&&', $this->getConfiguration('infoName'));
					if (is_array($cmds)) {
						foreach ($cmds as $cmd_id) {
							$cmd = cmd::byId(str_replace('#', '', $cmd_id));
							if (is_object($cmd)) {
								try {
									$cmd->execCmd($_options);
								} catch (\Exception $e) {
								}
							}
						}
						return;
					} else {
						$cmd = cmd::byId(str_replace('#', '', $this->getConfiguration('infoName')));
						return $cmd->execCmd($_options);
					}
				} else {
					if ($virtualCmd->getEqType() != 'virtual') {
						throw new Exception(__('La cible de la commande virtuelle n\'est pas un équipement de type virtuel', __FILE__));
					}
					if ($this->getSubType() == 'slider') {
						$value = $_options['slider'];
					} else if ($this->getSubType() == 'color') {
						$value = $_options['color'];
					} else if ($this->getSubType() == 'select') {
						$value = $_options['select'];
					} else {
						$value = $this->getConfiguration('value');
					}
					$result = jeedom::evaluateExpression($value);
					if ($this->getSubtype() == 'message') {
						$result = $_options['title'] . ' ' . $_options['message'];
					}
					$eqLogic->checkAndUpdateCmd($virtualCmd, $result);
				}
				break;
		}
	}
}
