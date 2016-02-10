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
	/*     * *************************Attributs****************************** */

	/*     * ***********************Methode static*************************** */

	public static function event() {
		$cmd = virtualCmd::byId(init('id'));
		if (!is_object($cmd)) {
			throw new Exception('Commande ID virtuel inconnu : ' . init('id'));
		}
		$value = init('value');
		$virtualCmd = virtualCmd::byId($cmd->getConfiguration('infoId'));
		if (is_object($virtualCmd)) {
			if ($virtualCmd->getEqLogic()->getEqType_name() != 'virtual') {
				throw new Exception(__('La cible de la commande virtuel n\'est pas un équipement de type virtuel', __FILE__));
			}
			if ($virtualCmd->getSubType() != 'slider' && $virtualCmd->getSubType() != 'color') {
				$value = $virtualCmd->getConfiguration('value');
			}
			$virtualCmd->setConfiguration('value', $value);
			$virtualCmd->save();
		} else {
			$cmd->setConfiguration('value', $value);
			$cmd->save();
		}
		$cmd->event($value);
	}

	public static function cron() {
		foreach (eqLogic::byType('virtual') as $eqLogic) {
			$autorefresh = $eqLogic->getConfiguration('autorefresh');
			if ($eqLogic->getIsEnable() == 1 && $autorefresh != '') {
				try {
					$c = new Cron\CronExpression($autorefresh, new Cron\FieldFactory);
					if ($c->isDue()) {
						try {
							foreach ($eqLogic->getCmd('info') as $cmd) {
								$value = $cmd->execute();
								if ($cmd->execCmd() != $cmd->formatValue($value)) {
									$cmd->setCollectDate('');
									$cmd->event($value);
								}
							}
						} catch (Exception $exc) {
							log::add('virtual', 'error', __('Erreur pour ', __FILE__) . $eqLogic->getHumanName() . ' : ' . $exc->getMessage());
						}
					}
				} catch (Exception $exc) {
					log::add('virtual', 'error', __('Expression cron non valide pour ', __FILE__) . $eqLogic->getHumanName() . ' : ' . $autorefresh);
				}
			}
		}
	}

	/*     * *********************Methode d'instance************************* */

	public function copyFromEqLogic($_eqLogic_id) {
		$eqLogic = eqLogic::byId($_eqLogic_id);
		if (!is_object($eqLogic)) {
			throw new Exception(__('Impossible de trouver l\'équipement : ', __FILE__) . $_eqLogic_id);
		}
		if ($eqLogic->getEqType_name() == 'virtual') {
			throw new Exception(__('Vous ne pouvez importer la configuration d\'un équipement virtuel', __FILE__));
		}
		foreach ($eqLogic->getCategory() as $key => $value) {
			$this->setCategory($key, $value);
		}
		foreach ($eqLogic->getCmd() as $cmd_def) {
			$cmd = new virtualCmd();
			$cmd->setName($cmd_def->getName());
			$cmd->setEqLogic_id($this->getId());
			$cmd->setIsVisible($cmd_def->getIsVisible());
			$cmd->setType($cmd_def->getType());
			$cmd->setUnite($cmd_def->getUnite());
			$cmd->setOrder($cmd_def->getOrder());
			$cmd->setDisplay('icon', $cmd_def->getDisplay('icon'));
			$cmd->setDisplay('invertBinary', $cmd_def->getDisplay('invertBinary'));
			foreach ($cmd_def->getTemplate() as $key => $value) {
				$cmd->setTemplate($key, $value);
			}
			$cmd->setSubType($cmd_def->getSubType());
			if ($cmd->getType() == 'info') {
				$cmd->setConfiguration('calcul', '#' . $cmd_def->getId() . '#');
				$cmd->setValue($cmd_def->getId());
				$cmd->setEventOnly(1);
			} else {
				$cmd->setValue($cmd_def->getValue());
				$cmd->setConfiguration('infoName', '#' . $cmd_def->getId() . '#');
			}
			$cmd->save();
		}
		$this->save();
	}

	/*     * **********************Getteur Setteur*************************** */
}

