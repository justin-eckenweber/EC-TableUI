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
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\Player;

class EventListener implements Listener {

    private $plugin;

    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
    }

    public function generateEnchants(Item $toEnchant, Block $ectable) : array {
        $bookshelfs = $this->getBookshelfs($ectable);

    }

    public function openECTUI(Player $player, Item $toEnchant, Block $ectable) {

        //$enchants = $this->generateEnchants($toEnchant, $ectable);
        $enchants = array(
            0 => $this->plugin->enchantments[array_rand($this->plugin->enchantments)].":".(1).":".rand(1, 9),
            1 => $this->plugin->enchantments[array_rand($this->plugin->enchantments)].":".rand(1, 2).":".rand(9, 16),
            2 => $this->plugin->enchantments[array_rand($this->plugin->enchantments)].":".rand(2, 3).":".rand(16, 30)
        );

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
            $form->addButton($arr[0]." (".$arr[1].") for ".$arr[2]." levels");
        }
        $form->setContent("Enchant your holding Item");
        $form->sendToPlayer($player);

    }

    public function onTouch(PlayerInteractEvent $event) {

        $block = $event->getBlock();
        if($block->getId() === Block::ENCHANTING_TABLE || $block->getId() === Block::ENCHANTMENT_TABLE) {
            $toEnchant = $event->getItem();
            $this->openECTUI($event->getPlayer(), $toEnchant, $block);
            $event->getPlayer()->sendMessage("Bookshelfs: ".$this->getBookshelfs($block));
        }

    }

}