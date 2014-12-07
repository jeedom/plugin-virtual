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
            if ($this->getSubType() != 'slider' && $this->getSubType() != 'color') {
                $value = $this->getConfiguration('value');
            }
            $virtualCmd->setConfiguration('value', $value);
            $virtualCmd->save();
        } else {
            $cmd->setConfiguration('value', $value);
            $cmd->save();
        }
        $cmd->event($value);
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
            } else {
                $actionInfo = virtualCmd::byEqLogicIdCmdName($this->getEqLogic_id(), $this->getConfiguration('infoName'));
                if (!is_object($actionInfo)) {
                    $actionInfo = new virtualCmd();
                    $actionInfo->setType('info');
                    $actionInfo->setSubType('string');
                    $actionInfo->setCache('enable', 0);
                }
                $actionInfo->setEventOnly(1);
                $actionInfo->setConfiguration('virtualAction', 1);
                $actionInfo->setName($this->getConfiguration('infoName'));
                $actionInfo->setEqLogic_id($this->getEqLogic_id());
                $actionInfo->save();
                $this->setConfiguration('infoId', $actionInfo->getId());
            }
        } else {
            $calcul = $this->getConfiguration('calcul');
            if (strpos($this->getConfiguration('calcul'), '#' . $this->getId() . '#') !== false) {
                throw new Exception(__('Vous ne pouvez faire un calcul sur la valeur elle meme (boucle infinie)!!!', __FILE__));
            }

            $this->setConfiguration('calcul', $calcul);
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
        if ($this->getEqLogic()->getIsEnable() == 1 && $this->getType() == 'info') {
            $this->event($this->execute());
        }
    }

    public function execute($_options = null) {
        switch ($this->getType()) {
            case 'info':
                if ($this->getConfiguration('virtualAction', 0) == '0') {
                    try {
                        $calcul = jeedom::evaluateExpression($this->getConfiguration('calcul'));
                        $test = new evaluate();
                        $result = $test->Evaluer($calcul);
                        if ($this->getSubType() == 'binary') {
                            if ($result) {
                                return 1;
                            } else {
                                return 0;
                            }
                        }
                        if (is_numeric($result)) {
                            $result = number_format($result, 2);
                        } else {
                            $result = str_replace('"', '', $result);
                        }
                        if ($this->getSubType() == 'numeric') {
                            if (strpos($result, '.') !== false) {
                                $result = str_replace(',', '', $result);
                            } else {
                                $result = str_replace(',', '.', $result);
                            }
                        }
                        return $result;
                    } catch (Exception $e) {
                        log::add('virtual', 'info', $e->getMessage());
                        return jeedom::evaluateExpression(str_replace('"', '', cmd::cmdToValue($this->getConfiguration('calcul'))));
                    }
                } else {
                    return $this->getConfiguration('value');
                }
                break;
            case 'action':
                $cmd = cmd::byId(str_replace('#', '', $this->getConfiguration('infoName')));
                if (is_object($cmd)) {
                    return $cmd->execCmd($_options);
                } else {
                    $virtualCmd = virtualCmd::byId($this->getConfiguration('infoId'));
                    if (!is_object($virtualCmd)) {
                        throw new Exception(__('Virtual info commande non trouvé, verifier ID', __FILE__));
                    }
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

                    $result = cmd::cmdToValue($value);

                    if (!is_numeric($result)) {
                        try {
                            $test = new evaluate();
                            $result = $test->Evaluer($result);
                        } catch (Exception $e) {
                            log::add('virtual', 'info', $e->getMessage());
                        }
                    }
                    $virtualCmd->setConfiguration('value', $result);
                    $virtualCmd->save();
                }
                break;
        }
    }

    /*     * **********************Getteur Setteur*************************** */
}

?>