class virtualCmd extends cmd {
	/*     * *************************Attributs****************************** */

	/*     * ***********************Methode static*************************** */

	/*     * *********************Methode d'instance************************* */

	public function preSave() {
		if ($this->getType() == 'info') {
			$this->setEventOnly(1);
		}
		if ($this->getConfiguration('virtualAction') == 1) {
			$actionInfo = virtualCmd::byEqLogicIdCmdName($this->getEqLogic_id(), $this->getName());
			if (is_object($actionInfo)) {
				$this->setId($actionInfo->getId());
			}
		}
		if ($this->getType() == 'action') {
			if ($this->getConfiguration('infoName') == '') {
				throw new Exception(__('Le nom de la commande info ne peut etre vide', __FILE__));
			}
			$cmd = cmd::byId(str_replace('#', '', $this->getConfiguration('infoName')));
			if (is_object($cmd)) {
				$this->setSubType($cmd->getSubType());
				$this->setEventOnly(1);
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

					$actionInfo->setCache('enable', 0);
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
				throw new Exception(__('Vous ne pouvez faire un calcul sur la valeur elle meme (boucle infinie)!!!', __FILE__));
			}
			preg_match_all("/#([0-9]*)#/", $calcul, $matches);
			$value = '';
			foreach ($matches[1] as $cmd_id) {
				if (is_numeric($cmd_id)) {
					$cmd = self::byId($cmd_id);
					if (is_object($cmd) && $cmd->getType() == 'info') {
						$value .= '#' . $cmd_id . '#';
					}
				}
			}
			if ($value != '') {
				$this->setValue($value);
			}
		}
	}

	public function postSave() {
		if ($this->getType() == 'info' && $this->getConfiguration('virtualAction', 0) == '0') {
			$this->event($this->execute());
		}
	}

	public function execute($_options = null) {
		switch ($this->getType()) {
			case 'info':
				if ($this->getConfiguration('virtualAction', 0) == '0') {
					try {
						$result = jeedom::evaluateExpression($this->getConfiguration('calcul'));
						if ($this->getSubType() == 'numeric') {
							if (is_numeric($result)) {
								$result = number_format($result, 2);
							} else {
								$result = str_replace('"', '', $result);
							}
							if (strpos($result, '.') !== false) {
								$result = str_replace(',', '', $result);
							} else {
								$result = str_replace(',', '.', $result);
							}
						}
						return $result;
					} catch (Exception $e) {
						log::add('virtual', 'info', $e->getMessage());
						return jeedom::evaluateExpression($this->getConfiguration('calcul'));
					}
				}
				break;
			case 'action':
				$virtualCmd = virtualCmd::byId($this->getConfiguration('infoId'));
				if (!is_object($virtualCmd)) {
					$cmds = explode('&&', $this->getConfiguration('infoName'));
					if (is_array($cmds)) {
						foreach ($cmds as $cmd_id) {
							$cmd = cmd::byId(str_replace('#', '', $cmd_id));
							if (is_object($cmd)) {
								$cmd->execCmd($_options);
							}
						}
						return;
					} else {
						$cmd = cmd::byId(str_replace('#', '', $this->getConfiguration('infoName')));
						return $cmd->execCmd($_options);
					}
				} else {
					if ($virtualCmd->getEqType() != 'virtual') {
						throw new Exception(__('La cible de la commande virtuel n\'est pas un équipement de type virtuel', __FILE__));
					}
					if ($this->getSubType() == 'slider') {
						$value = $_options['slider'];
					} else if ($this->getSubType() == 'color') {
						$value = $_options['color'];
					} else {
						$value = $this->getConfiguration('value');
					}
					$result = jeedom::evaluateExpression($value);
					if ($this->getSubtype() == 'message') {
						$result = $_options['title'] . ' ' . $_options['message'];
					}
					$virtualCmd->event($result);
				}
				break;
		}
	}

	/*     * **********************Getteur Setteur*************************** */
}

?>
