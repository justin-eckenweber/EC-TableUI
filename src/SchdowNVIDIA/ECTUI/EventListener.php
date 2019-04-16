<?php

/*
    EC-TableUI:

    Copyright (C) 2019 SchdowNVIDIA
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.
*/

declare(strict_types = 1);

namespace SchdowNVIDIA\ECTUI;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\block\Block;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\Armor;
use pocketmine\item\Bow;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\item\Sword;
use pocketmine\item\Tool;
use pocketmine\Player;

class EventListener implements Listener {

    private $plugin;

    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
    }

    public function generateEnchants(Item $toEnchant, Block $ectable) : array {
        $bookshelfs = $this->plugin->getBookshelfs($ectable);
        if($bookshelfs >= 0) {
            $levelSub = 0.20;
        }
        if($bookshelfs > 5) {
            $levelSub = 0.40;
        }
        if($bookshelfs > 10) {
            $levelSub = 0.70;
        }
        if($bookshelfs > 15) {
            $levelSub = 1;
        }
        if($toEnchant instanceof Sword) {
            $firstEnch = explode(":", $this->plugin->swordEnchantments[array_rand($this->plugin->swordEnchantments)]);
            $secondEnch = explode(":", $this->plugin->swordEnchantments[array_rand($this->plugin->swordEnchantments)]);
            $thirdEnch = explode(":", $this->plugin->swordEnchantments[array_rand($this->plugin->swordEnchantments)]);
            $enchants = array(
                0 => $firstEnch[0].":".rand(1, intval($firstEnch[1] * ($levelSub - 0.15))).":".rand(intval(2 * ($levelSub + 1)), intval(6 * ($levelSub + 1))),
                1 => $secondEnch[0].":".rand(1, intval($secondEnch[1] * ($levelSub - 0.10))).":".rand(intval(6 * ($levelSub + 1)), intval(10 * ($levelSub + 1))),
                2 => $thirdEnch[0].":".rand(2, intval($thirdEnch[1] * ($levelSub))).":".rand(intval(10 * ($levelSub + 1)), intval(15 * ($levelSub + 1)))
            );
        }
        else if($toEnchant instanceof Tool) {
            $firstEnch = explode(":", $this->plugin->toolEnchantments[array_rand($this->plugin->toolEnchantments)]);
            $secondEnch = explode(":", $this->plugin->toolEnchantments[array_rand($this->plugin->toolEnchantments)]);
            $thirdEnch = explode(":", $this->plugin->toolEnchantments[array_rand($this->plugin->toolEnchantments)]);
            $enchants = array(
                0 => $firstEnch[0].":".rand(1, intval($firstEnch[1] * ($levelSub - 0.15))).":".rand(intval(2 * ($levelSub + 1)), intval(6 * ($levelSub + 1))),
                1 => $secondEnch[0].":".rand(1, intval($secondEnch[1] * ($levelSub - 0.10))).":".rand(intval(6 * ($levelSub + 1)), intval(10 * ($levelSub + 1))),
                2 => $thirdEnch[0].":".rand(2, intval($thirdEnch[1] * ($levelSub))).":".rand(intval(10 * ($levelSub + 1)), intval(15 * ($levelSub + 1)))
            );
        }
        else if($toEnchant instanceof Armor) {
            $firstEnch = explode(":", $this->plugin->armorEnchantments[array_rand($this->plugin->armorEnchantments)]);
            $secondEnch = explode(":", $this->plugin->armorEnchantments[array_rand($this->plugin->armorEnchantments)]);
            $thirdEnch = explode(":", $this->plugin->armorEnchantments[array_rand($this->plugin->armorEnchantments)]);
            $enchants = array(
                0 => $firstEnch[0].":".rand(1, intval($firstEnch[1] * ($levelSub - 0.15))).":".rand(intval(2 * ($levelSub + 1)), intval(6 * ($levelSub + 1))),
                1 => $secondEnch[0].":".rand(1, intval($secondEnch[1] * ($levelSub - 0.10))).":".rand(intval(6 * ($levelSub + 1)), intval(10 * ($levelSub + 1))),
                2 => $thirdEnch[0].":".rand(2, intval($thirdEnch[1] * ($levelSub))).":".rand(intval(10 * ($levelSub + 1)), intval(15 * ($levelSub + 1)))
            );
        }
        else if($toEnchant instanceof Bow) {
            $firstEnch = explode(":", $this->plugin->bowEnchantments[array_rand($this->plugin->bowEnchantments)]);
            $secondEnch = explode(":", $this->plugin->bowEnchantments[array_rand($this->plugin->bowEnchantments)]);
            $thirdEnch = explode(":", $this->plugin->bowEnchantments[array_rand($this->plugin->bowEnchantments)]);
            $enchants = array(
                0 => $firstEnch[0].":".rand(1, intval($firstEnch[1] * ($levelSub - 0.15))).":".rand(intval(2 * ($levelSub + 1)), intval(6 * ($levelSub + 1))),
                1 => $secondEnch[0].":".rand(1, intval($secondEnch[1] * ($levelSub - 0.10))).":".rand(intval(6 * ($levelSub + 1)), intval(10 * ($levelSub + 1))),
                2 => $thirdEnch[0].":".rand(2, intval($thirdEnch[1] * ($levelSub))).":".rand(intval(10 * ($levelSub + 1)), intval(15 * ($levelSub + 1)))
            );
        } else {
            $enchants = [];
        }
        return $enchants;
    }

    public function openECTUI(Player $player, Item $toEnchant, Block $ectable) {

        $enchants = $this->generateEnchants($toEnchant, $ectable);
        if(empty($enchants)) {
            $player->sendMessage("§cThere are no enchantments available for this item!");
            return;
        }
        /*$enchants = array(
            0 => $this->plugin->enchantments[array_rand($this->plugin->enchantments)].":".(1).":".rand(1, 9),
            1 => $this->plugin->enchantments[array_rand($this->plugin->enchantments)].":".rand(1, 2).":".rand(9, 16),
            2 => $this->plugin->enchantments[array_rand($this->plugin->enchantments)].":".rand(2, 3).":".rand(16, 30)
        );*/

        $form = new SimpleForm(function (Player $player, int $data = null) use ($toEnchant, $enchants) {
            if($data != null) {
                switch ($data) {
                    case 1:
                        $arr = explode(":",$enchants[0]);
                        if($player->getXpLevel() < $arr[2]) {
                            $player->sendMessage("§cYou don't have enough levels!");
                            return;
                        } else {
                            $ench = Enchantment::getEnchantmentByName($arr[0]);
                            if($toEnchant->getEnchantment($ench->getId())) {
                                $player->sendMessage("§cYou can't enchant the same enchantment again!");
                                return;
                            }
                            $player->setXpLevel($player->getXpLevel() - $arr[2]);
                            $toEnchant->addEnchantment(new EnchantmentInstance($ench), (int) $arr[1]);
                            $player->getInventory()->setItemInHand($toEnchant);
                        }

                        break;
                    case 2:
                        $arr = explode(":",$enchants[1]);
                        if($player->getXpLevel() < $arr[2]) {
                            $player->sendMessage("§cYou don't have enough levels!");
                            return;
                        } else {
                            $ench = Enchantment::getEnchantmentByName($arr[0]);
                            if($toEnchant->getEnchantment($ench->getId())) {
                                $player->sendMessage("§cYou can't enchant the same enchantment again!");
                                return;
                            }
                            $player->setXpLevel($player->getXpLevel() - $arr[2]);
                            $toEnchant->addEnchantment(new EnchantmentInstance($ench), (int) $arr[1]);
                            $player->getInventory()->setItemInHand($toEnchant);
                        }
                        break;
                    case 3:
                        $arr = explode(":",$enchants[2]);
                        if($player->getXpLevel() < $arr[2]) {
                            $player->sendMessage("§cYou don't have enough levels!");
                            return;
                        } else {
                            $ench = Enchantment::getEnchantmentByName($arr[0]);
                            if($toEnchant->getEnchantment($ench->getId())) {
                                $player->sendMessage("§cYou can't enchant the same enchantment again!");
                                return;
                            }
                            $player->setXpLevel($player->getXpLevel() - $arr[2]);
                            $toEnchant->addEnchantment(new EnchantmentInstance($ench), (int) $arr[1]);
                            $player->getInventory()->setItemInHand($toEnchant);
                        }
                        break;
                    default:

                        break;
                }
            }
        });

        $form->setTitle("Enchanting: ".$toEnchant->getName());
        $form->addButton("§l§cLEAVE");
        foreach ($enchants as $ec) {
            $arr = explode(":", $ec);
            $lvl = $arr[1];
            if($lvl <= 0) {
                $lvl = 1;
            }
            $form->addButton($arr[0]." (".$lvl.") for ".$arr[2]." levels");
        }
        $form->setContent("Enchant your holding Item");
        $form->sendToPlayer($player);

    }

    public function onTouch(PlayerInteractEvent $event) {

        $block = $event->getBlock();
        if($block->getId() === Block::ENCHANTING_TABLE || $block->getId() === Block::ENCHANTMENT_TABLE) {
            if($event->getPlayer()->isSneaking() === false) {
                $toEnchant = $event->getItem();
                $this->openECTUI($event->getPlayer(), $toEnchant, $block);
                //$event->getPlayer()->sendMessage("Bookshelfs: ".$this->getBookshelfs($block));
            }
        }

    }

}